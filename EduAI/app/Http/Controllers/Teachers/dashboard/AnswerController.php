<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Show;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Section;
use App\Models\Student;
use App\Models\UserAnswer;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnswerController extends Controller
{

    public function store(Request $request)
    {
        $openai_api_key = getenv('OPENAI_API_KEY');
        try {

            $i = 0;
            $studentId = auth()->id();
            $student = auth()->user();
            $department = Department::findOrFail($student->department_id);
            $year = Year::findOrFail($student->year_id);
            $quiz_id = $request->quiz_id;
            $quiz = Quiz::findOrFail($quiz_id);

            $item = Item::where('quiz_id', $quiz_id)->first();
            $section = Section::find($item->section_id);

            if (Carbon::now() > Carbon::parse($request->start_time)->addMinutes($quiz->duration)) {
                return redirect()->route('Courses.editable', $section->course_id);
            }

            $db_answers = Question::where('quiz_id', $quiz_id)->get();

            $correct = 0;
            $total = $db_answers->count();
            $false_answer = [];
            $i = 0;

            foreach ($db_answers as $db_answer) {
                if ($db_answer->correct_option == $request->answer[$i + 1]) {
                    $correct++;
                } else {
                    if ($request->answer[$i + 1] == 'option_a') {
                        $false_answer[$i] = "The question is: " . $db_answer->question . " and the wrong answer is " . $db_answer->option_a;
                    }
                    if ($request->answer[$i + 1] == 'option_b') {
                        $false_answer[$i] = "The question is: " . $db_answer->question . " and the wrong answer is " . $db_answer->option_b;
                    }
                    if ($request->answer[$i + 1] == 'option_c') {
                        $false_answer[$i] = "The question is: " . $db_answer->question . " and the wrong answer is " . $db_answer->option_c;
                    }
                    if ($request->answer[$i + 1] == 'option_d') {
                        $false_answer[$i] = "The question is: " . $db_answer->question . " and the wrong answer is " . $db_answer->option_d;
                    }
                }
                $i++;
            }

            $show = Show::create([
                'student_id' => $studentId,
                'quiz_id' => $request->quiz_id,
                'quiz_score' => $total,
                'achieved_score' => $correct
            ]);

            $course = Course::find($section->course_id);

            $gpt_result = '';

            if (empty($false_answer)) {
                // All answers are correct
                $response = Http::withHeaders([
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . $openai_api_key,
                ])->post('https://api.openai.com/v1/chat/completions', [
                    "model" => "gpt-3.5-turbo-0125",
                    "messages" => [
                        ["role" => "system", "content" => "
                            Your name is EduAI. You are a specialized chatbot designed to assist students and instructors from the KASIT College at the University of Jordan in their learning and teaching endeavors. Your focus is on IT-related questions and materials, specifically within the academic and business IT departments. You possess expertise in IT, CIS, BIT, CS, AI, and DS, holding roles as professor, team leader, professional developer, and manager. You have extensive knowledge of IT books, internet content, and company operations. You provide detailed advice, materials, and innovative ideas for learning and teaching paths.
                            You are assisting a student who has recently completed a quiz and performed well. Your task is to analyze the quiz results and the student’s learning behavior. Congratulate the student on their success and suggest additional materials to further enhance their knowledge based on the quiz content and their learning behavior. The goal is to help the student build on their mastery of the quiz material.
                            the student info and learning info is:
                            its name make it english if its arabic:" . $student->name . ". its department in KASIT in University of Jordan is " . $department->Name . ". and its university year is " . $year->Name . " and some informations to help you
                            the student pressed on text " . $student->textClick . " and on image type " . $student->imageClick . " and on video " . $student->videoClick . " and on audio " . $student->audioClick . " and the course title is " . $course->title . ".
                        "],
                        ["role" => "user", "content" => "Congrats to the student who got full marks in the " . $quiz->title . " quiz!!"]
                    ]
                ])->json();
            } else {
                // Some answers are incorrect
                $wrong_answer = implode(', ', $false_answer);
                $response = Http::withHeaders([
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . $openai_api_key,
                ])->post('https://api.openai.com/v1/chat/completions', [
                    "model" => "gpt-3.5-turbo-0125",
                    "messages" => [
                        ["role" => "system", "content" => "
                            Your name is EduAI. You are a specialized chatbot designed to assist students and instructors from the KASIT College at the University of Jordan in their learning and teaching endeavors. Your focus is on IT-related questions and materials, specifically within the academic and business IT departments. You possess expertise in IT, CIS, BIT, CS, AI, and DS, holding roles as professor, team leader, professional developer, and manager. You have extensive knowledge of IT books, internet content, and company operations. You provide detailed advice, materials, and innovative ideas for learning and teaching paths.
                            You are assisting a student who has recently completed a quiz and made some incorrect answers. Your task is to analyze the quiz results, the incorrect answers, and the student’s learning behavior. Provide recommendations on what to watch, listen to, read, or study to address the knowledge gaps identified. Tailor your advice based on the detailed analysis of the student's performance and learning behavior.
                            the student info and learning info is:
                            its name make it english if its arabic: " . $student->name . ". its department in KASIT in University of Jordan is " . $department->Name . ". and its university year is " . $year->Name . " and some informations to help you
                            the student pressed on text " . $student->textClick . " and on image type " . $student->imageClick . " and on video " . $student->videoClick . " and on audio " . $student->audioClick . " and the course title is " . $course->title . ".
                        "],
                        ["role" => "user", "content" => $wrong_answer . ". Suggest for the student, based on the quiz name " . $quiz->title . ", what should the student study as topics from where (videos or books or images or voice or text, etc.) and from any course if it exists."]
                    ]
                ])->json();
            }

            // Store the concatenated GPT result in the database
            $gpt_result = $response['choices'][0]['message']['content'];

            $show->gpt_result = $gpt_result;
            $show->save();

            return redirect()->route('shows', $section->course_id)->with('success', 'Quiz done and result published');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.'], 500);
        }
    }
}