<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/29
 * Time: 下午12:26
 */

namespace Home\Controller;


use Common\Model\PeopleuserModel;
use Think\Controller;
use Think\Crypt;

class LoginController extends Controller
{
    /**
     * 登陆界面
     */
    public function index(){
        if (isset($_SESSION['puid'])){
            $this->success('您已登陆过，无需重新登陆',session('waq_url'));die;
        }
        if (IS_AJAX){
            $data= I('post.');
            //获取提交的用户名
            $username= $data['username'];
            //通过获取的用户名去数据库查询是否存在数据
            $pdata  = M('peopleuser')->where("username='{$username}'")->find();
            //判断用户名是否存在
            if (!$pdata){
                //不存在提示错误
                $this->error('账号不存在,请重新输入');die;
            }
            //接着判断密码是否正确
            if (Crypt::encrypt($data['password'],'user')!=$pdata['password']){
                $this->error('密码不正确,请重新输入');die;
            }
            //判断验证码是否正确
            if (!$this->check_verify($data['code'])){
                $this->error('验证码不正确,请重新输入');die;
            }
            //走到这说明都正确，存session
            session('puid',$pdata['puid']);
            session('pusername',$data['username']);
            //成功提示

            $this->success('登陆成功',session('waq_url'));die;
        }
        $this->display();
    }

    /**
     * 注册页面
     */
    public function reg(){
        if (IS_AJAX){
            $data = I('post.');
            //执行模型的添加方法
            $res = (new PeopleuserModel())->store($data);
            //判断返回是否成功
            if ($res['valid']){
                //成功提示
                $this->success($res['message'],U('home/login/index'));die;
            }
            //失败提示
            $this->error($res['message']);die;
        }
        $this->display();
    }

    /**
     * 异步获取用户是否存在
     */
    public function ajaxGetUsername(){
        if (IS_AJAX){
            //判断提交的数据是否为空
            if ($_POST['username']==''){
                //为空直接返回
                echo  3; die;
            }
            //查询数据
            $data = M('peopleuser')->where("username='{$_POST['username']}'")->find();
            //判断username是否存在数据库
            if ($data){
                //有数据 返回错误
                echo 0;die;
            }
            //没数据返回正确
            echo 1;die;
        }
    }
    /**
     * 验证码
     */
    public function code(){
        $Verify =     new \Think\Verify();
        $Verify->fontSize = 30;
        $Verify->length   = 3;
        $Verify->useNoise = false;
        $Verify->entry();
    }
    /**
     * 验证码验证
     */
    public function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
    /**
     * 退出
     */
    public function out(){
        //清空所有session
        session(null);
        $this->redirect('home/login/index');
    }
}