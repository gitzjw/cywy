/**
 * admin
 */
var _detailId = getUrlParam('i');
$('#detailList li div').toggle(function(){
	$(this).parent().attr('class','qrdd_act');
},function(){
	$(this).parent().attr('class','');
});
$('#quitBtn').click(function(){
	var _num = 0;
	var _val = '';
	$('#detailList li[class="qrdd_act"]').each(function(){
		++_num;
		_val+='data'+_num+'='+$(this).attr('_odi')+'@'+$(this).attr('_pi')+'&';		
	});
	_val += '_num='+_num+'&action=ShopOrder&run=quitOrder'+'&_oid='+_detailId;
	$(this).parent().hide();
	if(confirm('你确定取消该订单和商品吗？')){
		ComClass.post(_val,callback);
	}else{
		$(this).parent().show();
		return false;
	}
});
function callback(data){
	var _d = eval('('+data+')');
	if(_d.code=='1'){
		alert(_d.msg);
		window.location.reload();
	}else{
		alert(_d.msg);
		$(this).parent().show();
	}
}
$('#yesBtn').click(function(){	
	var _val = '';	
	var _s = $(this).attr('_s');
	_val = 'action=ShopOrder&run=yesOrderStatus'+'&_oid='+_detailId+'&_s='+_s;
	$(this).parent().hide();
	if(confirm('你确认本次操作吗？')){
		ComClass.post(_val,yescallback);
	}else{
		$(this).parent().show();
		return false;
	}
});
function yescallback(data){
	var _d = eval('('+data+')');
	if(_d.code=='1'){
		alert(_d.msg);
		window.location.reload();
	}else{
		alert(_d.msg);
		$(this).parent().show();
	}
}