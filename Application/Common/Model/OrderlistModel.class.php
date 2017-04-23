<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/4/5
 * Time: 上午10:20
 */

namespace Common\Model;


use Think\Model;

class OrderlistModel extends Model
{
    protected $pk='olid';
    protected $tableName='orderlist';
    protected $_validate= [];
}