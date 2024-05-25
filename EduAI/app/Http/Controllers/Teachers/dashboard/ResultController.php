<?php



namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Show;
use Illuminate\Http\Request;

class ResultController extends Controller
{

public function index($current_id)
{
    $studentId = auth()->id();

    if (auth('teacher')->check()) {
        $shows = Show::join('quizzes', 'shows.quiz_id', 'quizzes.id')
            ->join('students', 'shows.student_id', '=', 'students.id')
            ->select('shows.*', 'quizzes.title', 'students.name as student_name')
            ->get();

        return view('pages.Teachers.Lesson.Quiz.user.result-page', compact('shows','current_id'));
    }

    $shows = Show::join('quizzes', 'shows.quiz_id', 'quizzes.id')
        ->join('students', 'shows.student_id', '=', 'students.id')
        ->select('shows.*', 'quizzes.title', 'students.name as student_name')
        ->where('student_id', $studentId)
        ->get();

    return view('pages.Teachers.Lesson.Quiz.user.result-page', compact('shows','current_id'));
}



}