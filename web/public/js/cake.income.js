/**
 * cake main
 */
var _p = 1;
function defaulLoad() {
	var _params = 'action=CakeOrder&run=getCakeOrderIncome&page=' + _p;
	ComClass.post(_params, callback);
}
defaulLoad();
function callback(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '0') {
		var _html = '';
		$('#total').html(_d.msg.total);
		for (i = 0; i < _d.msg.res.length; i++) {
			_html += '<li>'+
						'<p><span>'+_d.msg.res[i].cpName+'</span> <strong>'+_d.msg.res[i].payTime+'</strong></p>'+
						'<div>+'+_d.msg.res[i].payMoney+'</div>'+
					'</li>';
		}
		$('#mainUl').append(_html);
	} else {
		$('#mainUl').append('<br><center>暂无收入</center>');
		$("#loadPage").remove();
	}
}
$('#loadPage').click(function() {
	++_p;
	defaulLoad();
});