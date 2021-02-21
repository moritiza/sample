<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\LogService;
use App\Exceptions\ApiServiceException;
use Illuminate\Http\Response;

class ReviewService
{
    /**
     * Store retrieved data
     *
     * @var array
     */
    private $_data = [];

    /**
     * Review service dispatcher
     *
     * @param string $method
     * @param $request
     * @param \App\Services\LogService $logService
     * @param ProductRepository $productRepo
     * @return mixed
     */
    public function dispatcher(string $method, $request, LogService $logService, ProductRepository $productRepo)
    {
        $log = [
            'request' => json_encode($request->all()),
        ];

        try {
            $this->$method($request, $productRepo);

            if ($method == '_control') {
                $successResponse = [
                    'message' => 'product control details retrieved successfully.',
                    'product' => $this->_data,
                ];
            } elseif ($method == '_lastComments') {
                $successResponse = [
                    'message' => 'product comments retrieved successfully.',
                    'comments' => $this->_data,
                ];
            } elseif ($method == '_rates') {
                $successResponse = [
                    'message' => 'product rates retrieved successfully.',
                    'rates' => $this->_data,
                ];
            }

            $log['response'] = json_encode($successResponse);
            $log['code'] = 200;

            return Response::success($successResponse, 200);
        } catch (ApiServiceException $e) {
            if ($e->getCode() > 499 && $e->getCode() < 600) {
                $e->customReport($e);
            }

            $log['response'] = json_encode(['message' => $e->getMessage()]);
            $log['code'] = $e->getCode();

            return Response::failure(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            $log['response'] = json_encode(['message' => $e->getMessage()]);
            $log['code'] = $e->getCode();

            return Response::failure(['message' => 'An error has occurred!'], $e->getCode());
        } finally {
            $logService->logger($request, $log);
        }
    }

    /**
     * Get product control details
     *
     * @param $requset
     * @param ProductRepository $productRepo
     * @return bool
     * @throws ApiServiceException
     */
    private function _control($requset, ProductRepository $productRepo)
    {
        $this->_data = $productRepo->getControl($requset->id);

        if (is_object($this->_data)) {
            return true;
        }

        throw new ApiServiceException('product not found!', 400);
    }

    /**
     * Get product last comments
     *
     * @param $requset
     * @param ProductRepository $productRepo
     * @return bool
     * @throws ApiServiceException
     */
    private function _lastComments($requset, ProductRepository $productRepo)
    {
        $this->_data = $productRepo->getLastComments($requset->id);

        if (is_object($this->_data) && $this->_data->count() > 0) {
            return true;
        }

        throw new ApiServiceException('there is no comment!', 400);
    }

    /**
     * Get product rates
     *
     * @param $requset
     * @param ProductRepository $productRepo
     * @return bool
     * @throws ApiServiceException
     */
    private function _rates($requset, ProductRepository $productRepo)
    {
        $this->_data = $productRepo->getRates($requset->id);

        if ($this->_data === false) {
            throw new ApiServiceException('an error has occurred!', 500);
        }

        return true;
    }
}
