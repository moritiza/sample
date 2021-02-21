<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Response::macro('success', function (array $message, int $code) {
            return response()->json($message, $code, [], JSON_UNESCAPED_UNICODE);
        });

        Response::macro('failure', function (array $message, int $code) {
            return response()->json($message, $code, [], JSON_UNESCAPED_UNICODE);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
