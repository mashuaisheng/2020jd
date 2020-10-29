<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    public $table = 'cinema';  //声明model使用的表
    protected $primaryKey ='c_id';  //声明表的主键
    public $timestamps = false; //时间戳
    protected $guarded = [];//黑名单
}
