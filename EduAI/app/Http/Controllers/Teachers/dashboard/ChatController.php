<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatController extends Controller
{
    public function index()
    {
        return view("pages.Teachers.Chatbot.chatBot");
    }

    public function startChat(Request $request)
    {
    }

    public function chat(Request $request)
    {
        // Get the authenticated teacher
        $teacher = auth()->user();
        $openai_api_key = getenv('OPENAI_API_KEY');
        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ".$openai_api_key, // Replace with your actual secret key
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => "gpt-3.5-turbo-0125", // Use the correct model name
                "messages" => [
                    ["role" => "system", "content" => "
                        Your name is EduAI. You are a specialized chatbot designed to assist students and instructors from the KASIT College at the University of Jordan in their learning and teaching endeavors. Your focus is on IT-related questions and materials, specifically within the academic and business IT departments. You possess expertise in IT, CIS, BIT, CS, AI, and DS, holding roles as professor, team leader, professional developer, and manager. You have extensive knowledge of IT books, internet content, and company operations. You provide detailed advice, materials, and innovative ideas for learning and teaching paths.
                        
                        You are assisting an instructor with their teaching responsibilities. Be ready to help the instructor with creating learning materials, quizzes, and course content. Provide support for both learning and teaching tasks, offering detailed advice and innovative ideas to enhance the instructor’s ability to teach effectively.
                        The instructor's name is " . $teacher->Name . ". If it was Arabic, make it English and go ahead and chat with him.
                    "],
                    ["role" => "user", "content" => trim($request->input('message'))]
                ]
            ])->json();

            return response()->json(['message' => $response['choices'][0]['message']['content']]);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.'], 500);
        }
    }
}