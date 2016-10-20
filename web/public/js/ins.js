/**
 * ins 操作
 */

var _num_add = 0;
var _btn_add = $('#btn_add');
var _btn_qx = $('ul[class="insur_qx"] li');
var _addTmpPObj = null;
var _payPrice = 0;
var _paySpan = 0;
var _modNum = 1;
var _oid = '';
var _e = null;
var _s_u_b = 0;

var _add_html = '<div class="insur_nei"><table class="tbg tbg1" cellpadding="0" cellspacing="0">'
		+ '<tr>'
		+ '<td>姓名</td>'
		+ '<td><input type="text" name="xm[]" placeholder="请输入姓名" onblur="checkIdentityOne($(this))"></td>'
		+ '</tr>'
		+ '<tr>'
		+ '<td>身份证</td>'
		+ '<td><input type="text" name="idcard[]" placeholder="请输入身份证号码" onblur="checkIdentity($(this))"></td>'
		+ '</tr>' + '</table>' + '<p class="insured_tishi"></p>' + '</div>';

_btn_add.click(function() {
	if (_num_add > 4) {
		alert('最多添加5个');
		return false;
	}
	$('[class="insur_nei"]:last').after(_add_html);
	++_num_add;
	getFormValue();
});
_btn_qx.click(function() {
	var tmpObj = $(this).find('span');
	_btn_qx.find('span').attr('class', '');
	tmpObj.attr('class', 'active_in');
	_payPrice = tmpObj.attr('_np');
	_paySpan = tmpObj.attr('_span');
	$('#price').html('￥' + parseFloat(tmpObj.attr('_np')) * _modNum);
});
function defaultPrice() {
	var tmpObj = $('ul[class="insur_qx"] li:eq(0)').find('span');
	_payPrice = tmpObj.attr('_np');
	_paySpan = tmpObj.attr('_span');
	$('#price').html('￥' + parseFloat(tmpObj.attr('_np')) * _modNum);
}
defaultPrice();
function checkIdentity(obj) {
	var _tmpObj = obj.parent().parent();
	var _name = _tmpObj.prev().find('input').val();
	if (_name == '') {
		_tmpObj.prev().find('input').focus();
		return false;
	}
	var _idcard = obj.val();
	if (_idcard == '') {
		return false;
	}
	var _p = _tmpObj.parent().parent().next().html();
	if (_p != '') {
		return false;
	}
	_addTmpPObj = _tmpObj.parent().parent().next();
	var _params = 'action=Pay&run=checkIdentity&_name=' + _name + '&_idcard='
			+ _idcard;
	ComClass.post(_params, checkIdentityCallBack);
}
function checkIdentityOne(obj) {
	var _tmpObj = obj.parent().parent();
	var _name = obj.val();
	if (_name == '') {
		obj.focus();
		return false;
	}
	var _idcard = _tmpObj.next().find('input').val();
	if (_idcard == '') {
		_tmpObj.next().find('input').focus();
		return false;
	}
	var _p = _tmpObj.parent().parent().next().html();
	if (_p != '') {
		return false;
	}
	_addTmpPObj = _tmpObj.parent().parent().next();
	var _params = 'action=Pay&run=checkIdentity&_name=' + _name + '&_idcard='
			+ _idcard;
	ComClass.post(_params, checkIdentityCallBack);
}
function checkIdentityCallBack(d) {
	var _d = eval("(" + d + ")");
	if (_d.code == '1') {
		var _res = _d.msg.split('@@@');
		_addTmpPObj.html(_res[0]);
		getFormValue();
	} else {
		alert(_d.msg);
	}
}
function getFormValue() {
	_modNum = 0;
	var _valStr = '';
	$('form div').each(function() {
		var i = 1;
		++_modNum;
		_valStr += 'd' + _modNum + '=';
		$(this).find('input').each(function() {
			if (i == 1) {
				_valStr += $(this).val();
			} else {
				_valStr += '@@@' + $(this).val();
			}
			++i;
		});
		_valStr += '& ';
	});
	$('#price').html('￥' + parseFloat(_payPrice) * _modNum);
	return _valStr;
}
$('#btn_s').click(
		function() {
			var _val = getFormValue();
			_val += 'action=Pay&run=cOrder&modNum=' + _modNum + '&_np='
					+ _payPrice + '&_span=' + _paySpan + '&_oid=' + _oid;
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
		"timeStamp" : _e.timestamp+"", // 时间戳，自1970年以来的秒数
		"nonceStr" : _e.newRndstr, // 随机串
		"package" : "prepay_id=" + _e.prepay_id,
		"signType" : "MD5", // 微信签名方式:
		"paySign" : _e.newSign
	// 微信签名
	}, function(res) {
		// 使用以下方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回 ok，但并不保证它绝对可靠。
		if (res.err_msg == "get_brand_wcpay_request:ok") {
			alert('支付成功');
			window.location.reload();
			WeixinJSBridge.invoke('closeWindow', {}, function(res) {
			});
		} else {
			_s_u_b = 0;
			alert('支付失败，请重新进行操作');
			// WeixinJSBridge.invoke('closeWindow', {}, function(res){});
		}
	});
}