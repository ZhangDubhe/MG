<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/27
 * Time: 21:45
 */
session_start();
if(isset($_SESSION['usr_name'])!="")
{
    header("Location: index.php");
}
include_once 'dbconnect.php';

if(isset($_POST['btn-signup']))//注册a
{
    $u_name = mysql_real_escape_string($_POST['name']);
    $res=mysql_query("SELECT * FROM loginfo WHERE usr_name='$u_name'");
    $pass = mysql_real_escape_string($_POST['password']);
    $email = mysql_real_escape_string($_POST['email']);
    $row=mysql_fetch_array($res);
    if($row['usr_name'])
    {
        ?>
        <script>
            alert('看来已经有这个人了\r\n再换一个名儿吧~');
            window.location.href="RIGISTER.php";
        </script>
        <?php
    }
    if(mysql_query("INSERT INTO loginfo(usr_name,password,usr_email) VALUES('$u_name','$pass','$email')"))
    {
        ?>
        <script>
            alert('successfully registered \r\n成功注册~');
            window.location.href="sign.php";
        </script>
        <?php
    }
    else
    {
        ?>
        <script>alert('error while registering you...T……T');</script>
        <?php
    }
}
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>M&G - Login & Registration System</title>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />

</head>
<body>
<center>
    <div id="login-form">
        <form method="post">
            <table align="center" width="30%" border="0">
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
                    <td><button type="submit" name="btn-signup">Sign Me Up</button></td>
                </tr>
                <tr>
                    <td><a href="sign.php">Sign In Here</a></td>
                </tr>
            </table>
        </form>
    </div>
</center>
</body>
</html>