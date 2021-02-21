<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductRepository
{
    /**
     * Get all products
     *
     * @return false
     */
    public function getAllProducts()
    {
        try {
            return Product::orderByDesc('id')->paginate(10);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Product Repository (getAllProducts method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Get all products with conditions
     *
     * @param array $conditions
     * @return false
     */
    public function getAllWithConditions(array $conditions)
    {
        try {
            return Product::where($conditions)->orderByDesc('id')->paginate(10);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Product Repository (getAllWithConditions method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Get displayable products by id
     *
     * @param int $productID
     * @return false
     */
    public function getDisplayableByID(int $productID)
    {
        try {
            return Product::where([
                ['id', '=', $productID],
                ['display', '=', 1]
            ])->first();
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Product Repository (getDisplayableByID method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Get product control details
     *
     * @param int $productID
     * @return false
     */
    public function getControl(int $productID)
    {
        try {
            return Product::select('id', 'display', 'comment', 'vote', 'buyer_comment_vote')->where('id', '=', $productID)->first();
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Product Repository (getDisplayableByID method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Update product by id
     *
     * @param int $productID
     * @param array $product
     * @return bool
     */
    public function updateByID(int $productID, array $product)
    {
        try {
            return Product::where('id', '=', $productID)->update($product);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Product Repository (updateByID method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Get product last comments
     *
     * @param int $productID
     * @return object|false
     */
    public function getLastComments(int $productID)
    {
        try {
            $product = Product::find($productID);

            if ($product != null) {
                return $product->comments()->where('comments.approve', '=', 1)->orderByDesc('id')->limit(3)->get();
            }

            return false;
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Comment Repository (getAllComments method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Get product rates
     *
     * @param int $productID
     * @return object|false|array
     */
    public function getRates(int $productID)
    {
        try {
            $product = Product::find($productID);

            if ($product != null) {
                $rates = [];
                $rates['comments'] = $product->comments()->where('comments.approve', '=', 1)->count();
                $rates['votes'] = intval($product->votes()->where('votes.approve', '=', 1)->avg('vote'));

                return $rates;
            }

            return null;
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Comment Repository (getAllComments method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Get product custom column by id
     *
     * @param int $productID
     * @param string $column
     * @return false
     */
    public function getCustomColumnByID(int $productID, string $column)
    {
        try {
            return Product::select($column)->where('id', '=', $productID)->first();
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Product Repository (getCustomColumnWithConditions method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }
}
