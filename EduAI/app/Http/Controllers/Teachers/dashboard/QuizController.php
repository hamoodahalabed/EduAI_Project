<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ExamCandidate;
use App\Models\Item;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Show;
use App\Models\Section;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index($current_id){
        if (auth('teacher')->check()){
            return view('pages.Teachers.Lesson.Quiz.quiz-list')->with([
                'quiz_list' => Quiz::all(),
                'current_id' => $current_id
            ]);
        }
        return view('user.quiz-list', compact('current_id'))->with([
            'quiz_list' => Quiz::join('questions', 'quizzes.id', '=', 'questions.quiz_id')->distinct('quizzes.id')
                ->select('quizzes.id as quiz_id', 'quizzes.*')
                ->get()
        ]);

    }


    public function addQuiz($current_id){
        $sections=Section::all();
        return view('pages.Teachers.Lesson.Quiz.add-quiz',compact('sections','current_id'));
    }

    public function storeQuiz(Request $request){

        $timestamp = time(); // get the current Unix timestamp
$dateString = date('Y-m-d H:i:s', $timestamp); // convert the timestamp to a string

$request->validate([
    'title' => 'required|max:220',
    'duration' => 'required|numeric|max:1000'
]);

        $quiz=Quiz::create([
            'title'=>$request->title,
            'from_time'=>$dateString,
            'to_time'=>$dateString ,
            'duration'=>$request->duration,
        ]);

 $destination_directory = public_path('attachments/Items');

 // New file name
 $new_file_name = time() . 'Quiz.txt';
 // Ensure the directory exists, create it if not
 if (!file_exists($destination_directory)) {
     mkdir($destination_directory, 0755, true);
 }
 file_put_contents($destination_directory . '/' . $new_file_name, '1');


 // Create a new Item instance and save it to the database
 $item = new Item();
 $item->name=$quiz->title;
 $item->section_id = $request->section_id;
  $item->file_name = $new_file_name;
  $item->quiz_id=$quiz->id;
 $item->save();
 $couresId=Section::findOrFail($request->section_id)->course_id;

 $countItem=0;
 $sections = Section::where('course_id', $couresId)->get();

 $items=Item::all();
 foreach($sections as $section)
 {

       foreach($items as $item)
       {
           if($item->section_id == $section->id)
           {
               $countItem++;
           }
       }

 }
 $course=Course::findOrFail($couresId);
 $course->item_counter = $countItem;
 $course->save(); // Ensure you save the course after updating item_counter
 $sections=Section::all();
 $current_id=$couresId;
 toastr()->success(trans('messages.success'));
 return view('pages.Teachers.Lesson.Quiz.add-quiz',compact('sections','current_id'));


    }

    public function editQuiz($id, $course_id, $item_id)
    {
        $quiz = quiz::find($id);
        $sections=Section::all();
        $item = Item::find($item_id);
        return view('pages.Teachers.Lesson.Quiz.edit-quiz', compact('quiz', 'course_id', 'item_id','sections','item'));
    }


        /**
         * Update the specified resource in storage.
         */
        public function updateQuiz(Request $request, $id,$course_id,$item_id)
        {
            $timestamp = time(); // get the current Unix timestamp
            $request->validate([
                'title' => 'required|max:220',
                
                'duration' => 'required|numeric|max:1000'
            ]);
            $quiz = quiz::find($id);
            $quiz->title=$request->title;
            $quiz->duration= $request->duration;
           $quiz->save();

     $destination_directory = public_path('attachments/Items');

     // New file name
     $new_file_name = time() . 'Quiz.txt';
     // Ensure the directory exists, create it if not
     if (!file_exists($destination_directory)) {
         mkdir($destination_directory, 0755, true);
     }
     file_put_contents($destination_directory . '/' . $new_file_name, '1');


     // Create a new Item instance and save it to the database
     $item = Item::find($item_id);
     $item->name=$quiz->title;
     $item->section_id = $request->section_id;

     $item->save();
                return redirect()->back()->with('success','Quiz: '.$request->title.' updated successfully!');

        }


   

    public function joinQuiz($id){
        $studentId = auth()->id(); // Get the logged-in student's ID
    
        ExamCandidate::create([
           'student_id'=>$studentId,
           'quiz_id'=>$id
        ]);
        $current_id = $id;
return view('pages.Teachers.Lesson.Quiz.user.give-quiz', compact('current_id'))
        ->with('quiz', Quiz::where('id', $id)->first())
        ->with('questions', Question::where('quiz_id', $id)->get())
        ->with('start_time', Carbon::now());

    }
}