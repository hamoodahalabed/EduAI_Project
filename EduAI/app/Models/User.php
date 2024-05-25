<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    
    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded=[];


   
}