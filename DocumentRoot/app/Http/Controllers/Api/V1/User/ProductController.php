<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\LogService;
use App\Repositories\ProductRepository;
use Illuminate\Http\Response;

/**
 * Class ProductController
 * @tag Product
 * @namespace App\Http\Controllers\Api\V1\User
 */
class ProductController extends Controller
{
    /**
     * Get all displayable products
     *
     * @param Request $request
     * @param ProductService $productService
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function index(
        Request $request,
        ProductService $productService,
        LogService $logService,
        ProductRepository $productRepo
    )
    {
        return $productService->dispatcher('_getProducts', $request, $logService, $productRepo);
    }

    /**
     * Get displayable product
     *
     * @param Request $request
     * @param ProductService $productService
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function show(
        Request $request,
        ProductService $productService,
        LogService $logService,
        ProductRepository $productRepo
    )
    {
        return $productService->dispatcher('_getProduct', $request, $logService, $productRepo);
    }
}
