<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasTranslations;
    public $translatable = ['Name'];
    protected $fillable =['Name'];

    public function courses()
{
    return $this->belongsToMany(Course::class, 'course_department');
}
}