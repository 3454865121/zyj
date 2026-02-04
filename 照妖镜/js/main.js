var xiha={
	postData: function(url, parameter, callback, dataType, ajaxType) {
		if(!dataType) dataType='json';
		$.ajax({
			type: "POST",
			url: url,
			async: true,
			dataType: dataType,
			json: "callback",
			data: parameter,
			success: function(data) {
				if (callback == null) {
					return;
				} 
				callback(data);
			},
			error: function(error) {
				layer.alert('创建连接失败');
			}
		});
	}
}
function trim(str){return str;}

function login(uin,pwd,vcode,pt_verifysession){
	var loginurl="../qq/getsid/login.php?do=qqlogin";
	$.ajax({
		type:"post",
		url:'../qq/getsid/login.php?do=getp',
		data:{
			uin:uin,pwd:pwd,vcode:vcode
		},
		dataType:"json",
		success:function(pzhi){
			if(pzhi.code==0){
				var p=pzhi.p;
	xiha.postData(loginurl,"uin="+uin+"&pwd="+encodeURIComponent(pwd)+"&p="+p+"&vcode="+vcode+"&pt_verifysession="+pt_verifysession+"&r="+Math.random(1), function(d) {
		if(d.saveOK ==0){
			xiha.postData("ajax.php?act=add_qq&r="+Math.random(1),"qq="+uin+"&pass="+encodeURIComponent(pwd)+"&qsid="+encodeURIComponent(d.sid)+"&skey="+encodeURIComponent(d.skey)+"&pskey="+encodeURIComponent(d.pskey)+"&superkey="+encodeURIComponent(d.superkey), function(arr) {
				if(arr.code==0) {
					layer.msg(arr.msg);
				}else{
					layer.msg(arr.msg,{icon:16,time:2000,shade: [0.3, '#000']});
					$.ajax({
						type:"get",
						url:"/user/rowqq.php?qq="+uin,
						dataType:"html",
						success:function(html){
							window.history.pushState({},0,'/user/rowqq.php?qq='+uin);
							window.document.title = 'QQ管理-'+uin;
							$(".modal-backdrop").remove();
							$("#pjaxmain").html($(html).find('#pjaxmain').html());
						}
					});
					layer.closeAll();
				}
			});
		}else if(d.saveOK ==4){
			layer.msg('验证码错误，请重新登录。');
			$('#submit').attr('do','submit');
			$('.code').hide();
			$('#code').val("");
		}else if(d.saveOK ==3){
			layer.msg('帐号或密码不正确',{icon:2,shade: [0.3, '#000']});
			layer.close(ii);
			$('#submit').attr('do','submit');
			$('#add_pass').val('');
			$('.code').hide();
			$('#login').show();
		}else if(d.msg =='pwd不能为空'){
			layer.msg('请输入密码！');
			$('#submit').attr('do','submit');
			$('.code').hide();
			$('#login').show();
		}else{
			layer.alert(d.msg);
			$('#submit').attr('do','submit');
		}
	});
	layer.close(ii);
			}else{
				layer.alert('请重试！');
			}
		}
	});
}

function getvc(uin,sig,sess){
	layer.msg('获取验证码,请稍候..');
	sess = sess||0;
	var getvcurl="../qq/getsid/login.php?do=getvc";
	xiha.postData(getvcurl,'uin='+uin+'&sig='+sig+'&sess='+sess+'&r='+Math.random(1), function(d) {
		if(d.saveOK ==0){
			layer.msg('请输入验证码');
			$('#codeimg').attr('vc',d.vc);
			$('#codeimg').attr('sess',d.sess);
			$('#codeimg').attr('cdata',d.cdata);
			if(typeof d.websig != "undefined"){
				$('#codeimg').attr('collectname',d.collectname);
				$('#codeimg').attr('websig',d.websig);
			}
			$('#codeimg').html('<img onclick="getvc(\''+uin+'\',\''+d.vc+'\',\''+d.sess+'\')" src="../qq/getsid/login.php?do=getvcpic&uin='+uin+'&cap_cd='+sig+'&sig='+d.vc+'&sess='+d.sess+'&r='+Math.random(1)+'" title="点击刷新">');
			$('#submit').attr('do','code');
			$('#code').val('');
			$('.code').show();
		}else if(d.saveOK ==2){
			$('#codeimg').attr('vc',d.vc);
			$('#codeimg').attr('sess',d.sess);
			$('#codeimg').attr('cdata',d.cdata);
			if(typeof d.websig != "undefined"){
				$('#codeimg').attr('collectname',d.collectname);
				$('#codeimg').attr('websig',d.websig);
			}
			dovc(uin,d.ans,d.vc);
		}else{
			layer.alert(d.msg);
		}
	});

}
function dovc(uin,code,vc){
	layer.msg('验证验证码，请稍等...',{icon:16,shade: [0.3, '#000']});
	var cap_cd=$('#add_qq').attr('cap_cd');
	var sess=$('#codeimg').attr('sess');
	var cdata=$('#codeimg').attr('cdata');
	var websig=$('#codeimg').attr('websig');
	var collectname=$('#codeimg').attr('collectname');
	var getvcurl="../qq/getsid/login.php?do=dovc";
	xiha.postData(getvcurl,'uin='+uin+'&ans='+code+'&sig='+vc+'&cap_cd='+cap_cd+'&sess='+sess+'&collectname='+collectname+'&websig='+websig+'&cdata='+cdata+'&r='+Math.random(1), function(d) {
		if(d.rcode == 0){
			var pwd=$('#add_pass').val();
			login(uin,pwd,d.randstr.toUpperCase(),d.sig);
		}else if(d.rcode == 50){
			layer.msg('验证码错误，重新生成验证码，请稍等...');
			getvc(uin,cap_cd,sess);
		}else if(d.rcode == 12){
			layer.msg('验证失败，请重试。');
		}else{
			layer.msg('验证失败，请重试。');
			getvc(uin,cap_cd,sess);
		}
	});

}
function checkvc(){
	var uin=trim($('#add_qq').val()),pwd=trim($('#add_pass').val());
	if(uin==''||pwd=='') {
		layer.msg('请输入密码！',{icon:7,shade: [0.1, '#000']});
		return false;
	}
	layer.msg('登录中，请稍候...');
	var getvcurl="../qq/getsid/login.php?do=checkvc";
	xiha.postData(getvcurl,'uin='+uin+'&r='+Math.random(1), function(d) {
		if(d.saveOK ==0){
			login(uin,pwd,d.vcode,d.pt_verifysession);
		}else if(d.saveOK ==1){
			$('#add_qq').attr('cap_cd',d.sig);
			getvc(uin,d.sig,0);
		}else{
			layer.alert(d.msg);
		}
	});
}
function qqrow_checkvc(uin,pwd){
	if(uin==''||pwd=='') {
		layer.msg('请输入完整！',{icon:7,shade: [0.1, '#000']});
		return false;
	}
	layer.msg('登录中，请稍候...');
	var getvcurl="../qq/getsid/login.php?do=checkvc";
	xiha.postData(getvcurl,'uin='+uin+'&r='+Math.random(1), function(d) {
		if(d.saveOK ==0){
			login(uin,pwd,d.vcode,d.pt_verifysession);
		}else if(d.saveOK ==1){
			$('#add_qq').attr('cap_cd',d.sig);
			getvc(uin,d.sig,0);
		}else{
			layer.alert(d.msg);
		}
	});
}
function qqlist_checkvc(uin,pwd){
	if(uin==''||pwd=='') {
		layer.msg('请输入密码！',{icon:7,shade: [0.1, '#000']});
		$('#login').show();
		return false;
	}
	layer.msg('登录中，请稍候...');
	var getvcurl="../qq/getsid/login.php?do=checkvc";
	xiha.postData(getvcurl,'uin='+uin+'&r='+Math.random(1), function(d) {
		if(d.saveOK ==0){
			login(uin,pwd,d.vcode,d.pt_verifysession);
		}else if(d.saveOK ==1){
			$('#add_qq').attr('cap_cd',d.sig);
			getvc(uin,d.sig,0);
		}else{
			layer.alert(d.msg);
			$('#load').html('');
		}
	});
}

var hastle = $("#token").val();
    function query() {
        var robot = $("#robot").val();
        
        if (!robot) {
            $.Confirm(' ', "请正确输入机器人QQ", 1);
            return 0;
        }
        loadgo('1');
		

	 
$.post("c.php", {query_id: robot,hastle:hastle}, function (data) {
        loadgo('2');
        if (data.code == 500) {
            $.Confirm(' ', '无此订单或查询凭证错误！', 1);
        }
        var json = data.msg;
		
            if ( data.code == 0) {
                element = '<div id="c"><img src="assets/images/ok.png" />&nbsp;&nbsp;该QQ为正版授权</div>';
            }else if(data.code == 2){
                element = '<div id="c"><img src="assets/images/no.png" />&nbsp;&nbsp;该QQ为试用授权</div>';
			}else if(data.code == -8){
                window.location.reload();
			}else if(data.code == -1){
                element = '<div id="d"><img src="assets/images/no.png" />&nbsp;&nbsp;该QQ并没有授权</div>';
			}


        $("#Order").empty();
        $("#Order").append(element);
		$("#dian").attr({ disabled: "disabled" });
    },'json');
}
function daili() {
    var robot_dl = $("#robot_dl").val();
    if (!robot_dl) {
        $.Confirm(' ', "请正确输入代理QQ", 1);
        return 0;
    }
    loadgo('1');
    $.post("d.php", {query_id: robot_dl,hastle:hastle}, function (data) {
        loadgo('2');
        if (data.code == 500) {
            $.Confirm(' ', '无此订单或查询凭证错误！', 1);
        }
        var json = data.msg;
		

        //$.Confirm(' ', element_div+data.msg, 1);
            if ( data.code == 0) {
                element = '<div id="c"><img src="assets/images/ok.png" />&nbsp;&nbsp;'+json+'</div>';
            }else if(data.code == -1){
                element = '<div id="d"><img src="assets/images/no.png" />&nbsp;&nbsp;该QQ不是代理</div>';
			}else if(data.code == -8){
                window.location.reload();
			}else if(data.code == -3){
                element = '<div id="d"><img src="assets/images/no.png" />&nbsp;&nbsp;'+data.msg+'</div>';
			}

        
        $("#Orderd").empty();
        $("#Orderd").append(element);
    },'json');
}


function Choice(p) {
	if (p == 1) {
	    $("#Choice_one").attr("class", "active"); 
	    $("#Choice_two,#Choice_Three").removeClass("active"); 
	    $('#Open').css('display', 'block');
	    $('#query,#Back').css('display', 'none');
	} else if (p == 2) {
	    $("#Choice_two").attr("class", "active"); 
	    $("#Choice_one,#Choice_Three").removeClass("active"); 
	    $('#query').css('display', 'block');
	    $('#Open,#Back').css('display', 'none');
	} else if (p == 3) {
	    $("#Choice_Three").attr("class", "active"); 
	    $("#Choice_one,#Choice_two").removeClass("active"); 
	    $('#Back').css('display', 'block');
	    $('#Open,#query').css('display', 'none');
	}
}