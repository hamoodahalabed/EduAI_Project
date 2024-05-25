<?php

namespace App\Http\Controllers\Students\dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\StoreLessonsRequest;
use App\Models\Course;
use App\Models\Student;

use App\Models\Department;

use App\Models\Year;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $Lesson;

   

public function index()
{
    $departments = Department::all();
    $userDepartmentId = Auth::user()->department_id; // Assuming you have department_id in your user model
    $years=Year::all();
    $courses = Course::all();

    $imag_dir = asset('attachments/course');

    return view('pages.Students.dashboard.courses.index', compact('courses', 'departments', 'imag_dir','years'));
}



    public function editable($id)
    {
    $currentCourseTitle = Course::findOrFail($id)->title;
     $current_id=$id;
    $courses = Course::all();
    $items=Item::all();
    $sections=Section::all();
  
    return view('pages.Students.dashboard.courses.lesson_management', compact('courses','current_id','items','sections','currentCourseTitle'));
    }

    public function show($id)
    {
        $currentCourseTitle = Course::findOrFail($id)->title;

     $current_id=$id;
 
    $sections=Section::all();
  
    return view('pages.Students.dashboard.courses.show_course', compact('current_id','sections','currentCourseTitle'));
    }

    

    public function add($id) {
        // Retrieve the course based on the provided id
        $course = Course::findOrFail($id);

        // Check if the course is already attached to the student
        if (auth()->user()->courses->contains($course)) {
            return redirect()->back()->with('warning', 'Course is already added.');
        }

        // Assuming you have a relationship between the User model and the Course model
        // You can add the course to the current user's list of courses
        auth()->user()->courses()->attach($course);

        return redirect()->back()->with('success', 'Course added successfully.');
    }

    public function remove($id) {
        // Retrieve the course based on the provided id
        $course = Course::findOrFail($id);

        // Check if the course is attached to the current user
        if (auth()->user()->courses->contains($course)) {
            // Detach the course from the current user
            auth()->user()->courses()->detach($course);
            return redirect()->back()->with('success', 'Course removed successfully.');
        } else {
            return redirect()->back()->with('error', 'Course not found in your list of courses.');
        }
    }


    public function myCourses() {
        $departments = Department::all();
        $courses = Course::all();
       // $imag_dir="public\attachments\course";
$years=Year::all();
        $imag_dir = asset('attachments/course');
        // Retrieve the current user's courses
        $courses = Auth::user()->courses()->get();

        // Return the view with the user's courses
        return view('pages.Students.dashboard.courses.my-courses', compact('courses', 'departments','imag_dir','years'));
    }
    public function myNewCourses() {
        $departments = Department::all();
        $courses = Course::all();
       // $imag_dir="public\attachments\course";
$years=Year::all();
        $imag_dir = asset('attachments/course');
        // Retrieve the current user's courses
        $courses = Auth::user()->courses()->get();

        // Return the view with the user's courses
        return view('pages.Students.dashboard.courses.my-new-courses', compact('courses', 'departments','imag_dir','years'));
    }

    public function myCompletedCourses() {
        $departments = Department::all();
        $courses = Course::all();
     
        $years=Year::all();
        $imag_dir = asset('attachments/course');
        // Retrieve the current user's courses
        $courses = Auth::user()->courses()->get();

        // Return the view with the user's courses
        return view('pages.Students.dashboard.courses.my-completed-courses', compact('courses', 'departments','imag_dir','years'));
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

    public function download($filename)
    {
        $filePath = public_path('attachments/items/'.$filename);
        $newFilename = substr($filename, 10); // Remove the first 10 letters from the filename
        return response()->download($filePath, $newFilename);
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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
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
    public function updateCheckbox(Request $request)
    {
        $itemId = $request->input('item_id');
        $isChecked = $request->input('checked'); // Get the actual value of the checkbox

        // Find the currently authenticated student
        $student = auth()->user(); // Assuming your authentication setup

        // Check if the student-item relationship exists and update it
        $student->items()->syncWithoutDetaching([$itemId => ['checked' => $isChecked]]);

        // Return a JSON response
        return response()->json(['message' => 'Checkbox updated successfully']);
    }


    public function updateCheckedItemsCounter(Request $request) {
        $studentId = auth()->user()->id;
        $courseId = $request->course_id;

        $checkedItemsCount = DB::table('student_item')
            ->where('student_id', $studentId)
            ->where('checked', 1)
            ->count();

        DB::table('student_course')
            ->where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->update(['checked_items_counter' => $checkedItemsCount]);

        return response()->json(['message' => 'Checked items counter updated successfully']);
    }
    public function updateClickCounter(Request $request)
    {
        $student = auth()->user(); // Assuming your authentication setup
        $clickType = $request->input('click_type');

        // Update the respective click counter based on the click type
        switch ($clickType) {
            case 'video':
                $student->videoClick++;
                break;
            case 'image':
                $student->imageClick++;
                break;
            case 'audio':
                $student->audioClick++;
                break;
            case 'document':
                $student->textClick++;
                break;
            default:
                // Invalid click type
                return response()->json(['error' => 'Invalid click type'], 400);
        }

        // Save the updated click counters
        $student->save();

        // Return a success response
        return response()->json(['message' => 'Click counter updated successfully']);
    }
}