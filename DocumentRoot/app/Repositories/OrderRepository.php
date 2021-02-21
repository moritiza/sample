<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    /**
     * Check order product buyer user
     *
     * @param int $userID
     * @param int $productID
     * @return bool
     */
    public function checkOrderProductUser(int $userID, int $productID)
    {
        try {
            $count = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('orders.user_id', '=', $userID)
                ->where('order_details.product_id', '=', $productID)
                ->count();

            if ($count > 0) {
                return true;
            }

            return false;
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
