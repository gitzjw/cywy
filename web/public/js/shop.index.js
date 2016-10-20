/**
 * cake main
 */
SessionUtils.removeParam('_goodsListNavId');
SessionUtils.removeParam('_goodsListNavIdLeftWtype');

var _p = 1;
function defaulLoad() {
	var _htmlLocal = SessionUtils.getParam('shopIndexHtml');
	if(_htmlLocal==null){
		var _params = 'action=ShopType&run=getShopTypeParent&_index=1';
		ComClass.post(_params, callback);
	}else{
		$('#mainLi').append(_htmlLocal);
	}
}
defaulLoad();
function callback(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '1') {
		var _html = '';
		for(i=0;i<_d.msg.length;i++){
			//<li><a href="cake_details.html"><img src="<?php echo IMG_PATH;?>icon_xd_cwpz.png" >主食    </a></li>
			_html += '<li>'+
					 	'<a href="shop.php?tpl=v1.shop.goods.list&i='+_d.msg[i].id+'">'+'<img src="'+_d.msg[i].imgPath+'" /><span>'+_d.msg[i].sName+'</span></a>'+
					 '</li>';
		}		
		$('#mainLi').append(_html);
		SessionUtils.setParam('shopIndexHtml',_html);
	} else {
		
	}
}

