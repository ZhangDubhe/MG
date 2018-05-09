<?php

include_once('phpfile/application.php');

?>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">
    <title>M.A.P.</title>
    <link rel="icon" href="filesource/img/favicon.ico" mce_href="filesource/img/favicon.ico" type="image/x-icon"/>


    <link rel="stylesheet" href="filesource/leaflet/leaflet.css" />
    <link rel="stylesheet" href="css/mobile-structure.css" />
    <link rel="stylesheet" href="css/struct.css?v=20171107" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="filesource/leaflet/leaflet-src.js"></script>
<!--    <script src="js/EcnuBuildingJson2.js" type="text/javascript"></script>-->

    <style>

    </style>
    <script>
        var last_chose=0;
        function on_The_map(i) {
            if(last_chose!=0){
                point_all[last_chose].remove();
            }
            last_chose=i;
            point_all[i].addTo(map).openPopup();
            map.flyTo(point_all[i].getLatLng(),16)
        }
    </script>

</head>
<body >
<div class="container-fluid">
    <div class="row page">
        <div id="left_control" class="col-sm-4 col_both">
            <div class="row content_head">
                <!--主页图标-->
                <div  class="col-md-6 head_title" >
                    <a href="BG_AN.html">
                        <img src="filesource\img\logo.svg" id="title"/>
                    </a>
                </div>
                <!--头像图标,login需要先隐藏-->
                <div  class="col-md-6 head_tag" >
                    <a  href="#log_in"  data-toggle="modal" data-target="#log_in" title="登录">
                        <img src="filesource\img\login.svg" id="tag"/>
                        <p id="showUsrName" name="<? $usrName?>"></p>
                    </a>

                </div>

            </div>
            <div id="nav_group" class="row">
                <div class="g_nav col-xs-3 col-sm-6"id="space" onclick="change_to_map()">
                    空间
                </div>
                <div class="g_nav col-xs-3 col-sm-6" id="gallery" onclick="change_to_list();showGallery()">
                    展览
                </div>
                <div class="g_nav col-xs-3" id="go-to-map" onclick="map_on()">
                    地图
                </div>
                <div class="g_nav col-xs-3" id="mine">
                    我的
                </div>

            </div>

            <div id="content" class="row content">
                <!--putting those space into this section-->
                <div id="selector_space" class="col-sm-12 content_space" >
                    <div class="select_type">
                        <input id="Checkbox3" type="checkbox" class="select_box p-l-3" onclick="only_on();showArtMuseum()"/> 美术馆
                        <br/><br/>
                        <section id="Art_Museum" >
                        </section>
                        <br/><br/>

                        <input  id="Checkbox2" type="checkbox" class="select_box" onclick="only_on();showThemeMuseum()" /> 专题博物馆
                        <br/><br/>
                        <section id="Theme_Museum">
                        </section>
                        <br/><br/>

                        <input  id="Checkbox1" type="checkbox" class="select_box" onclick="only_on();showSynMuseum()"/> 综合博物馆
                        <br/><br/>
                        <section id="Synthesize_Museum">
                        </section>
                        <br/><br/>


                    </div>


                </div>
                <div id="selector_list" class="col-sm-12">
                    <!--                start-->

                    <div id="selector_header" class="row selector_header content_container">
                        <select class="col-sm-4">
                            <option id="selector_option_1" selected>最新</option>
                            <option id="selector_option_2">最近</option>
                            <option id="selector_option_3">热门</option>
                            <option id="selector_option_4" onclick="add_more()" label="添加新展览">添加</option>
                        </select>


                    </div>

                    <div id="selector_li" class="row content_container">
                        <form id="galleryContent" action="" class="select_type col-sm-11 p-l-0" method="GET">
                            <!--这里原来放了php-->
                            <input id="ii" type="submit" name="wanted" value="1"  />
                        </form>
                        <div class="filled"></div>
                    </div>

                    <!--                name 传递为list_%d id 为 li_%d -->

                </div>
            </div>
            <div id="foot" class="row footer_info">
                <p>Designing: <a href="person/syl.html">Sun Yalan</a>
                    ,Coding: <a href="person/zht.html">Zhang Haotian</a>,
                    <a href="person/qjl.html">Qian Jiale</a>
                </p>
            </div>
        </div>
        <!--以上是左侧边栏，以下是地图及控件-->
        <div id="right_map"class="col-sm-8 col_both">
            <div id="map">
                <a id="get_location" class="control_button" title="get_location" onclick="get_location()">
                </a>
            </div>
        </div>
        <iframe id="weather-plugin" allowtransparency="true" frameborder="0" width="410" height="98" scrolling="no" src="//tianqi.2345.com/plugin/widget/index.htm?s=1&z=1&t=1&v=0&d=2&bd=0&k=&f=&ltf=009944&htf=cc0000&q=1&e=1&a=1&c=54511&w=410&h=98&align=center"></iframe>
    </div>

</div>




<!--
<a id="open_button"  onclick="left()" title="查看及关闭列表">
        <p>点击查看更多</p> </a>
    <a id="notice_para" >←LOOK HERE~</a>
    -->


<!--添加-->
<form id="inputing" class="input_box" method="post" align="center" >
    <h2>添加行程</h2>
    <hr/>
    <table align="center">
    <tr>
        <td
            <input type="text" id="adding_name" placeholder="展览或博物馆名" name="mg_name" required/>
        </td>
    </tr>
    <tr>
        <td>
            <input type="text" id="adding_type" placeholder="主题" name="mg_type" required/>
        </td>
    </tr>
    <tr>
        <td>
            <button title="添加" class="button" name="add_thing" required>添加</button>
        </td>
    </tr>
    <tr>
        <td>
            <button class="button" onclick="close_add_windows()">关闭</button>
        </td>
    </tr>
</table>


</form>
<!--下为注册注册注册！sign_in()函数用以访问后台，
    注册成功后如何返回？增加新元素“usr_div”
    内容 1.天气悬浮窗 button
         2.再点击头像 更换头像 函数change_head_img()
          3.-->
<div id="sign_in" class="modal fade modal-sm" style="display:none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="Sign_title">注册</h4>

            </div>
            <div class="modal-body">
                <input id="sign_name"type="text"  placeholder="Your Nickname" />
                <br/>
                <input id="sign_email" type="text"  placeholder="Your Email" />
                <br/>
                <input id="sign_password" type="password" placeholder="Your Password"/>
                <br/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" name="to_log_in" onclick="change_sign_way(this.name)" data-dismiss="modal" >
                    登录
                </button>
                <button type="button" class="btn btn-primary" onclick="sign_in()">注册</button>
            </div>
        </div>
    </div>
</div>
<!--以下为登录，log_in()函数用以登录后台-->
<div id="log_in" class="modal fade modal-sm" style="display:none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="log_title">登录</h4>

            </div>
            <div class="modal-body">
                <input id="log_name"type="text"  placeholder="Your Nickname" />
                <br/>

                <input id="log_password" type="password" placeholder="Your Password"/>
                <br/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" name="to_sign_in" onclick="change_sign_way(this.name);">
                    注册
                </button>
                <button type="button" class="btn btn-primary" onclick="log_in()">登录</button>
            </div>
        </div>
    </div>
</div>


<div  id="mobile-head" class="control_face">
<center>
    <a id="mobile-selector-selected">最新<img src="./filesource/img/arrow.png"/></a>
    <div id="mobile-selector" >
        <a id="m-s-1">最近</a>
        <a id="m-s-2">最新</a>
        <a id="m-s-3">热门</a>
        <a id="m-s-4">即将结束</a>
        <a id="m-s-5">即将开始</a>
    </div>
</center>
</div>
</body>

<!--引入leaflet地图层-->
<script src="js/jquery-3.2.0.min.js" charset="UTF-8"></script>
<script>
	window.jQuery || document.write('<script src="js/jquery.js"><\/script>')
</script>
<script src="js/bootstrap.js" charset="UTF-8"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/control.js" charset="UTF-8"></script>
<script src="js/leaflets.js"></script>
<!--地图的点状要素，分类显示-->
<script src="filesource/layer/layer.js" charset="UTF-8"></script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/M.A.P/phpfile/addPoint.php");

?>
<script>
	var list_g_id=0;
    <?php
    $sql = "SELECT * FROM exhibition ";//查询所有的地点，并标记为id
    $check_name = mysql_query($sql);
    while($row = mysql_fetch_assoc($check_name)){?>
	list_g_id= <?php  echo($row['eventId']) ?>;
	point_all[list_g_id] = L.marker([<?php echo($row['eventLatWGS84']) ?>,<?php echo($row['eventLonWGS84']) ?>])
		.bindPopup("<?php
            $p_g_name = $row['eventName'];
            echo("<span onclick='check_here($p_g_name);change_heart()'class='glyphicon glyphicon-heart'><h5><a class='pop_a' target='blank'  href='".$row['eventUrl']."' >".$row['eventName']."</a></h5></span>");
            echo("<br/>地址：");
            echo(str_replace('\"','',$row['eventAddress']));
            echo("<br/>票价：");
            echo($row['eventPrice']);
            echo("<br/>开放时间：");
            echo($row['eventBeginDay'].'~'.$row['eventEndDay'])
            ?>");//待打开的pop及marker

    <?php } ?>
</script>
</html>
