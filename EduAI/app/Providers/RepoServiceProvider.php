<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('App\Repository\TeacherRepositoryInterface', 'App\Repository\TeacherRepository');
        $this->app->bind('App\Repository\StudentRepositoryInterface', 'App\Repository\StudentRepository');
        $this->app->bind('App\Repository\CourseRepositoryInterface', 'App\Repository\CourseRepository');
        $this->app->bind('App\Repository\LessonRepositoryInterface', 'App\Repository\LessonRepository');
        $this->app->bind('App\Repository\ItemRepositoryInterface', 'App\Repository\ItemRepository');


    }


    public function boot()
    {
        //
    }
}