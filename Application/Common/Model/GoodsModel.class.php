<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/22
 * Time: 上午9:56
 */

namespace Common\Model;


use Think\Model;

class GoodsModel extends Model
{
    protected $pk = 'gid';
    protected $tableName = 'goods';
    //gname、gnumber、unit、marketprice、shopprice、pic
    //click、time、uid、bid、cid、tid、total
    protected $_validate = [
        ['gname', 'require', '请填写商品名称'],
        ['gnumber', 'number', '请重新填写商品货号'],
        ['unit', 'require', '请填写商品单位'],
        ['marketprice', 'currency', '请填写市场价'],
        ['shopprice', 'currency', '请填写商城价'],
        ['pic', 'require', '请选择列表图'],
        ['click', 'number', '请填写点击次数'],
        ['bid', 'require', '请填写选择品牌'],
        ['cid', 'require', '请填写商品分类'],
        ['tid', 'require', '请填写商品类型'],
    ];
    /**
     * 添加编辑方法
     * @param $data 处理的数据
     * @return array
     */
    public function store($data)
    {
        //dd($data);die;
        //验证商品表
        if (!$this->create()) {
            return ['valid' => false, 'message' => $this->getError()];
        }
        //实例化商品详情模型
        $goodDetail = new GooddetailModel();
        //验证详情表
        if (!$goodDetail->create()) {
            return ['valid' => false, 'message' => $goodDetail->getError()];
        }

        //验证商品属性
        if (!array_filter($data['attr'])){
            return ['valid' => false, 'message' => '请选择商品属性'];
        }
        $res = 1;
        //验证商品规格
        foreach ($data['spec'] as $jj=>$pp){
            foreach ($pp['spec'] as $k=>$v){
                if (!$v){
                    $res = 0;
                }
            }

        }
        if ($res==0){
            return ['valid' => false, 'message' => '请选择商品规格'];
        }
        //添加商品表
        //gname、gnumber、unit、marketprice、shopprice、pic
        //click、time、uid、bid、cid、tid、total
        $data['time'] = time();
        $data['uid'] = session('uid');
        $goodsWay = isset($data[$this->pk])?'save':'add';
        $gid = $this->$goodsWay($data);
        if ($goodsWay=="save"){
            $gid=$data['gid'];
        }
        //详情表添加
        //大图路径
        $bigpath = '';
        //小图路径
        $smallpath = '';
        //中图路径
        $mediumpath = '';
        //遍历存入大图
        foreach ($data['img'] as $k => $v) {
            $image = new \Think\Image();
            $image->open($v);
            //生成路径
            $dirpath = dirname($v);
            $baseName =  basename($v);
            //判断是旧数据提交的图片数据否
            if (substr($baseName,0,4)!="big_"){
                $baseName = 'big_'.$baseName;
            }
            $path = $dirpath . '/' . $baseName;
            $bigpath .= $path . '|';
            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
            $image->thumb(800, 800,\Think\Image::IMAGE_THUMB_FIXED)->save($path);
        }
        //遍历存入中图
        foreach ($data['img'] as $k => $v) {
            $image = new \Think\Image();
            $image->open($v);
            //生成路径
            $dirpath = dirname($v);
            $baseName = basename($v);
            //判断是旧数据提交的图片数据否
            if (substr($baseName,0,4)=="big_"){
                $baseName = str_replace('big_','medium_',$baseName);
            }else{
                $baseName = 'medium_' . basename($v);
            }
            $path = $dirpath . '/' . $baseName;
            $mediumpath .= $path . '|';
            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
            $image->thumb(400, 400,\Think\Image::IMAGE_THUMB_FIXED)->save($path);
        }
        //遍历存入小图
        foreach ($data['img'] as $k => $v) {
            $image = new \Think\Image();
            $image->open($v);
            //生成路径
            $dirpath = dirname($v);
            $baseName =basename($v);
            //判断是旧数据提交的图片数据否
            if (substr($baseName,0,4)=="big_"){
                $baseName = str_replace('big_','small_',$baseName);
            }else{
                $baseName = 'small_' . basename($v);
            }
            $path = $dirpath . '/' . $baseName;
            $smallpath .= $path . '|';
            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
            $image->thumb(80, 80,\Think\Image::IMAGE_THUMB_FIXED)->save($path);
        }
        //删除上传到服务器的文件
        if (isset($data['gid'])){
            foreach ($data['img'] as $k=>$v){
                $baseName =basename($v);
                //判断是旧数据提交的图片数据否
                if (substr($baseName,0,4)!="big_"){
                    unlink($v);
                }
            }
        }else{
            foreach ($data['img'] as $k=>$v){
                    unlink($v);
            }
        }

        /**
         * 生成要处理的数据
         */

        $detailData = [
            'small' => rtrim($smallpath, '|'),
            'big' => rtrim($bigpath, '|'),
            'medium' => rtrim($mediumpath, '|'),
            'intro' => $data['intro'],
            'service' => $data['service'],
            'gid' => $gid
        ];
        if ($goodsWay=="save"){
            $goodDetail->where("gid={$gid}")->save($detailData);
        }else{
            //执行添加
            $goodDetail->add($detailData);
        }
        //商品属性表添加
        $goodattri = new GoodsattriModel();
        //删除原有的当前商品的所有属性
        if ($goodsWay=='save'){
            $map['gaid']=['IN',$data['gaid']];
            $goodattri->where($map)->delete();
        }
        //循环规格数据写入数据库
        foreach ($data['spec'] as $k => $v) {
            foreach ($v['spec'] as $kk => $vv) {
                //判断追加价格是否为空
                if (!$v['added'][$kk]){
                    //为空就给他赋值为0
                    $v['added'][$kk]=0;
                }
                $attriData = [
                    'gavalue' => $vv,
                    'added' => $v['added'][$kk],
                    'gid' => $gid,
                    'taid' => $k,
                ];
                $goodattri->add($attriData);
            }
        }
        //循环属性数据写入数据库
        foreach ($data['attr'] as $m => $n) {
            $attriData = [
                'gavalue' => $n,
                'gid' => $gid,
                'taid' => $m
            ];
            $goodattri->add($attriData);
        }
        //删除货品表数据
        M('goodslist')->where("gid={$gid}")->delete();
        //成功返回
        return ['valid'=>true,'message'=>'添加成功'];
    }

    /**
     * 获取表数据
     */
    public function getGoodsData($gid){
            return $this->where("gid={$gid}")->find();
    }


}