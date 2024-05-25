<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Models\User;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCoursesRequest;
use App\Http\Traits\AttachFilesTrait;
use App\Models\Department;
use App\Models\Image;
use App\Models\Item;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Support\Facades\DB;
use App\Repository\CourseRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DOMDocument;



class CourseController extends Controller
{
    use AttachFilesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $Course;

     public function __construct(CourseRepositoryInterface $Course)
     {
         $this->Course = $Course;
     }
 
    public function index()
    {
      
        $courses=Course::all();
        $counter=0;
        $imag_dir = asset('attachments/course');

        return view('pages.Teachers.courses.index',compact('courses','counter','imag_dir'));
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
        return view('pages.Teachers.courses.create',compact('years','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(StoreCoursesRequest $request)
     {
        $request->validate([
            'photos' => ['required', 'file'],
        ]);
        
      
       return $this->Course->StoreCoursesRequest($request);
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
        try {
            $course_department=Course::all();
            $departments = Department::all();
            $years = Year::all();
            $course = Course::findOrFail($id); // Retrieve course directly in the edit method
            return view('pages.Teachers.courses.edit', compact('departments', 'years', 'course','course_department'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    

    public function update(StoreCoursesRequest $request, Course $course)
{
    return $this->Course->UpdateCourses($request, $course);
}

     
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy(Request $request)
     {
         return $this->Course->DeleteCourse($request);
     }
   

     /**
     * Restore Course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

     /**
     * Permanently delete Course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
       

   
    

    public function course_overview()
    {
        $Courses=Course::all(); 
        $Item=Item::all();
          return view('course-overview',compact('Courses','Item'));
    }

    public function course_list()
    {
            
        $Courses=Course::all(); 
        $departments = Department::all();
          return view('course-list',compact('Courses'));
    }



    public function delete(Request $request)
    {
       
        try{
            $course=Course::findOrFail($request->id);
    
            // Delete img in server disk
            $courseId = $request->id;
           $sections = DB::table('sections')->where('course_id', $courseId)->get();
        
           // Initialize an empty array to store items
    $items = [];
    
    // Loop through each section and retrieve its associated items
        foreach ($sections as $section) {
        // Retrieve items associated with the current section
    
         $itemsInSection = Item::where('section_id', $section->id)->get();
    
        // Merge the items of this section with the overall items array
         $items = array_merge($items, $itemsInSection->toArray());
        }
    
            foreach ($items as $item) {
    
            // Perform any necessary operations before deleting (such as deleting associated files)
          
            Storage::disk('upload_attachments')->delete('attachments/Items/'.$item['file_name']);
    
            // Delete the item from the database
            if($item['wysiwyg_id']!=-1){
    
            $id=$item['wysiwyg_id'];
            $post = Post::find($id);
    
            $dom= new DOMDocument();
            $dom->loadHTML($post->description,9);
            $images = $dom->getElementsByTagName('img');
    
            foreach ($images as $key => $img) {
    
                $src = $img->getAttribute('src');
                $path = Str::of($src)->after('/');
    
    
                if (File::exists($path)) {
                    File::delete($path);
    
                }
    
            }}
    
        }
    
            Storage::disk('upload_attachments')->delete('attachments/course/'.$course->time_stamp.$course->title.'/'.$course->images->filename);
            Storage::disk('upload_attachments')->deleteDirectory('attachments/course/'.$course->time_stamp.$course->title);
            // Delete in data
            Image::where('id',$course->image_id)->delete();
            $course->delete();
            toastr()->success('Deleted Successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }
    }
    

    public function togglePublish($id)
{
    $course = Course::find($id);

    if ($course->published=="Active") {
       
        $course->published = false;
        $course->save();
    }

    else{    
      
        $course->published = true;
        $course->save();
    }

    return redirect()->back();
}
}