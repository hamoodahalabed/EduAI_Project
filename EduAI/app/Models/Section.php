<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name','course_id','position'];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }
}
