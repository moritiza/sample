<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\LogService;
use App\Exceptions\ApiServiceException;
use Illuminate\Http\Response;
use App\Repositories\CommentRepository;
use App\Repositories\VoteRepository;
use App\Repositories\OrderRepository;

class FeedbackService
{
    /**
     * Store product control status
     *
     * @var null
     */
    private $_status = null;

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
            $this->_getProductControl($request, $productRepo);
            $this->_checkProductControlStatus($method);

            if ($this->_status['buyer_comment_vote'] === 0) {
                $this->$method($request);
            } else {
                $this->_checkProductBuyer($request);
                $this->$method($request);
            }

            if ($method == '_storeComment') {
                $successResponse = [
                    'message' => 'comment stored successfully.',
                ];
            } elseif ($method == '_storeVote') {
                $successResponse = [
                    'message' => 'vote stored successfully.',
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

            return Response::failure(['message' => 'an error has occurred!'], $e->getCode());
        } finally {
            $logService->logger($request, $log);
        }
    }

    /**
     * Get product control status
     *
     * @param $request
     * @param ProductRepository $productRepo
     * @return bool
     * @throws ApiServiceException
     */
    private function _getProductControl($request, ProductRepository $productRepo)
    {
        $this->_status = $productRepo->getControl($request->get('product_id'));

        if (is_null($this->_status)) {
            throw new ApiServiceException('product not found!', 404);
        }

        return true;
    }

    /**
     * Store comment
     *
     * @param $request
     * @return bool
     * @throws ApiServiceException
     */
    private function _storeComment($request)
    {
        if ((new CommentRepository())->create(
            array_merge(
                $request->only(['user_id', 'product_id', 'description']),
                ['approve' => 0, 'created_at' => date('Y-m-d H:i:s')]
            )
        )) {
            return true;
        }

        throw new ApiServiceException('can not store comment!', 500);
    }

    /**
     * Store vote
     *
     * @param $request
     * @return bool
     * @throws ApiServiceException
     */
    private function _storeVote($request)
    {
        if ((new VoteRepository())->create(
            array_merge(
                $request->only(['user_id', 'product_id', 'vote']),
                ['approve' => 0, 'created_at' => date('Y-m-d H:i:s')]
            )
        )) {
            return true;
        }

        throw new ApiServiceException('can not store vote!', 500);
    }

    /**
     * Check product control status
     *
     * @param string $method
     * @return bool
     * @throws ApiServiceException
     */
    private function _checkProductControlStatus(string $method)
    {
        if ($method == '_storeComment') {
            if ($this->_status['comment'] == 1) {
                return true;
            }

            throw new ApiServiceException('can not set comment!', 401);
        } elseif ($method == '_storeVote') {
            if ($this->_status['vote'] == 1) {
                return true;
            }

            throw new ApiServiceException('can not set vote!', 401);
        }
    }

    /**
     * Check is user buy the product
     *
     * @param $request
     * @return bool
     * @throws ApiServiceException
     */
    private function _checkProductBuyer($request)
    {
        if ((new OrderRepository())->checkOrderProductUser($request->get('user_id'), $request->get('product_id'))) {
            return true;
        }

        throw new ApiServiceException('can not set comment or vote!', 401);
    }
}
