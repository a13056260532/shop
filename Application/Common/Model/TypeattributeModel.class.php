<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/17
 * Time: 下午4:25
 */

namespace Common\Model;


class TypeattributeModel extends BaseModel
{
    protected $pk = 'taid';
    protected $tableName = 'typeattribute';

    /**
     * 获取tid =$tid 的数据
     * @param $tid
     * @return mixed
     */
    public function getArriData($tid){
        return $this->where("tid={$tid}")->select();

    }
}