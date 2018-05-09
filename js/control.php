<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 15:28
 */
include_once 'dbconnect.php';
//$sql=mysql_query("INSERT INTO total(mg_name,mg_type,mg_content) VALUES('ecnu','school','default')");
$allres= mysql_query("SELECT * FROM total ");



if(isset($_POST['add_thing']))//添加事件
{
    $mg_name = mysql_real_escape_string($_POST['mg_name']);
    $check_name= mysql_query("SELECT * FROM total WHERE mg_name='$mg_name'");
    $mg_type = mysql_real_escape_string($_POST['mg_type']);
    $mg_content=mysql_real_escape_string('default');
    $row = mysql_fetch_array($check_name);
    $_input=mysql_query("INSERT INTO total(mg_name,mg_type) VALUES('$mg_name','$mg_type')");
    if($_input){
        echo('添加成功');
    }

}

?>
