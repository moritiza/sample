<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Repositories\ProductRepository;
use App\Services\LogService;
use App\Exceptions\ApiServiceException;

/**
 * Class ProductService
 * @tag Product
 * @namespace App\Services
 */
class ProductService
{
    /**
     * Store products
     *
     * @var array
     */
    private $_products = [];

    /**
     * Product service dispatcher
     *
     * @param string $method
     * @param $request
     * @param LogService $logService
     * @param ProductRepository $productRepo
     * @return mixed
     */
    public function dispatcher(string $method, $request, LogService $logService, ProductRepository $productRepo)
    {
        $log = [
            'request' => json_encode($request->all()),
        ];

        try {
            if ($method == '_getProducts') {
                $this->$method($productRepo);

                $successResponse = [
                    'message' => 'products retrieved successfully.',
                    'products' => $this->_products,
                ];
            } elseif ($method == '_getProduct') {
                $this->$method($request, $productRepo);

                $successResponse = [
                    'message' => 'product retrieved successfully.',
                    'product' => $this->_products,
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
     * Get all displayable products
     *
     * @param ProductRepository $productRepo
     * @return bool
     * @throws ApiServiceException
     */
    private function _getProducts(ProductRepository $productRepo)
    {
        $this->_products = $productRepo->getAllWithConditions([['display', '=', 1]]);

        if (is_object($this->_products) && $this->_products->toArray()['total'] > 0) {
            return true;
        }

        throw new ApiServiceException('There is no product!', 400);
    }

    /**
     * Get displayable product
     *
     * @param $request
     * @param ProductRepository $productRepo
     * @return bool
     * @throws ApiServiceException
     */
    private function _getProduct($request, ProductRepository $productRepo)
    {
        $this->_products = $productRepo->getDisplayableByID($request->id);

        if (is_object($this->_products)) {
            return true;
        }

        throw new ApiServiceException('product not found!', 400);
    }
}
