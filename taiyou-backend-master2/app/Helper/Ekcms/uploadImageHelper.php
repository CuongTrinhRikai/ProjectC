<?php
/**
 * Created by PhpStorm.
 * User: cjanna
 * Date: 5/3/21
 * Time: 1:16 PM
 */

namespace App\Helper\Ekcms;


class uploadImageHelper
{
    public static function uploadImage($file = null, $path = null, $height = null, $width = null)
    {

        $image = $file;
        $paths = public_path() . $path;
        if (is_dir($paths) != true) {
            \File::makeDirectory($paths, $mode = 0755, true);
        }

        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        $img = \Image::make($image->getRealPath());

        $img->resize($img->width(), $img->height(), function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save($paths . '/' . $filename);

        return $filename;
    }


    public static function uploadImages($files, $key_name, $path)
    {

        $filePath = [];
        $paths = public_path() . $path;
        foreach ($files as $file) {
            $image = $file;
            if (isset($key_name)) {


                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $img = \Image::make($image->getRealPath());

                $img->resize($img->width(), $img->height(), function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($paths . '/' . $fileName);

                $filePath[] = $fileName;
            }
        }

        return $filePath;
    }
}