/**
 * 主样式
 */
document.write('<link rel="stylesheet" type="text/css" href="../../public/js/jq-eui-src/themes/gray/easyui.css">'+
		'<link rel="stylesheet" type="text/css" href="../../public/js/jq-eui-src/themes/icon.css">'+
		'<script type="text/javascript" src="../../public/js/jq-eui-src/jquery.min.js">'+
		'</script>'+
		'<script type="text/javascript" src="../../public/js/jq-eui-src/jquery.easyui.min.js">'+
		'</script>'+
		'<script type="text/javascript" src="../../public/js/jq-eui-src/locale/easyui-lang-zh_CN.js">'+
		'</script>'+
		'<script language="javascript" type="text/javascript" src="../../public/js/My97DatePicker/WdatePicker.js"></script>');

function getCityName(code){
	var _str='';
	switch (code) {
		case '100001':
			_str='北京';
			break;
		case '200001':
			_str='上海';
			break;
		case '300001':
			_str='深圳';
			break;	
		case '400001':
			_str='其它城市';
			break;	
		default:
			_str='北京';
			break;
	}
	return _str;
}
