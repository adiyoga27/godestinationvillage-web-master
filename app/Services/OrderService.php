<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;
// use DB;
use Illuminate\Support\Facades\DB as DB;

class OrderService
{

    public static function all()
    {
        DB::statement(DB::raw('set @rownum=0'));
        return Order::query()
                ->leftJoin('bank_accounts', 'orders.bank_account_id', '=', 'bank_accounts.id')                            
                ->select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    DB::raw('orders.*'),
                ])->where('orders.deleted_at', NULL);
    }

    public static function count($village_id = NULL)
    {
        if($village_id == NULL)
            return Order::where('payment_status', 'success')->count();
        else
            return Order::where('payment_status', 'success')->where('village_id', $village_id)->count();
    }

    public static function income($village_id = NULL)
    {
        if($village_id == NULL)
            return Order::where('payment_status', 'success')->sum('total_payment');
        else
            return Order::where('payment_status', 'success')->where('village_id', $village_id)->sum('total_payment');
    }

    public static function find($id)
    {
        return Order::with(['bank_account', 'village'])->find($id);
    }

    public static function get_order_by_user($user_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return Order::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('orders.*')
        ])->where('orders.user_id', $user_id)->where('orders.deleted_at', NULL);
    }

    public static function find_by_user($user_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return Order::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('orders.*')
        ])->where('orders.village_id', $user_id)->where('orders.deleted_at', NULL);
    }

    public static function find_by_package($package_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return Order::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('orders.*')
        ])->where('orders.package_id', $package_id)->where('orders.deleted_at', NULL);
    }

    public static function destroy($id)
    {
        $model = Order::find($id);
        return $model->destroy($id);
    }

    public static function change_status($id, $status)
    {
        $order = Order::find($id);
        $order->payment_status = $status;
        return $order->save();
    }

    public static function search_order($village_id = 'All', $package_id = 'All', $start_date = 0, $end_date = 0)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $order = Order::query()
                ->leftJoin('bank_accounts', 'orders.bank_account_id', '=', 'bank_accounts.id')                            
                ->select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    DB::raw('orders.*'),
                ]);

        if($village_id != 'All')
            $order->where('orders.village_id', $village_id);

        if($package_id != 'All')
            $order->where('orders.package_id', $package_id);

        if($start_date != 0)
            $order->where(DB::raw('DATE(orders.created_at)'), '>=', date('Y-m-d', strtotime($start_date)));

        if($end_date != 0)
            $order->where(DB::raw('DATE(orders.created_at)'), '<=', date('Y-m-d', strtotime($end_date)));

        return $order->where('orders.deleted_at', NULL);
    }

}