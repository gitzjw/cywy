/**
 * cake pay
 */
$(function() {
	// 初始化日期控件
	var opt = {
		preset : 'date', // 日期
		display : 'modal', // 显示方式
		dateFormat : 'yy-mm-dd', // 日期格式
		setText : '确定', // 确认按钮名称
		cancelText : '取消',// 取消按钮名籍我
		dateOrder : 'yymmdd', // 面板中日期排列格式
		dayText : '日',
		monthText : '月',
		yearText : '年', // 面板中年月日文字
		endYear : 2030
	// 结束年份
	};

	$("#petDate").mobiscroll(opt);
});

var _obj_div_show = '';

function showDiv(s) {
	_obj_div_show = $('#' + s);
	_obj_div_show.show();
	$('#t_box').show();
}

function hideDiv() {
	_obj_div_show.hide();
	$('#t_box').hide();
}

var _sendtypeVal = '';
$('#id_div_sendtype').find('li').click(function() {
	var _tmpObj = $(this);
	if (_tmpObj.attr('_v') == '') {
		return false;
	} else {
		_sendtypeVal = _tmpObj.attr('_v');
		// 1 个人 2到店
		if (_sendtypeVal == '2') {
			$('#id_inp_ads').val(_defaultAds);
			$('#id_inp_name').val(_defaultName);
			$('#id_inp_tel').val(_defaultTel);
		} else {
			$('#id_inp_ads').val('');
			$('#id_inp_name').val('');
			$('#id_inp_tel').val('');
		}
		$('#sendtype').html(_tmpObj.find('a').html());
		hideDiv();
	}
});

var _psexVal = '';
$('#id_div_sex').find('li').click(function() {
	var _tmpObj = $(this);
	if (_tmpObj.attr('_v') == '') {
		return false;
	} else {
		_psexVal = _tmpObj.attr('_v');
		$('#psex').html(_tmpObj.find('a').html());
		hideDiv();
	}
});

var _s_u_b = 0;
var _oid = '';
function getFormValue() {
	var _valStr = '';
	$('input').each(function() {
		_valStr += $(this).attr('name') + '=' + $(this).val();
		_valStr += '&';
	});
	_valStr += 'address=' + $('#id_inp_ads').val() + '&sendtype='
			+ _sendtypeVal + '&psex=' + _psexVal + '&cpid=' + _cpId + '&';
	return _valStr;
}
$('#btn_s').click(function() {
	var _val = getFormValue();
	_val += 'action=CakeOrder&run=cOrder&_oid=' + _oid;
	if (_s_u_b == 0) {
		++_s_u_b;
		ComClass.post(_val, callbackData);
	}
});
function callbackData(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '1') {
		_e = _d.msg;
		_oid = _e.oid;
		onBridgeReady();
	} else {
		_s_u_b = 0;
		alert(_d.msg);
	}
}

function onBridgeReady() {
	WeixinJSBridge.invoke('getBrandWCPayRequest', {
		"appId" : _e.appid, // 公众号名称，由商户传入
		"timeStamp" : _e.timestamp + "", // 时间戳，自1970年以来的秒数
		"nonceStr" : _e.newRndstr, // 随机串
		"package" : "prepay_id=" + _e.prepay_id,
		"signType" : "MD5", // 微信签名方式:
		"paySign" : _e.newSign
	// 微信签名
	}, function(res) {
		// 使用以下方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回 ok，但并不保证它绝对可靠。
		if (res.err_msg == "get_brand_wcpay_request:ok") {
			alert('支付成功');
			WeixinJSBridge.invoke('closeWindow', {}, function(res) {
			});
		} else {
			_s_u_b = 0;
			alert('支付失败，请重新进行操作');
			// WeixinJSBridge.invoke('closeWindow', {}, function(res){});
		}
	});
}