<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rreimi
 * Date: 7/14/13
 * Time: 3:06 PM
 */

namespace Fototea\Util;

class ImageHelper {

    const MODE_RESIZE = 'resize';
    const MODE_CROP_CENTER = 'crop_center';
    const IMAGE_LANDSCAPE = 'landscape';
    const IMAGE_PORTRAIT = 'portrait';

    /**
     * Generate a thumb for given image
     *
     * @param $source_image_path        string path from source image
     * @param $thumbnail_image_path     string path for thumb image to be generated
     * @param $thumbWidth               integer thumb max width
     * @param $thumbHeight              integer thumb max height
     * @return bool
     */
    public static function generateThumb($source_image_path, $thumbnail_image_path, $thumbWidth, $thumbHeight, $mode = self::MODE_RESIZE) {
        list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);

        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_image_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_image_path);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_image_path);
                break;
        }
        if ($source_gd_image === false) {
            return false;
        }

        $source_aspect_ratio = $source_image_width / $source_image_height;
        $thumbnail_aspect_ratio = $thumbWidth / $thumbHeight;

        $image_orientation = ($source_aspect_ratio >= 1)? self::IMAGE_LANDSCAPE: self::IMAGE_PORTRAIT;

        $offsetW = 0;
        $offsetY = 0;

        $thumbnail_gd_image = null;

        if ($mode == self::MODE_RESIZE){
            /* Calcular tamaños , solo si es resize */
            if ($source_image_width <= $thumbWidth && $source_image_height <= $thumbHeight) { //
                $thumbnail_image_width = $source_image_width;
                $thumbnail_image_height = $source_image_height;
            } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                $thumbnail_image_width = (int) ($thumbHeight * $source_aspect_ratio);
                $thumbnail_image_height = $thumbHeight;
            } else {
                $thumbnail_image_width = $thumbWidth;
                $thumbnail_image_height = (int) ($thumbWidth / $source_aspect_ratio);
            }

            $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
            imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, $offsetW, $offsetY, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

        }

        /* Calcular punto de corte */
        if ($mode == self::MODE_CROP_CENTER){

            if ($source_aspect_ratio <= $thumbnail_aspect_ratio){
                $resize_image_width = $thumbWidth;
                $resize_image_height = $thumbWidth * $source_image_height / $source_image_width;
            } else {
                $resize_image_width = $thumbHeight * $source_image_width / $source_image_height;
                $resize_image_height = $thumbHeight;

            }

            $offsetX = (int) ($resize_image_width - $thumbWidth) / 2;
            $offsetY = (int) ($resize_image_height - $thumbHeight) / 2;

            //function imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) {}
            $resized_image = imagecreatetruecolor($resize_image_width, $resize_image_height);
            imagecopyresampled($resized_image, $source_gd_image, 0, 0, 0, 0, $resize_image_width, $resize_image_height, $source_image_width, $source_image_height);

            //imagecrop ( resource $image , array $rect )

            /* De la resize saco el crop en el medio */
            $thumbnail_gd_image = imagecreatetruecolor($thumbWidth, $thumbHeight);
            //function imagecopy ($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h) {}
            imagecopy($thumbnail_gd_image, $resized_image, 0, 0, $offsetX, $offsetY, $resize_image_width, $resize_image_height);
        }

        $result = imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 80);
        imagedestroy($source_gd_image);
        imagedestroy($thumbnail_gd_image);
        return $result;
    }

    public static function cropImage($source_image_path, $thumbnail_image_path, $x, $y, $w, $h, $scaleWidth , $quality = 100) {
        //getimagesize($source_image_path);
        //$source_image_path = './../'. $source_image_path;

        //$scaleWidth = 1;

        $fileInfo = getimagesize($source_image_path);
        $source_image_width = $fileInfo[0];
        $source_image_height = $fileInfo[1];
        $source_image_type = $fileInfo[2];

        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_image_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_image_path);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_image_path);
                break;
        }

        if ($source_gd_image === false) {
            return false;
        }

        $thumbnail_gd_image = imagecreatetruecolor($w, $h);
        imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, $x, $y, $w, $h, $w, $h);
        //header('Content-type: image/jpeg');
        $result = imagejpeg($thumbnail_gd_image, $thumbnail_image_path);
        //exit;
        imagedestroy($source_gd_image);
        imagedestroy($thumbnail_gd_image);
        return $result;
    }

    /**
     * Given a mime type return the correct enum image type
     */
    public static function getTypeFromMime($mimeType) {
        switch ($mimeType) {
            case 'image/png':
                return IMAGETYPE_PNG;
            case 'image/jpeg':
                return IMAGETYPE_JPEG;
            case 'image/jpg':
                return IMAGETYPE_JPEG;
            case 'image/gif':
                return IMAGETYPE_GIF;
            default:
                return false;
        }
    }

    /**
     * Save an image as jpeg
     *
     * @param $source_image_path
     * @param $source_type  (enum image type or mime type)
     * @param $final_path
     * @param int $quality
     * @return bool
     */
    public static function saveImageAsJPG($source_image_path, $source_type, $final_path, $quality = 100) {

        if (!is_numeric($source_type)) {
            $source_type = self::getTypeFromMime($source_type);
        }

        switch ($source_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_image_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_image_path);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_image_path);
                break;
        }

        if ($source_gd_image === false) {
            return false;
        }

        $result = imagejpeg($source_gd_image, $final_path, $quality);
        imagedestroy($source_gd_image);
        return $result;

    }

    public static function clearImageCache($cacheBaseDir, $fileName) {
        if ($handle = opendir($cacheBaseDir)) {
            $blacklist = array('.', '..');
            while (false !== ($dir = readdir($handle))) {
                if (!in_array($dir, $blacklist)) {
                    $file = $cacheBaseDir . $dir . DIRECTORY_SEPARATOR . $fileName;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            closedir($handle);
        }
    }

    public static function getMessage(){
        die('sadfalksdjflkdsfsdfdsf');
    }

}