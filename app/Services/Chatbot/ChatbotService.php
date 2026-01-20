<?php

namespace App\Services\Chatbot;

use OpenAI;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client as GuzzleClient;

class ChatbotService
{
    protected $client;

    public function __construct()
    {
        $apiKey = config('services.openai.key') ?? env('OPENAI_API_KEY');

        if (empty($apiKey)) {
            Log::critical('OpenAI API Key is missing.');
            return; 
        }

        // Timeout 60s para garantir geração de áudio
        $this->client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withHttpClient(new GuzzleClient(['timeout' => 60])) 
            ->make();
    }

    public function handleMessage(string $message, string $locale = 'pt', array $history = []): array
    {
        // 1. Mensagem de erro inicial traduzida se a API falhar
        if (!$this->client) {
            $msg = $locale === 'en' 
                ? 'The assistant is currently under maintenance.' 
                : 'O assistente está em manutenção momentânea.';
            
            return [
                'reply' => $msg,
                'audio' => null,
                'data'  => null
            ];
        }

        // 2. Obter definições de ferramentas no idioma correto
        $tools = $this->getToolsDefinition($locale);
        
        // 3. Obter o System Prompt (Personalidade) no idioma correto
        $systemPrompt = $this->getSystemPrompt($locale);

        // Limpar histórico (mantém apenas as últimas 6 mensagens)
        $cleanHistory = array_map(function($msg) {
            return ['role' => $msg['role'], 'content' => $msg['content'] ?? ''];
        }, array_slice($history, -6)); 

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $cleanHistory,
            [['role' => 'user', 'content' => $message]]
        );

        try {
            // Chamada à API
            $response = $this->client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'tools' => $tools,
                'tool_choice' => 'auto', 
            ]);

            $choice = $response->choices[0];
            $replyContent = $choice->message->content ?? '';
            $frontendData = null;

            // Se a IA decidiu chamar uma ferramenta
            if ($choice->finishReason === 'tool_calls') {
                $messages[] = $choice->message->toArray();

                foreach ($choice->message->toolCalls as $toolCall) {
                    $functionName = $toolCall->function->name;
                    $args = json_decode($toolCall->function->arguments, true);

                    // Executa a função passando o locale para traduzir a resposta do sistema
                    $toolResult = $this->executeFunction($functionName, $args, $locale);

                    // Se for busca, separa dados visuais do texto
                    if ($functionName === 'search_properties' && is_array($toolResult) && isset($toolResult['data'])) {
                        $frontendData = $toolResult['data'];
                        $toolResult = $toolResult['summary'];
                    }

                    $messages[] = [
                        'role' => 'tool',
                        'tool_call_id' => $toolCall->id,
                        'content' => is_string($toolResult) ? $toolResult : json_encode($toolResult)
                    ];
                }

                // Segunda chamada para gerar a resposta final
                $finalResponse = $this->client->chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                ]);

                $replyContent = $finalResponse->choices[0]->message->content;
            }

            // Fallback se a resposta vier vazia
            if (empty($replyContent)) {
                $replyContent = $locale === 'en' 
                    ? "Understood. Is there anything else I can assist you with?" 
                    : "Compreendido. Posso ajudar com algo mais?";
            }
            
            // --- GERAÇÃO DE ÁUDIO (TTS) ---
            $audioBase64 = $this->textToSpeech($replyContent);

            return [
                'reply' => $replyContent,
                'audio' => $audioBase64,
                'data'  => $frontendData
            ];

        } catch (\Exception $e) {
            Log::error("Chatbot Error: " . $e->getMessage());
            
            $errorMsg = $locale === 'en'
                ? "I apologize, but I'm experiencing a slight connection instability. Could you please repeat?"
                : "Peço desculpa, mas estou com uma ligeira instabilidade na ligação. Pode repetir?";

            return [
                'reply' => $errorMsg,
                'audio' => null,
                'data' => null
            ];
        }
    }

    /**
     * Define a Personalidade do Bot (System Prompt)
     */
    private function getSystemPrompt(string $locale): string
    {
        if ($locale === 'en') {
            return "
                You are the 'Private Virtual Assistant' for Porthouse, a high-end real estate agency in Portugal.
                
                BRANDING & TONE:
                - Identity: Exclusive, Heritage, Trust.
                - Tone: Professional, Executive, Discreet, and Expert.
                
                CRITICAL INSTRUCTIONS:
                1. You MUST speak in ENGLISH (British English preferred).
                2. Be concise but sophisticated. High-net-worth clients value time.
                3. Use 'search_properties' ONLY when the user asks for properties, houses, or investment opportunities.
                4. Use 'schedule_meeting' if the user wants to sell, talk to an agent, or schedule a visit.
                5. Do not invent property data. Only use what the tool returns.
                6. Currency is always Euros (€).
            ";
        }

        // Padrão: Português
        return "
            Tu és o 'Assistente Virtual Privado' da Porthouse, uma imobiliária de luxo em Portugal.
            
            BRANDING & TOM:
            - Identidade: Exclusividade, Legado, Confiança.
            - Tom: Profissional, Executivo, Discreto e Especialista.
            
            INSTRUÇÕES CRÍTICAS:
            1. Tens de falar em PORTUGUÊS DE PORTUGAL (Europeu).
               - Usa 'estou a fazer' em vez de 'estou fazendo'.
               - Usa 'connosco' em vez de 'conosco'.
               - Trata o utilizador com formalidade (implícita 'O senhor/A senhora').
            2. Sê conciso mas sofisticado. Clientes Private valorizam o tempo.
            3. Usa 'search_properties' APENAS quando pedirem imóveis ou investimentos.
            4. Usa 'schedule_meeting' se quiserem vender, falar com agente ou visitar.
            5. Nunca inventes dados. Usa apenas o que a ferramenta devolver.
        ";
    }

    private function executeFunction(string $name, array $args, string $locale)
    {
        try {
            switch ($name) {
                case 'search_properties':
                    $query = Property::query()->where('is_visible', true);

                    if (!empty($args['location'])) {
                        $query->where(function($q) use ($args) {
                            $q->where('location', 'LIKE', "%{$args['location']}%")
                              ->orWhere('city', 'LIKE', "%{$args['location']}%")
                              ->orWhere('title', 'LIKE', "%{$args['location']}%");
                        });
                    }
                    
                    if (!empty($args['type'])) {
                        $query->where('type', 'LIKE', "%{$args['type']}%");
                    }

                    if (!empty($args['max_price'])) {
                        $price = preg_replace('/[^0-9]/', '', $args['max_price']);
                        $query->where('price', '<=', $price);
                    }

                    $properties = $query->latest()->limit(3)->get();

                    if ($properties->isEmpty()) {
                        return $locale === 'en' 
                            ? "I couldn't find any properties matching those exact criteria in our private portfolio."
                            : "Não encontrei imóveis com esses critérios exatos no nosso portfólio privado.";
                    }

                    $summary = $locale === 'en'
                        ? "I found " . $properties->count() . " exclusive options for you."
                        : "Encontrei " . $properties->count() . " opções exclusivas.";

                    return [
                        'summary' => $summary,
                        'data' => $properties->map(function($p) {
                            return [
                                'id' => $p->id,
                                'title' => $p->title,
                                'price' => number_format($p->price, 0, ',', '.') . ' €',
                                'image' => $p->cover_image ? asset('storage/' . $p->cover_image) : 'https://placehold.co/600x400?text=Porthouse',
                                'link' => route('properties.show', $p->slug)
                            ];
                        })
                    ];

                case 'schedule_meeting':
                    try {
                        $contact = $args['contact'] ?? 'N/A';
                        $reason = $args['reason'] ?? 'Geral';
                        Log::info("Lead Chatbot [{$locale}]: [{$contact}] - {$reason}");
                    } catch (\Exception $e) {
                        Log::error("Lead Error: " . $e->getMessage());
                    }

                    return $locale === 'en'
                        ? "The scheduling request has been successfully registered. Our team will contact you shortly."
                        : "O pedido de agendamento foi registado com sucesso. A nossa equipa entrará em contacto brevemente.";

                default:
                    return "Function unknown.";
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    private function getToolsDefinition(string $locale): array
    {
        $descSearch = $locale === 'en' 
            ? 'Search for properties for sale or investment based on location, type, or price.'
            : 'Procurar imóveis para venda ou investimento com base em localização, tipo ou preço.';

        $descSchedule = $locale === 'en'
            ? 'Schedule a meeting, visit, or request commercial contact.'
            : 'Agendar reunião, visita ou pedir contacto comercial.';

        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_properties',
                    'description' => $descSearch,
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'location' => ['type' => 'string', 'description' => 'City or zone (e.g., Lisbon, Cascais)'],
                            'type' => ['type' => 'string', 'description' => 'Property type (Apartment, Villa, Land)'],
                            'max_price' => ['type' => 'number', 'description' => 'Maximum price in Euros'],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'schedule_meeting',
                    'description' => $descSchedule,
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'contact' => ['type' => 'string', 'description' => 'User email or phone'],
                            'reason' => ['type' => 'string', 'description' => 'Reason (Buy, Sell, Visit)'],
                        ],
                        'required' => ['contact'],
                    ],
                ],
            ],
        ];
    }

    private function textToSpeech(string $text): ?string
    {
        try {
            $inputText = mb_substr($text, 0, 4096);

            $response = $this->client->audio()->speech([
                'model' => 'tts-1',
                'input' => $inputText,
                'voice' => 'onyx', // Voz "Onyx"
                'response_format' => 'mp3',
                'speed' => 1.0
            ]);

            return base64_encode($response); 

        } catch (\Exception $e) {
            Log::error("Chatbot TTS Error: " . $e->getMessage());
            return null;
        }
    }
}