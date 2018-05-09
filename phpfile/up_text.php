<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 0:12
 */
include_once '../js/connect/dbconnect.php';
if($_REQUEST['GetQuestion']){
    $_usrid = md5(_GET['urlmsg']);
    $sql = "SELECT * FROM wirte";
    $result = mysqli_query($sql);
    $row = mysqli_fetch_row($result);
    if($result)
        echo $row;
    else{
        echo mysqli_errno($sql);
    }
}
if($_REQUEST['UploadText']){

}
?>