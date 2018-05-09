<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/20
 * Time: 0:03
 */
include_once '../js/connect/dbconnect.php';
//$sql=mysql_query("INSERT INTO total(mg_name,mg_type,mg_content) VALUES('ecnu','school','default')");
//判断是否是输入
$allres= mysql_query("SELECT * FROM total ");
if($_GET["inputmessage"]){
    $name=mysql_real_escape_string($_GET["contactname"]);
    $email=mysql_real_escape_string($_GET["contactemail"]);
    $message=mysql_real_escape_string($_GET["text"]);
    echo $name;
//存入服务器端数据库
    $sql="INSERT INTO message(contactname,contactemail,message) VALUES('$name','$email','$message')";
    if (mysql_query($sql) === TRUE) {
        echo "上传成功！";
    } else {
        echo "上传失败！";
    }


}
//判断是否是输出
if(isset($_GET["checkcontact"])){
    $sql="SELECT * FROM message";
    $result=mysql_query($sql);
    echo "<table border='1' style='border: 1px solid;'>";
    echo "<tr style='border: 1px solid;'><td>usrname</td><td>email</td><td>suggestion</td><td>time</td></tr>";
    while($row=mysql_fetch_array($result)){
        echo "<tr style='border: 1px solid;'><td>", $row[0],"</td><td>",$row[1],"</td><td>", $row[2],"</td><td>",$row[3],"</td></tr>";
    }
    echo "</table>";
}
?>