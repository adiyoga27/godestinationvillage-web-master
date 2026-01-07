<?php

namespace App\Filter;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Filter300x150 implements FilterInterface
{
    // 300 x 150
    public function applyFilter(Image $image)
    {
        return $image->fit(300, 150);
    }
}