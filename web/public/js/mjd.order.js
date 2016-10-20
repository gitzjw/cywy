/**
 * 磨剪刀下单
 */
function hideBox() {
	$('#boxPrev').hide();
	$('#box').hide();
}
function hideCityBox() {
	$('#boxCityPrev').hide();
	$('#box').hide();
}
$('#quitBox').click(function() {
	hideBox();
});
$('#quitCityBox').click(function() {
	hideCityBox();
});
$('#fwfsP').click(function() {
	$('#boxPrev').show();
	$('#box').show();
});
$('#cityP').click(function() {
	$('#boxCityPrev').show();
	$('#box').show();
});
var _fwfsId = '';
$('#boxContentUl li')
		.click(
				function() {
					var _vid = $(this).attr('_vid');					
					var _vname = $(this).attr('_vname');
					if (_vid == '') {
						return false;
					}
					_fwfsId = _vid;
					var _params = 'action=Params&run=setParams&mjdFwfsName='
							+ _vname + '&mjdFwfsId=' + _vid;
					ComClass.setParams(_params);
					hideBox();
					$('#fwfsName')
							.html(
									_vname
											+ ' <img src="/public/images/you1.png" width="10">');
					defaultShowAds(_vid);
				});
$('#boxContentCityUl li')
		.click(
				function() {
					var _vid = $(this).attr('_vid');
					var _vname = $(this).attr('_vname');
					if (_vid == '') {
						return false;
					}
					var _params = 'action=Params&run=setParams&mjdCityName='
							+ _vname + '&mjdCityId=' + _vid;
					ComClass.setParams(_params);
					hideCityBox();
					if(_vname=='北京'){
						var _tmpCitySpanStr = '<strong>服务覆盖北京五环内</strong>';
					}else if(_vname=='上海'){
						var _tmpCitySpanStr = '<strong>服务覆盖上海外环内</strong>';
					}else if(_vname=='深圳'){
						var _tmpCitySpanStr = '<strong>服务覆盖深圳全市境内</strong>';
					}
					$('#cityName')
							.html(
									_vname
											+ ' <img src="/public/images/you1.png" width="10"> '+_tmpCitySpanStr);
					window.location.reload();
				});

function defaultShowAds(_vid) {
	if (_vid == "18") {
		$('#yjfw').hide();
		$('#smfw').show();
	} else if (_vid == '19') {
		$('#yjfw').show();
		$('#smfw').hide();
	}
	_fwfsId = _vid;
}

var _modNum = 0;
var _nTotalPrice = 0;
var _totalPrice = 0;
var _modVal = 0;

function checkPrice() {
	_modNum = 0;
	_nTotalPrice = 0;
	_totalPrice = 0;
	_modVal = 0;
	var _params = '';
	$('input[class="inputdata"]').each(
			function() {

				var _tmpId = $(this).attr('_v');
				var _tmpVal = $(this).val();
				if (_tmpVal == '') {
					_tmpVal = 0;
				}
				_tmpVal = parseInt(_tmpVal);
				_modVal = _modVal + _tmpVal;
				var _tmpOP = parseFloat($(this).attr('_o')) * _tmpVal;
				var _tmpDP = parseFloat($(this).attr('_d')) * _tmpVal;
				var _tmpNP = parseFloat($(this).attr('_n')) * _tmpVal;
				_nTotalPrice = _nTotalPrice + _tmpNP;
				_totalPrice = _totalPrice + _tmpOP;

				++_modNum;
				_params += 'data' + _modNum + '=' + _tmpId + '@@' + _tmpVal
						+ '@@' + _tmpOP + '@@' + _tmpDP + '@@' + _tmpNP + '&';

			});

	$('#nPrice').html('<div class="or_je1">￥</div>' + _nTotalPrice);	
	$('#oPrice').html('￥' + _totalPrice);
	if(_nTotalPrice==_totalPrice){
		$('#oPrice').hide();
	}
	_params += 'modNum=' + _modNum + '&modVal=' + _modVal + '&nTotal='
			+ _nTotalPrice + '&total=' + _totalPrice + '&';
	return _params;
}

function checkAds() {
	var _badsObj = $('#bAddress');
	var _cadsObj = $('#cAddress');
	var _madsObj = $('#mAddress');

	var _badsVal = _badsObj.val();
	if(_fwfsId=='19'){
		if(_badsVal==''){
			alert('请输入回寄地址');return false;
		}
	}
	var _cadsVal = _cadsObj.val();
	if(_fwfsId=='18'){
		if(_cadsVal==''){
			alert('请输入您的地址，师傅会在3天内上门为您服务');return false;
		}
	}	
	var _madsVal = _madsObj.html();

	var _params = 'action=Params&run=setParams&badsVal=' + _badsVal
			+ '&cadsVal=' + _cadsVal + '&madsVal=' + _madsVal;
	ComClass.setParams(_params);
	return true;
}
var _s_u_b = 0;
var _oid = '';
$('#btn_s').click(function() {
	var _val = checkPrice();
	var _adsValEnd = checkAds();
	if(!_adsValEnd){		
		return false;
	}
	if (_modVal < 5) {
		alert('至少需要5把，才能下单');
		return false;
	}
	_val += 'action=RepairPay&run=cOrder&repairPaySign=mjd&_oid=' + _oid;
	if (_s_u_b == 0) {
		++_s_u_b;
		$('input[class="inputdata"]').each(function(){
			$(this).attr('readonly',true);
		});
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
			window.location.href = "?tpl=v1.mjd.order.list";
			// WeixinJSBridge.invoke('closeWindow', {}, function(res) {});
		} else {
			_s_u_b = 0;
			alert('支付失败，请重新进行操作');
			// WeixinJSBridge.invoke('closeWindow', {}, function(res){});
		}
	});
}