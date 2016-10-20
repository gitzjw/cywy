/**
 * shop goods detail
 */
var _detailId = getUrlParam('i');
var _wtype = '';

var leftArray = new Array();
var rightArray = new Array();
//var rightHtmlArray = new Array();
var carArray = new Array();
var leftTotalArray = new Array(0);

var _totalNum = 0;
var _totalPrice = 0;
var _marketingData = '';

//物品详情
var _params = 'action=ShopPro&run=getShopProDetail&i='+_detailId;
ComClass.post(_params,shopProLoadCallBack);
function shopProLoadCallBack(data){
	var _d = eval('('+data+')');
	if(_d.code=='1'){
		var _tmpImgPath = _d.msg.dImgPath.split('?');
		var _tmpImg = '';
		if(typeof(_tmpImgPath[1])!='undefined'){
			_tmpImg = _d.msg.dImgPath + '';
		}else{
			_tmpImg = _d.msg.dImgPath + '';
		}
		var _speMark = '';

		var _dujia = '';
		if(typeof(_d.msg.isSingle) != "undefined"){
			if(_d.msg.isSingle == '1'){
				_dujia='<span class="dujia">精选</span>';
			}
		}

		if(_d.msg.speMark=='' || _d.msg.speMark=='0' || _d.msg.speMark==null){
			_speMark = '';
		}else{
			_speMark = '<span class="tejia">特价</span>';
		}
		var _marketPrice = '';
		if(_d.msg.marketPrice=='' || _d.msg.marketPrice=='0.00' || _d.msg.marketPrice==null){
			_marketPrice = '';
		}else{
			_marketPrice = '￥'+_d.msg.marketPrice;
		}
		$('#scPrice').html(_marketPrice);
		$('#sImg').html('<div class="swiper-slide blue-slide"><img src="'+_tmpImg+'" width="100%"></div>');
		$('#sTitle').html(_dujia+_speMark+_d.msg.title);
		$('#sNum').html('已售'+_d.msg.sNum+'单');
		$('#nPrice').html('￥'+_d.msg.nPrice+' ');
		if(_d.msg.goodsNote!='' && _d.msg.goodsNote){
			$('#pDesc').html(_d.msg.spDesc+'<br/>'+_d.msg.goodsNote);
		}else{
			$('#pDesc').html(_d.msg.spDesc);
		}			
		$('#content').html(_d.msg.spContent);
		$('#pJiaJian').attr('_list',_d.msg.id);
		$('#pJiaJian').attr('_price',_d.msg.nPrice);
		$('#pJiaJian').attr('_title',_d.msg.title);
		$('#pJiaJian').attr('_wtype',_d.msg.wType);
		$('#pJiaJian').find('span[class="minus"]').attr('id','cp-jian-'+_d.msg.id);
		$('#pJiaJian').find('span[class="shuzi"]').attr('id','cp-num-'+_d.msg.id);
	}else{
		alert(_d.msg);
	}
}

function downCar(obj){
	var _proNum = obj.next().html();
	_proNum = parseInt(_proNum)-1;	
	obj.next().html(_proNum);
	var _id = obj.parent().attr('_list');
	var _price = parseFloat(parseFloat(obj.parent().attr('_price')).toFixed(2));	
	var _title = obj.parent().attr('_title');
	var _proPrice = parseFloat((_price*_proNum).toFixed(2));
	var _wtype_tmp = obj.parent().attr('_wtype');
	//侧边统计	
	leftTotalArray[_wtype_tmp] = typeof(leftTotalArray[_wtype_tmp])=='undefined'?0:parseInt(leftTotalArray[_wtype_tmp]);
	if(parseInt(leftTotalArray[_wtype_tmp])==1 || parseInt(leftTotalArray[_wtype_tmp])==0 ){
		leftTotalArray[_wtype_tmp]=0;
		var _params = 'action=ShopPro&run=shopLeftCarDel&i='+_wtype_tmp;
		ComClass.setParams(_params);
	}else{
		leftTotalArray[_wtype_tmp] = parseInt(leftTotalArray[_wtype_tmp])-1;
	}
	curdLeftTotalNum();
	
	_totalPrice = parseFloat((_totalPrice-_price).toFixed(2));
	_totalNum = _totalNum-1;
	if(parseInt(_proNum)<=0){
		obj.hide();
		obj.next().html('0');
		obj.next().hide();
		carArray[_id] = new Array();
		var _params = 'action=ShopPro&run=shopCarDel&i='+_id+'&price='+_price;
		ComClass.setParams(_params);
	}else{		
		carArray[_id] = new Array(_id,_price,_title,_proNum,_proPrice,_wtype_tmp);
	}
	opCar(_id,carArray[_id]);
}

function addCar(obj){
	//by zjw
	var _id = obj.parent().attr('_list');
	var _shopGoodsCar = SessionUtils.getParam('shopGoodsCar');

	//console.log(_id);
	//console.log(_shopGoodsCar);
	var _params = 'action=ShopPro&run=addCarTypeIf&id='+_id+'&goods='+_shopGoodsCar;
	ComClass.post(_params,function(data){
		var _d = eval('('+data+')');
		//console.log(_d);
		if(_d.code == 'false') {
			alert(_d.msg);
			return false;
		}else {
			//订单状态作为调用支付展示 标示
			SessionUtils.setParam('shopOrderTypeHT',_d.msg);
			obj.prev().show();
			obj.prev().prev().show();
			var _proNum = obj.prev().html();


			if (parseInt(_proNum) > 99) {
				alert('最多支持99个');
				return false;
			}
			_proNum = parseInt(_proNum) + 1
			_totalNum = _totalNum + 1;
			obj.prev().html(_proNum);
			var _id = obj.parent().attr('_list');
			var _price = parseFloat(parseFloat(obj.parent().attr('_price')).toFixed(2));
			var _title = obj.parent().attr('_title');
			var _proPrice = parseFloat((_price * _proNum).toFixed(2));
			var _wtype_tmp = obj.parent().attr('_wtype');
			//侧边统计
			leftTotalArray[_wtype_tmp] = typeof(leftTotalArray[_wtype_tmp]) == 'undefined' ? 0 : parseInt(leftTotalArray[_wtype_tmp]);
			leftTotalArray[_wtype_tmp] = parseInt(leftTotalArray[_wtype_tmp]) + 1;
			curdLeftTotalNum();

			_totalPrice = parseFloat((_totalPrice + _price).toFixed(2));
			carArray[_id] = new Array(_id, _price, _title, _proNum, _proPrice, _wtype_tmp);
			opCar(_id, carArray[_id]);
		}
	});

}

function downCarAlert(obj){
	var _proNum = obj.next().html();
	_proNum = parseInt(_proNum)-1;	
	obj.next().html(_proNum);
	var _id = obj.parent().attr('_list');
	var _price = parseFloat(parseFloat(obj.parent().attr('_price')).toFixed(2));	
	var _title = obj.parent().attr('_title');
	var _proPrice = parseFloat((_price*_proNum).toFixed(2));
	var _wtype_tmp = obj.parent().attr('_wtype');
	//侧边统计	
	leftTotalArray[_wtype_tmp] = typeof(leftTotalArray[_wtype_tmp])=='undefined'?0:parseInt(leftTotalArray[_wtype_tmp]);
	if(parseInt(leftTotalArray[_wtype_tmp])==1 || parseInt(leftTotalArray[_wtype_tmp])==0){
		leftTotalArray[_wtype_tmp]=0;
		var _params = 'action=ShopPro&run=shopLeftCarDel&i='+_wtype_tmp;
		ComClass.setParams(_params);
	}else{
		leftTotalArray[_wtype_tmp] = parseInt(leftTotalArray[_wtype_tmp])-1;
	}	
	curdLeftTotalNum();
	
	_totalPrice = parseFloat((_totalPrice-_price).toFixed(2));
	_totalNum = _totalNum-1;
	if(parseInt(_proNum)<=0){
		$("#cp-num-"+_id).html(0);
		$("#cp-num-"+_id).hide();
		$("#cp-jian-"+_id).hide();
		obj.parent().parent().remove();			
		carArray[_id] = new Array();
		var _params = 'action=ShopPro&run=shopCarDel&i='+_id+'&price='+_price;
		ComClass.setParams(_params);
	}else{		
		carArray[_id] = new Array(_id,_price,_title,_proNum,_proPrice,_wtype_tmp);
		$("#cp-num-"+_id).show();
		$("#cp-jian-"+_id).show();
		$("#cp-num-"+_id).html(_proNum);
	}	
	opCar(_id,carArray[_id]);
}

function addCarAlert(obj){
	obj.prev().show();
	obj.prev().prev().show();
	var _proNum = obj.prev().html();
	if(parseInt(_proNum)>99){
		alert('最多支持99个');return false;
	}
	_proNum = parseInt(_proNum)+1
	_totalNum = _totalNum+1;
	obj.prev().html(_proNum);
	var _id = obj.parent().attr('_list');
	var _price = parseFloat(parseFloat(obj.parent().attr('_price')).toFixed(2));
	var _title = obj.parent().attr('_title');
	var _proPrice = parseFloat((_price*_proNum).toFixed(2));
	var _wtype_tmp = obj.parent().attr('_wtype');
	//侧边统计	
	leftTotalArray[_wtype_tmp] = typeof(leftTotalArray[_wtype_tmp])=='undefined'?0:parseInt(leftTotalArray[_wtype_tmp]);
	leftTotalArray[_wtype_tmp] = parseInt(leftTotalArray[_wtype_tmp])+1;
	curdLeftTotalNum();
	
	$("#cp-num-"+_id).show();
	$("#cp-jian-"+_id).show();
	$("#cp-num-"+_id).html(_proNum);
	_totalPrice = parseFloat((_totalPrice+_price).toFixed(2));
	carArray[_id] = new Array(_id,_price,_title,_proNum,_proPrice,_wtype_tmp);
	opCar(_id,carArray[_id]);
}

function curdLeftTotalNum(){
	var _tmpLeftCarDStr = '';
	for(o in leftTotalArray){		
		_tmpLeftCarDStr+='"'+o+'":["'+leftTotalArray[o]+'"],';
	}
	var _tmpLeftCarStr = '{"code":"1","msg":{"leftcar":{'+_tmpLeftCarDStr+'"":[]}}}';
	SessionUtils.setParam('shopGoodsLeftCarNum',_tmpLeftCarStr);
	setLeftTotalNum();
}

function clearLeftTotalNum(){
	var _tmpLeftCarDStr = '';
	for(o in leftTotalArray){		
		_tmpLeftCarDStr+='"'+o+'":["0"],';
		leftTotalArray[o]=0;
	}
	var _tmpLeftCarStr = '{"code":"1","msg":{"leftcar":{'+_tmpLeftCarDStr+'"":[]}}}';
	SessionUtils.removeParam('shopGoodsLeftCarNum');	
	setLeftTotalNum();
}

function setLeftTotalNum(){
	for(var lin in leftTotalArray ){
		if(typeof(lin)!='undefined'){
			var tmp_li_html = $(".goods_left").find('li[_i="'+lin+'"]').html();
			if(typeof(tmp_li_html)!='undefined'){
				if(leftTotalArray[lin]==0){
					var _tmp_lin_html_split = tmp_li_html.split("<span>");
					$(".goods_left").find('li[_i="'+lin+'"]').html(_tmp_lin_html_split[0]);
				}else{
					$(".goods_left").find('li[_i="'+lin+'"]').html(tmp_li_html+'<span>'+leftTotalArray[lin]+'</span>');
				}
			}					
		}		
	}
}

function opCar(id,data){
	//rightHtmlArray[_wtype]=$('#rightList').html();
	$('#totalNum').html('共'+_totalNum+'件<strong>(满1000元起订)</strong>');
	$('#totalPrice').html('￥'+_totalPrice);
	
	/*//结算合计
	$('#orderEndOPrice').html('￥'+_totalPrice);	
	//结算实收
	$('#orderEndNPrice').html('￥'+(_totalPrice-parseFloat(_marketingData.nMoney)));
	$("#orderEndTotalMoney").html('￥'+(_totalPrice-parseFloat(_marketingData.nMoney)));*/
	
	//if(data!=''){
		//var _tmpStr = data.join('@-@-@');		
		//var _params = 'action=ShopPro&run=shopCar&_data='+_tmpStr+'&totalNum='+_totalNum+'&totalPrice='+_totalPrice;
		//ComClass.post(_params,sessionStorageCarCallback);
		curdShopCar();
	//}
	carList();
}

function curdShopCar(){	
	var _tmpCarDStr = '';
	for(o in carArray){	
		if(typeof(carArray[o][0])=='undefined'){
			_tmpCarDStr+='"'+o+'":[""],';
		}else{
			_tmpCarDStr+='"'+carArray[o][0]+'":["'+carArray[o][0]+'","'+carArray[o][1]+'","'+carArray[o][2]+'","'+carArray[o][3]+'","'+carArray[o][4]+'","'+carArray[o][5]+'"],';
		}		
	}
	var _tmpCarStr = '{"code":"1","msg":{"car":{'+_tmpCarDStr+'"":[]},"totalNum":"'+_totalNum+'","totalPrice":"'+_totalPrice+'"}}';
	SessionUtils.setParam('shopGoodsCar',_tmpCarStr);
}

function carList(){
	marketingAct();
	$_html = '';
	$_orderListHtml = '';
	for(var key in carArray){
		if(typeof(carArray[key][2])!='undefined'){
			$_html += '<li>'+ 
						'<strong class="goods_bt">'+carArray[key][2]+'</strong>'+ 
						'<p _list="'+key+'" _price="'+carArray[key][1]+'" _title="'+carArray[key][2]+'" _wtype="'+carArray[key][5]+'">'+
							'<span class="minus" onclick="downCarAlert($(this))"></span>'+ 
							'<span class="shuzi">'+carArray[key][3]+'</span>'+
							'<span class="add" onclick="addCarAlert($(this))"></span>'+
						'</p>'+
						'<strong class="goods_jg">￥'+carArray[key][4]+'</strong>'+
					'</li>';
			$_orderListHtml += '<li> <strong class="goods_bt">'+carArray[key][2]+'</strong>  <span>￥'+carArray[key][4]+'</span><strong class="goods_jg">X '+carArray[key][3]+'</strong></li>';
			$("#cp-num-"+key).show();
			$("#cp-jian-"+key).show();
			$("#cp-num-"+key).html(carArray[key][3]);
		}
	}	
	$('#goodsCarList').html($_html);
	$('#orderEndListUl').html($_orderListHtml);
}

//清空购物车
function clearCartList(){
	carArray = new Array();
	carList();	
	_totalNum = 0;
	_totalPrice = 0;
	opCar(0,'');
	
	clearLeftTotalNum();
	
	var _params = 'action=ShopPro&run=shopCarDel';
	ComClass.setParams(_params);
	SessionUtils.removeParam('shopGoodsCar');
	
	var _params = 'action=ShopPro&run=shopLeftCarDel';
	ComClass.setParams(_params);
	SessionUtils.removeParam('shopGoodsLeftCarNum');
	
	$('#rightList').find('span[class="minus"]').hide();
	$('#rightList').find('span[class="shuzi"]').html(0).hide();
	
	$('#pJiaJian').find('span[class="minus"]').hide();
	$('#pJiaJian').find('span[class="shuzi"]').html(0).hide();
}

//加载优惠活动
var _shopMarketingAct = SessionUtils.getParam('shopMarketingAct');
if(_shopMarketingAct==null){
	var _params = 'action=ShopMarketing&run=getShopMarketing';
	ComClass.post(_params,marketingLoadCallBack);	
}else{
	marketingLoadCallBack(_shopMarketingAct);
}
function marketingLoadCallBack(data){
	var _d = eval('('+data+')');
	SessionUtils.setParam('shopMarketingAct',data);	
	if(_d.code=='1'){
		var _html = '';
		var i = 1;
		for(o in _d.msg){
			if(_d.msg[o].wType=='1'){
				_html += i+'、满'+parseInt(_d.msg[o].money)+'减'+parseInt(_d.msg[o].nMoney)+'元<br>';
			}else if(_d.msg[o].wType=='2'){
				_html += i+'、满'+parseInt(_d.msg[o].money)+'赠商品<br>'
			}
			i++;
		}
		$('#discountNoteHtml').html(_html);
	}else{
		
	}
}
function marketingAct(){
	var _mMoney = new Array();
	var _shopMarketingActM = SessionUtils.getParam('shopMarketingAct');
	if(_shopMarketingActM!=null){
		var _html = '';
		var _d = eval('('+_shopMarketingActM+')');
		for(o in _d.msg){
			if(_d.msg[o].wType=='1' && _totalPrice>=_d.msg[o].money){
				_html = '满'+parseInt(_d.msg[o].money)+'减'+parseInt(_d.msg[o].nMoney)+'元<br>';
				_mMoney[0] = parseInt(_d.msg[o].money);
				_mMoney[1] = parseInt(_d.msg[o].nMoney);
				_mMoney[2] = _d.msg[o].oMark;
			}else if(_d.msg[o].wType=='2' && _totalPrice>=_d.msg[o].money){
				_html = '满'+parseInt(_d.msg[o].money)+'赠商品<br>'
				_mMoney[0] = parseInt(_d.msg[o].money);
				_mMoney[1] = parseInt(_d.msg[o].nMoney);
				_mMoney[2] = _d.msg[o].oMark;
			}
		}
		$('#marketingShow').html(_html);
		$('#orderEndMarketing').html(_html);
	}else{
		
	}
	return _mMoney;
}

function defaultLoadCar(){
	var _shopGoodsCar = SessionUtils.getParam('shopGoodsCar');
	if(_shopGoodsCar==null){
		var _params = 'action=ShopPro&run=shopCar';
		ComClass.post(_params,defaultLoadCarCallBack);
	}else{
		defaultLoadCarCallBack(_shopGoodsCar)
	}
}
function defaultLoadCarCallBack(data){
	var _d = eval('('+data+')');
	SessionUtils.setParam('shopGoodsCar',data);
	if(_d.code=='1'){		
		_totalNum = parseInt(_d.msg.totalNum);
		_totalPrice = parseFloat(_d.msg.totalPrice);
		for(var o in _d.msg.car){
			carArray[_d.msg.car[o][0]] = _d.msg.car[o];
		}
		$('#totalNum').html('共'+_totalNum+'件<strong>(满500元起订)</strong>');
		$('#totalPrice').html('￥'+_totalPrice);
		
		carList();
	}else{
		
	}
}
defaultLoadCar();

//leftLoadTotalNum 加载左侧统计数据
function defaultLoadLeftCar(){
	var _shopGoodsLeftCar = SessionUtils.getParam('shopGoodsLeftCarNum');
	if(_shopGoodsLeftCar==null){
		var _params = 'action=ShopPro&run=shopLeftCar';
		ComClass.post(_params,defaultLoadLeftCarCallBack);
	}else{
		defaultLoadLeftCarCallBack(_shopGoodsLeftCar)
	}
}
function defaultLoadLeftCarCallBack(data){
	var _d = eval('('+data+')');
	SessionUtils.setParam('shopGoodsLeftCarNum',data);	
	if(_d.code=='1'){
		for(var o in _d.msg.leftcar){
			if(o!=''){
				leftTotalArray[o] = _d.msg.leftcar[o];
			}			
		}	
		setLeftTotalNum();
	}else{
		
	}
}
defaultLoadLeftCar();


//商户资料
var _shopUserDetail = SessionUtils.getParam('shopUserDetail');
if(_shopUserDetail==null){
	var _params = 'action=ShopMarketing&run=getCakeShopUid';
	ComClass.post(_params,shopUserLoadCallBack);
}else{
	shopUserLoadCallBack(_shopUserDetail);
}
function shopUserLoadCallBack(data){
	SessionUtils.setParam('shopUserDetail', data);
	var _d = eval('('+data+')');
	if(_d.code=='1'){		
		//if(_d.msg.city=='400001'){
			//$('#xianxiashouqian').show();
		//}
		$('#rShopName').html(_d.msg.shopName);
		$('#rName').html(_d.msg.shopMainName+'&nbsp;&nbsp;'+_d.msg.shopTel);
		$('#rAddress').html(_d.msg.shopAddress);
	}else{
		alert(_d.msg);
	}
}

//赠品显示
var _marketPro = function(_m){
	var _params = 'action=ShopMarketing&run=getShopMarketingPro&_m='+_m;
	ComClass.post(_params,_marketProCallBack);
}
var _marketProCallBack = function(data){	
	var _d = eval('('+data+')');
	if(_d.code=='1'){
		var _html = '';
		for(var o in _d.msg){
			_html += '<li> <strong class="goods_bt"><span>【赠品】</span>'+_d.msg[o].title+'</strong>  <span class="through">￥'+_d.msg[o].price+'</span><strong class="goods_jg">X '+_d.msg[o].num+'</strong></li>';
		}
		$('#zpListUl').html(_html);
	}else{
		$('#zpListUl').remove();
	}
}

//结算
function account(){
	if(_totalNum<=0){
		alert('请选择商品，再进行结算')
		return false;
	}

	var _shopUserDetailD = SessionUtils.getParam('shopUserDetail');
	var _shopUserDetailDR = eval('('+_shopUserDetailD+')');

	//额外判断其他城市订单综合
	if(_shopUserDetailDR.msg.city=='400001'){
		if(parseInt(_totalPrice)<500){
			alert('您的订单不足500元，无法结算');
			return false;
		}
	}else{
		if(parseInt(_totalPrice)<1000){
			alert('您的订单不足1000元，无法结算');
			return false;
		}
	}

	/*by zjw
	var _tmpCarStr = SessionUtils.getParam('shopGoodsCar');
	var _params = 'action=ShopPro&run=setShopCarData&car='+_tmpCarStr;
	ComClass.post(_params,function(data){
		var _d = eval('('+data+')');
		if(_d.code == 707) {
			alert(_d.msg);
			location.reload()
		}
	});*/

	
	_marketPro(_totalPrice);
	
	var _psf = 0;
	var _params = 'action=ShopOrder&run=findShopOrderExpressMoney&_m='+_totalPrice+'&city='+_shopUserDetailDR.msg.city;
	ComClass.post(_params,function(data){
		var _d = eval('('+data+')');
		if(_d.code=='1'){
			_psf = parseInt(_d.msg.exp_money);
			$('#psf').html('￥'+_psf);
			//强制设置运费为0，同shopOrder中
			_psf = 0;
		}else{
			
		}
	});

	var _tmpCarStr = SessionUtils.getParam('shopGoodsCar');
	var _params = 'action=ShopPro&run=setShopCarData&car='+_tmpCarStr;
	ComClass.setParams(_params);




	
	var _tmpLeftCarStr = SessionUtils.getParam('shopGoodsLeftCarNum');
	var _params = 'action=ShopPro&run=setShopLeftCarData&car='+_tmpLeftCarStr;
	ComClass.setParams(_params);
	$('#goodsDetailDiv').hide();
	$('#orderEndListPay').show();
	
	var _tmpDataMarketingData = marketingAct();
	
	//结算合计
	$('#orderEndOPrice').html('￥'+_totalPrice);	
	$('#downlinePay').html('￥'+_totalPrice);
	if(_totalPrice>=parseFloat(_tmpDataMarketingData[0])){
		//结算实收
		$('#orderEndNPrice').html('￥'+((_totalPrice-parseFloat(_tmpDataMarketingData[1]))+_psf));
		$("#orderEndTotalMoney").html('￥'+(_totalPrice-parseFloat(_tmpDataMarketingData[1])));
		//优惠
		$("#orderEndDprice").html('￥' + parseInt(_tmpDataMarketingData[1]));
		
		$('#onlinePay').html('￥'+((_totalPrice-parseFloat(_tmpDataMarketingData[1]))+_psf));
		
		$('#yhsmHtml').html(_tmpDataMarketingData[2]);
	}else{
		//结算实收
		$('#orderEndNPrice').html('￥'+(_totalPrice+_psf));
		$("#orderEndTotalMoney").html('￥'+_totalPrice);
		//优惠
		$("#orderEndDprice").html('￥0');

		$('#onlinePay').html('￥'+(_totalPrice+_psf));
	}
}

var _s_u_b = 0;
var _oid = '';

$('#payOrder').click(function() {
	$(".box").show();
    $(".zffs").show();
});

$('#onlinePay').click(function() {
	var _val = 'action=ShopOrder&run=cOrderPay&_oid=' + _oid;
	if (_s_u_b == 0) {
		++_s_u_b;
		ComClass.post(_val, cOrderPayCallbackData);
	}
});

$('#downlinePay').click(function() {
	var _val = 'action=ShopOrder&run=cOrder&_oid=' + _oid;
	if (_s_u_b == 0) {
		++_s_u_b;
		ComClass.post(_val, cOrderCallbackData);
	}
});

function cOrderCallbackData(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '1') {
		_e = _d.msg;
		_oid = _e._oid;
		SessionUtils.removeParam('shopMarketingAct');
		SessionUtils.removeParam('shopGoodsCar');
		SessionUtils.removeParam('shopGoodsLeftCarNum');
		ComClass.href('shop.php?tpl=v1.shop.order.detail&i='+_oid);
		//onBridgeReady();
	} else {
		_s_u_b = 0;
		alert(_d.msg);
	}
}

function cOrderPayCallbackData(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '1') {
		_e = _d.msg;
		_oid = _e._oid;
		SessionUtils.removeParam('shopMarketingAct');
		SessionUtils.removeParam('shopGoodsCar');
		SessionUtils.removeParam('shopGoodsLeftCarNum');
//		ComClass.href('shop.php?tpl=v1.shop.order.detail&i='+_oid);
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
			ComClass.href('shop.php?tpl=v1.shop.order.detail&i='+_oid);
//			WeixinJSBridge.invoke('closeWindow', {}, function(res) {
//			});
		} else {
			_s_u_b = 0;
			var _val = 'action=ShopOrder&run=payFail&_oid=' + _oid;			
			$.get('/c/run.php?'+_val,'',function(rs){
				
			});
			alert('支付失败，请重新下单');
			ComClass.href('shop.php');
			// WeixinJSBridge.invoke('closeWindow', {}, function(res){});
		}
	});
}