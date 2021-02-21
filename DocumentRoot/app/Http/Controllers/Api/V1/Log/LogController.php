<?php

namespace App\Http\Controllers\Api\V1\Log;

use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;

/**
 * Class LogController
 * @tag Log
 * @namespace App\Http\Controllers\Api\V1\Log
 */
class LogController extends Controller
{
    /**
     * Logger
     *
     * @param $request
     * @param LogRepository $logRepo
     * @param array $logMetaData
     * @return void
     */
    public function logger($request, LogRepository $logRepo, array $logMetaData)
    {
        $log = [
            'ip' => $request->ip(),
            'verb' => $request->method(),
            'endpoint' => $request->getRequestUri(),
            'request' => $logMetaData['request'],
            'response' => $logMetaData['response'],
            'code' => $logMetaData['code'],
        ];

        $logRepo->create($log);
    }
}
