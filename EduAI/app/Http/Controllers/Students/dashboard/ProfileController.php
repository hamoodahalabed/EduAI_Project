<?php

namespace App\Http\Controllers\Students\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index()
    {
        $information = Student::findorFail(auth()->user()->id);
        $departments=Department::all();
        $years=Year::all();
        return view('pages.Students.dashboard.profile', compact('information','departments','years'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }



    public function update(Request $request, $id)
    {
        $request->validate([

            'Name_ar'=>'required',
            'Name_en'=>'required',
                    ]);
        // Find the student's information by ID
        $information = Student::findOrFail($id);
    
        // Update the student's name in English and Arabic
        $information->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
    
        // Check if a password was provided in the request and update if present
        if (!empty($request->password)) {
            $request->validate([

                'password' => [ 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/'],
    
            ]);
            $information->password = Hash::make($request->password);
        }
    
        // Update the student's year and department based on the request data
        $information->year_id = $request->year_id;
        $information->department_id = $request->department_id;
    
        // Save the changes to the database
        $information->save();
    
        // Show a success message
        toastr()->success(trans('messages.Update'));
    
        // Redirect back to the previous page
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        //
    }
}