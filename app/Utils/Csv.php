<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;

class CSV
{
    private static $file = null;

    /**
     * 导出数据为CSV
     * @param string  $fileName
     * @param array   $header 表头(第一行)
     * @param array   $data   二维数组，数组中每个元素对应表格的一行。该元素可以是普通数组，也可以是 一个 Eloquent\Model
     */
    public static function export($fileName, $header, $data) {
        self::open($fileName);
        self::writeHeader($header);
        self::writeData($data);
        self::close();
    }


    /**
     * 打开输出流
     * @param $fileName
     */
    public static function open($fileName){
        if(substr($fileName, -4) != '.csv'){
            $fileName .= '.csv';
        }
        $fileName = mb_convert_encoding($fileName, 'gb2312');
        if(is_null(self::$file)){
            header("Pragma: public");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");
            header("Content-Transfer-Encoding:binary");
            header('Content-Disposition:inline;filename="' . $fileName . '"');
            self::$file = fopen('php://output', 'w');
        }
    }

    /**
     * 添加表头
     * @param array $headers
     */
    public static function writeHeader($headers){
        $line = '"' . implode('","', $headers) . '"';
        self::_writeLine(mb_convert_encoding($line, 'gb2312', 'UTF-8'));
    }

    /**
     * 追加数据
     * @param array $list
     */
    public static function writeData($list){
        foreach ($list as $rowIndex => $row) {
            if ($row instanceof Model) {
                $list[$rowIndex] = $row->toArray();
            }
            foreach ($list[$rowIndex] as $cellIndex => $cell){
                $list[$rowIndex][$cellIndex] = self::getFormattedCell($cell);
            }
            $line = '"' . implode('","', $list[$rowIndex]) . '"';
            self::_writeLine(mb_convert_encoding($line, 'gb2312', 'UTF-8'));
        }
    }

    /**
     * 追加一行
     * @param $line
     */
    private static function _writeLine($line){
        self::_write($line . "\r\n");
    }

    /**
     * 写数据
     * @param $text
     */
    private static function _write($text){
        if(!self::$file){
            exit('写入错误, 没有打开文件流');
        }
        fwrite(self::$file, $text);
    }

    /**
     * 关闭输出流
     */
    public static function close() {
        fclose(self::$file);
        die;
    }

    /**
     * 在长数字或特殊格式的字符串前面补充空格，以免文件打开时展示的是 'XXXXXX'
     *
     * @param $cell
     *
     * @return string
     */
    private static function getFormattedCell($cell)
    {
        // 在长数字(如身份证号，手机号)后面补充空格
        if (is_numeric($cell) and strlen($cell) > 9) {
            return  "\t".$cell;
        }
        // 在日期时间(如2017-7-26 14:15:13)后面补充空格
        if (is_string($cell) and strlen($cell) > 9 and strtotime($cell) !== false) {
            return "\t" .$cell ;
        }
        return $cell;
    }
}