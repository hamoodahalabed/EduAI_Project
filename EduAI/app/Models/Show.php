<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Show extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['student_name'];

    protected $fillable=[
      'student_id',
      'quiz_id',
      'quiz_score',
      'achieved_score',
      'gpt_result'
    ];

   
}