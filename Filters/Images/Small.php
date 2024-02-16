<?php

// namespace Intervention\Image\Templates;

declare(strict_types=1);

namespace Modules\Xot\Filters\Images;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Small implements FilterInterface
{
<<<<<<< HEAD
    public function applyFilter(Image $image): Image
=======
    /**
     * @return Image
     */
    public function applyFilter(Image $image)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
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
