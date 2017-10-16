<?php

namespace App\Utils;



use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode as EndroidQrCode;

class QrCode
{
    /**
     * 生成并下载二维码
     *
     * @param string $text      二维码内容
     * @param string $file_name 文件名称
     *
     */
    public static function downloadQrcode($text, $file_name){
        $qrCode = new EndroidQrCode($text);
        $qrCode->setMargin(4)
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
            ->setSize(200);

        // TODO 1. 临时文件的保存路径
        // TODO 2. 如何返回一个 下载类型的 response 对象并且实现下载后删除临时文件
        $temp_file_dir = config('app_temp_file_dir') ?: app()->storagePath().'/private/temp/';
        $temp_file_path = $temp_file_dir . $file_name;
        $temp_file_path = $qrCode->writeFile($temp_file_path);

        $file = fopen($temp_file_path, "r");
        Header("Content-type: application/octet-stream,charset=UTF-8");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: " . filesize($temp_file_path));
        Header("Content-Disposition: attachment; filename=" . $file_name);
        // 输出文件内容
        echo fread($file, filesize($temp_file_path));
        fclose($file);

        //下载完成后,删除该图片
        unlink($temp_file_path);
    }

    /**
     * 向浏览器绘制二维码
     *
     * @param string $text 二维码内容
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public static function renderQrcode($text){
        $qrCode = new EndroidQrCode($text);
        $qrCode->setMargin(4)
               ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
               ->setSize(200);

        return response()->make($qrCode->writeString(),200, [
            'Content-Type'  => $qrCode->getContentType(),
        ]);
    }
}