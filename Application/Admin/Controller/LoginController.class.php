<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/16
 * Time: 下午5:22
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Crypt;

class LoginController extends Controller
{
   public function get_server_ip() {
        if (isset($_SERVER)) {
            if($_SERVER['SERVER_ADDR']) {
                $server_ip = $_SERVER['SERVER_ADDR'];
            } else {
                $server_ip = $_SERVER['LOCAL_ADDR'];
            }
        } else {
            $server_ip = getenv('SERVER_ADDR');
        }
        return $server_ip;
    }
    public function index(){
        //获取ip
        $str =get_outer();
        $str = substr($str,15);
        $ip = trim($str,'] ');
        if (IS_POST){

            //接收get参数
            $data = I('post.');
            //获取数据库的数据
            $user = M('user')->find(1);
            //判断账号密码是否正确
            if ($data['username']!=$user['username'] || $data['password']!=Crypt::decrypt($user['password'],'admin888') ){
                $this->error('账号或者密码不正确，请重新登陆');die;

            }
            //判断验证码是否正确
            $res = $this->check_verify($data['code']);
            if (!$res){
                $this->error('验证码不正确！');die;
            }
            //获取之前登录信息
            $loginData =M('user')->find(1);
            session('uid',$loginData['uid']);
            $loginData = json_encode($loginData,JSON_UNESCAPED_UNICODE);
            session('logindata',$loginData);
            //存入新的登录信息
            $model = M('user');
            $model->logintime = time();
            $model->loginip =$ip;
            $model->where("uid=1")->save();
            //存session
            session('username',$data['username']);
            $this->success('欢迎您再次归来。王者！',U('admin/index/index'));
            die;
        }
        $this->display();
    }

    /**
     * 实例化验证码
     */
    public function code(){
        $Verify =     new \Think\Verify();
        $Verify->fontSize = 30;
        $Verify->length   = 3;
        $Verify->useNoise = false;
        $Verify->entry();
    }
    /**
     * 验证码验证方法
     */
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /**
     * 退出登陆
     */
    public function out(){
        session(null);
        session('[destroy]');
        $this->success('退出成功',U('admin/login/index'));
    }

    /**
     * 修改密码
     */
    public function changePassword(){
        if (IS_POST){
            $data= I('post.');
            //判断输入密码是否为空
            if (strlen($data['newpassword1'])==0 && strlen($data['newpassword2'])==0 &&strlen($data['oldpassword'])==0){
                $this->error('密码不能为空');
            }
            //获取旧密码
            $oldpassword = M('user')->where('uid=1')->getField('password');
            //验证输入的旧密码是否和数据库的密码一样
            if (Crypt::encrypt($data['oldpassword'],'admin888') != $oldpassword){
                $this->error('旧密码错误，请重新输入.');die;
            }
            //判断两次输入的新密码是否一样
            if ($data['newpassword1'] !=$data['newpassword2']){
                $this->error('验证密码不正确，请重新输入');die;
            }
            //生成需要存入数据库的数据
            $data =[
                'uid'=>1,
                'username'=>'admin',
                'password'=>Crypt::encrypt($data['newpassword1'],'admin888')
            ];
            //执行数据库添加
            D('user')->save($data);
            //成功提示
            $this->success("修改成功",U('admin/index/index'));die;
        }
        $this->display();
    }

}