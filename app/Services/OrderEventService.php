<?php

namespace App\Services;

use App\Models\OrderEvent;
use Illuminate\Support\Facades\DB;

class OrderEventService
{

    public static function all()
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
                ->leftJoin('bank_accounts', 'order_events.bank_account_id', '=', 'bank_accounts.id')                            
                ->select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    DB::raw('order_events.*'),
                ])->where('order_events.deleted_at', NULL);
    }

    public static function count($village_id = NULL)
    {
        if($village_id == NULL)
            return OrderEvent::where('payment_status', 'success')->count();
        else
            return OrderEvent::where('payment_status', 'success')->where('village_id', $village_id)->count();
    }

    public static function income($village_id = NULL)
    {
        if($village_id == NULL)
            return OrderEvent::where('payment_status', 'success')->sum('total_payment');
        else
            return OrderEvent::where('payment_status', 'success')->where('village_id', $village_id)->sum('total_payment');
    }

    public static function find($id)
    {
        return OrderEvent::with(['bank_account'])->find($id);
    }

    public static function get_order_by_user($user_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('order_events.*')
        ])->where('order_events.user_id', $user_id)->where('order_events.deleted_at', NULL);
    }

    public static function find_by_user($user_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('order_events.*')
        ])->where('order_events.village_id', $user_id)->where('order_events.deleted_at', NULL);
    }

    public static function find_by_package($package_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('order_events.*')
        ])->where('order_events.package_id', $package_id)->where('order_events.deleted_at', NULL);
    }

    public static function destroy($id)
    {
        $model = OrderEvent::find($id);
        return $model->destroy($id);
    }

    public static function change_status($id, $status)
    {
        $order = OrderEvent::find($id);
        $order->payment_status = $status;
        return $order->save();
    }

    public static function search_order($village_id = 'All', $package_id = 'All', $start_date = 0, $end_date = 0)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $order = OrderEvent::query()
                ->leftJoin('bank_accounts', 'order_events.bank_account_id', '=', 'bank_accounts.id')                            
                ->select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    DB::raw('order_events.*'),
                ]);

        if($village_id != 'All')
            $order->where('order_events.village_id', $village_id);

        if($package_id != 'All')
            $order->where('order_events.package_id', $package_id);

        if($start_date != 0)
            $order->where(DB::raw('DATE(order_events.created_at)'), '>=', date('Y-m-d', strtotime($start_date)));

        if($end_date != 0)
            $order->where(DB::raw('DATE(order_events.created_at)'), '<=', date('Y-m-d', strtotime($end_date)));

        return $order->where('order_events.deleted_at', NULL);
    }

}