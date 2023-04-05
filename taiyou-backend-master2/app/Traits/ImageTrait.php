<?php

namespace App\Traits;

use File;
use Request;
use Image;

trait ImageTrait
{
    public function uploadImage($dir, $input)
    {
        $directory = public_path() . $dir;
        if (is_dir($directory) != true) {
            \File::makeDirectory($directory, $mode = 0755, true);
        }
        $fileName = uniqid() . '.' . Request::file($input)->getClientOriginalExtension();
        $image = Image::make(Request::file($input));
        $image->save($directory . '/' . $fileName, 100);
        return $fileName;
    }

    public function removeImage($dir, $image)
    {
        $f1 = public_path() . $dir . '/' . $image;
        File::delete($f1);
    }
}
