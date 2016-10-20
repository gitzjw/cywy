<?php
$_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Dshop.php%3Ftpl%3Dv1.shop.shop&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect';
//重定向浏览器 
header ( "Location: {$_url}" );
//确保重定向后，后续代码不会被执行 
exit ();