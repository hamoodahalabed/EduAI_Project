<?php
 namespace App\Http\Controllers\Teachers\dashboard;
 use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Item;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Section;
use DOMDocument;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('pages.Teachers.Lesson.WYSIWYG.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $sections=Section::all();
        return view('pages.Teachers.Lesson.WYSIWYG.create',compact('id','sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id)
    {
        $description = $request->description;

        $dom = new DOMDocument();
        $dom->loadHTML($description,9);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $data = base64_decode(explode(',',explode(';',$img->getAttribute('src'))[1])[1]);
            $image_name = "/upload/" . time(). $key.'.png';
            file_put_contents(public_path().$image_name,$data);

            $img->removeAttribute('src');
            $img->setAttribute('src',$image_name);
        }
        $description = $dom->saveHTML();
 $post=new Post();
 $post->title=$request->title;
 $post->description=$description;
 $post->save();

 $destination_directory = public_path('attachments/Items');

 // New file name
 $new_file_name = time() . 'WYSIWYG.txt';
 // Ensure the directory exists, create it if not
 if (!file_exists($destination_directory)) {
     mkdir($destination_directory, 0755, true);
 }
 file_put_contents($destination_directory . '/' . $new_file_name, '1');


 // Create a new Item instance and save it to the database
 $item = new Item();
 $item->name=$post->title;
 $item->section_id = $request->section_id;
  $item->file_name = $new_file_name;
  $item->wysiwyg_id=$post->id;
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
 $course->save(); // Ensure you save the course after updating item_counter         // Post::create([
     

        return redirect()->route('lesson.editable',$id);
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $course_id, $item_id)
{
    $post = Post::find($id);
    $sections=Section::all();
    $item = Item::find($item_id);
    return view('pages.Teachers.Lesson.WYSIWYG.edit', compact('post', 'course_id', 'item_id','sections','item'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id,$course_id,$item_id)
    {
        $post = Post::find($id);
        $item = Item::find($item_id);

        $description = $request->description;

        $dom = new DOMDocument();
        $dom->loadHTML($description,9);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {

            // Check if the image is a new one
            if (strpos($img->getAttribute('src'),'data:image/') ===0) {

                $data = base64_decode(explode(',',explode(';',$img->getAttribute('src'))[1])[1]);
                $image_name = "/upload/" . time(). $key.'.png';
                file_put_contents(public_path().$image_name,$data);

                $img->removeAttribute('src');
                $img->setAttribute('src',$image_name);
            }

        }
        $description = $dom->saveHTML();

        $post->update([
            'title' => $request->title,
            'description' => $description
        ]);
            $item->name=$request->title;
            $item->section_id = $request->section_id;
            $item->save();
        return redirect()->route('lesson.editable',$course_id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
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
}