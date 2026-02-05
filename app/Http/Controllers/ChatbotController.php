<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat(Request $request)
{
    // Normalize message input
    $message = trim(strtolower($request->input('message')));

    

    // Predefined responses
    $responses = [
        "hello" => "Hi there! How can I help?",
        "how are you" => "I'm a bot, always good!",
        "bye" => "Goodbye! Have a great day!",
        "thanks" => "You're welcome!",
        "who are you" => "I'm a chatbot here to assist you!"
    ];

    // Check for an exact match first
    $reply = $responses[$message] ?? null;

    // If no exact match, attempt fuzzy matching
    if (!$reply) {
        foreach ($responses as $key => $response) {
            if (similar_text($message, $key) > 4) { // If message is close enough
                $reply = $response;
                break;
            }
        }
    }

    // If still no match, use default response & log the unknown input
    if (!$reply) {
        \Log::info("Unrecognized message: " . $message);
        $reply = "I didn't understand that. Can you rephrase?";
    }

    return response()->json(['reply' => $reply]);
}

}
