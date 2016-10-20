/**
 * cake main
 */
var _p = 1;
function defaulLoad() {
	var _params = 'action=CakeOrder&run=getCakeOrderUid&page=' + _p;
	ComClass.post(_params, callback);
}
defaulLoad();
function callback(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '0') {
		var _html = '';
		for (i = 0; i < _d.msg.length; i++) {
			var _sendType = '';
			if (_d.msg[i].sendType == '2') {
				_sendType = '配送到宠物店';
			} else {
				_sendType = '配送到个人';
			}
			_html += '<a href="?tpl=v1.cake.order.detail&i=' + _d.msg[i].id
					+ '" >' + '<dl class="jf_active">' + '<dt><img src="'
					+ _d.msg[i].cpImg + '"></dt>' + '<dd> '
					+ _d.msg[i].createTime + '</dd>' + '<dd>'
					+ _d.msg[i].cpName + '</dd>' + '<dd>' + _sendType + '</dd>'
					+ '</dl>' + '</a>';
		}
		$('#divList').append(_html);
	} else {
		$('#divList').append('<br><center>暂无更多订单</center>');
		$("#loadPage").remove();
	}
}
$('#loadPage').click(function() {
	++_p;
	defaulLoad();
});