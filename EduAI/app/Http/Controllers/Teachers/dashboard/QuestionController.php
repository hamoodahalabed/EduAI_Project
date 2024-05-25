<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function addQuestion($id){
        return view('pages.Teachers.Lesson.Quiz.add-questions')->with('quiz_list',Quiz::where('id',$id)->first())
            ->with('questions',Question::where('quiz_id',$id)->get())
            ->with('quiz_id',$id);
    }

    public function editQuestion($id, $quiz_id)
    {
         $quiz = quiz::find($id);
        $question = Question::find($id);
        $questions=Question::where('quiz_id',$id)->get();
        return view('pages.Teachers.Lesson.Quiz.edit-qustion', compact('question','quiz','questions'));
    }
    
    public function deleteQuestion($id)
    {
    $question = Question::findOrFail($id);
    $question->delete();
    return redirect()->back()->with('success', 'Question deleted successfully.');
    }
    public function updateQuestion(Request $request, $id,$quiz_id)
    {
        $request->validate([
            'question' => 'required|max:330',
            'option_a' => 'required|max:220',
            'option_b' => 'required|max:220',
            'option_c' => 'required|max:220',
            'option_d' => 'required|max:220',
            'correct_option' => 'required'
        ]);
        
        $question = Question::find($id);
        $question->question=$request->question;
        $question->option_a=$request->option_a;
        $question->option_b=$request->option_b;
        $question->option_c= $request->option_c;
        $question->option_d= $request->option_d;
        $question->correct_option= $request->correct_option;
       $question->save();
       return redirect()->back()->with('success','Question: '.$request->question.' updated successfully!');


    }





    
    public function storeQuestion(Request $request){
        $request->validate([
            'question' => 'required|max:330',
            'option_a' => 'required|max:220',
            'option_b' => 'required|max:220',
            'option_c' => 'required|max:220',
            'option_d' => 'required|max:220',
            'correct_option' => 'required'
        ]);
        
        if (Question::create([
            'quiz_id'=>$request->quiz_id,
            'Question'=>$request->question,
            'option_a'=>$request->option_a,
            'option_b'=>$request->option_b,
            'option_c'=>$request->option_c,
            'option_d'=>$request->option_d,
            'correct_option'=>$request->correct_option,
        ])){
            return redirect()->back()->with('success','Question added successfully!');
        }
        return redirect()->back()->with('error','Something wrong!');
    }

}