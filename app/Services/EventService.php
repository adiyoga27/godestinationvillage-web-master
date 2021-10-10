<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventService  
{
    public static function all()
    {
        DB::statement(DB::raw('set @rownum=0'));
        return Event::query()->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('events.*')
        ]);

    }

    public static function find($id)
    {
        return Event::find($id);
    }

    public static function create($payload)
    {
        $model = Event::create($payload);
        return $model;
    }

    public static function update($id, $payload)
    {
        $model = Event::find($id);
        return $model->update($payload);
    }

    public static function destroy($id)
    {
        $model = Event::find($id);
        return $model->destroy($id);
    }

    public static function pluck()
    {
        return Event::where('is_active', 1)->pluck('name', 'id');
    }
}
