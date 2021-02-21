<?php

namespace App\Http\Controllers\Api\V1\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\VoteUpdateRequest;
use App\Http\Controllers\Api\V1\Log\LogController;
use App\Repositories\LogRepository;
use App\Repositories\VoteRepository;
use App\Exceptions\ApiManagementException;

/**
 * Class VoteController
 * @tag Vote
 * @namespace App\Http\Controllers\Api\V1\Management
 */
class VoteController extends Controller
{
    /**
     * Store votes
     *
     * @var array
     */
    private $_votes = [];

    /**
     * Get all votes
     *
     * @param Request $request
     * @param VoteRepository $voteRepo
     * @param LogController $logController
     * @param LogRepository $logRepo
     * @return mixed
     */
    public function index(
        Request $request,
        VoteRepository $voteRepo,
        LogController $logController,
        LogRepository $logRepo
    )
    {
        $this->_log = [
            'request' => json_encode($request->all()),
        ];

        try {
            $this->_getVotes($voteRepo);

            $successResponse = [
                'message' => 'votes retrieved successfully.',
                'data' => $this->_votes,
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
     * Update vote
     *
     * @param VoteUpdateRequest $request
     * @param VoteRepository $voteRepo
     * @param LogController $logController
     * @param LogRepository $logRepo
     * @return mixed
     */
    public function update(
        VoteUpdateRequest $request,
        VoteRepository $voteRepo,
        LogController $logController,
        LogRepository $logRepo)
    {
        $this->_log = [
            'request' => json_encode($request->all()),
        ];

        try {
            $this->_doUpdate($request, $voteRepo);

            $successResponse = [
                'message' => 'vote updated successfully.',
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
     * Get all votes
     *
     * @param VoteRepository $voteRepo
     * @return bool
     * @throws ApiManagementException
     */
    private function _getVotes(VoteRepository $voteRepo)
    {
        $this->_votes = $voteRepo->getAllVotes();

        if (is_object($this->_votes) && $this->_votes->toArray()['total'] > 0) {
            return true;
        }

        throw new ApiManagementException('There is no vote!', 400);
    }

    /**
     * Update vote by id
     *
     * @param VoteUpdateRequest $request
     * @param VoteRepository $voteRepo
     * @return mixed
     * @throws ApiManagementException
     */
    private function _doUpdate(VoteUpdateRequest $request, VoteRepository $voteRepo)
    {
        $result = $voteRepo->updateByID($request->id, array_merge(
                $request->only(['approve', 'vote']), ['updated_at' => date('Y-m-d H:i:s')])
        );

        if ($result) {
            return true;
        }

        throw new ApiManagementException('Operation failed!', 400);
    }
}
