<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrizeModel extends Model
{
    public $table = 'p_prize';  //声明model使用的表
    public $timestamps = false; //时间戳
}
