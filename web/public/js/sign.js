/**
 * sign class
 */
var _cHtml = $('#content_html');
$(".sign_gz").click(function() {
					_cHtml.html('<h4>签到攻略</h4>'
									+ '<p>1. 每月连续签到7天、15天、30天领取相应的签到奖励</p>'
									+ '<p>2. 每月累计签到25天，可额外领取相应的签到奖励</p>'
									+ '<p>3.对不正当手段（包括但不限于作弊、扰乱系统、实施网络攻击等）参与活动的用户，萌工社有权禁止其参加活动，取消其获奖资格（如奖励已发放，萌工社有权追回）</p>'
									+ '<p>4. 此活动最终解释权归萌工社所有</p>');
					$(".box").show();
					$(".popup").show();
});
$(".sign_aniu").click(function() {
	$(".box").hide();
	$(".popup").hide();
});

$('.jf_dhlb').find('li').click(function() {
	var _id = $(this).find('a').attr('_i');
	var _obj = $('#dd_c_'+_id);
	_cHtml.html(_obj.html());
	$(".box").show();
	$(".popup").show();
});

$('body').attr('style', 'background:#f1f1f1');
var _s = 0;
$('#sign_button').click(function() {
	var _params = 'action=SignMainRecord&run=sign';
	if (_s == 0) {
		_s = 1;
		ComClass.post(_params, _callback);
	}
});
function _callback(data) {
	_s = 0;
	var _tmpData = eval('(' + data + ')');
	if (_tmpData.code == '1') {
		window.location.reload();
	} else {
		if (_tmpData.code == '201' && confirm(_tmpData.msg)) {
			ComClass.href('?tpl=v1.reg&b=v1.sign');
		} else {
			if (_tmpData.code == '201') {

			} else {
				alert(_tmpData.msg);
			}
		}
	}
}