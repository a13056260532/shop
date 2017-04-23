<?php

/**
 * 我们自定义助手函数库
 */
/**
 * 打印函数
 * @param $var  打印数据
 */
function dd($var){
    echo "<pre style='padding: 15px;background: #ccc;border-radius: 6px'>";
    if(is_null($var)){
        var_dump($var);
    }elseif(is_bool($var)){
        var_dump($var);
    }else{
        print_r($var);
    }
    echo '</pre>';
}


if ( ! function_exists( 'v' ) ) {
    /**
     * 全局变量
     *
     * @param null $name 变量名
     * @param string $value 变量值
     *
     * @return array|mixed|null|string
     */
    function v( $name = null, $value = '[null]' ) {
        static $vars = [ ];
        if ( is_null( $name ) ) {
            return $vars;
        } else if ( $value == '[null]' ) {
            //取变量
            $tmp = $vars;
            foreach ( explode( '.', $name ) as $d ) {
                if ( isset( $tmp[ $d ] ) ) {
                    $tmp = $tmp[ $d ];
                } else {
                    return null;
                }
            }

            return $tmp;
        } else {
            //设置
            $tmp = &$vars;
            foreach ( explode( '.', $name ) as $d ) {
                if ( ! isset( $tmp[ $d ] ) ) {
                    $tmp[ $d ] = [ ];
                }
                $tmp = &$tmp[ $d ];
            }

            return $tmp = $value;
        }
    }
}
/**
 * 生成连接到Addons里面的方法
 * @param $url 按照 模块/控制器/方法 传个字符串
 * @param $data
 * @return string
 */
function url($url,$data=null){
    $url = explode('/',$url); ['kid'=>12];
    if ($data){
        $data = str_replace('&','/',http_build_query($data));
        $data = str_replace('=','/',$data);
        return __ROOT__."/index.php/module/index/index/mo/{$url[0]}/t/{$url[1]}/ac/{$url[2]}/".$data.'.html';
    }else{
        return __ROOT__."/index.php/module/index/index/mo/{$url[0]}/t/{$url[1]}/ac/{$url[2]}".'.html';
    }
}
/**
 * 加密函数
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function aqencrypt($txt, $key = ''){
    if (empty($txt)) return $txt;
    if (empty($key)) $key = md5(MD5_KEY);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $nh1 = rand(0,64);
    $nh2 = rand(0,64);
    $nh3 = rand(0,64);
    $ch1 = $chars{$nh1};
    $ch2 = $chars{$nh2};
    $ch3 = $chars{$nh3};
    $nhnum = $nh1 + $nh2 + $nh3;
    $knum = 0;$i = 0;
    while(isset($key{$i})) $knum +=ord($key{$i++});
    $mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum%8,$knum%8 + 16);
    $txt = base64_encode(time().'_'.$txt);
    $txt = str_replace(array('+','/','='),array('-','_','.'),$txt);
    $tmp = '';
    $j=0;$k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i=0; $i<$tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = ($nhnum+strpos($chars,$txt{$i})+ord($mdKey{$k++}))%64;
        $tmp .= $chars{$j};
    }
    $tmplen = strlen($tmp);
    $tmp = substr_replace($tmp,$ch3,$nh2 % ++$tmplen,0);
    $tmp = substr_replace($tmp,$ch2,$nh1 % ++$tmplen,0);
    $tmp = substr_replace($tmp,$ch1,$knum % ++$tmplen,0);
    return $tmp;
}
/**
 * 解密函数
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function aqdecrypt($txt, $key = '', $ttl = 0){
    if (empty($txt)) return $txt;
    if (empty($key)) $key = md5(MD5_KEY);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $knum = 0;$i = 0;
    $tlen = @strlen($txt);
    while(isset($key{$i})) $knum +=ord($key{$i++});
    $ch1 = @$txt{$knum % $tlen};
    $nh1 = strpos($chars,$ch1);
    $txt = @substr_replace($txt,'',$knum % $tlen--,1);
    $ch2 = @$txt{$nh1 % $tlen};
    $nh2 = @strpos($chars,$ch2);
    $txt = @substr_replace($txt,'',$nh1 % $tlen--,1);
    $ch3 = @$txt{$nh2 % $tlen};
    $nh3 = @strpos($chars,$ch3);
    $txt = @substr_replace($txt,'',$nh2 % $tlen--,1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum % 8,$knum % 8 + 16);
    $tmp = '';
    $j=0; $k = 0;
    $tlen = @strlen($txt);
    $klen = @strlen($mdKey);
    for ($i=0; $i<$tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars,$txt{$i})-$nhnum - ord($mdKey{$k++});
        while ($j<0) $j+=64;
        $tmp .= $chars{$j};
    }
    $tmp = str_replace(array('-','_','.'),array('+','/','='),$tmp);
    $tmp = trim(base64_decode($tmp));
    if (preg_match("/\d{10}_/s",substr($tmp,0,11))){
        if ($ttl > 0 && (time() - substr($tmp,0,11) > $ttl)){
            $tmp = null;
        }else{
            $tmp = substr($tmp,11);
        }
    }
    return $tmp;
}
/**
 * 正则匹配url
 */
function pregURL($test){
    /**
    匹配url
    url规则：
    例
    协议://域名（www/tieba/baike...）.名称.后缀/文件路径/文件名
    http://zhidao.baidu.com/question/535596723.html
    协议://域名（www/tieba/baike...）.名称.后缀/文件路径/文件名?参数
    www.lhrb.com.cn/portal.php?mod=view&aid=7412
    协议://域名（www/tieba/baike...）.名称.后缀/文件路径/文件名/参数
    http://www.xugou.com.cn/yiji/erji/index.php/canshu/11

    协议：可有可无，由大小写字母组成；不写协议则不应存在://，否则必须存在://
    域名：必须存在，由大小写字母组成
    名称：必须存在，字母数字汉字
    后缀：必须存在，大小写字母和.组成
    文件路径：可有可无，由大小写字母和数字组成
    文件名：可有可无，由大小写字母和数字组成
    参数:可有可无，存在则必须由?开头，即存在?开头就必须有相应的参数信息
     */
    $rule = '/^(([a-zA-Z]+)(:\/\/))?([a-zA-Z]+)\.(\w+)\.([\w.]+)(\/([\w]+)\/?)*(\/[a-zA-Z0-9]+\.(\w+))*(\/([\w]+)\/?)*(\?(\w+=?[\w]*))*((&?\w+=?[\w]*))*$/';
    preg_match($rule,$test,$result);
    return $result;
}

/**
 * 正则匹配手机号
 * @param $phonenumber 验证字段
 */
function pregTel($phonenumber){
    if(preg_match("/^1[34578]{1}\d{9}$/",$phonenumber)){
        return true;
    }else{
        return false;
    }
}


/**
 * 获取用户ip
 * @return mixed
 */
function get_outer()
{
    $url = 'http://www.ip138.com/ip2city.asp';
    $info = file_get_contents($url);
    preg_match('|<center>(.*?)</center>|i', $info, $m);
    return $m[1];
}