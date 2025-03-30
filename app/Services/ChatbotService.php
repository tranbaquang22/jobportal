<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChatbotService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function getResponse($message)
    {
        if (!$this->apiKey) {
            return "API Key chưa được cấu hình.";
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type'  => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model'    => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là trợ lý chatbot hỗ trợ người dùng.'],
                ['role' => 'user', 'content' => $message],
            ],
            'max_tokens' => 100,
        ]);

        if ($response->failed()) {
            return "Lỗi khi gọi API OpenAI.";
        }

        return $response->json()['choices'][0]['message']['content'] ?? 'Không nhận được phản hồi.';
    }
}
