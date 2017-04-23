<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8"/>
    <title>后台管理 | 安琪</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="/shop/Public/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/shop/Public/css/animate.css" type="text/css"/>
    <link rel="stylesheet" href="/shop/Public/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="/shop/Public/css/font.css" type="text/css"/>
    <link rel="stylesheet" href="/shop/Public/js/calendar/bootstrap_calendar.css" type="text/css"/>
    <link rel="stylesheet" href="/shop/Public/js/jvectormap/jquery-jvectormap-1.2.2.css" type="text/css"/>
    <link rel="stylesheet" href="/shop/Public/css/app.css" type="text/css"/>
    <script src="/shop/node_modules/hdjs/js/jquery.min.js"></script>
    <script src="/shop/Public/layer/layer.js"></script>
    <!--[if lt IE 9]>
    <script src="/shop/Public/js/ie/html5shiv.js"></script>
    <script src="/shop/Public/js/ie/respond.min.js"></script>
    <script src="/shop/Public/js/ie/excanvas.js"></script>
    <![endif]-->
    <script>
        //配置后台地址
        var hdjs = {
            'base': '/shop/node_modules/hdjs',
            'ueditor': '',
            'uploader': '/shop/system/Component/uploader',
            'removeImage': '删除图片后台地址'
        };
    </script>
    <script src="/shop/node_modules/hdjs/app/util.js"></script>
    <script src="/shop/node_modules/hdjs/require.js"></script>
    <script src="/shop/node_modules/hdjs/config.js"></script>
</head>
<style>
    .ng-cloak {
        display: none;
    }
</style>

<body ng-cloak class="ng-cloak">
<section class="vbox">
    <header class="bg-black dk header navbar navbar-fixed-top-xs">
        <div class="navbar-header aside-md">
            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                <i class="fa fa-bars"></i>
            </a>
            <a href="#" class="navbar-brand" data-toggle="fullscreen"><img src="/shop/Public/images/logo.png"
                                                                           class="m-r-sm"><?php echo v('config.webname');?></a>
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                <i class="fa fa-cog"></i>
            </a>
        </div>
        <ul class="nav navbar-nav hidden-xs">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle dker" data-toggle="dropdown">
                    <i class="fa fa-wordpress"></i>
                    <span class="font-bold"> 文章管理</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle dker" data-toggle="dropdown">
                    <i class="fa fa-paper-plane"></i>
                    <span class="font-bold"> 文章管理</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle dker" data-toggle="dropdown">
                    <i class="fa fa-building-o"></i>
                    <span class="font-bold"> 配置管理</span>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
            <li class="hidden-xs">
                <a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-sm up bg-danger m-l-n-sm count">2</span>
                </a>
                <section class="dropdown-menu aside-xl">
                    <section class="panel bg-white">
                        <header class="panel-heading b-light bg-light">
                            <strong>You have <span class="count">2</span> notifications</strong>
                        </header>
                        <div class="list-group list-group-alt animated fadeInRight">
                            <a href="#" class="media list-group-item">
                  <span class="pull-left thumb-sm">
                    <img src="/shop/Public/images/avatar.jpg" alt="John said" class="img-circle">
                  </span>
                                <span class="media-body block m-b-none">
                    Use awesome animate.css<br>
                    <small class="text-muted">10 minutes ago</small>
                  </span>
                            </a>
                            <a href="#" class="media list-group-item">
                  <span class="media-body block m-b-none">
                    1.0 initial released<br>
                    <small class="text-muted">1 hour ago</small>
                  </span>
                            </a>
                        </div>
                        <footer class="panel-footer text-sm">
                            <a href="#" class="pull-right"><i class="fa fa-cog"></i></a>
                            <a href="#notes" data-toggle="class:show animated fadeInRight">See all the notifications</a>
                        </footer>
                    </section>
                </section>
            </li>
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle dker" data-toggle="dropdown"><i class="fa fa-fw fa-search"></i></a>
                <section class="dropdown-menu aside-xl animated fadeInUp">
                    <section class="panel bg-white">
                        <form role="search">
                            <div class="form-group wrapper m-b-none">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-icon"><i class="fa fa-search"></i></button>
                    </span>
                                </div>
                            </div>
                        </form>
                    </section>
                </section>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
              <img src="/shop/Public/images/avatar.jpg">
            </span>
                    <?php echo session('username');?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInRight">
                    <span class="arrow top"></span>
                    <li>
                        <a href="<?php echo U('admin/login/changePassword');?>">修改密码</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo u('admin/login/out');?>">退出</a>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <aside class="bg-light lter b-r aside-md hidden-print hidden-xs" id="nav">
                <section class="vbox">
                    <header class="header bg-primary lter text-center clearfix">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-dark btn-icon" title="New project"><i
                                    class="fa fa-plus"></i></button>
                            <div class="btn-group hidden-nav-xs">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                        data-toggle="dropdown">
                                    快捷导航
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu text-left">
                                    <li><a href="#">网站配置</a></li>
                                    <li><a href="#">公众号设置</a></li>
                                </ul>
                            </div>
                        </div>
                    </header>
                    <section class="w-f scrollable">
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0"
                             data-size="5px" data-color="#333333">

                            <!-- nav -->
                            <nav class="nav-primary hidden-xs">
                                <ul class="nav">
                                    <li class="active">
                                        <a href="index.html" class="active">
                                            <i class="fa fa-dashboard icon">
                                                <b class="bg-danger"></b>
                                            </i>
                                            <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                                            <span>基本设置</span>
                                        </a>
                                        <ul class="nav lt">
                                            <li>
                                                <a href="<?php echo U('admin/config/set');?>">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>网站配置</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#layout">
                                            <i class="fa fa-columns icon">
                                                <b class="bg-warning"></b>
                                            </i>
                                            <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                                            <span>类型管理</span>
                                        </a>
                                        <ul class="nav lt">
                                            <li>
                                                <a href="<?php echo u('admin/type/lists');?>">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>类型列表</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo u('admin/type/add');?>">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>类型添加</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#uikit">
                                            <i class="fa fa-flask icon">
                                                <b class="bg-success"></b>
                                            </i>
                                            <span class="pull-right">
                                                <i class="fa fa-angle-down text"></i>
                                                <i class="fa fa-angle-up text-active"></i>
                                            </span>
                                            <span>分类管理</span>
                                        </a>
                                        <ul class="nav lt">
                                            <li>
                                                <a href="<?php echo U('admin/cate/lists');?>">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>分类列表</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('admin/cate/add');?>">
                                                    <!--<b class="badge bg-info pull-right">369</b>-->
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>顶级分类添加</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#uikit">
                                            <i class="fa fa-flask icon">
                                                <b class="bg-success"></b>
                                            </i>
                                            <span class="pull-right">
                                                <i class="fa fa-angle-down text"></i>
                                                <i class="fa fa-angle-up text-active"></i>
                                            </span>
                                            <span>品牌管理</span>
                                        </a>
                                        <ul class="nav lt">
                                            <li>
                                                <a href="<?php echo U('admin/brand/lists');?>">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>品牌列表</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('admin/brand/add');?>">
                                                    <!--<b class="badge bg-info pull-right">369</b>-->
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>品牌添加</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#uikit">
                                            <i class="fa fa-flask icon">
                                                <b class="bg-success"></b>
                                            </i>
                                            <span class="pull-right">
                                                <i class="fa fa-angle-down text"></i>
                                                <i class="fa fa-angle-up text-active"></i>
                                            </span>
                                            <span>商品管理</span>
                                        </a>
                                        <ul class="nav lt">
                                            <li>
                                                <a href="<?php echo U('admin/goods/lists');?>">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>商品列表</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('admin/goods/add');?>">
                                                    <!--<b class="badge bg-info pull-right">369</b>-->
                                                    <i class="fa fa-angle-right"></i>
                                                    <span>商品添加</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </nav>
                            <!-- / nav -->
                        </div>
                    </section>

                    <footer class="footer lt hidden-xs b-t b-light">
                        <div id="chat" class="dropup">
                            <section class="dropdown-menu on aside-md m-l-n">
                                <section class="panel bg-white">
                                    <header class="panel-heading b-b b-light">Active chats</header>
                                    <div class="panel-body animated fadeInRight">
                                        <p class="text-sm">No active chats.</p>
                                        <p><a href="#" class="btn btn-sm btn-default">Start a chat</a></p>
                                    </div>
                                </section>
                            </section>
                        </div>
                        <div id="invite" class="dropup">
                            <section class="dropdown-menu on aside-md m-l-n">
                                <section class="panel bg-white">
                                    <header class="panel-heading b-b b-light">
                                        John <i class="fa fa-circle text-success"></i>
                                    </header>
                                    <div class="panel-body animated fadeInRight">
                                        <p class="text-sm">No contacts in your lists.</p>
                                        <p><a href="#" class="btn btn-sm btn-facebook"><i
                                                class="fa fa-fw fa-facebook"></i> Invite from Facebook</a></p>
                                    </div>
                                </section>
                            </section>
                        </div>
                        <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-light btn-icon">
                            <i class="fa fa-angle-left text"></i>
                            <i class="fa fa-angle-right text-active"></i>
                        </a>
                        <div class="btn-group hidden-nav-xs">
                            <i class="fa fa-user-md"></i> 客服: <?php echo v('config.tel');?>
                            <!--<button type="button" title="Chats" class="btn btn-icon btn-sm btn-light" data-toggle="dropdown" data-target="#chat"><i class="fa fa-comment-o"></i></button>-->
                            <!--<button type="button" title="Contacts" class="btn btn-icon btn-sm btn-light" data-toggle="dropdown" data-target="#invite"><i class="fa fa-facebook"></i></button>-->
                        </div>
                    </footer>
                </section>
            </aside>
            <!-- /.aside -->

            <section id="content">
                <section class="vbox">
                    <section class="scrollable padder">
                        
我是首页
                    </section>
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open"
                   data-target="#nav,html"></a>
            </section>
        </section>
    </section>
</section>
<script>
    require(['util', 'underscore'], function ($, _) {
        require(['/shop/Public/js/app.js','css!/shop/Public/css/app.css']);

        require(['angular', 'jquery'], function (angular,$) {
            angular.module('app', []).controller('ctrl', ['$scope', function ($scope) {

                if (typeof(controller)=='function') {
                    controller($scope, $, _);
                }

            }]);
            angular.bootstrap(document.getElementsByTagName('body'), ['app']);
        });
    });
</script>
<!--<script src="/shop/Public/js/bootstrap.js"></script>-->
<!--<script src="/shop/Public/js/app.js"></script>-->
<!--<script src="/shop/Public/js/slimscroll/jquery.slimscroll.min.js"></script>-->
<!--<script src="/shop/Public/js/charts/easypiechart/jquery.easy-pie-chart.js"></script>-->
<!--<script src="/shop/Public/js/charts/sparkline/jquery.sparkline.min.js"></script>-->
<!--<script src="/shop/Public/js/charts/flot/jquery.flot.min.js"></script>-->
<!--<script src="/shop/Public/js/charts/flot/jquery.flot.tooltip.min.js"></script>-->
<!--<script src="/shop/Public/js/charts/flot/jquery.flot.resize.js"></script>-->
<!--<script src="/shop/Public/js/charts/flot/jquery.flot.grow.js"></script>-->
<!--<script src="/shop/Public/js/charts/flot/demo.js"></script>-->

<!--<script src="/shop/Public/js/calendar/bootstrap_calendar.js"></script>-->
<!--<script src="/shop/Public/js/calendar/demo.js"></script>-->

<!--<script src="/shop/Public/js/sortable/jquery.sortable.js"></script>-->

<!--<script src="/shop/Public/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>-->
<!--<script src="/shop/Public/js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>-->
<!--<script src="/shop/Public/js/jvectormap/demo.js"></script>-->
<!--<script src="/shop/Public/js/app.plugin.js"></script>-->
</body>
</html>