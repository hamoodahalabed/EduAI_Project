<!-- <?php

// namespace App\Repository;

// use App\Http\Requests\StoreLessonsRequest;
// use App\Models\Lesson;
// use Illuminate\Support\Facades\Hash;

// class LessonRepository implements LessonRepositoryInterface{

//     public function StoreLessonsRequest(StoreLessonsRequest $request){

//     try {
//             $Lessons = new Lesson();
//             $Lessons->description = $request->description;
//             $Lessons->title = $request->title;
//             $Lessons->course_image = $request->course_image;
//             $Lessons->published = $request->published;
//             $Lessons->year_id = $request->years;
//             $Lessons->teacher_id = $request->teacher_id;
//             $Lessons->save();
//             // Attach selected departments to the newly created course
//            $Lessons->Department()->attach($request->departments);
//             toastr()->success(trans('messages.success'));
//             return redirect()->back();
//         }
//         catch (\Exception $e) {
//             return redirect()->back()->with(['error' => $e->getMessage()]);
//         }

//     }


    // public function editLesson($id)
    // {
    //     return Lesson::findOrFail($id);
    // }


//     public function UpdateLessons($request, $course)
// {
//     try {
//         // Use find instead of findOrFail
//         $course = Lesson::find($request->id);

//         if (!$course) {
//             // Handle the case where the course is not found
//             return redirect()->back()->with(['error' => 'Lesson not found']);
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

    // public function UpdateLessons($request, $course)
    // {
    //     try {
    //         $course = Lesson::findOrFail($request->id);
    //         $course->description = $request->description;
    //         $course->title = $request->title;
    //         if(!$request->course_image === null)
    //         $course->course_image = $request->course_image;
    //         $course->published = $request->published;
    //         $course->year_id = $request->years;
    //         $course->teacher_id = $request->teacher_id;
    //         $course->save();
    //      $course->Department()->detach();

    //            // Attach selected departments to the newly created course
    //        $course->Department()->attach($request->departments);

            
            // Sync selected departments with the course
            // if ($request->has('departments')) {
            //     $course->departments()->sync($request->departments);
            // } else {
            //     // If no departments are selected, detach all departments
            //     $course->departments()->detach();
            // }
    
    //         toastr()->success(trans('messages.Update'));
    //         return redirect()->back();
    //      } catch (\Exception $e) {
    //        return redirect()->back()->with(['error' => $e->getMessage()]);
    //     }
    // }
    // public function DeleteLesson($request)
    // {
    //     Lesson::findOrFail($request->id)->delete();
    //     toastr()->error(trans('messages.Delete'));
    //     return redirect()->back();
    // }



// } -->