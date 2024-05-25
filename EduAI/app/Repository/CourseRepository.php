<?php

namespace App\Repository;

use App\Http\Requests\StoreCoursesRequest;
use App\Http\Traits\AttachFilesTrait;
use App\Models\Course;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Item;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class CourseRepository implements CourseRepositoryInterface{
    use AttachFilesTrait;

    public function StoreCoursesRequest(StoreCoursesRequest $request){

    try {
            $Courses = new Course();
            $Courses->description = $request->description;
            $Courses->title = $request->title;
            $Courses->published = $request->published;
            $Courses->year_id = $request->years;
            $Courses->teacher_id = $request->teacher_id;
            $Courses->time_stamp=time();

        $file=$request->file('photos');
        // $name = time().'.'.$file->getClientOriginalName();
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Remove non-English letters and spaces
        $englishFilename = preg_replace('/[^a-zA-Z\s]/', '', $originalFilename);

        // If English filename is empty, use a generic name
        if (empty(trim($englishFilename))) {
           $englishFilename = 'new_file' ;
        }

        // Append current timestamp to ensure uniqueness
        $name = time() . $englishFilename.'.'.$file->getClientOriginalExtension();
        $file->storeAs('attachments/course/'.$Courses->time_stamp.$Courses->title,$name,'upload_attachments');

        // insert in image_table
        $images = new Image();
        $images->filename=$name;
        // $images->imageable_id = $Courses->id;
       // $images->imageable_type = 'App\Models\Course';
        $images->save();
        //$images = DB::table('images')->where('filename', $name)->first();
        $Courses->image_id=$images->id;
        $Courses->save();
           // Attach selected departments to the newly created course
           $Courses->Department()->attach($request->departments);

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function editCourse($id)
    {
        return Course::findOrFail($id);
    }


//     public function UpdateCourses($request, $course)
// {
//     try {
//         // Use find instead of findOrFail
//         $course = Course::find($request->id);

//         if (!$course) {
//             // Handle the case where the course is not found
//             return redirect()->back()->with(['error' => 'Course not found']);
//         }

//         // Update course attributes
//         $course->description = $request->description;
//         $course->title = $request->title;
//         $course->course_image = $request->course_image;
//         $course->published = $request->published;
//         // $course->year_id = $request->years;
//         $course->teacher_id = $request->teacher_id;
//         $course->save();

//         // Other logic...

//         toastr()->success(trans('messages.Update'));
//         return redirect()->back();
//     } catch (\Exception $e) {
//         return redirect()->back()->with(['error' => $e->getMessage()]);
//     }
// }
    public function DeleteCourse($request)
    {

        try{
        $course=Course::findOrFail($request->id);

        // Delete img in server disk
        $courseId = $request->id;
       $sections = DB::table('sections')->where('course_id', $courseId)->get();
        //$sections=Section::all()->where('course_id',$courseId);
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
        // $this->deleteFile($item->file_name);
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

    public function UpdateCourses($request, $course)
    {
        try {
            $course = Course::findOrFail($request->id);
            $oldFolderName = $course->time_stamp.$course->title;

            $course->description = $request->description;
            $course->title = $request->title;
            $course->published = $request->published;
            $course->year_id = $request->years;
            $course->teacher_id = $request->teacher_id;


            if ($oldFolderName !== $request->title) {
                $course->time_stamp=time();
                $oldFolderPath = 'attachments/course/' . $oldFolderName;
                $newFolderPath = 'attachments/course/' .$course->time_stamp. $course->title;
                Storage::disk('upload_attachments')->move($oldFolderPath, $newFolderPath);
            }

            if ($request->course_image != null) {
                Storage::disk('upload_attachments')->delete('attachments/course/'.$course->time_stamp .$course->title.'/'.$course->images->filename);
                // Upload new image file
                $file = $request->file('course_image');
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                // Remove non-English letters and spaces
                $englishFilename = preg_replace('/[^a-zA-Z\s]/', '', $originalFilename);
    
                // If English filename is empty, use a generic name
                if (empty(trim($englishFilename))) {
                   $englishFilename = 'new_file' ;
                }
    
                // Append current timestamp to ensure uniqueness
                $name = time() . $englishFilename.'.'.$file->getClientOriginalExtension();
                //$item->save();
               // $name = time().'.'.$file->getClientOriginalName();
                $file->storeAs('attachments/course/'.$course->time_stamp .$course->title, $name, 'upload_attachments');

                // Update filename of the existing image record
                $image = Image::findOrFail($course->image_id);
                $image->filename = $name;
                $image->save();
            }

            $course->save();

            // Attach selected departments to the newly created course
            $course->Department()->detach();
            $course->Department()->attach($request->departments);

            toastr()->success(trans('messages.Update'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



}