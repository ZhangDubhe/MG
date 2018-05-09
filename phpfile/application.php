<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6
 * Time: 15:34
 */
// 保存一天
$lifeTime = 24 * 3600;
#session_save_path($savePath);
session_set_cookie_params($lifeTime);
session_start();
if(isset($_SESSION['userId'])){
    $usrId = $_SESSION['userId'];
    $usrName = $_SESSION['userName'];

}
include_once ($_SERVER['DOCUMENT_ROOT'].'/M.A.P/js/connect/dbconnect.php');
if($_POST["sign"]){
    sign_in();
}
if($_POST["log"]){
    if(isset($_SESSION['usrId'])&& $_SESSION['admin']==true){
        echo 447;
    }
    else{
        $_SESSION['admin']=false;
        $_SESSION['usrId']='';
        $_SESSION['usrName']='';
        //验证失败 admin设为false
        log_in();
    }
}
if($_POST['logout']){
    session_start();
// 这种方法是将原来注册的某个变量销毁
    unset($_SESSION['admin']);
// 这种方法是销毁整个 Session 文件
//    session_destroy();
}
function log_in(){
    include_once '../js/connect/dbconnect.php';
    $usr_name=mysql_real_escape_string($_POST['username']);
    $upass = mysql_real_escape_string($_POST['password']);
    $res=mysql_query("SELECT * FROM loginfo WHERE usr_name='$usr_name'");
    $row=mysql_fetch_array($res);
    if(is_null($row['usr_name']))
    {
        echo 444;
//        不存在登录的用户名
    }
    else{
        if($row['password']==$upass)
        {
            session_start();
            $_SESSION['admin'] = False;
            $_SESSION['userName'] = $row['usr_name'];
            $_SESSION['userId']= $row['usr_id'];
            if($row['usr_name']=="admin"){$_SESSION['admin'] = True;}
            session_write_close();
            $img_path = 'filesource\img\logo_r.svg';
            echo "446,".$_SESSION['userName'].','.$img_path;
        }
        else
        {
            echo 445;
        }
    }

}
function sign_in(){
    include_once '../js/connect/dbconnect.php';
    $u_name = mysql_real_escape_string($_POST['username']);
    $res=mysql_query("SELECT * FROM loginfo WHERE usr_name='$u_name'");
    $pass = mysql_real_escape_string($_POST['password']);
    $email = mysql_real_escape_string($_POST['email']);
    $row=mysql_fetch_array($res);
    if($row['usr_name'])/*判断是否有存在的注册名*/
    {
        echo "不好啦，".$u_name."已经被占用了！";
    }
    else{
        if(mysql_query("INSERT INTO loginfo(usr_name,password,usr_email) VALUES('$u_name','$pass','$email')"))
        {
            session_start();
            $_SESSION['admin'] = False;
            $_SESSION['userName'] = $row['usr_name'];
            $_SESSION['userId']= $row['usr_id'];
            $img_path = 'filesource\img\logo_r.svg';
            if($row['admin']=="admin"){$_SESSION['admin'] = True;}
            session_write_close();
            echo "446,".$_SESSION['userName'].','.$img_path;
        }
        else
        {
            echo mysql_error();
            echo "程序猿小哥哥等会回来帮你debug";
        }
    }


}

function add_thing(){

    if(isset($_POST['add_thing']))//添加事件
    {
        $mg_name = mysql_real_escape_string($_POST['mg_name']);
        $check_name= mysql_query("SELECT * FROM total WHERE mg_name='$mg_name'");
        if($_POST['mg_type']="专题博物馆"){$mg_type='2';}
        if($_POST['mg_type']="美术馆"){$mg_type='3';}
        $mg_type = mysql_real_escape_string($_POST['mg_type']);
        $mg_content=mysql_real_escape_string('default');
        $row = mysql_fetch_array($check_name);
        $_input=mysql_query("INSERT INTO total(mg_name,address) VALUES('$mg_name','$mg_type')");
        if($_input){
            ?>
            <script>
				alert('添加成功');
				var pro_text=document.getElementById("adding_name");
				pro_text.value=null;
				var pro_text=document.getElementById("adding_type");
				pro_text.value=null;
            </script>
            <?php
        }
    }

}


?>