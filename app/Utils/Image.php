<?php


namespace App\Utils;

class ImageHandler
{

    /**
     * 图片压缩 函数
     * 压缩函数，无论多大的图片，都压缩到稍小于1m的大小
     *
     * @param string $srcImgPath  原图路径
     *
     * @param string $destImgPath 目标图片路径
     *
     * @return bool|string
     */
    public static function compress( $srcImgPath , $destImgPath = '') {
        if (empty( $srcImgPath)) {
            return false;
        }
        $srcImgFileSize = filesize( $srcImgPath);
        if ($srcImgFileSize <= 0) {
            return false;
        }

        list($width, $height, $type) = getimagesize( $srcImgPath);
        $srcImgInfo = array(
            'width' => $width,
            'height' => $height,
            'type' => image_type_to_extension($type, false),
        );

        $imgCreator = "imagecreatefrom" . $srcImgInfo['type'];
        $srcImgInMemory = $imgCreator( $srcImgPath);

        $percent = sqrt(500000 / $srcImgFileSize);    // 经过计算，图片大小小于 1m ，以0.47m为压缩基数比例
        $destImgWidth = $srcImgInfo['width'] * $percent;
        $destImgHeight = $srcImgInfo['height'] * $percent;

        $destImgInMemory = imagecreatetruecolor($destImgWidth, $destImgHeight);
        imagecopyresampled($destImgInMemory, $srcImgInMemory, 0, 0, 0, 0, $destImgWidth, $destImgHeight, $srcImgInfo['width'], $srcImgInfo['height']);
        imagedestroy($srcImgInMemory);

        if (empty($destImgPath)) {
            $destImgPath = dirname( $srcImgPath) . '/' . md5(time() . rand(1, 100)) . '.' . $srcImgInfo[ 'type'];
        }

        $imgCreator = "image" . $srcImgInfo['type'];
        if ($imgCreator($destImgInMemory, $destImgPath)) {
            return $destImgPath;
        }

        imagedestroy($destImgInMemory);
        return false;
    }

}