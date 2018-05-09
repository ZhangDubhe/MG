<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/28
 * Time: 0:14
 */
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['usr_name'])!="")
{
    header("Location: index.php");
}
if(isset($_POST['btn-login']))
{
    $usr_name=mysql_real_escape_string($_POST['usr_name']);
    $upass = mysql_real_escape_string($_POST['pass']);
    $res=mysql_query("SELECT * FROM loginfo WHERE usr_name='$usr_name'");
    $row=mysql_fetch_array($res);
    if(is_null($row['usr_name']))
    {
        ?>
        <script>
            var text = document.getElementsByName('usr_name').value;

            alert('这里好像没有叫这个名儿的 \n你最好再去注册一下');
            window.location.href="sign.php";
        </script>
        <?php
    }


    if($row['password']==$upass)
    {
        $_SESSION['usr_name'] = $row['user_id'];
        header("Location: ../index.php");
    }
    else
    {
        ?>
        <script>alert('Wrong Password!');
            window.location.href="sign.php";</script>
<?php
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
                    <td><input type="text" name="usr_name" placeholder="Your user name" required /></td>
                </tr>
                <tr>
                    <td><input type="password" name="pass" placeholder="Your Password" required /></td>
                </tr>
                <tr>
                    <td><button type="submit" name="btn-login">Sign In</button></td>
                </tr>
                <tr>
                    <td><a href="RIGISTER.php">Sign Up Here</a></td>
                </tr>
            </table>
        </form>
    </div>
</center>
</body>
=======
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/28
 * Time: 0:14
 */
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['usr_name'])!="")
{
    header("Location: index.php");
}
if(isset($_POST['btn-login']))
{
    $usr_name=mysql_real_escape_string($_POST['usr_name']);
    $upass = mysql_real_escape_string($_POST['pass']);
    $res=mysql_query("SELECT * FROM loginfo WHERE usr_name='$usr_name'");
    $row=mysql_fetch_array($res);
    if(is_null($row['usr_name']))
    {
        echo "这里没有".$usr_name.",最好去注册一下？"
        ?>
        <script>
            window.location.href="sign.php";
        </script>
        <?php
    }


    if($row['password']==$upass)
    {
        $_SESSION['usr_name'] = $row['user_id'];
        header("Location: ../index.php");
    }
    else
    {
        ?>
        <script>alert('Wrong Password!');
            window.location.href="sign.php";</script>
<?php
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>M.A.P. - Login & Registration System</title>
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/bootstrap-theme.css">
</head>
<body>
<center>
    <div id="login-form">
        <form method="post">
            <table align="center" width="30%" border="0">
                <tr>
                    <td><input class="input-group-lg"type="text" name="usr_name" placeholder="Your user name" required /></td>
                </tr>
                <tr>
                    <td><input class="input-group-lg"type="password" name="pass" placeholder="Your Password" required /></td>
                </tr>
                <tr>
                    <td><button type="submit" name="btn-login">Sign In</button></td>
                </tr>
                <tr>
                    <td><a href="RIGISTER.php">Sign Up Here</a></td>
                </tr>
            </table>
        </form>
    </div>
</center>
<script src="jquery-3.2.0.min.js"></script>
<script>
	window.jQuery || document.write('<script src="js/jquery.js"><\/script>')
</script>
<script src="bootstrap.js"></script>
</body>
>>>>>>> master
</html>