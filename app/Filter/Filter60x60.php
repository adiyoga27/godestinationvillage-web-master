<?php

namespace App\Filter;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Filter60x60 implements FilterInterface
{
    // 300 x 150
    public function applyFilter(Image $image)
    {
        return $image->fit(60, 60);
    }
}