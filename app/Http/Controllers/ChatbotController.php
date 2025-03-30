<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $question = $request->input('question');

        // Kiểm tra nếu không có câu hỏi
        if (!$question) {
            return response()->json(['error' => 'Bạn chưa nhập câu hỏi.'], 400);
        }

        // Giả lập phản hồi từ chatbot
        $reply = "Chatbot phản hồi: " . $question;

        return response()->json(['reply' => $reply]);
    }
}
