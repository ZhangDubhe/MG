<?php
/**
 * Created by PhpStorm.
 * User: Z
 * Date: 2016/9/27
 * Time: 21:40
 */
//$my_server_name='localhost';//$引导变量传输字符串
//$my_username='root';
//$my_password='12345678';
$my_server_name = '139.224.8.209';
$my_username = 'zht';
$my_password = 'dubhe19960115zht';
$my_database='mg';

$conn=mysqli_connect($my_server_name,$my_username,$my_password,$my_database) or die("error connecting") ; //连接数据库 //打开数据库

mysqli_query($conn,"set names 'utf8mb4'"); //数据库输出编码 应该与你的数据库编码保持一致.

header("Content-Type: text/html; charset=utf-8");

//$sql ="select * from loginfo "; //SQL语句
//
//mysqli_query($sql,$conn); //查询


?>