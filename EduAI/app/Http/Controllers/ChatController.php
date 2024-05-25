<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatController extends Controller
{
    /**
     * Handle incoming chat messages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request)
    {
       
        $student = auth()->user();
        $department=Department::find($student->department_id);
        $year = Year::find($student->year_id);
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

You are assisting a student based on their previous interaction and last result. Continue the conversation by analyzing the student’s past performance and learning behavior. Be ready to engage and provide tailored support and guidance according to the last provided information. Your goal is to help the student progress further based on their last result and ongoing learning needs.

                    
                    You have to tell the student right answer for the questions which is wrong if isnt exist just guess it"."The student is studying in the IT department, specifically in the " . $department->Name . " department, if its arabic make it english., in the year " . $year->Name . ". The students name is".$student->name.". If the student's name is Arabic, please use English."."Your last suggestion or assist for this student last quiz result was ".trim($request->input('finalResult')." now chat with this student")],
                    ["role" => "user", "content" => trim($request->input('message'))]
                ]
            ])->json();

            return response()->json(['message' => $response['choices'][0]['message']['content']]);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.'], 500);
        }
    }

    /**
     * Start a chat session for the student.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   

    public function startChat(Request $request)
    {
    }
    
}