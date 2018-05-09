<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/27
 * Time: 8:42
 */

set_time_limit(0);

function get_url_content($url){
    $proxy = "jp.1mo.igaotizi.com";
    $proxyport = "1080";    
// 初始化一个 cURL 对象
    $curl = curl_init();
//设置你需要抓取的URL
    curl_setopt($curl, CURLOPT_URL,$url );
//设置header
    curl_setopt($curl, CURLOPT_HEADER, 1);
//设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//设置代理服务器，proxytunnel为1表示需要使用代理服务器
    //curl_setopt($curl,CURLOPT_HTTPPROXYTUNNEL, 1);
   // curl_setopt ($curl, CURLOPT_PROXY, "localhost:1080"); 
     //   curl_setopt ($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 


//    curl_setopt($curl,CURLOPT_PROXYUSERPWD, '87420318');
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

//运行cURL，请求网页
    $data = curl_exec($curl);
    //express the error
    if($data === FALSE ){
        echo "CURL Error:".curl_error($curl);
    }
    curl_close($curl);
    echo $url," has been caught</br>";
    return $data;
}
function get_img($url,$fp){

    $curl = curl_init();

//设置你需要抓取的URL
    curl_setopt($curl, CURLOPT_URL,$url );
//设置header
    curl_setopt($curl, CURLOPT_HEADER, 0);
//设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl,CURLOPT_FILE,$fp);

    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_TIMEOUT,200);
//运行cURL，请求网页
    $data = curl_exec($curl);
    if($data === FALSE ){
        echo "CURL Error:".curl_error($curl);
        echo"</br>";
    }

    curl_close($curl);
    return $data;
}
function if_img_tail($path){
    //本函数用于判断lofter是否有版权保护，若有就截断
    $_path=explode('?',$path)[0];
    return $_path;
}
function download_img($data_test,$url_test){
    $filename=pathinfo($url_test)['filename'];
    if(preg_match("/[^0-9a-z._-]/i", $filename))
        $filename = md5(microtime(true));
    mkdirs($filename);

    $pattern = '/<img.*?\"([^\"]*(jpg|bmp|jpeg|gif)).*?>/';
    preg_match_all($pattern, $data_test, $results);
//关闭URL请求
    $num=0;

    foreach($results[1] as $path){
        //保存路径设置
        $num=$num+1;

        if(strstr($path,"imageView")){
            $path=if_img_tail($path);//lofter中判断是否有版权保护
            echo"Not allowed </br>";
        }
        $pi = pathinfo($path);
        $ext = $pi['extension'];
        $name = $pi['filename'];
        $saveFile = '.\\'.$filename.'\\'.$name.'.'.$ext;
        if(preg_match("/[^0-9a-z._-]/i", $saveFile))
            $saveFile = '.\\'.$filename.'\\'.md5(microtime(true)).'.'.$ext;
//保存数据

        $handle = fopen($saveFile, 'wb');
        get_img($path,$handle);//调用curl函数进行爬取
        fclose($handle);
        echo $name," has download! </br>";
    }
//*******************







//显示获得的数据

    echo "</br>**************************************</br>here is the website </br>**************************************</br>";
//var_dump($data_test);
}
function mkdirs($dir, $mode = 0777)
{
    if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
    if (!mkdirs(dirname($dir), $mode)) return FALSE;
    return @mkdir($dir, $mode);
}
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
return ((float)$usec + (float)$sec);
}
// 'http://wanimal1983.org/';

//var_dump($data_test);
//xpath:/html/body/http:/div/div/div[2]/div[1]/div[1]/div/div/div[1]/a/img
//selector:body > http: > div > div > div.autopagerize_page_element > div:nth-child(1) > div.photo-posts > div > div > div:nth-child(1) > a > img
//<img src="http://68.media.tumblr.com/1283196767a691111f110a0f5fe256e7/tumblr_oll3wqDWWZ1r2xjmjo2_1280.jpg" data-highres="http://68.media.tumblr.com/1283196767a691111f110a0f5fe256e7/tumblr_oll3wqDWWZ1r2xjmjo2_1280.jpg" style="width: 100%; height: auto; margin-top: 0px;">

/*    'http://hazukiryo025.lofter.com/',
'http://strickwang.lofter.com/',
'http://ziyouzhizhu.lofter.com',
    'http://duandian.lofter.com',
    'http://moxisang.lofter.com',
    'http://merson.lofter.com',
    'http://shelly928.lofter.com',
    'http://3318024.lofter.com',
    'http://www.garyzhu.cn',
    'http://mykk2003.lofter.com/',
    'http://wanimal.lofter.com/',
    'http://linlian.lofter.com/',
    'http://chihato.lofter.com/',
    'http://laoyao.lofter.com/',
    'http://inshanghai.lofter.com/',
    'http://coculiu.lofter.com/'
    'http://shrekdx.lofter.com/',
    'http://shrekdx.lofter.com/?page=2',
    'http://shrekdx.lofter.com/?page=3',
    'http://loftermeirenzhi.lofter.com/',
    'http://loftermeirenzhi.lofter.com/?page=2',
    'http://loftermeirenzhi.lofter.com/?page=3',
'http://static.tumblr.com/5526cea9ef61808c4ca223b3506a2511/hku65sn/q97oey1o1/tumblr_static_tumblr_static__focused_v3.jpg',
   'http://ambiakpower.tumblr.com/',
    'http://jshunet.tumblr.com/',
    'http://chenle0108.tumblr.com/'
'http://baoshengmei.lofter.com/?age=3',
		'http://baoshengmei.lofter.com/?age=2',
		'http://baoshengmei.lofter.com/',
		'http://lmomol.lofter.com/?age=4',
		'http://lmomol.lofter.com/?age=3',
    'http://lmomol.lofter.com/?age=2',
    'http://lmomol.lofter.com/',
'http://tree-fmyself.lofter.com/'
*/

?>
<html>
<head>
    <title>WEBSCRAPER</title>
</head>
<body>
<center>

</center>
</body>
</html>
<?php
$_array_=array(	
	'http://swordvision.lofter.com/',
        'http://swordvision.lofter.com/?age=2',
'http://swordvision.lofter.com/?age=3',
'http://swordvision.lofter.com/?age=4',
'http://swordvision.lofter.com/?age=5',
);
global $_url_;
$init_starttime= microtime_float();
foreach ($_array_ as $_url_){
    $starttime = microtime_float();
    $data_test=get_url_content($_url_);
    download_img($data_test,$_url_);
    //结束计时，放在最底部
    $runtime = number_format((microtime_float() - $starttime), 4).'s';
    echo "<br>***************************************<br>";
    echo $_url_.'     RunTime:'.$runtime;
    echo "<br>***************************************<br><br><br>";
}
$runtime = number_format((microtime_float() - $init_starttime), 4).'s';
echo '<br><hr>     AllRunTime:'.$runtime;
?>

