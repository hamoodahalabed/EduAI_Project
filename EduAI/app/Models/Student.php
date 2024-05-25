<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;
use App\Models\Course;

class Student extends Authenticatable
{
    use SoftDeletes;

    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];

    // علاقة بين الطلاب الاقسام لجلب اسم القسم في جدول الطلاب

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

     // علاقة بين الطلاب , السنوات لجلب اسم السنة في جدول الطلاب

     public function year()
     {
         return $this->belongsTo('App\Models\Year', 'year_id');
     }
    

     public function courses() {
        return $this->belongsToMany(Course::class, 'student_course');
    }
    
    public function quizzes() {
        return $this->belongsToMany(Quiz::class, 'exam_candidates');
    }
     
    public function result(){
        $this->hasMany(Quiz::class,'shows');
    }
    public function items() {
        return $this->belongsToMany(Item::class, 'student_item');
    }
}