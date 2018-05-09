<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/6
 * Time: 23:24
 */
include_once '../js/connect/dbconnect.php';
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : '';
// 上传图片

if($action=='add'){

    $image = mysql_escape_string(file_get_contents($_FILES['photo']['tmp_name']));
    $type = $_FILES['photo']['type'];
    $sqlstr = "insert into image(type,binarydata) values('".$type."','".$image."')";

    @mysql_query($sqlstr) or die(mysql_error());

    header('location:uploadimg.php');
    exit();

// 显示图片
}elseif($action=='show'){

    $id = isset($_GET['id'])? intval($_GET['id']) : 0;
    $sqlstr = "select * from image where id=$id";
    $query = mysql_query($sqlstr) or die(mysql_error());

    $thread = mysql_fetch_assoc($query);

    if($thread){
        header('content-type:'.$thread['type']);
        echo $thread['binarydata'];
        exit();
    }

}else{
// 显示图片列表及上传表单
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title> upload image to db demo </title>
    </head>

    <body>
    <center>
        <form name="form1" method="post" action="uploadimg.php" enctype="multipart/form-data">
            <p>图片：<input type="file" name="photo"></p>
            <p><input type="hidden" name="action" value="add"><input type="submit" name="b1" value="提交"></p>
        </form>


    <?php
    $sqlstr = "select * from image order by id desc";
    $query = mysql_query($sqlstr) or die(mysql_error());
    $result = array();
    while($thread=mysql_fetch_assoc($query)){
        $result[] = $thread;
    }
    foreach($result as $val){
        echo '<p><img src="uploadimg.php?action=show&id='.$val['id'].'&t='.time().'" width="150"></p>';
    }
    ?>
    </center>
    </body>
    </html>
    <?php
}
?>