<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 8:57
 */
if($_GET[''])
    $sql = "SELECT * FROM total ";
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

?>