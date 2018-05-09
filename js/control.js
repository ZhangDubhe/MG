<<<<<<< HEAD
/**
 * Created by Administrator on 2016/10/11.
 */

// Notifications
function open_left(){
    notifyMe(
        'bottom',
        'error',
        'Lorem Ipsum Text',
        'Lorem ipsum dolos lorem uisnsnd h jsakdh ajkdbh',
        200,
        1500
    );
}

function notifyMe($){
    'use strict';

    // Define plugin name and parameters
    $.fn.notifyMe = function($position, $type, $title, $content, $velocity, $delay){
        // Remove recent notification for appear new
        $('.notify').remove();

        // Create the content of Alert
        var close = "<a class='notify-close'>x</a>";
        var header = "<section class='notify' data-position='"+ $position +"' data-notify='" + $type + "'>" + close + "<h1>" + $title + "</h1>";
        var content =  "<div class='notify-content'>" + $content + "</div></section>";

        var notifyModel = header + content;

        $('body').prepend(notifyModel);

        var notifyHeigth = $('.notify').outerHeight();

        // Show Notification

        if($position == "bottom"){
            $('.notify').css('bottom', '-' + notifyHeigth);
            $('.notify').animate({
                bottom: '0px'
            },$velocity);

            // Close Notifications automatically
            if(typeof $delay !== 'undefined') {
                setTimeout(function(){
                    $('.notify').animate({
                        bottom: '-' + notifyHeigth
                    },$velocity);

                    // Remove item when close
                    setTimeout(function(){
                        $('.notify').remove();
                    },$velocity + 100);
                },$delay);
            }
        }

        else if($position == "top"){
            $('.notify').css('top', '-' + notifyHeigth);
            $('.notify').animate({
                top: '0px'
            },$velocity);

            // Close Notification automatically
            if(typeof $delay !== 'undefined') {
                setTimeout(function(){
                    $('.notify').animate({
                        top: '-' + notifyHeigth
                    },$velocity);

                    // Remove item when close
                    setTimeout(function(){
                        $('.notify').remove();
                    },$velocity + 100);
                },$delay);
            }
        }

        else if($position == "right"){
            $('.notify').css('right', '-' + notifyHeigth);
            $('.notify').animate({
                right: '0px'
            },$velocity);

            // Close Notification automatically
            if(typeof $delay !== 'undefined') {
                setTimeout(function(){
                    $('.notify').animate({
                        right: '-' + notifyHeigth
                    },$velocity);

                    // Remove item when close
                    setTimeout(function(){
                        $('.notify').remove();
                    },$velocity + 100);
                },$delay);
            }
        }

        else if($position == "left"){
            $('.notify').css('left', '-' + notifyHeigth);
            $('.notify').animate({
                left: '0px'
            },$velocity);

            // Close Notifications automatically
            if(typeof $delay !== 'undefined') {
                setTimeout(function(){
                    $('.notify').animate({
                        left: '-' + notifyHeigth
                    },$velocity);

                    // Remove item when close
                    setTimeout(function(){
                        $('.notify').remove();
                    },$velocity + 100);
                },$delay);
            }
        }

        // Close Notification
        $('.notify-close').click(function(){
            // Move notification
            if($position == "bottom"){
                $(this).parent('.notify').animate({
                    bottom: '-' + notifyHeigth
                },$velocity);
            }
            else if($position == "top"){
                $(this).parent('.notify').animate({
                    top: '-' + notifyHeigth
                },$velocity);
            }
            else if($position == "right"){
                $(this).parent('.notify').animate({
                    right: '-' + notifyHeigth
                },$velocity);
            }
            else if($position == "left"){
                $(this).parent('.notify').animate({
                    left: '-' + notifyHeigth
                },$velocity);
            }

            // Remove item when close
            setTimeout(function(){
                $('.notify').remove();
            },$velocity + 200);

        });


    }
};








=======
/**
 * Created by Zhang Dubhe on 2016/10/11.
 */
$('#mobile-selector-selected').onclick

var whether_mobile=false;
function whether_small_screen() {
    if($(window).width()<=720){whether_mobile=true}
    else{whether_mobile=false}
}
function mobile_up() {
    if(whether_mobile){
        $('#mobile-head').show();
        $('#mobile-head').animate({display:'block'},0.5);
    }

}
mobile_up();

var if_left_open=false;
function left() {
    if(if_left_open==false){
        open_left();
        if_left_open=true;
    }
    else {
        close_left();
        if_left_open=false;
    }

}
function open_left() {
    $('#left').show();
    $('#left').animate({width:'21.2em'},0.3);
    $('#notice_para').hide();
    $map_width=$(window).width()-253;
   // console.error($map_width);
   // console.error($('#left').width());
    $("#map").animate({width:$map_width,left:'21.2em'},0.3);

}
//打开左边侧栏，使用jquery的show函数及animate
function close_left(){
    $('#notice_para').show();
    $('#left').animate({width:'0'},0.5);
    $("#map").animate({width:$(window).width(),left:'0'},0.5);
    $('#left').hide(500);
    console.error($(window).width());
}
//关闭左边侧栏，使用hide函数，由于未设置时间出现闪屏的现象，将其时间调味500ms
function add_more() {
    if(document.getElementById("inputing"))
    {
        $(document).ready(function(){
            $("div").click(function(){
                $('#inputing').show();
                $('#inputing').animate({width:'200px'});
            });
        });

    }

}

function close_add_windows() {
    $(document).ready(function(){
        $("div").click(function(){
            $('#inputing').hide();

        });
    });
}
function change_to_list() {
    whether_small_screen();
    if(whether_mobile){
        document.getElementById('selector_space').style.display='none';
        document.getElementById('selector_list').style.display='block';
        if(if_mob_map_open){
            close_map();
            if_mob_map_open=false;}

    }
    else
    {
        document.getElementById('selector_space').style.display='none';
        document.getElementById('selector_list').style.display='block';
        document.getElementById('space').style.backgroundColor='#595757';
        document.getElementById('gallery').style.backgroundColor='#666666';

    }

}

function change_to_map() {
    whether_small_screen();
    if(whether_mobile){
        document.getElementById('selector_list').style.display='none';
        var list=document.getElementById('selector_space').style.display='block';
        if(if_mob_map_open){
            close_map();
            if_mob_map_open=false;}

    }
    else{
        document.getElementById('selector_list').style.display='none';
        var space=document.getElementById('selector_space').style.display='block';
        document.getElementById('space').style.backgroundColor='#666666';
        document.getElementById('gallery').style.backgroundColor='#595757';

    }

}


var if_mob_map_open=false;
function map_on() {
    if(if_mob_map_open==false){
        open_map();
        if_mob_map_open=true;
    }
    else {
        close_map();
        if_mob_map_open=false;
    }

}
function open_map() {
    $('#content').hide();
	$('#right_map').show(500);
    // $('#map').show();
    // $('#map').animate({display:'block'},0.5);
    $('#left').animate({width:'40%',float:'left'},0.5);
    // console.error($map_width);
    // console.error($('#left').width());
    $("#map").animate({opacity:1},0.5);
}

function close_map(){
    whether_small_screen();
    if(whether_mobile){
        $('#content').show();
    }
    $('#left').animate({width:'100%'},0.5);
    $("#map").animate({opacity:0},0.5);

    $('#right_map').hide(500);

}
function change_sign_way(_switch_){
	if (_switch_ == 'to_sign_in') {
		$('#sign_in').modal('show');
		$('#log_in').modal('hide');
	} else $('#log_in').modal("show")
}

function showHint(str)
{
	var xmlHttp;
	if (str.length==0)
	{
		document.getElementById("txtHint").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest)
	{
		// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
		xmlHttp=new XMLHttpRequest();
	}
	else
	{
		//IE6, IE5 浏览器执行的代码
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			// $('#ContactName').attr('placeholder',xmlHttp.responseText);
			alert(xmlHttp.responseText);
		}

	}
	xmlHttp.open("GET","phpfile/noticeName.php?NoticeName=true&q="+str,true);
	xmlHttp.send();
}


var xmlhttp;

function showGallery(){
	createXMLHttpRequest();
	var url = "phpfile/createGallery.php?gallery=true";
	xmlhttp.onreadystatechange =function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				var result=xmlhttp.responseText;
				document.getElementById("galleryContent").innerHTML=result;
			}
		}
	} ;
	xmlhttp.open("GET",url, true);
	xmlhttp.send();
}
var check_art = false;
var check_theme =false;
var check_syn = false;
function showArtMuseum(){
	if (!check_art){
		createXMLHttpRequest();
		var url = "phpfile/createGallery.php?art=true";
		xmlhttp.onreadystatechange =function() {
			if (xmlhttp.readyState == 4) {
				if (xmlhttp.status == 200) {
					var result=xmlhttp.responseText;
					document.getElementById("Art_Museum").innerHTML=result;
				}
			}
		} ;
		xmlhttp.open("GET",url, true);
		xmlhttp.send();
		check_art = true;
	}
	else {
		document.getElementById("Art_Museum").innerHTML="";
		check_art = false;
	}
}
function showThemeMuseum(){
	if (!check_theme){
		createXMLHttpRequest();
		var url = "phpfile/createGallery.php?theme=true";
		xmlhttp.onreadystatechange =function() {
			if (xmlhttp.readyState == 4) {
				if (xmlhttp.status == 200) {
					var result=xmlhttp.responseText;
					document.getElementById("Theme_Museum").innerHTML=result;
				}
			}
		} ;
		xmlhttp.open("GET",url, true);
		xmlhttp.send();
		check_theme =true;
	}
	else{
		document.getElementById("Theme_Museum").innerHTML="";
		check_theme = false;
	}
}
function showSynMuseum(){
	if (!check_syn){
		createXMLHttpRequest();
		var url = "phpfile/createGallery.php?Syn=true";
		xmlhttp.onreadystatechange =function() {
			if (xmlhttp.readyState == 4) {
				if (xmlhttp.status == 200) {
					var result=xmlhttp.responseText;
					document.getElementById("Synthesize_Museum").innerHTML=result;
				}
			}
		} ;
		xmlhttp.open("GET",url, true);
		xmlhttp.send();
		check_syn = true;
	}
	else{
		document.getElementById("Synthesize_Museum").innerHTML="";
		check_syn = false;
	}

}
function uploadMessage()
{
	//处理post数据 ajax url传参数到服务器
	var text = document.getElementById("MessageText").value;
	//url传参数  尚未完成登陆系统
	var uname = document.getElementById("ContactName").value;
	var email = document.getElementById("ContactEmail").value;
	if(text == ''| uname =='' | email == ''){
		alert("请输入后再上传！");
		return
	}
	if(checkEmail(email) == null){alert("请输入正确邮箱~");return};

	var url = "phpfile/message.php" + "?inputmessage=true&text=" + text + "&contactname=" + uname+"&contactemail="+email;
	GetMesRequest(url,true);
}
//后台查询Messeage content
function showMessage() {
	var url = "phpfile/message.php"+"?checkcontact=true";
    GetMesRequest(url,false);
}

//get request process
function GetMesRequest(_url_,_t_) {
	createXMLHttpRequest();
	xmlhttp.onreadystatechange =function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				var result=xmlhttp.responseText;
				if (_t_){
					alert("The server replied with: " + result);
					//to debug and give user a visible active
				}
				else{
					document.getElementById("messagecheck").innerHTML=result;
				}
			}
		}
	} ;
	xmlhttp.open("GET",_url_, true);
	xmlhttp.send();
}
var application_path;
application_path = "phpfile/application.php";
function sign_in() {
	var name=document.getElementById("sign_name").value;
	var pwd=document.getElementById("sign_password").value;
	if (pwd.toString().length > 8){
		layer.alert('密码不能超过8位');
	}
	var email=document.getElementById("sign_email").value;
	if (checkEmail(email) == null){
		layer.alert("请输入正确的email地址~");
		return
	}
	var postStr="sign=true&username="+name+"&password="+pwd+"&email="+email;
	PostPhp(application_path,postStr,function (result) {
		alert("注册：",result);
	});
}
function log_in(){
	var name=document.getElementById("log_name").value;
	var pwd=document.getElementById("log_password").value;

	var postStr="log=true&username="+name+"&password="+pwd;
	PostPhp(application_path,postStr);
}
//异步，执行时伴随服务器返回
//post request process
function PostPhp(url,postStr){
	createXMLHttpRequest();

	xmlhttp.onreadystatechange = handleStateChange;
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(postStr);

}


function checkEmail(text){
	T = text.match("^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$");
	console.log(T);
	return T
}

//xmlhttp request process
function createXMLHttpRequest() {
	if (window.ActiveXObject) {
		xmlhttp = new ActiveXObject("Microsoft.XMLHttp");
	}
	else if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}

}
//返回信息
function handleStateChange() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var result = xmlhttp.responseText;
			//to debug and give user a visible active
			if(result==444)
			{
				alert("这里不存在您输入的用户名，最好去注册一下。");
			}
			else{
				if (result==445)
				{
					alert("密码错误!")
				}
				else{
					if (446 == result.split(',')[0]){
						alert("欢迎登录！");
						$("#log_in").modal("hide");
						$('#sign_in').modal("hide");
						var res = result.split(',');
						$('#showUsrName').html(res[1]);
						$('#tag').attr('src',res[2])

						/*
						此处应有掌声
						*/
					}
					else{
						if (result==447){
							alert("您已成功登录~");$("#log_in").modal("hide");
						}
						else{
							alert(result);
						}
					};
				}

			}




		}
	}


}

>>>>>>> master
