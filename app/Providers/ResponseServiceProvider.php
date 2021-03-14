<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        // Success response
        $factory->macro('success', function($message = '', $data = [], $httpStatusCode = 200) use ($factory){
            $formatedResponse = [
                'success'   =>  true,
                'message'   =>  $message,
                'content'   =>  $data
            ];

            return $factory->make($formatedResponse, $httpStatusCode);
        });
        
        // Error response
        $factory->macro('error', function($message = '', $errors = [], $httpStatusCode = 500) use ($factory){
            $formatedResponse = [
                'success'   =>  false,
                'message'   =>  $message,
                'errors'    =>  $errors
            ];

            return $factory->make($formatedResponse, $httpStatusCode);
        });
    }
}
