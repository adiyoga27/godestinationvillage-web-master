<?php

namespace App\Filter;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Filter530x620 implements FilterInterface
{
    // 530 x 620
    public function applyFilter(Image $image)
    {
        return $image->fit(530, 620);
    }
}