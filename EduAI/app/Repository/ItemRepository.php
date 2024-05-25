<?php

namespace App\Repository;

use App\Http\Requests\StoreCoursesRequest;
use App\Http\Traits\AttachFilesTrait;
use App\Models\Course;
use App\Models\Image;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Quiz;
use App\Models\Section;
use DOMDocument;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class ItemRepository implements ItemRepositoryInterface{
    use AttachFilesTrait;


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

    public function create($current_id)
    {
        $sections=Section::all();
       return view('pages.Teachers.Lesson.create',compact('sections','current_id'));
    }
    public function create_Youtube_URL($current_id)
    {
        $sections=Section::all();
        return view('pages.Teachers.Lesson.create_Youtube_URL',compact('sections','current_id'));
    }

    public function store($request)
    {
        try {
            if($request->youtube_url === null){
            $file=$request->file('file_name');
            $item = new Item();
            $item->name = $request->title;
            $item->section_id = $request->section_id;
            // $item->file_name =time().$request->file('file_name')->getClientOriginalName();
            // $item->save();
             // Get original filename without extension
             $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

             // Remove non-English letters and spaces
             $englishFilename = preg_replace('/[^a-zA-Z\s]/', '', $originalFilename);

             // If English filename is empty, use a generic name
             if (empty(trim($englishFilename))) {
                $englishFilename = 'new_file' ;
             }

             // Append current timestamp to ensure uniqueness
             $item->file_name = time() . $englishFilename.'.'.$file->getClientOriginalExtension();
             $item->save();
          //  $this->uploadFile($request,'file_name','Items');
          $file->storeAs('attachments/Items',$item->file_name,'upload_attachments');
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
         toastr()->success(trans('messages.success'));
            return redirect()->route('Item.create',$course->id);
        }


        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function storeURL($request)
    {
        try {
            if ($request->has('youtube_url')) {
                // Call convertToEmbedUrl function to get the embed URL from YouTube URL
                $embedUrl = $this->convertToEmbedUrl($request->youtube_url);

                if ($embedUrl) {
                    // Destination directory
                    $destination_directory = public_path('attachments/Items');

                    // New file name
                    $new_file_name = time() . 'Youtube_Video.txt';
                    $embedUrl='$2y$10$icrfILR/E1R9cV0AGrYw.OgJm6mylyyI8sS6jaTXn896e75CCP/Fq'.$embedUrl;
                    // Ensure the directory exists, create it if not
                    if (!file_exists($destination_directory)) {
                        mkdir($destination_directory, 0755, true);
                    }

                    // Check if the file already exists
                    if (file_exists($destination_directory . '/' . $new_file_name)) {
                        // If the file exists, open it and append the embed URL
                        file_put_contents($destination_directory . '/' . $new_file_name, PHP_EOL . $embedUrl);
                    } else {
                        // If the file doesn't exist, create a new file and write the embed URL
                        file_put_contents($destination_directory . '/' . $new_file_name, $embedUrl);
                    }

                    // Create a new Item instance and save it to the database
                    $item = new Item();
                    $item->name = $request->title;
                    $item->section_id = $request->section_id;
                    $item->file_name = $new_file_name;
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

                    toastr()->success(trans('messages.success'));
                    return redirect()->route('Item.create_youtube_url',$course->id);
                } else {
                    return "Failed to generate embed URL from YouTube URL";
                }
            } else {
                return "No YouTube URL provided";
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

// Function to convert YouTube URL to embed URL
private function convertToEmbedUrl($url)
{
    // Regular expression pattern to extract video ID from YouTube URL
    $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=|shorts\/)|(youtu\.be\/|m\.youtube\.com\/))(?P<video_id>[a-zA-Z0-9_-]+)/';

    // Match the pattern in the URL
    preg_match($pattern, $url, $matches);

    // Check if a video ID is found
    if (isset($matches['video_id'])) {
        // Construct the embed URL
        $embedUrl = 'https://www.youtube.com/embed/' . $matches['video_id'];
        return $embedUrl;
    } else {
        // If no video ID is found, return null or handle accordingly
        return null;
    }
}


    // public function download($filename)
    // {
    //     return response()->download(public_path('attachments/items/'.$filename));
    // }
    public function download($filename)
    {
        $filePath = public_path('attachments/items/'.$filename);
        $newFilename = substr($filename, 10); // Remove the first 10 letters from the filename
        return response()->download($filePath, $newFilename);
    }

    // public function destroyItem($request)
    // {
    //     $this->deleteFile($request->file_name);
    //     Item::destroy($request->id);
    //     toastr()->error(trans('messages.Delete'));
    //     return redirect()->back();
    // }

    // public function destroyItem($request)
    // {
    //     try {
    //         $item = Item::findorFail($request);

    //         // Perform any necessary operations before deleting (such as deleting associated files)
    //         //$this->deleteFile($request->file_name);
    //         Storage::disk('upload_attachments')->delete('attachments/Items/'.$item->file_name);

    //         // Delete the item from the database
    //         Item::destroy($item->id);

    //         // Optionally, you can add a success message using toastr or any other messaging system
    //         toastr()->success(trans('messages.Delete'));

    //         // Redirect back to the previous page
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         // If an error occurs during the deletion process, catch the exception and handle it appropriately
    //         toastr()->error(trans('messages.Error'));

    //         // Redirect back to the previous page
    //         return redirect()->back();
    //     }
    // }
    public function destroy($request)
{

    // Call the destroy method of the ItemRepository
    try {
        $item = Item::findOrFail($request->id);

        // Perform any necessary operations before deleting (such as deleting associated files)
        // $this->deleteFile($item->file_name);
        Storage::disk('upload_attachments')->delete('attachments/Items/'.$item->file_name);
        $couresId=Section::findOrFail($item->section_id)->course_id;
        $course=Course::findOrFail($couresId);

        // $course=Course::findOrFail($couresId);
        $course->item_counter-=1;
        $course->save(); // Ensure you save the course after updating item_counter
        // Delete the item from the database
        if($item->wysiwyg_id!=-1){

        $id=$item->wysiwyg_id;
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
        }

        $post->delete();

    }
    if($item->quiz_id!=-1){

        $id=$item->quiz_id;
        $quiz = Quiz::find($id);

        $quiz->delete();
    }
        $item->delete();

        // Optionally, you can add a success message using toastr or any other messaging system
            toastr()->success(trans('messages.Delete'));

        // Redirect back to the previous page
        return redirect()->back();
    } catch (\Exception $e) {
        // If an error occurs during the deletion process, catch the exception and handle it appropriately
        toastr()->error(trans('messages.Error'));

        // Redirect back to the previous page
        return redirect()->back();
    }}




    public function edit($id,$current_id)
    {
        $item = Item::findorFail($id);
        $sections=Section::all();
        return view('pages.Teachers.Lesson.edit',compact('item','sections','current_id'));
    }


    // public function update($request)
    // {
    //     try {

    //         $item = Item::findorFail($request->id);
    //         $item->name = $request->title;

    //         if($request->hasfile('file_name')){

    //             $this->deleteFile($item->file_name);

    //             $this->uploadFile($request,'file_name','items');

    //             $file_name_new = $request->file('file_name')->getClientOriginalName();
    //             $item->file_name = $item->file_name !== $file_name_new ? $file_name_new : $item->file_name;
    //         }
    //         $item->save();
    //         toastr()->success(trans('messages.Update'));
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with(['error' => $e->getMessage()]);
    //     }
    // }
    public function update($request)
    {
        try {
            $item = Item::findOrFail($request->id);
            $item->name = $request->title;
            $item->section_id = $request->section_id;
            if ($request->hasFile('file_name')) {
                $file=$request->file('file_name');

                // Delete the old file
              //  $this->deleteFile($item->file_name);
                Storage::disk('upload_attachments')->delete('attachments/Items/'.$item->file_name);

                // Upload the new file
               // $this->uploadFile($request, 'file_name', 'items');
            //    $item->file_name =time().$request->file('file_name')->getClientOriginalName();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Remove non-English letters and spaces
            $englishFilename = preg_replace('/[^a-zA-Z\s]/', '', $originalFilename);

            // If English filename is empty, use a generic name
            if (empty(trim($englishFilename))) {
               $englishFilename = 'new_file' ;
            }

            // Append current timestamp to ensure uniqueness
            $item->file_name = time() . $englishFilename.'.'.$file->getClientOriginalExtension();
           // $item->save();
               $file->storeAs('attachments/Items',$item->file_name,'upload_attachments');
                // Update the file name in the database
                // $item->file_name = $request->file('file_name')->getClientOriginalName();
            }

            $item->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }












    public function Upload_attachment($request)
    {
        foreach($request->file('photos') as $file)
        {
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/students/'.$request->student_name, $file->getClientOriginalName(),'upload_attachments');

            // insert in image_table
            $images= new image();
            $images->filename=$name;
            $images->imageable_id = $request->student_id;
            $images->imageable_type = 'App\Models\Student';
            $images->save();
        }
        toastr()->success(trans('messages.success'));
        return redirect()->route('Students.show',$request->student_id);
    }


}
