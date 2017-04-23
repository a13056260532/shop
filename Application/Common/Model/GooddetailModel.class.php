<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/22
 * Time: 上午9:59
 */

namespace Common\Model;


use Think\Model;

class GooddetailModel extends Model
{
    protected $pk='';
    protected $tableName='gooddetail';
    protected $_validate = [
        ['intro','require','请填写商品描述'],
        ['service','require','请填写商品描述'],
    ];
}