<?php

namespace App\Services;

use App\Tag;

class TagServices
{
    public static function pluck()
    {
        return Tag::pluck('name', 'id');
    }
}
