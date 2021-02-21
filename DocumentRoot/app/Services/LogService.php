<?php

namespace App\Services;

use App\Repositories\LogRepository;

/**
 * Class ProductService
 * @tag Product
 * @namespace App\Services
 */
class LogService
{
    /**
     * Logger
     *
     * @param $request
     * @param array $logMetaData
     * @return void
     */
    public function logger($request, array $logMetaData)
    {
        $log = [
            'ip' => $request->ip(),
            'verb' => $request->method(),
            'endpoint' => $request->getRequestUri(),
            'request' => $logMetaData['request'],
            'response' => $logMetaData['response'],
            'code' => $logMetaData['code'],
        ];

        (new LogRepository())->create($log);
    }
}
