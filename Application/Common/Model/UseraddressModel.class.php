<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/31
 * Time: 下午2:33
 */

namespace Common\Model;


use Think\Model;

class UseraddressModel extends Model
{
    protected $pk='uaid';
    protected $tableName='useraddress';
    protected $_validate=[
        ['uname','require','请输入收货人姓名'],
        ['site','require','请输入所属地址'],
        ['address','require','请输入详细地址'],
        ['postcode','require','请输入邮编'],
    ];

    /**
     * 添加收货地址
     */
    public function store($data){

        if ($this->create($data)){
            //判断是否是手机号
            if (!pregTel($data['tel'])){
                return ['valid'=>0,'message'=>'请输入正确的手机号码'];
            }
            //执行添加
            $uaid  = $this->data($data)->add();
            //如果是选中默认
            if ($data['is_m']==1){
                //其他的都变成0
                $m['is_m'] = 0;
                $this->where("uaid!={$uaid}")->save($m);
            }
            //成功返回
            return['valid'=>1,'message'=>'添加成功','uaid'=>$uaid];
        }else{
            //失败返回
            return ['valid'=>0,'message'=>$this->getError()];
        }
    }

    /**
     * 执行编辑
     */
    public function edit($data){

        if ($this->create($data)){
            //判断是否是手机号
            if (!pregTel($data['tel'])){
                return ['valid'=>0,'message'=>'请输入正确的手机号码'];
            }
            //执行编辑
            $this->data($data)->save();
            //如果是选中默认
            if ($data['is_m']==1){
                //其他的都变成0
                $m['is_m'] = 0;
                $this->where("uaid!={$data['uaid']}")->save($m);
            }
            //成功返回
            return['valid'=>1,'message'=>'添加成功'];
        }else{
            //失败返回
            return ['valid'=>0,'message'=>$this->getError()];
        }
    }
}