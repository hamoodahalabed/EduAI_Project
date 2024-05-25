<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('youtube_url', function ($attribute, $value, $parameters, $validator) {
            // Your regular expression pattern
            $pattern = '/^(https?:\/\/)?(www\.)?(youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=|shorts\/)|(youtu\.be\/|m\.youtube\.com\/)|(?:youtube\.com\/shorts\/\S+))(?:\S+)?$/';
            return preg_match($pattern, $value);
        });
    }
}
