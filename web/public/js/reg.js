/**
 * 注册
 */
var checkCode = $('#checkcodeA');
var tInput = $('#telnumInput');
var cInput = $('#checkcodeInput');

var wait = 60; //设置秒数(单位秒) 
var i = 0;
var iid = 0;
var sTimer = function(){
    var lr = wait - i;
    if (lr == 0) {
        clearInterval(iid);
        checkCode.parent().attr('class', 'Buy_btn4  ');
        checkCode.attr('href', 'javascript:send()');
        checkCode.html("获取验证码");
        iid = 0;
        i = 0;
    }
    else {
        checkCode.parent().attr('class', 'Buy_btn5  ');
        checkCode.html(lr + "秒后再发");
        i++;
    }
}

var send = function(){
    var _v = $.trim(tInput.val());
	var _cls = $.trim(checkCode.parent().attr('class'));
	if(_cls=='Buy_btn5'){
		return false;
	}
    if (_v.length != 11) {
        alert('请输入手机号');
        return false;
    }
    var params = 'action=Users&run=sendRndStr&telnum=' + _v;
    ComClass.post(params, c);
};

var c = function(data){
    if (data == '1') {
        checkCode.attr('href', 'javascript:void(0)');
        iid = setInterval("sTimer()", 1000);
        $('#s').attr('_b', '1');
    }
    else {
        alert('发送失败，请检查手机号');
    }
}

$('#s').click(function(){
    var _v = $.trim(tInput.val());
	var _cls = $(this).parent().attr('class');
	if(_cls=='Buy_btn5 submit_order   '){
		return false;
	}
    if (_v.length != 11) {
        alert('请输入手机号');
        return false;
    }
    var _t = $.trim(cInput.val());
    if (_t == '') {
        alert('请输入验证码');
        return false;
    }
    var _ic = $.trim($('#idcard').val());
    var params = 'action=Users&run=regUsers&telNumber=' + _v + '&rndstr=' + _t+'&idCard='+_ic+'&uType=1&uPwd=&uStatus=1&openId='+openid;
    ComClass.post(params, su);
});

var su = function(data){
    if (data == '0') {
        alert('验证码输入错误');
        return false;
    }
    else 
        if (data == 3) {
            alert('创建用户失败');
            return false;
        }
        else if (data == 4) {
            alert('身份证格式错误');
            return false;
        }else{
        	ComClass.href(brekHref);
        }
}

tInput.bind("input propertychange", function(){
    var _valD = $.trim($(this).val());
    if (_valD.length == 11) {
		if(i!=0){
			return false;
		}
        checkCode.parent().attr('class', 'Buy_btn4  ');
    }else{
		checkCode.parent().attr('class', 'Buy_btn5  ');
	}
});

cInput.bind("input propertychange", function(){
    var _valD = $.trim($(this).val());
    if (_valD.length != 0) {
        $('#s').parent().attr('class', 'Buy_btn4 submit_order   ');
    }else{
		$('#s').parent().attr('class', 'Buy_btn5 submit_order   ');
	}
});
