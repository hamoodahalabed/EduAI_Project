<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class Teacher extends  Authenticatable
{
    use HasTranslations;
    public $translatable = ['Name'];
    protected $guarded=[];
}