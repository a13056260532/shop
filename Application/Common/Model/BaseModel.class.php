<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/17
 * Time: 上午10:30
 */

namespace Common\Model;


use Think\Model;

class BaseModel extends Model
{
    /**
     * 公共添加
     * @param $data 处理的数据
     * @return array 返回处理的结果
     */
    public function store($data){
        if ($this->create($data)){
            //判断是添加还是编辑
            $res = isset($data[$this->pk]) ?'save':'add';
            //执行添加或者编辑
            $res = $this->$res($data);
            return ['valid' => true, 'message' => '编辑成功','data'=>$res];
        }else{
            return ['valid' => false, 'message' => $this->getError()];
        }
    }
}