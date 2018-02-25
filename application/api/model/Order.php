<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/25
 * Time: 23:06
 */

namespace app\api\model;


class Order extends BaseModel {
    protected $hidden=['user_id','delete_time','update_time'];
}