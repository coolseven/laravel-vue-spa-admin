<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/4
 * Time: 20:55
 */

namespace App\Models;
//
//use Jenssegers\Mongodb\Eloquent\Model;
use MongoModel;

class MongoUser extends MongoModel
{
    protected $connection = 'seven_local_mongodb';
    protected $collection = 'students';
}