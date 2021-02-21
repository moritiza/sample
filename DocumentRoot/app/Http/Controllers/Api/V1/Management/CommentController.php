<?php

namespace App\Http\Controllers\Api\V1\Management;

use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Controllers\Api\V1\Log\LogController;
use App\Repositories\LogRepository;
use App\Exceptions\ApiManagementException;

/**
 * Class CommentController
 * @tag Comment
 * @namespace App\Http\Controllers\Api\V1\Management
 */
class CommentController extends Controller
{
    /**
     * Store comments
     *
     * @var array
     */
    private $_comments = [];

    /**
     * Get all comments
     *
     * @param Request $request
     * @param CommentRepository $commentRepo
     * @param LogController $logController
     * @param LogRepository $logRepo
     * @return mixed
     */
    public function index(
        Request $request,
        CommentRepository $commentRepo,
        LogController $logController,
        LogRepository $logRepo
    )
    {
        $this->_log = [
            'request' => json_encode($request->all()),
        ];

        try {
            $this->_getComments($commentRepo);

            $successResponse = [
                'message' => 'comments retrieved successfully.',
                'data' => $this->_comments,
            ];

            $this->_log['response'] = json_encode($successResponse);
            $this->_log['code'] = 200;

            return Response::success($successResponse, 200);
        } catch (ApiManagementException $e) {
            if ($e->getCode() > 499 && $e->getCode() < 600) {
                $e->customReport($e);
            }

            $this->_log['response'] = json_encode(['message' => $e->getMessage()]);
            $this->_log['code'] = $e->getCode();

            return Response::failure(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            $this->_log['response'] = json_encode(['message' => $e->getMessage()]);
            $this->_log['code'] = $e->getCode();

            return Response::failure(['message' => 'An error has occurred!'], $e->getCode());
        } finally {
            $logController->logger($request, $logRepo, $this->_log);
        }
    }

    /**
     * Update comment
     *
     * @param CommentUpdateRequest $request
     * @param CommentRepository $commentRepo
     * @param LogController $logController
     * @param LogRepository $logRepo
     * @return mixed
     */
    public function update(
        CommentUpdateRequest $request,
        CommentRepository $commentRepo,
        LogController $logController,
        LogRepository $logRepo)
    {
        $this->_log = [
            'request' => json_encode($request->all()),
        ];

        try {
            $this->_doUpdate($request, $commentRepo);

            $successResponse = [
                'message' => 'comment updated successfully.',
            ];

            $this->_log['response'] = json_encode($successResponse);
            $this->_log['code'] = 200;

            return Response::success($successResponse, 200);
        } catch (ApiManagementException $e) {
            if ($e->getCode() > 499 && $e->getCode() < 600) {
                $e->customReport($e);
            }

            $this->_log['response'] = json_encode(['message' => $e->getMessage()]);
            $this->_log['code'] = $e->getCode();

            return Response::failure(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            $this->_log['response'] = json_encode(['message' => $e->getMessage()]);
            $this->_log['code'] = $e->getCode();

            return Response::failure(['message' => 'An error has occurred!'], $e->getCode());
        } finally {
            $logController->logger($request, $logRepo, $this->_log);
        }
    }

    /**
     * Get all comments
     *
     * @param CommentRepository $commentRepo
     * @return bool
     * @throws ApiManagementException
     */
    private function _getComments(CommentRepository $commentRepo)
    {
        $this->_comments = $commentRepo->getAllComments();

        if (is_object($this->_comments) && $this->_comments->toArray()['total'] > 0) {
            return true;
        }

        throw new ApiManagementException('There is no comment!', 400);
    }

    /**
     * Update comment by id
     *
     * @param CommentUpdateRequest $request
     * @param CommentRepository $commentRepo
     * @return mixed
     * @throws ApiManagementException
     */
    private function _doUpdate(CommentUpdateRequest $request, CommentRepository $commentRepo)
    {
        $result = $commentRepo->updateByID($request->id, array_merge(
                $request->only(['approve', 'description']), ['updated_at' => date('Y-m-d H:i:s')])
        );

        if ($result) {
            return true;
        }

        throw new ApiManagementException('Operation failed!', 400);
    }
}
