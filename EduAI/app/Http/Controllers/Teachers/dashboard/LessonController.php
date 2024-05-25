<?php

namespace App\Http\Controllers\Teachers\dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\StoreLessonsRequest;
use App\Models\Course;
use App\Models\Department;

use App\Models\Year;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Section;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $Lesson;

    //  public function __construct(LessonRepositoryInterface $Lesson)
    //  {
    //      $this->Lesson = $Lesson;
    //  }

    public function index()
    {
    $departments = Department::all();
    $courses = Course::all();
   // $imag_dir="public\attachments\course";

    $imag_dir = asset('attachments/course');
    return view('pages.Teachers.Lesson.index', compact('courses', 'departments','imag_dir'));
    }
    public function editable($id)
    {
        $currentCourseTitle = Course::findOrFail($id)->title;

     $current_id=$id;
    $courses = Course::all();
    $items=Item::all();
    $sections=Section::all();
   

  
    return view('pages.Teachers.Lesson.lesson_management', compact('courses','current_id','items','sections','currentCourseTitle'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $years = Year::all();
        return view('pages.Teachers.lessons.create',compact('years','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(StoreLessonsRequest $request)
     {
       return $this->Lesson->StoreLessonsRequest($request);
     }

  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy(Request $request)
     {
         return $this->Lesson->DeleteLesson($request);
     }
    

     /**
     * Restore Lesson from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('lesson_delete')) {
            return abort(401);
        }

 
    }

     /**
     * Permanently delete Lesson from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
       


        return redirect()->back();
    }



}