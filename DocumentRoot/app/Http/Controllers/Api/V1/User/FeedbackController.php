<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\Response;
use App\Services\FeedbackService;
use App\Repositories\ProductRepository;
use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\VoteCreateRequest;

/**
 * Class FeedbackController
 * @tag Feedback
 * @namespace App\Http\Controllers\Api\V1\User
 */
class FeedbackController extends Controller
{
    /**
     * Store product comment
     *
     * @param CommentCreateRequest $request
     * @param FeedbackService $feedbackService
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function storeComment(
        CommentCreateRequest $request,
        FeedbackService $feedbackService,
        LogService $logService,
        ProductRepository $productRepo
    )
    {
        return $feedbackService->dispatcher('_storeComment', $request, $logService, $productRepo);
    }

    /**
     * Store product vote
     *
     * @param VoteCreateRequest $request
     * @param FeedbackService $feedbackService
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function storeVote(
        VoteCreateRequest $request,
        FeedbackService $feedbackService,
        LogService $logService,
        ProductRepository $productRepo
    )
    {
        return $feedbackService->dispatcher('_storeVote', $request, $logService, $productRepo);
    }
}
