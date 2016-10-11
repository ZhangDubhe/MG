<?php
/**
 * Created by PhpStorm.
 * User: Z
 * Date: 2016/9/27
 * Time: 21:40
 */
$my_server_name='localhost';//$引导变量传输字符串
$my_username='root';
$my_password='12345678';
$my_database='mg';

$conn=mysql_connect($my_server_name,$my_username,$my_password) or die("error connecting") ; //连接数据库

mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.

mysql_select_db($my_database); //打开数据库

$sql ="select * from loginfo "; //SQL语句

mysql_query($sql,$conn); //查询


?>