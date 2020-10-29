<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShowModel extends Model
{
    public $table = 'p_show';  //声明model使用的表
    protected $primaryKey ='id';  //声明表的主键
    public $timestamps = false; //时间戳
    protected $guarded = [];//黑名单
}
