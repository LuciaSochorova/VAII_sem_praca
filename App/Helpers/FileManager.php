<?php

namespace App\Helpers;

use Exception;

class FileManager
{

    public static function saveImage($image) : ?string {
        $newName = md5($image["name"] . time()) ;
        $path = "public/uploads/images/" . "img_" . $newName;

        if (move_uploaded_file($image["tmp_name"], $path)) {
            return $path;
        } else {
            return null;
        }
    }

    public static function deleteFile(string $path) : bool {
        return unlink($path);
    }

}