<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Http\Traits\AttachFilesTrait;
use App\Models\Course;
use DOMDocument;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Item;
class SectionController extends Controller
{
    use AttachFilesTrait;
    public function index()
    {
        $sections = Section::all();
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        return view('sections.create');
    }

    public function store(Request $request)
{

    $request->validate([
        'name' => 'required|string|max:255',
        'course_id'=>'required',
    ]);

    Section::create([
        'name' => $request->name,
        'course_id' => $request->course_id,
    ]);

    return redirect()->back()->with('success', 'Section created successfully.');
}

    public function show(Section $section)
    {
        return view('sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }
    public function updateOrder(Request $request)
{
    try {
        // Retrieve the section_order from the request

        $sectionOrder = $request->input('section_order');

                $i=0;
        // Loop through the section_order array and update the positions in the database
        foreach ($sectionOrder as $sectionId) {

            $section = Section::findOrFail($sectionId["id"]);

            $section->position =   $i;
            $i++;
            $section->save();
        }

        // Return a JSON response indicating success
        return redirect()->back()->with('success', 'Section updated successfully');
    } catch (\Exception $e) {
        // Log the exception message
        Log::error('Error updating section order: ' . $e->getMessage());

        // Return a JSON response with an error message
        return redirect()->back()->with('success', 'Section updated successfully');
    }
}


    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:sections,name,'.$request->id,
        ]);

        $section = Section::findOrFail($request->id);
        $section->name = $request->name;

        $section->update($validatedData);

        return redirect()->back()->with('success', 'Section updated successfully');
    }

    public function destroy(Request $request)
    {
        $items = Item::where('section_id', $request->id)->get();
        $course=Course::findOrFail(Section::findOrFail($request->id)->course_id);
        $countItem=$course->item_counter;
        foreach ($items as $item) {

        // Perform any necessary operations before deleting (such as deleting associated files)
       
        Storage::disk('upload_attachments')->delete('attachments/Items/'.$item->file_name);
        $countItem--;
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
        }}}

        $course->item_counter = $countItem;
        $course->save();

        $section = Section::find($request->id);
        $section->delete();
        toastr()->success(trans('messages.Delete'));
        return redirect()->back();
   
    }
}