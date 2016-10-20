/**
 * cake main
 */
var _p = 1;
function defaulLoad() {
	var _params = 'action=CakePro&run=getCakeMainPro&page=' + _p;
	ComClass.post(_params, callback);
}
defaulLoad();
function callback(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '0') {
		var _html = '';
		for(i=0;i<_d.msg.length;i++){
			_html += '<li>'+
					 	'<a href="?tpl=v1.cake.detail&i='+_d.msg[i].id+'">'+
						    '<dl>'+
						      '<dt><img src="'+_d.msg[i].listImgPath+'"></dt>'+
						      '<dd>'+_d.msg[i].title+'<span>￥'+_d.msg[i].nPrice+'</span></dd>'+
						    '</dl>'+
					    '</a>'+
					   '</li>';
		}		
		$('#cakeMainList').append(_html);
	} else {
		$("#loadPage").remove();
	}
}
$('#loadPage').click(function() {
	++_p;
	defaulLoad();
});