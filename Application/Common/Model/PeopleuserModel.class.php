<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/29
 * Time: 下午2:43
 */

namespace Common\Model;


use Think\Crypt;
use Think\Model;

class PeopleuserModel extends Model
{
    protected $pk = 'puid';
    protected $tableName ='peopleuser';
    protected $_validate = [
        ['username','require','请输入用户名'],
        ['password','require','请输入密码'],
    ];

    /**
     * 新增用户
     */
    public function store($data){
        //自动验证
        if (!$this->create()){
            return ['valid'=>0,'message'=>$this->getError()];
        }
        //验证两次输入的密码是否一样
        if ($data['password']!=$data['password1']){
            return ['valid'=>0,'message'=>'两次输入的密码不一样'];
        }
        //判断验证码是否正确
        if (!$this->check_verify($data['code'])){
            return ['valid'=>0,'message'=>'验证码不正确'];
        }
        //执行密码加密
        $data['password']=Crypt::encrypt($data['password'],'user');
        //写入数据库
        $this->add($data);
        //成功返回
        return ['valid'=>1,'message'=>'注册成功，请前往登陆'];

    }

    /**
     * 验证码验证
     */
    public function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
}