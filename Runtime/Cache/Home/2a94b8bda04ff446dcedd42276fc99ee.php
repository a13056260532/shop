<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo ($title); ?></title>
    <link rel="icon" type="text/css" href="/shop/Public/home/shop.ico"/>
    <?php if(is_array($cs)): foreach($cs as $key=>$v): ?><link rel="stylesheet" type="text/css" href="/shop/Public/home/css/<?php echo ($v); ?>.css"/><?php endforeach; endif; ?>
    <script src="/shop/Public/home/js/jquery-1.10.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var ajaxGetUinfo = "<?php echo U('home/account/ajaxGetUinfo')?>";
    </script>
    <script src="/shop/Public/layer/layer.js"></script>
    <?php if(is_array($js)): foreach($js as $key=>$vo): ?><script src="/shop/Public/home/js/<?php echo ($vo); ?>.js" type="text/javascript" charset="utf-8"></script><?php endforeach; endif; ?>
</head>
<body>
<!--头部开始-->
<div id="top">
    <!--头部灰条就开始-->
    <div class="topbox">
        <div class="main">
            <div class="topleft fl">
                <a href="<?php echo U('home/index/index');?>">欢迎来到天使商城</a>
                <script>
                    function AddFavorite(sURL, sTitle)
                    {

                        try
                        {
                            window.external.addFavorite(sURL, sTitle);
                        }
                        catch (e)
                        {
                            try
                            {
                                window.sidebar.addPanel(sTitle, sURL, "");
                            }
                            catch (e)
                            {
                                alert("加入收藏失败，请使用Ctrl+D进行添加");
                            }
                        }
                    }
                    //设为首页 <a onclick="SetHome(this,window.location)">设为首页</a>
                    function SetHome(obj,vrl){
                        try{
                            obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);
                        }
                        catch(e){
                            if(window.netscape) {
                                try {
                                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                                }
                                catch (e) {
                                    alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
                                }
                                var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                                prefs.setCharPref('browser.startup.homepage',vrl);
                            }
                        }
                    }
                </script>
                <a  href="javascript:;" onclick="SetHome(this,window.location)" >设为首页</a>
                <a  href="javascript:;"    onclick="AddFavorite(window.location,document.title)"  >收藏本站</a>
            </div>
            <div class="topright fr">
                <?php if(!isset($_SESSION['puid'])): ?><div class="login fl">
                        <a href="<?php echo U('home/login/index');?>">登录</a>
                        <a href="<?php echo U('home/login/reg');?>">注册</a>
                    </div>
                    <?php else: ?>
                    <div class="login fl">
                        <i style="color: white;">尊敬的会员:</i><i style="color: red;"><?php echo session('pusername');?></i><i
                            style="color: white;">,欢迎您的大驾光临！</i>
                        <a href="<?php echo U('home/login/out');?>" style="color: red"> 退出</a>

                    </div><?php endif; ?>
                <span class="fl">|</span>
                <div class="fcode fl">

                    <a href="<?php echo U('home/orderList/index');?>">我的订单</a>
                </div>
            </div>
        </div>
    </div>
    <!--头部灰条结束-->
    <!--logo区域开始-->
    <div class="logoRegion">
        <div class="main">
            <div class="logo">
                <a href="<?php echo U('home/index/index');?>"><img src="/shop/Public/home/images/timg.jpeg"/></a>
            </div>
            <div class="seachRegion">
                <div class="seach fl">
                    <form action="" method="post" onsubmit="return searchgoods(this)" >
                        <?php if($seach_waq): ?><input type="text" class="seachtxt fl" value="<?php echo ($seach_waq); ?>"/>

                            <?php else: ?>
                        <input type="text" class="seachtxt fl" value="手机"/><?php endif; ?>
                        <input type="submit" class="btn" value=""/>
                    </form>
                    <script>
                        function searchgoods() {
                            location.href = "<?php echo u('home/lists/index');?>"+'?p='+$('.seachtxt').val();
                            return false;
                        }
                    </script>
                    <p class="searchkey">
                        <?php if(is_array($allGoodsData)): $i = 0; $__LIST__ = array_slice($allGoodsData,0,2,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vzv): $mod = ($i % 2 );++$i;?><a href="<?php echo U('home/content/index',['gid'=>$vzv['gid']]);?>"><?php echo ($vzv['gname']); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                    </p>

                </div>
                <style>
                    .cart-tips ul {
                        display: block;
                        padding: 6px 12px;
                        background: #fff;
                        font-size: 12px;
                    }

                    .cart-tips ul li {
                        display: block;
                        height: 72px;
                        line-height: 72px;
                        padding: 6px 0;
                        border-top: none;
                        list-style: none;
                        border-top: 1px solid #ddd;
                    }

                    .cart-tips ul li:nth-of-type(1) {

                        border-top: none;
                    }

                    .cart-tips ul li img {
                        float: left;
                    }

                    .cart-tips ul li .mccs {
                        float: left;
                        line-height: 20px;
                        width: 140px;
                    }

                    .cart-tips ul li .cart_pr {
                        color: #333;
                        float: left;
                        height: 100%;
                        text-align: right;
                        width: 60px;
                    }

                    .cart-tips ul li .cart_nb {
                        color: #333;
                        float: left;
                        height: 100%;
                        text-align: center;
                        width: 60px;
                    }

                    .cart-tips ul li .mccs strong {
                        display: table-cell;
                        font-weight: 400;
                        height: 72px;
                        overflow: hidden;
                        vertical-align: middle;
                    }

                    .cart-count {
                        background: #f6f6f6;
                        color: #31373c;
                        font-size: 12px;
                        height: 40px;
                        line-height: 40px;
                        padding: 10px 15px 10px 20px;
                    }

                    .cart_count_left {
                        display: block;
                        width: 100%;
                        float: left;
                    }

                    .cart_count_left a {
                        display: block;
                        background: #30ab38;
                        border-radius: 2px;
                        color: #fff;
                        float: right;
                        font-size: 14px;
                        height: 40px;
                        line-height: 40px;
                        text-align: center;
                        width: 120px;
                    }
                    .cart_count_left a:hover{
                        color: red;
                    }
                </style>
                <?php if(!isset($mynameiscart) && $mynameiscart!=123){?>
                <div n="{}" class="topshopcart fr">
                    <a href="<?php echo U('home/cart/index');?>" class="header-cart"><i></i>我的购物车<span class="cart-size"
                                                                                            style="color: red">  (<span class="allnum"><?php if($_SESSION['cart']['total_rows']==0): ?>0<?php else: echo ($_SESSION['cart']['total_rows']); endif; ?></span>) </span></a>

                    <div class="cart-tips">
                            <?php if($_SESSION['cart']['total_rows']==0): ?>您的购物车暂无商品，赶紧去选购吧！
                                <?php else: ?>
                                <ul>
                                    <?php if(is_array($_SESSION['cart']['goods'])): foreach($_SESSION['cart']['goods'] as $k=>$vo): ?><li>
                                            <img src="/shop/<?php echo ($vo['options']['img']); ?>"
                                                 style="width: 72px;height: 72px;" alt="">
                                            <span class="mccs"><strong><?php echo ($vo['name']); ?>（<?php if(is_array($vo['options']['options'])): foreach($vo['options']['options'] as $kk=>$vv): echo ($kk); ?>:<?php echo ($vv); endforeach; endif; ?>）</strong></span>
                                            <span class="cart_pr">
                                    <span>￥</span>
                                    <?php echo ($vo['price']); ?>
                                </span>
                                            <span class="cart_nb">×<?php echo ($vo['num']); ?></span>
                                            <a href="javascript:;" momey="<?php echo ($vo['total']); ?>" num="<?php echo ($vo['num']); ?>"
                                               aq_sid="<?php echo ($k); ?>">X</a>
                                        </li><?php endforeach; endif; ?>
                                </ul>
                                <div class="cart-count">
                            <span class="cart_count_left">共<b class="cart_num_aq" style="color: red;"><?php echo ($_SESSION['cart']['total_rows']); ?></b>件商品 总价<b
                                    style="color: red;">￥</b><span
                                    style="color: red"><?php echo ($_SESSION['cart']['total']); ?></span>
                                <a href="<?php echo U('home/cart/index');?>">去购物车</a>
                            </span>
                                </div>
                                <script>
                                    $('.cart-tips ul li a').click(function () {
                                        //获取商品的id
                                        var sid = $(this).attr('aq_sid');
                                        var THIS = $(this);
                                        //获取当前商品总价格
                                        var oldmomey = parseInt($(this).attr('momey'));
                                        //抓住当前商品的数量
                                        var cartnum = parseInt(THIS.attr('num'));
                                        //获取商品总价
                                        var allmomey = parseInt($('.cart-count .cart_count_left span').html());
                                        $.post("<?php echo U('home/cart/delShops');?>", {goodid: sid}, function (res) {
                                            if (res == 1) {
                                                //获取原来的总数量
                                                var cartallnum = parseInt($('.topshopcart .header-cart .cart-size .allnum').html());
                                                //新数量等于旧总数量减去当前的商品数量
                                                var newcartnum = cartallnum - cartnum;
                                                //判断购物车内是否还有商品。
                                                if (newcartnum == 0) {
                                                    //如果没有修改小购物车的内容
                                                    $('.topshopcart .cart-tips').html('您的购物车暂无商品，赶紧去选购吧！')
                                                }
                                                //修改购物车内的数量数据
                                                $('.topshopcart .header-cart .cart-size .allnum').html(newcartnum);
                                                $('.cart-count .cart_count_left .cart_num_aq').html(newcartnum);
                                                //获取删除商品后的新价格
                                                var newmomey = allmomey - oldmomey;
                                                //编辑新价格
                                                $('.cart-count .cart_count_left span').html(newmomey)
                                                //移除当前元素
                                                THIS.parents('li').remove();
                                            }
                                        }, 'json')
                                    })
                                </script><?php endif; ?>
                    </div>
                </div>
                <?php }?>
            </div>

        </div>
    </div>
    <!--logo区域结束-->
    <!--导航开始-->
    <div class="navbox">
        <div class="main">
            <h5 class="fl"><a href="<?php echo U('home/lists/index');?>"><i></i>全部智能酷品</a></h5>
            <ul class="menu fl">
                <?php if(is_array($cid)): $k = 0; $__LIST__ = array_slice($cid,0,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$topvo): $mod = ($k % 2 );++$k;?><li class="menulist">
                    <a href="<?php echo U('home/lists/index',['cid'=>$topvo]);?>"><?php echo M('category')->where("cid=$topvo")->getField('cname');?></a>
                    <div class="menuHiden">
                        <ul class="product">
                            <?php $path = 'data'.($k-1);$cidData = $$path;?>
                            <?php if(is_array($cidData)): $aq_kk = 0; $__LIST__ = array_slice($cidData,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$topvo): $mod = ($aq_kk % 2 );++$aq_kk;?><li>
                                <a href="<?php echo U('home/content/index',['gid'=>$topvo['gid']]);?>">
                                    <img src="/shop/<?php echo ($topvo['pic']); ?>" alt=""/>
                                </a>
                                <span style="display: block;width:150px;color: red; text-align: center; font-size: 10px">￥<?php echo ($topvo['shopprice']); ?></span>

                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>

        </div>
        <?php if(CONTROLLER_NAME=='Index'): ?><div class="main hiden">
                <div class="navHidden">
                    <ul class="list2">
                        <?php if(is_array($cateData)): $i = 0; $__LIST__ = array_slice($cateData,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <a href="<?php echo U('home/lists/index',['cid'=>$vo['cid']]);?>"><i></i><?php echo ($vo['cname']); ?></a>
                                <div class="listhide">
                                    <div class="contentOne">
                                        <?php if(is_array($vo['_data'])): $i = 0; $__LIST__ = array_slice($vo['_data'],0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><dl>
                                                <dt><a href="<?php echo U('home/lists/index',['cid'=>$v['cid']]);?>"><?php echo ($v['cname']); ?>&gt;</a>
                                                </dt>
                                                <?php if(is_array($v['_data'])): $i = 0; $__LIST__ = array_slice($v['_data'],0,9,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><dd>
                                                        <a href="<?php echo U('home/lists/index',['cid'=>$vv['cid']]);?>"
                                                           class="noo"><?php echo ($vv['cname']); ?></a>
                                                    </dd><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </dl><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </div>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <!--两张图-->
                <!--<div class="topad">-->
                    <!--<div class="righttopad">-->
                        <!--<a href=""><img src="/shop/Public/home/images/right.png"/></a>-->
                    <!--</div>-->
                    <!--<div class="righttopad">-->
                        <!--<a href=""><img src="/shop/Public/home/images/right.png"/></a>-->
                    <!--</div>-->
                <!--</div>-->
            </div><?php endif; ?>
    </div>
    <!--导航结束-->
    <div class="clear"></div>

    <?php if(CONTROLLER_NAME=='Index'){ ?>
    <!--banner开始-->
    <div class="banner">
        <ul class="pic">
            <li style='background: url("/shop/Public/home/images/lb1.jpg") no-repeat center center;'>
                <a href="<?php echo U('home/content/index',['gid'=>44]);?>"></a>
            </li>
            <li style="background: url(/shop/Public/home/images/lb2.jpg) no-repeat center center;">
                <a href="<?php echo U('home/content/index',['gid'=>1]);?>"></a>
            </li>
            <li style="background: url(/shop/Public/home/images/lb3.jpg) no-repeat center center;">
                <a href="<?php echo U('home/content/index',['gid'=>45]);?>"></a>
            </li>
            <li style="background: url(/shop/Public/home/images/lb4.jpg) no-repeat center center;">
                <a href="<?php echo U('home/content/index',['gid'=>46]);?>"></a>
            </li>
            <li style="background: url(/shop/Public/home/images/lb5.jpg) no-repeat center center;">
                <a href="<?php echo U('home/content/index',['gid'=>44]);?>"></a>
            </li>

        </ul>
        <ul class="dot">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <span class="prev"></span><span class="next"></span>
    </div>
    <!--banner结束-->
    <?php }?>
</div>
<!--头部结束-->






<!--中间开始-->
<div id="content">
	<div class="main">
		<div class="tip">
			<ul>
				<?php if(is_array($goodsData)): $i = 0; $__LIST__ = array_slice($goodsData,0,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="background: #fff;">
						<a   href="<?php echo U('home/content/index',['gid'=>$vo['gid']]);?>">
							<img style=" height: 241px;" src="/shop/<?php echo ($vo['pic']); ?>" alt="" />
							<span style="display: block;color:red; text-align: center;"><?php echo ($vo['gname']); ?></span>
							<span style="display: block; color:red; text-align: center;">$<?php echo ($vo['shopprice']); ?></span>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>

			</ul>
		</div>
		<div class="hot" id="hot">
			<h5 class="hline">
				<span class="vline"></span>
				<span class="tiao"></span>
				<span class="zi">热门活动</span>
				<span class="tiao"></span>
				<span class="vline"></span></h5>
		</div>
		<ul class="part-container">
			<li class="ac0">
				<a href="<?php echo U('home/content/index',['gid'=>43]);?>" target="_blank"><img class="js-lazyload" src="/shop/Public/home/images/1.webp"> </a>
			</li>
			<li class="ac1">
				<a href="<?php echo U('home/content/index',['gid'=>40]);?>" target="_blank"><img class="js-lazyload" src="/shop/Public/home/images/2.webp"> </a>
			</li>
			<li class="ac2">
				<a href="<?php echo U('home/content/index',['gid'=>24]);?>" target="_blank"> <img class="js-lazyload" src="/shop/Public/home/images/3.webp"> </a>
			</li>
			<li class="ac3">
				<a href="<?php echo U('home/content/index',['gid'=>39]);?>" target="_blank"> <img class="js-lazyload" src="/shop/Public/home/images/4.webp"> </a>
			</li>
			<li class="ac4">
				<a href="<?php echo U('home/content/index',['gid'=>44]);?>" target="_blank"> <img class="js-lazyload" src="/shop/Public/home/images/5.webp"> </a>
			</li>
			<li class="ac5">
				<a href="<?php echo U('home/content/index',['gid'=>43]);?>" target="_blank"> <img class="js-lazyload" src="/shop/Public/home/images/1.webp"> </a>
			</li>
		</ul>


		<?php if(is_array($cid)): $k = 0; $__LIST__ = array_slice($cid,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><!--楼层一-->
		<div class="container" id="floor<?php echo ($k); ?>">
			<div class="part-title"><?php echo M('category')->where("cid=$vo")->getField('cname');?></div>
			<div class="part-hot">
				<span class="hotsou">热搜：</span>
				<ul>
					<?php $path = 'data'.($k-1);$cidData = $$path;?>
					<li>
						<a href="<?php echo U('home/content/index',['gid'=>$cidData[0]['gid']]);?>" target="_blank"><?php echo ($cidData[0]['gname']); ?></a>
					</li>
					<li>|</li>
					<li>
						<a href="<?php echo U('home/content/index',['gid'=>$cidData[1]['gid']]);?>" target="_blank"><?php echo ($cidData[1]['gname']); ?></a>
					</li>

				</ul>
			</div>
			<a href="<?php echo U('home/lists/index',['cid'=>$vo]);?>" target="_blank" class="indexmore">更多</a>
		</div>
		<div class="container">
			<div class="part-left">
				<a class="part-left1" href="<?php echo U('home/content/index',['gid'=>36]);?>" target="_blank">
					<img src="/shop/Public/home/images/flot1.webp">
				</a>
				<a class="part-left2" href="<?php echo U('home/content/index',['gid'=>43]);?>" target="_blank">
					<img src="/shop/Public/home/images/shouji.webp">
				</a>
			</div>
			<div class="part-center">
				<ul>
					<?php if(is_array($cidData)): $i = 0; $__LIST__ = array_slice($cidData,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><li>
						<a href="<?php echo U('home/content/index',['gid'=>$vv['gid']]);?>">
							<span class="title"><?php echo ($vv['gname']); ?></span>
							<span class="info"><?php echo ($vv['gname']); ?></span>
							<span class="price">￥<?php echo ($vv['shopprice']); ?></span>
							<img style="width: 164px;height: 164px;" src="/shop/<?php echo ($vv['pic']); ?>" alt="" />
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<div class="part-right">
				<p class="part-suggest-title">热销推荐</p>
				<div class="slideBox">
					<div class="slider-film">
						<?php if(is_array($cidData)): $i = 0; $__LIST__ = array_slice($cidData,0,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?><a href="<?php echo U('home/content/index',['gid'=>$vvv['gid']]);?>">
							<dl>
								<dt><img src="/shop/<?php echo ($vvv['pic']); ?>" > </dt>
								<dd class="title"><?php echo ($vvv['gname']); ?></dd>
								<dd class="info"><?php echo ($vvv['gname']); ?></dd>
								<dd class="price"><i class="yen">￥</i><?php echo ($vvv['shopprice']); ?></dd>
							</dl>
						</a><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="slider-film">
						<?php if(is_array($cidData)): $i = 0; $__LIST__ = array_slice($cidData,4,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?><a href="<?php echo U('home/content/index'),['gid'=>$vvv['gid']];?>">
								<dl>
									<dt><img src="/shop/<?php echo ($vvv['pic']); ?>" > </dt>
									<dd class="title"><?php echo ($vvv['gname']); ?></dd>
									<dd class="info"><?php echo ($vvv['gname']); ?></dd>
									<dd class="price"><i class="yen">￥</i><?php echo ($vvv['shopprice']); ?></dd>
								</dl>
							</a><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
				<div class="slide-point">
					<a href="javascript:;" class="curr-point"></a>
					<a href="javascript:;"></a>
				</div>

			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>


		<!--新品速递-->
		<div class="newproduct" id="newproduct">
			<div class="part-title">新品速递</div>
			<ul class="newproduct-list">
				<?php if(is_array($allGoodsData)): foreach($allGoodsData as $key=>$vvvv): ?><li>
					<a href="<?php echo U('home/content/index',['gid'=>$vvvv['gid']]);?>" class="new-item">
						<dl>
							<dt><img  class="js-lazyload" src="/shop/<?php echo ($vvvv['pic']); ?>"></dt>
							<dd class="title"><?php echo ($vvvv['gname']); ?></dd>
							<dd class="price"><span><i class="yen">￥</i><?php echo ($vvvv['shopprice']); ?></span> <?php echo date('Y-m-d',$vvvv['time']);?>上新</dd>
						</dl>
					</a>
				</li><?php endforeach; endif; ?>
			</ul>
			<div class="nomore" style="display: block;">没有更多了</div>
		</div>
	</div>
</div>
<!--中间结束-->



<!--左侧楼层开始-->
<div class="floor">
	<ul>
		<li class="on1">
			<a href="javascript:;"><span>1F<br />活动</span></a>
		</li>
		<li class="on2">
			<a href="javascript:;"><span>2F<br />活动</span></a>
		</li>
		<li class="on3">
			<a href="javascript:;"><span>3F<br />活动</span></a>
		</li>
		<li class="on5">
			<a href="javascript:;"><span>4F<br />活动</span></a>
		</li>
		<li class="on6">
			<a href="javascript:;"><span>6F<br />活动</span></a>
		</li>
	</ul>

</div>
<!--左侧楼层结束-->

<!--尾部开始-->
<div class="mod-footer">
    <div class="foot-bannerw">
        <div class="foot-banner clearfix">
            <div class="banner-item">
                <a href="#" target="_blank" data-monitor="home_foot_days7"><i class="icon1">7</i>7天无理由退货</a>
            </div>
            <div class="banner-item">
                <a href="#" target="_blank" data-monitor="home_foot_days15"><i class="icon2">15</i>15天免费换货</a>
            </div>
            <div class="banner-item"><i class="icon3">包</i>满99元包邮</div>
            <div class="banner-item">
                <a href="#" target="_blank" data-monitor="home_foot_moblie"><i class="icon4">服</i>手机特色服务</a>
            </div>
        </div>
    </div>
    <div class="foot-containerw">
        <div class="foot-container clearfix">
            <dl class="foot-con">
                <dt data-monitor="home_foot_freshman">前端项目</dt>
                <dd data-monitor="home_help_freshman">
                    <a target="_blank" href="http://www.weilezy.com/mt/index.html" rel="nofollow">我的美团</a>
                </dd>
                <dd>
                    <a target="_blank" href="http://www.weilezy.com/jd/index.html" rel="nofollow">我的京东</a>
                </dd>
                <dd>
                    <a target="_blank" href="http://www.weilezy.com/small/index.html" rel="nofollow">微场景开发</a>
                </dd>
                <dd>
                    <a target="_blank" href="http://www.weilezy.com/weixinduan/index.html" rel="nofollow">angularjs前后端交互</a>
                </dd>
                <dd>
                    <a target="_blank" href="http://www.weilezy.com/angular/index.html" rel="nofollow">响应式页面开发</a>
                </dd>
            </dl>
            <dl class="foot-con">
                <dt data-monitor="home_foot_help">php项目</dt>
                <dd data-monitor="home_help_help">
                    <a target="_blank" href="http://www.weilezy.com/angular/index.html">商城项目</a>
                </dd>
                <dd>
                    <a target="_blank" href="http://www.weilezy.com/myblog/index.html" rel="nofollow">个人博客1</a>
                </dd>
                <dd>
                    <a target="_blank" href="http://www.weilezy.com/blog/index.html" rel="nofollow">个人博客2</a>
                </dd>

            </dl>


        </div>
    </div>
    <div class="footer-copyright">天使商城 ©2017-2018 安琪版权所有 </div>
</div>
<!--尾部结束-->
<!--右边底部返回顶部-->
<div class="slidebar" id="slidebar">
    <ul>
        <li class="topback">
            <a href="javascript:;"></a>
        </li>
    </ul>
</div>
<!--右边底部返回顶部结束-->
</body>

</html>