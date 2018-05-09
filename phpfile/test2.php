<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/27
 * Time: 22:46
 */

/*
@ 计算php程序运行时间
*/
function microtime_float()
{
    list($usec, $sec) = explode(' ', microtime());
return ((float)$usec + (float)$sec);
}
//开始计时，放在头部
$starttime = microtime_float();


function if_img_tail($path){
    //本函数用于判断lofter是否有版权保护，若有就截断
    $_path=explode('?',$path)[0];
    return $_path;
}
$path="http://f8andbethere90.lofter.com/";
echo if_img_tail($path),'<br>';

$pi = pathinfo($path);
$ext = $pi['extension'];
$name = $pi['filename'];
echo $name,'<br>';
$saveFile = '.\\'.$name.'\\'.$name.'.'.$ext;
if(preg_match("/[^0-9a-z._-]/i", $saveFile))
    $saveFile =  '.\\'.$name.'\\'.md5(microtime(true)).'.'.$ext;
echo $saveFile,'<br>';
function mkdirs($dir, $mode = 0777)
{
    if(preg_match("/[^0-9a-z._-]/i", $dir))
        $dir = md5(microtime(true));
    if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
    if (!mkdirs(dirname($dir), $mode)) return FALSE;
    return @mkdir($dir, $mode);
}

mkdirs($name);
$handle = fopen($saveFile, 'w');
fwrite($handle,'hello world');
fclose($handle);


//结束计时，放在最底部
$runtime = number_format((microtime_float() - $starttime), 4).'s';
//输出
echo 'RunTime:'.$runtime;
?>