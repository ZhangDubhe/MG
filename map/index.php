<?php
session_start();
include_once 'js/connect/dbconnect.php';
ini_set('session.save_path','filesource/local');
//6个钟头
ini_set('session.gc_maxlifetime',21600);
//保存一天
$lifeTime = 180;

setcookie(session_name(), session_id(), time() + $lifeTime, "/");

?>





<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">
    <title>M.A.P.</title>
    <link rel="icon" href="filesource/img/favicon.ico" mce_href="filesource/img/favicon.ico" type="image/x-icon"/>

    <link rel="stylesheet" href="css/struct.css"/>
    <link rel="stylesheet" href="filesource/leaflet/leaflet.css" />
    <link rel="stylesheet" href="css/mobile-structure.css" />

    <script src="filesource/leaflet/leaflet-src.js"></script>
    <script src="js/EcnuBuildingJson2.js" type="text/javascript"></script>
    <script src="js/echarts.js" type="text/javascript"></script>
    <script src="js/control.js" type="text/javascript"></script>
    <script src="js/jquery.js" type="text/javascript"></script>

    <script src="js/control.php" type="js/text"></script>
    <style>

    </style>
    <script>
        var last_chose=0;
        function on_The_map(i) {
            console.debug(i);
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
<div id="left">
    <div id="header" >
        <img src="filesource\img\logo.svg" id="title"/>
    </div>
    <div id="log-sign">
        <nav id="tag" onclick="log_in()">
            <img src="filesource\img\login.svg" />
        </nav>
    </div>

    <div id="nav_group">
        <div class="nav"id="space" onclick="change_to_map()">
            空间
        </div>
        <div class="nav" id="gallery" onclick="change_to_list()">
            展览
        </div>
        <div class="nav" id="go-to-map" onclick="map_on()">
            地图
        </div>
        <div class="nav" id="mine">
            我的
        </div>
    </div>
    <div id="content" >
        <div >
            <!--putting those space into this section-->
            <div id="selector_space" >
                <input id="Checkbox3" type="checkbox" class="select_box" onclick="only_on()"/>美术馆
                <br/><br/>
                <section id="Art Museum"></section>
                <br/><br/>
                <input  id="Checkbox2" type="checkbox" class="select_box" onclick="only_on()" />专题博物馆
                <br/><br/>
                <section id="Art Museum"></section>
                <br/><br/>
                <input  id="Checkbox1" type="checkbox" class="select_box" onclick="only_on()"/>综合博物馆
                <br/><br/>
                <section id="Art Museum"></section>
                <br/><br/>
            </div>


            <div id="selector_list">
<!--                start-->

                <div id="selector_header" class="selector_header">
                    <select>
                        <option id="selector_option_1" selected>最新</option>
                        <option id="selector_option_2">最近</option>
                        <option id="selector_option_3">热门</option>
                        <option id="selector_option_4" onclick="add_more()" label="添加新展览">添加</option>
                    </select>


                </div>

                <div id="selector_li">
                    <form action="" class="select_type" method="GET">
                        <?php
                        $sql = "SELECT * FROM total ";
                        $check_name= mysql_query($sql);
                        $_i=1;
                        while($row=mysql_fetch_assoc($check_name)){
                            ?>
                            <a id="li_<?php echo $_i ?>"
                               name="<?php echo($row['mg_id']) ?>"
                               class="list_tag"
                               onclick="on_The_map(name)">
                                <b><?php echo($_i);$_i=$_i+1; ?> </b>
                                <?php echo($row['mg_name']); ?>

                            </a>

                        <?php } ?>
                        <input id="ii" type="submit" name="wanted" value="1"  />
                    </form>

                </div>

<!--                name 传递为list_%d id 为 li_%d -->

            </div>

        </div>

    </div>
</div>
<!--以上是左侧边栏，以下是地图及控件-->

    <a id="open_button"  onclick="left()" title="查看及关闭列表">
        <p>点击查看更多</p> </a>
    <a id="notice_para" >←LOOK HERE~</a>

<div >
    <div id="map">
        <a id="get_location" class="control_button" title="get_location" onclick="get_location()"></a>
    </div>



</div>

<form id="inputing" class="input_box" method="post" >
    <input type="text" id="adding_name" placeholder="展览或博物馆名" name="mg_name" required/>
    <input type="text" id="adding_type" placeholder="主题" name="mg_type" required/>
    <button title="添加" class="button" name="add_thing" required>添加</button>
    <button class="button" onclick="close_add_windows()">关闭</button>
</form>
<!--下为注册注册注册！-->
<form id="sign_in" class="input_box"  method="post">
    <h2>注册</h2>
    <table align="center" >
        <tr>
            <td><input type="text" name="name" placeholder="User Name" required /></td>
        </tr>
        <tr>
            <td><input type="text" name="email" placeholder="User Email" required /></td>
        </tr>
        <tr>
            <td><input type="password" name="password" placeholder="Your Password" required /></td>
        </tr>
        <tr>
            <td><button type="submit" name="btn-sign-in">Sign In</button></td>
        </tr>
        <tr>
            <td><a onclick="sign_in();" >Log In Here</a></td>
        </tr>
    </table>
</form>
<form id="log_in" class="input_box" method="post">
    <h2>登录</h2>
    <table align="center">
        <tr>
            <td><input type="text" name="usr_name" placeholder="Your user name" required /></td>
        </tr>
        <tr>
            <td><input type="password" name="pass" placeholder="Your Password" required /></td>
        </tr>
        <tr>
            <td><button type="submit" name="btn-log-in">Log In</button></td>
        </tr>
        <tr>
            <td><a onclick="log_in()">Sign in Here</a></td>
        </tr>
        <tr>
            <td><p id="info"></p></td>
        </tr>
    </table>
</form>

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
<script src="js/leaflets.js"></script>
<!--地图的点状要素，分类显示-->
<script>
    console.clear();
    var j = 0;
    var k = 0;
    var l = 0;
    var point_1=new Array();
    var point_2=new Array();
    var point_3=new Array();
    var point_all=new Array();
    var allIcon = {
            radius: 8,
            fillColor: "#ff7800",
            color: "#000",
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
    };

    var themeIcon ={
            fillColor: "#ff2148",
            color: "#000",
            radius: 8,
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        };
    var artIcon ={
            fillColor: "#78ff02",
            color: "#000",
            radius: 8,
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        };
function only_on() {
    var Obj1=document.getElementById('Checkbox1');
    var Obj2=document.getElementById('Checkbox2');
    var Obj3=document.getElementById('Checkbox3');


    if(Obj1.checked==true){
        if(j==0){only_1_on();}
    }
    else {
        while(j>0){
            point_1[j].remove();
            j=j-1;
        };
    }
    if(Obj2.checked==true){
        if(k==0){only_2_on();}
    }
    else
    {
        while(k>0){
            point_2[k].remove();
            k--;
        }
    }
    if(Obj3.checked==true ){
        if(l==0){only_3_on();}
    }
    else
    {
        while(l>0){
            point_3[l].remove();
            l=l-1;
        }
    }
    function only_1_on() {
        <?php
        $sql = "SELECT * FROM total where `mg_type`=1";
        $check_name = mysql_query($sql);
        $_i = 1;
        while($row = mysql_fetch_assoc($check_name)){
        ?>
            j=<?php echo $_i;$_i++ ?>;
            point_1[j] = L.circleMarker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>],allIcon)
                .bindPopup("<?php
                    echo($row['mg_name']);
                    echo("<br/>地址：");
                    echo($row['address']);
                    echo("<br/>");
                    echo($row['price_text']);
                    echo("<br/>开放时间：");
                    echo($row['opening_time'])
                    ?>");
            point_1[j].addTo(map);
        <?php } ?>

    }
    function only_2_on() {
        <?php
        $sql = "SELECT * FROM total where `mg_type`=2";
        $check_name = mysql_query($sql);
        $_i = 1;
        while($row = mysql_fetch_assoc($check_name)){
        ?>
            k=<?php echo $_i;$_i++ ?>;
            point_2[k] = L.circleMarker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>],themeIcon)
                .bindPopup("<?php
                    echo($row['mg_name']);
                    echo("<br/>地址：");
                    echo($row['address']);
                    echo("<br/>");
                    echo($row['price_text']);
                    echo("<br/>开放时间：");
                    echo($row['opening_time'])
                    ?>");
            point_2[k].addTo(map);
        <?php } ?>
    }
    function only_3_on() {
        <?php
        $sql = "SELECT * FROM total where `mg_type`=3";
        $check_name = mysql_query($sql);
        $_i = 1;
        while($row = mysql_fetch_assoc($check_name)){
        ?>
            l=<?php echo $_i ;$_i++?>;
            point_3[l] = L.circleMarker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>],artIcon)
                .bindPopup("<?php
                    echo($row['mg_name']);
                    echo("<br/>地址：");
                    echo($row['address']);
                    echo("<br/>");
                    echo($row['price_text']);
                    echo("<br/>开放时间：");
                    echo($row['opening_time'])
                    ?>");
            point_3[l].addTo(map);
            console.log(point_3[l])
        <?php } ?>

    }


}


    var list_id=0;
    <?php
    $sql = "SELECT * FROM total ";//查询所有的地点，并标记为id
    $check_name = mysql_query($sql);
    while($row = mysql_fetch_assoc($check_name)){?>
    list_id= <?php  echo($row['mg_id']) ?>;
    point_all[list_id] = L.marker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>])
        .bindPopup("<?php
            echo("<a class='pop_a' target='blank' style='font-size=2em;text-decoration: none;color:#2b2d2f;' href='".$row['website']."' >".$row['mg_name']."</a>");
            echo("<br/>地址：");
            echo($row['address']);
            echo("<br/>");
            echo($row['price_text']);
            echo("<br/>开放时间：");
            echo($row['opening_time'])
            ?>");//待打开的pop及marker

    <?php } ?>



</script>
</html>
