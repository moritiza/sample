<?php

namespace App\Http\Controllers\Api\V1\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Controllers\Api\V1\Log\LogController;
use App\Repositories\LogRepository;
use App\Repositories\ProductRepository;
use App\Exceptions\ApiManagementException;

/**
 * Class ProductController
 * @tag Product
 * @namespace App\Http\Controllers\Api\V1\Management
 */
class ProductController extends Controller
{
    /**
     * Store products
     *
     * @var array
     */
    private $_products = [];

    /**
     * Get all products
     *
     * @param Request $request
     * @param ProductRepository $productRepo
     * @param LogController $logController
     * @param LogRepository $logRepo
     * @return mixed
     */
    public function index(
        Request $request,
        ProductRepository $productRepo,
        LogController $logController,
        LogRepository $logRepo
    )
    {
        $this->_log = [
            'request' => json_encode($request->all()),
        ];

        try {
            $this->_getProducts($productRepo);

            $successResponse = [
                'message' => 'products retrieved successfully.',
                'data' => $this->_products,
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
     * Update product
     *
     * @param ProductUpdateRequest $request
     * @param ProductRepository $productRepo
     * @param LogController $logController
     * @param LogRepository $logRepo
     * @return mixed
     */
    public function update(
        ProductUpdateRequest $request,
        ProductRepository $productRepo,
        LogController $logController,
        LogRepository $logRepo
    )
    {
        $this->_log = [
            'request' => json_encode($request->all()),
        ];

        try {
            $this->_doUpdate($request, $productRepo);

            $successResponse = [
                'message' => 'product updated successfully.',
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
     * Get all products
     *
     * @param ProductRepository $productRepo
     * @return bool
     * @throws ApiManagementException
     */
    private function _getProducts(ProductRepository $productRepo)
    {
        $this->_products = $productRepo->getAllProducts();

        if (is_object($this->_products) && $this->_products->toArray()['total'] > 0) {
            return true;
        }

        throw new ApiManagementException('There is no product!', 400);
    }

    /**
     * Update product by id
     *
     * @param ProductUpdateRequest $request
     * @param ProductRepository $productRepo
     * @return mixed
     * @throws ApiManagementException
     */
    private function _doUpdate(ProductUpdateRequest $request, ProductRepository $productRepo)
    {
        $result = $productRepo->updateByID($request->id, array_merge($request->only([
            'provider_id',
            'title',
            'price',
            'display',
            'comment',
            'vote',
            'buyer_comment_vote',
        ]), ['updated_at' => date('Y-m-d H:i:s')]));

        if ($result) {
            return true;
        }

        throw new ApiManagementException('Operation failed!', 400);
    }
}
