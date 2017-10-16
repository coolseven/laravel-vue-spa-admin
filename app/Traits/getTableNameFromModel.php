<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/4
 * Time: 19:22
 */

namespace App\Traits;


trait getTableNameFromModel
{
    public static function getTableName(){
        return (new static)->getTable();
    }

}