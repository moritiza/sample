<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ApiServiceException extends Exception
{
    /**
     * Report custom exception
     *
     * @param Exception $exception
     */
    public function customReport(Exception $exception)
    {
        Log::channel('api_service_exceptions')->emergency(
            'Code => ' . $exception->code .
            ' ***** Message => ' . $exception->message .
            ' ***** File => ' . $exception->file .
            ' ***** Line => ' . $exception->line
        );
    }
}
