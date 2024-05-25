<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_image',
        'published',
        'year_id',
        'department_id',
        'teacher_id',
        'image_id',
        'time_stamp',
        'item_counter'
    ];

       // علاقة بين الطلاب والصور لجلب اسم الصور  في جدول الطلاب
       public function images()
       {
           return $this->belongsTo('App\Models\Image', 'image_id');
       }

    public function Department(){
        return $this->belongsToMany(Department::class, 'course_department');
    }

    public function year()
    {
        return $this->belongsTo('App\Models\Year', 'year_id');
    }

    

    public function Teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id');
    }


    public function getPublishedAttribute($attribute){
        return [
            0 => 'Inactive',
            1 => 'Active'
        ][$attribute];
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'student_course');
    }
    
    



}