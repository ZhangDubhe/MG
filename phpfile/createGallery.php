<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/20
 * Time: 10:24
 */
include_once '../js/connect/dbconnect.php';
//展开gallery的内容
if($_GET['gallery'])
{
    $sql = "SELECT * FROM exhibition ";
    $check_name= mysql_query($sql);
    $_i=1;
    while($row=mysql_fetch_assoc($check_name)){
        $name=$row['eventId'];
        echo "<a id='ga_".$_i."' name='".$name."' class='list_tag col_sm_12' onclick='on_The_map(name)'>";
        echo "<b>".$_i."</b>";
        $_i=$_i+1;
        echo $row['eventName'];
        echo "</a>";
    }

    echo mysql_error();
}
if($_GET['Syn']){
    $sql = "SELECT * FROM total where `mg_type`=1";
    $check_name= mysql_query($sql);
    $_i=1;
    while($row=mysql_fetch_assoc($check_name)){
        $name=$row['mg_id'];
        echo "<a id='li_".$_i."' name='".$name."' class='list_tag col_sm_12' onclick='on_The_map(name)'>";
        echo "<b>".$_i."</b>";
        $_i=$_i+1;
        echo $row['mg_name'];
        echo "</a>";
    }

    echo mysql_error();
}
if($_GET['theme']){
    $sql = "SELECT * FROM total where `mg_type`=2";
    $check_name= mysql_query($sql);
    $_i=1;
    while($row=mysql_fetch_assoc($check_name)){
        $name=$row['mg_id'];
        echo "<a id='li_".$_i."' name='".$name."' class='list_tag col_sm_12' onclick='on_The_map(name)'>";
        echo "<b>".$_i."</b>";
        $_i=$_i+1;
        echo $row['mg_name'];
        echo "</a>";
    }

    echo mysql_error();
}
if($_GET['art']){
    $sql = "SELECT * FROM total where `mg_type`=3";
    $check_name= mysql_query($sql);
    $_i=1;
    while($row=mysql_fetch_assoc($check_name)){
        $name=$row['mg_id'];
        echo "<a id='li_".$_i."' name='".$name."' class='list_tag col_sm_12' onclick='on_The_map(name)'>";
        echo "<b>".$_i."</b>";
        $_i=$_i+1;
        echo $row['mg_name'];
        echo "</a>";
    }

    echo mysql_error();
}
?>
