<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReviewService;
use App\Services\LogService;
use App\Repositories\ProductRepository;
use Illuminate\Http\Response;

/**
 * Class ReviewController
 * @tag Review
 * @namespace App\Http\Controllers\Api\V1\User
 */
class ReviewController extends Controller
{
    /**
     * Get product control details
     *
     * @param Request $request
     * @param ReviewService $reviewService
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function control(
        Request $request,
        ReviewService $reviewService,
        LogService $logService,
        ProductRepository $productRepo
    )
    {
        return $reviewService->dispatcher('_control', $request, $logService, $productRepo);
    }

    /**
     * Get displayable product rates
     *
     * @param Request $request
     * @param ReviewService $reviewService
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function rates(
        Request $request,
        ReviewService $reviewService,
        LogService $logService,
        ProductRepository $productRepo
    )
    {
        return $reviewService->dispatcher('_rates', $request, $logService, $productRepo);
    }

    /**
     * Get displayable product last 3 comments
     *
     * @param Request $request
     * @param ReviewService $reviewService
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function lastComments(
        Request $request,
        ReviewService $reviewService,
        LogService $logService,
        ProductRepository $productRepo
    )
    {
        return $reviewService->dispatcher('_lastComments', $request, $logService, $productRepo);
    }
}
