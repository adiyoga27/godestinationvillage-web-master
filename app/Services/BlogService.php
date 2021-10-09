<?php

namespace App\Services;

use App\Blog;
use App\Helpers\CustomImage;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlogService
{

	public static function all()
    {
        DB::statement(DB::raw('set @rownum=0'));
        return Blog::query()->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('post.*')
        ]);
    }

    public static function find($id)
    {
        return Blog::find($id);
    }

    public static function create($payload)
    {   
        if (!empty($payload['post_thumbnail'])){
            $upload = CustomImage::storeImage($payload['post_thumbnail'], 'blogs');
            $payload['post_thumbnail'] = $upload['name'];
        }

       
        $model = Blog::create(array_merge($payload, ['post_author'=>Auth::user()->id]));
        return $model;
    }

    public static function update($id, $payload)
    {
        
        $model = Blog::find($id);

        if (!empty($payload['post_thumbnail'])){
            if (!empty($model->post_thumbnail)){
                Storage::delete('blogs/'.$model->post_thumbnail);
        };
            $upload = CustomImage::storeImage($payload['post_thumbnail'], 'blogs');
            $payload['post_thumbnail'] = $upload['name'];
        }

        $model = Blog::find($id);
        return $model->update(array_merge($payload, ['updated_by'=> Auth::user()->id]));
    }

    public static function destroy($id)
    {
        $model = Blog::find($id);
        if (!empty($model->post_thumbnail)){
            Storage::delete('blogs/'.$model->post_thumbnail);
        };

        return $model->destroy($id);
    }

}