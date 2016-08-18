<?php

namespace Core\ComunBundle\Util;

use FOS\UserBundle\Util\CanonicalizerInterface;
use Imagine\Gd\Imagine;

class Util implements CanonicalizerInterface {

    public static function objsToId($val) {
        $ids = array();
        foreach ($val as $obj)
            $ids[] = $obj->getId();
        return $ids;
    }

    public static function boolean($val, $center = true) {
        if ($center)
            return $val == true ? '<div class="text-center"><i class="fa fa-check" ></i></div>' : "";
        else
            return $val == true ? '<i class="fa fa-check" ></i>' : "";
    }

    public static function activo($val) {
        if ($val)
            return 'Activo';
        return 'Inactivo';
    }

    public static function activa($val) {
        if ($val)
            return 'Activa';
        return 'Inactiva';
    }

    public static function sino($val) {
        if ($val)
            return 'Sí';
        return 'No';
    }

    public static function text($val) {
        if ($val)
            return $val;
        return '';
    }

    public static function generarRandom() {
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_*-";
        $randlength = mt_rand(strlen($alphabet), strlen($alphabet) * 2);
        $randomValue = "";
        while ($randlength > 0) {
            $el = mt_rand(0, strlen($alphabet) - 1);
            $randomValue .= "" . $alphabet[$el];
            $randlength--;
        }
        return md5($randomValue);
    }

    public static function makeCanonic($name) {
        $name = strtolower($name);
        $name = str_replace('ñ', 'n', $name);
        $name = str_replace('á', 'a', $name);
        $name = str_replace('í', 'i', $name);
        $name = str_replace('é', 'e', $name);
        $name = str_replace('ó', 'o', $name);
        $name = str_replace('ú', 'u', $name);
        $name = str_replace('Á', 'a', $name);
        $name = str_replace('É', 'e', $name);
        $name = str_replace('Í', 'i', $name);
        $name = str_replace('Ó', 'o', $name);
        $name = str_replace('Ú', 'u', $name);

        return $name;
    }

    public function canonicalize($name) {
        return Util::makeCanonic($name);
    }

    public static function generarNumericRandom($length) {
        $alphabet = "1234567890";
        $randlength = $length;
        $randomValue = "Z";
        while ($randlength > 0) {
            $el = mt_rand(0, strlen($alphabet) - 1);
            $randomValue .= "" . $alphabet[$el];
            $randlength--;
        }
        return $randomValue;
    }

    public static function createFileDirectory($nameRoute) {
        if (!file_exists("../web/digitalizaciones/" . $nameRoute))
            mkdir("../web/digitalizaciones/" . $nameRoute);

        return self::createFileThumbNailDirectory($nameRoute);
    }

    private static function createFileThumbNailDirectory($nameRoute) {
        if (!file_exists("../web/digitalizaciones/" . $nameRoute . "/thumbnails")) {
            mkdir("../web/digitalizaciones/" . $nameRoute . "/thumbnails");
            return true;
        }
        return false;
    }

    public static function resizeImagen($direccion_foto, $nombre, $width, $height, $nuevoNombre = null) {
        $imagine = new Imagine();
        if ($nuevoNombre == null)
            $nuevoNombre = $nombre;
        $imagine->open($direccion_foto . "/" . $nombre)->resize(
                new \Imagine\Image\Box($width, $height))->save($direccion_foto . "/" . $nuevoNombre);
    }

    public static function createThumbnail($ruta, $nombre) {
        $imagine = new Imagine();
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
        $imagine->open($ruta . "/" . $nombre)->thumbnail(new \Imagine\Image\Box(100, 100), $mode)->save($ruta . "/thumbnails/" . $nombre);
    }

    public static function determineImageScale($sourceWidth, $sourceHeight, $targetWidth, $targetHeight) {
        $scalex = $targetWidth / $sourceWidth;
        $scaley = $targetHeight / $sourceHeight;
        return min($scalex, $scaley);
    }

    public static function returnCorrectFunction($ext) {
        $function = "";
        switch ($ext) {
            case "png":
                $function = "imagecreatefrompng";
                break;
            case "jpeg":
                $function = "imagecreatefromjpeg";
                break;
            case "jpg":
                $function = "imagecreatefromjpeg";
                break;
            case "gif":
                $function = "imagecreatefromgif";
                break;
        }
        return $function;
    }

    public static function parseImage($ext, $img, $file = null) {

        switch ($ext) {
            case "png":
                imagepng($img, ($file != null ? $file : ''));
                break;
            case "jpeg":
                imagejpeg($img, ($file ? $file : ''), 90);
                break;
            case "jpg":
                imagejpeg($img, ($file ? $file : ''), 90);
                break;
            case "gif":
                imagegif($img, ($file ? $file : ''));
                break;
        }
    }

    public static function setTransparency($imgSrc, $imgDest, $ext) {

        if ($ext == "png" || $ext == "gif") {
            $trnprt_indx = imagecolortransparent($imgSrc);
            // If we have a specific transparent color
            if ($trnprt_indx >= 0) {
                // Get the original image's transparent color's RGB values
                $trnprt_color = imagecolorsforindex($imgSrc, $trnprt_indx);
                // Allocate the same color in the new image resource
                $trnprt_indx = imagecolorallocate($imgDest, $trnprt_color['red'], $trnprt_color['blue'], $trnprt_color['blue']);
                // Completely fill the background of the new image with allocated color.
                imagefill($imgDest, 0, 0, $trnprt_indx);
                // Set the background color for new image to transparent
                imagecolortransparent($imgDest, $trnprt_indx);
            }
            // Always make a transparent background color for PNGs that don't have one allocated already
            elseif ($ext == "png") {
                // Turn off transparency blending (temporarily)
                imagealphablending($imgDest, true);
                // Create a new transparent color for image
                $color = imagecolorallocatealpha($imgDest, 0, 0, 0, 127);
                // Completely fill the background of the new image with allocated color.
                imagefill($imgDest, 0, 0, $color);
                // Restore transparency blending
                imagesavealpha($imgDest, true);
            }
        }
    }
    public static function convertStringToTime($time) {
        $hora = new \DateTime();
        $exploded = explode(":",$time);
        $hora->setTime($exploded[0],$exploded[1],0);
        return $hora;
    }
    public static function convertStringToDate($date) {
        $r = date_create($date);
        if($r) {
            $today = new \DateTime();
            if ($today->format('Y') == $r->format('Y') && $today->format('m') == $r->format('m') && $today->format('d') == $r->format('d'))
                return false;
            return $r;
        }
        return false;
    }    
}
