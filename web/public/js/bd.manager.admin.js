/**
 * cake main
 */

$('#qd_kh_list').find('.clc').click(function(e){
	$('.box').show();
	$('#loadMsgAbc').show();
	$('#qd_kh_list').hide();
	$('#xs_yj_list').show();
	$('#wdkh').attr('class','');
	$('#xsyj').attr('class','active');
	var _uid = $(this).parent().attr('_u');	
	loadShopOrder(_uid);
});

$('#wdkh').click(function(e){
	$('#qd_kh_list').show();
	$('#xs_yj_list').hide();
	$('#wdkh').attr('class','active');
	$('#xsyj').attr('class','');
});

$('#xsyj').click(function(e){
	$('#qd_kh_list').hide();
	$('#xs_yj_list').show();
	$('#wdkh').attr('class','');
	$('#xsyj').attr('class','active');
});

var _p = 1;

function loadShopOrder(_uid) {
	var _params = 'action=ShopOrder&run=getShopOrderListBD&page=' + _p+'&_uid='+_uid;
	ComClass.post(_params, callback);
}

function callback(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '0') {
		var _html = '';
		for (var o in _d.msg) {	
			var _tmp_html = '';
			for(var oo in _d.msg[o].chil){
				_tmp_html += '<span>'+_d.msg[o].chil[oo].pTitle+' x'+_d.msg[o].chil[oo].eNum+'</span>';
			}
						
			_html += '<a href="shop.php?tpl=v1.shop.order.detail.admin&_t=1&i='+o+'"><dl>'+
							'<dt>'+formatS(_d.msg[o].detail.oStatus)+
							'</dt>'+
							'<dt>'+formatDate(_d.msg[o].detail.createTime)+
							'</dt>'+
							'<dd>'+_d.msg[o].detail.oShopName+'</dd>'+
							'<dd>'+_tmp_html+'</dd>'+
							'<dd class="goods_r">共'+_d.msg[o].detail.totalNum+'份，实付<strong>￥'+_d.msg[o].detail.nMoney+'</strong></dd>'+
						'</dl></a>'+
						'<div class="background1 height1"></div>';
		}
		$('#xs_yj_list').html(_html);
		$(".box").hide(500);
		$(".popup_l").hide();
		$('#loadMsgAbc').hide(500);
	} else {
		$('#xs_yj_list').html('');
		$('#xs_yj_list').append('<p class="goods_zudd">目前没有更多采购订单。</p>');
		$("#loadPage").remove();
		$(".box").hide(500);
		$(".popup_l").hide();
		$('#loadMsgAbc').hide(500);
	}	
}


function formatS(val){
	var _str = '';
	switch (val) {
		case '1' :
			_str = '<b style="color:#386594">订单创建成功</b>';
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
			_str = '<b style="color:#386594">订单创建成功</b>';
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