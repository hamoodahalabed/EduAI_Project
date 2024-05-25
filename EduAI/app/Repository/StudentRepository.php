<?php

namespace App\Repository;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Year;


class StudentRepository implements StudentRepositoryInterface{


    public function Get_Student()
    {
        $students = Student::all();
        return view('pages.Students.index',compact('students'));
    }

    public function Edit_Student($id)
    {
        
        $Students =  Student::findOrFail($id);
        $departments = Department::all();
        $years = Year::all();
        return view('pages.Students.edit',compact('Students','departments','years'));
    }

    public function Update_Student($request)
    {
        try {
           
                        $Edit_Students = Student::findorfail($request->id);
                        if (!empty($request->password)) {
                            $request->validate([
                
                                'password' => [ 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/'],
                    
                            ]);
                            $Edit_Students->password = Hash::make($request->password);
                        }
                    
         
            $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $Edit_Students->email = $request->email;
            $Edit_Students->department_id = $request->department_id;
            $Edit_Students->year_id = $request->year_id;
            // $Edit_Students->password = Hash::make($request->password);
            $Edit_Students->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Students.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function Create_Student(){

    
       $data['departments'] = Department::all();
       $data['years'] = Year::all();
       return view('pages.Students.add',$data);

    }

    public function Show_Student($id)
    {
        $Student = Student::findorfail($id);
        return view('pages.Students.show',compact('Student'));
    }


   

    public function Store_Student($request){

        $request->validate([

            'password'=>'required',
                    ]);
        DB::beginTransaction();

        try {
            $students = new Student();
            if (!empty($request->password)) {
                $request->validate([
    
                    'password' => [ 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/'],
        
                ]);
                $students->password = Hash::make($request->password);
            }
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->department_id= $request->department_id;
            $students->year_id= $request->year_id;
            $students->save();
            DB::commit(); // insert data
            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.create');

        }

        catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function Delete_Student($request)
    {

        Student::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.index');
    }


 



}