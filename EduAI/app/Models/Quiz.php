<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable=[
      'title',
      'duration',
      'from_time',
      'to_time',
    ];

    public function question(){
        $this->hasMany(Question::class);
    }

    public function result(){
        $this->hasMany(Student::class,'shows');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'exam_candidates');
    }
}