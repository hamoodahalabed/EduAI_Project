<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position','wysiwyg_id','section_id','quiz_id'];
    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }
    // You can add any additional methods or relationships here
    public function students() {
        return $this->belongsToMany(Student::class, 'student_item');
    }
}