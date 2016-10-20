/**
 * cake main
 */
var _p = 1;
function defaulLoad() {
	var _params = 'action=ShopOrder&run=getShopOrderAdminList&page=' + _p+'&city='+_city+'&type='+_type;
	ComClass.post(_params, callback);
}
defaulLoad();
function callback(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '0') {
		var _html = '';
		for (var o in _d.msg) {	
			var _tmp_html = '';
			for(var oo in _d.msg[o].chil){
				_tmp_html += '<span>'+_d.msg[o].chil[oo].pTitle+' x'+_d.msg[o].chil[oo].eNum+'</span>';
			}
			_html += '<a href="shop.php?tpl=v1.shop.order.detail.admin&i='+o+'"><dl>'+
							'<dt>'+
								'<strong>'+formatS(_d.msg[o].detail.oStatus)+'</strong>'+
								'<span>'+formatDate(_d.msg[o].detail.createTime)+'</span><br />'+_d.msg[o].detail.oShopName+
							'</dt>'+
							'<dd>'+_tmp_html+'</dd>'+
							'<dd class="goods_r">共'+_d.msg[o].detail.totalNum+'份，实付<strong>￥'+_d.msg[o].detail.nMoney+'</strong></dd>'+
						'</dl></a>'+
						'<div class="background1 height1"></div>';
		}
		$('#mainList').append(_html);
	} else {
		$('#mainList').append('<p class="goods_zudd">目前没有更多采购订单。</p>');
		$("#loadPage").remove();
	}
}

function formatS(val){
	var _str = '';
	switch (val) {
		case '1' :
			_str = '<b style="color:C0C0C0">订单创建成功</b>';
			break;
		case '2' :
			_str = '<b style="color:#DAA520">订单已确认，待配送</b>';
			break;
		case '3' :
			_str = '<b style="color:#696969">订单已取消</b>';
			break;
		case '4' :
			_str = '<b style="color:#D2691E">订单配送中</b>';
			break;
		case '5' :
			_str = '<b style="color:#00FF00">收款成功</b>';
			break;
		case '6' :
			_str = '<b style="color:#008000">订单已完成</b>';
			break;
		case '7' :
			_str = '<b style="color:#FF0000">退货申请中</b>';
			break;
		case '8' :
			_str = '<b style="color:#B22222">退货成功</b>';
			break;
		default :
			_str = '<b style="color:#90EE90">订单创建成功</b>';
			break;
	}
	return _str;
}

function formatDate(val){
	var _val = val.split(' ');
	var _valTmp = _val[0].split('-');
	var _valTimeTmp = _val[1].split(':');
	return _valTmp[1]+'-'+_valTmp[2]+' '+_valTimeTmp[0]+':'+_valTimeTmp[1];
}

$('#loadPage').click(function() {
	++_p;
	defaulLoad();
});