<?php

namespace App\Services;

use App\Models\User;
use App\VillageDetail;
use App\Helpers\CustomImage;

use Illuminate\Support\Facades\Storage;
use DB;
use Auth;

class VillageService
{

	public static function find($id)
    {
        return User::with('village_detail')->find($id);
    }

    public static function find_with($id)
    {
        return User::with(['village_detail', 'village_orders', 'packages'])->find($id);
    }

    public static function get_by_role($role_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return DB::table('users')->join('village_details', 'users.id', '=', 'village_details.user_id')->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('users.*'),
            DB::raw('village_details.village_name')
        ])->where('role_id', $role_id)->where('users.deleted_at', NULL);
    }

    public static function create($user_id, $payload)
    {
        $payload['user_id'] = $user_id;
        $model = VillageDetail::create($payload);
        return $model;
    }

    public static function update($user_id, $payload)
    {
        $model = VillageDetail::where('user_id',$user_id);
        return $model->update($payload);
    }

    public static function destroy($user_id)
    {
        $model = VillageDetail::where('user_id',$user_id);
        return $model->delete();
    }

    public static function pluck()
    {
        return VillageDetail::pluck('village_name', 'user_id');
    }
}