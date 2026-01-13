<?php

namespace App\Http\Controllers;

use App\Services\Chatbot\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request, ChatbotService $bot)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array|nullable',
        ]);

        try {
            $response = $bot->handleMessage(
                $validated['message'],
                'pt', // Forçamos PT para consistência com o site
                $validated['history'] ?? []
            );

            return response()->json([
                'status' => 'success',
                'reply'  => $response['reply'],
                'data'   => $response['data'] // Cards de imóveis
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Controller Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Erro interno.'
            ], 500);
        }
    }
}