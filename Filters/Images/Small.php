<?php

// namespace Intervention\Image\Templates;

declare(strict_types=1);

namespace Modules\Xot\Filters\Images;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

final class Small implements FilterInterface
{
    public function applyFilter(Image $image): Image
    {
        // return $image->fit(120, 90);
        $width = 120;
        $height = 120;
        return $image->fit($width, $height);

        /*
        $image->resize($width, $height, function ($constraint): void {
            $constraint->aspectRatio();
        });

        return $image->resizeCanvas($width, $height, 'center', false, '#fff');
        */
    }
}
