<?php

namespace App\Services\Chatbot;

use OpenAI;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client as GuzzleClient;

class ChatbotService
{
    protected $client;

    public function __construct()
    {
        $apiKey = config('services.openai.key') ?? env('OPENAI_API_KEY');

        if (empty($apiKey)) {
            Log::critical('OpenAI API Key is missing.');
            // Em produção não lançamos erro para não quebrar, mas logamos
            return; 
        }

        // Configuração com timeout relaxado
        $this->client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withHttpClient(new GuzzleClient(['timeout' => 30]))
            ->make();
    }

    public function handleMessage(string $message, string $locale = 'pt', array $history = []): array
    {
        if (!$this->client) {
            return [
                'reply' => 'O assistente está em manutenção momentânea. Por favor, utilize o formulário de contacto.',
                'audio' => null,
                'data'  => null
            ];
        }

        $tools = $this->getToolsDefinition();
        
        $systemPrompt = "
            You are the 'Private Virtual Assistant' for José Carvalho, a high-end real estate consultant in Portugal.
            Your tone is: Professional, Executive, Discreet, and Expert.
            Current Language: '{$locale}'.
            
            RULES:
            1. Answer exclusively in '{$locale}'.
            2. Be concise but sophisticated. Avoid emojis unless very subtle.
            3. Use 'search_properties' when the user asks for properties, houses, or investment opportunities.
            4. Use 'schedule_meeting' if the user wants to sell, talk to José, or schedule a visit.
            5. Do not invent property data. Only use what the tool returns.
        ";

        // Limpar histórico para poupar tokens e evitar erros
        $cleanHistory = array_map(function($msg) {
            return ['role' => $msg['role'], 'content' => $msg['content'] ?? ''];
        }, array_slice($history, -6)); // Mantém apenas as últimas 6 mensagens

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $cleanHistory,
            [['role' => 'user', 'content' => $message]]
        );

        try {
            $response = $this->client->chat()->create([
                'model' => 'gpt-4o-mini', // Modelo rápido e eficiente
                'messages' => $messages,
                'tools' => $tools,
                'tool_choice' => 'auto', 
            ]);

            $choice = $response->choices[0];
            $replyContent = $choice->message->content ?? '';
            $frontendData = null;

            // Se a IA decidiu usar uma ferramenta (função)
            if ($choice->finishReason === 'tool_calls') {
                $messages[] = $choice->message->toArray();

                foreach ($choice->message->toolCalls as $toolCall) {
                    $functionName = $toolCall->function->name;
                    $args = json_decode($toolCall->function->arguments, true);

                    $toolResult = $this->executeFunction($functionName, $args);

                    // Se for busca de imóveis, preparamos os dados para o Frontend (Cards)
                    if ($functionName === 'search_properties' && is_array($toolResult) && isset($toolResult['data'])) {
                        $frontendData = $toolResult['data'];
                        $toolResult = $toolResult['summary']; // O que a IA vai "ler"
                    }

                    $messages[] = [
                        'role' => 'tool',
                        'tool_call_id' => $toolCall->id,
                        'content' => is_string($toolResult) ? $toolResult : json_encode($toolResult)
                    ];
                }

                // Segunda chamada para gerar a resposta final com os dados da ferramenta
                $finalResponse = $this->client->chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                ]);

                $replyContent = $finalResponse->choices[0]->message->content;
            }

            if (empty($replyContent)) $replyContent = "Compreendido. Posso ajudar com algo mais?";
            
            // Gerar Áudio (Opcional, pode comentar se quiser poupar custos)
            // $audioBase64 = $this->textToSpeech($replyContent);
            $audioBase64 = null; // Desativado por padrão para velocidade

            return [
                'reply' => $replyContent,
                'audio' => $audioBase64,
                'data'  => $frontendData
            ];

        } catch (\Exception $e) {
            Log::error("Chatbot Error: " . $e->getMessage());
            return [
                'reply' => "Peço desculpa, mas estou com uma ligeira instabilidade na ligação. Pode repetir?",
                'audio' => null,
                'data' => null
            ];
        }
    }

    private function executeFunction(string $name, array $args)
    {
        try {
            switch ($name) {
                case 'search_properties':
                    $query = Property::query()
                        ->where('is_visible', true)
                        ->where('status', '!=', 'Sold'); // Exemplo

                    if (!empty($args['location'])) {
                        $query->where('location', 'LIKE', "%{$args['location']}%");
                    }
                    
                    if (!empty($args['type'])) {
                        $query->where('type', 'LIKE', "%{$args['type']}%");
                    }

                    if (!empty($args['max_price'])) {
                        $price = preg_replace('/[^0-9]/', '', $args['max_price']);
                        $query->where('price', '<=', $price);
                    }

                    $properties = $query->latest()->limit(3)->get();

                    if ($properties->isEmpty()) return "Não encontrei imóveis com esses critérios exatos no nosso portfólio privado.";

                    return [
                        'summary' => "Encontrei " . $properties->count() . " opções exclusivas.",
                        'data' => $properties->map(function($p) {
                            return [
                                'id' => $p->id,
                                'title' => $p->title,
                                'price' => number_format($p->price, 0, ',', '.') . ' €',
                                'image' => $p->cover_image ? asset('storage/' . $p->cover_image) : asset('img/placeholder.jpg'),
                                'link' => route('properties.show', $p->slug)
                            ];
                        })
                    ];

                case 'schedule_meeting':
                    // Aqui podias enviar um email real. Por enquanto simulamos.
                    try {
                        $contact = $args['contact'] ?? 'Não informado';
                        Log::info("Lead Chatbot: " . $contact);
                    } catch (\Exception $e) {
                        Log::error("Mail Error: " . $e->getMessage());
                    }
                    return "O pedido de agendamento foi registado. A equipa entrará em contacto.";

                default:
                    return "Função desconhecida.";
            }
        } catch (\Exception $e) {
            return "Erro ao processar pedido: " . $e->getMessage();
        }
    }

    private function getToolsDefinition(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_properties',
                    'description' => 'Procurar imóveis para venda ou investimento.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'location' => ['type' => 'string', 'description' => 'Cidade ou zona (ex: Lisboa, Cascais)'],
                            'type' => ['type' => 'string', 'description' => 'Tipo (Apartamento, Moradia)'],
                            'max_price' => ['type' => 'number', 'description' => 'Preço máximo em euros'],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'schedule_meeting',
                    'description' => 'Agendar reunião ou pedir contacto para vender/comprar.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'contact' => ['type' => 'string', 'description' => 'Email ou telefone do utilizador'],
                            'reason' => ['type' => 'string'],
                        ],
                        'required' => ['contact'],
                    ],
                ],
            ],
        ];
    }
}