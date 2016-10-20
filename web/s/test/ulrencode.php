<?php
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.person.d&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.sign&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.mjd.order&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Ds%2F20151216&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.cake.main&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

//商品订单列表
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Dshop.php%3Ftpl%3Dv1.shop.shop&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

//北京
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Ds%2Fact%2F20160105_bj.html&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect
//上海
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Ds%2Fact%2F20160105_sh.html&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect
//深圳
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Ds%2Fact%2F20160105_sz.html&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

//专员绑定
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Dshop.php%3Ftpl%3Dv1.shop.spe&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect

echo urlencode('shop.php?tpl=v1.shop.shop&i=1');

$str = '{
     "button":[
     {	
     	   "name":"关爱计划",
           "sub_button":[	               
	            {	
	              "type":"view",
	          	  "name":"保险介绍",
	          	  "url":"http://mp.weixin.qq.com/s?__biz=MzA4MDUzNDA1NQ==&mid=400141985&idx=1&sn=af318bc6b75e3656b0ac66e8c19546bb&scene=18#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"投保 · 续保",
	          	  "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.ins&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"我的保单",
	          	  "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.person.d&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"出险理赔",
	          	  "url":"http://mp.weixin.qq.com/s?__biz=MzA4MDUzNDA1NQ==&mid=400142892&idx=1&sn=bb709a9ce52ebc2dc0240ea78c3c593c&scene=18#wechat_redirect"
	            }   
            ]      
      },{	
          "type":"view",
          "name":"每日签到",
          "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.sign&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
      },
      {
           "name":"贴心服务",
           "sub_button":[           
            {
               "type":"view",
               "name":"上门磨剪刀",
               "url":"http://mgs.momoday.net/tmp.php?tpl=v1.mjd"
            },{	
               "type":"view",
               "name":"上门洗笼子",
               "url":"http://mgs.momoday.net/tmp.php?tpl=v1.clear"
            }
            ]
       }]
 }';

$str = '{
     "button":[
     {	
          "type":"view",
          "name":"保障服务",
          "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.person.d&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
      },{	
          "type":"view",
          "name":"每日签到",
          "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.sign&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
      },
      {
           "name":"贴心服务",
           "sub_button":[           
            {
               "type":"view",
               "name":"上门磨剪刀",
               "url":"http://mgs.momoday.net/tmp.php?tpl=v1.mjd"
            },{	
               "type":"view",
               "name":"上门洗笼子",
               "url":"http://mgs.momoday.net/tmp.php?tpl=v1.clear"
            }
            ]
       }]
 }';

$str = '{
     "button":[
     {	
          "type":"view",
          "name":"保障服务",
          "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.person.d&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
      },{	
          "type":"view",
          "name":"每日签到",
          "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.sign&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
      },
      {
           "name":"贴心服务",
           "sub_button":[ 
           {	
               "type":"view",
               "name":"宠物蛋糕",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.cake.main&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
            },          
            {
               "type":"view",
               "name":"上门磨剪刀",
               "url":"http://mgs.momoday.net/tmp.php?tpl=v1.mjd"
            }
            ]
       }]
 }';

$str = '{
     "button":[
     {	
     	   "name":"保障计划",
           "sub_button":[	               
	            {	
	              "type":"view",
	          	  "name":"保险介绍",
	          	  "url":"http://mp.weixin.qq.com/s?__biz=MzA4MDUzNDA1NQ==&mid=400141985&idx=1&sn=af318bc6b75e3656b0ac66e8c19546bb&scene=18#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"保单查询",
	          	  "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.person.d&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"出险理赔",
	          	  "url":"http://mp.weixin.qq.com/s?__biz=MzA4MDUzNDA1NQ==&mid=400142892&idx=1&sn=bb709a9ce52ebc2dc0240ea78c3c593c&scene=18#wechat_redirect"
	            } 
            ]      
      },{	
          "type":"view",
          "name":"每日签到",
          "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.sign&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
      },
      {
           "name":"贴心服务",
           "sub_button":[ 
           {	
               "type":"view",
               "name":"宠物蛋糕",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.cake.main&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
            },          
            {
               "type":"view",
               "name":"上门磨剪刀",
               "url":"http://mgs.momoday.net/tmp.php?tpl=v1.mjd"
            }
            ]
       }]
 }';

$str = '{
     "button":[
     {	
     	   "name":"保障计划",
           "sub_button":[	               
	            {	
	              "type":"view",
	          	  "name":"保险介绍",
	          	  "url":"http://mp.weixin.qq.com/s?__biz=MzA4MDUzNDA1NQ==&mid=400413494&idx=2&sn=e902d1a779f53b2c6de5d341c88a1ee4&scene=23&srcid=0121Rm11EuVeHFibFYdgqkrb#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"保单查询",
	          	  "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.person.d&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"出险理赔",
	          	  "url":"http://mp.weixin.qq.com/s?__biz=MzA4MDUzNDA1NQ==&mid=400142892&idx=1&sn=bb709a9ce52ebc2dc0240ea78c3c593c&scene=18#wechat_redirect"
	            } 
            ]      
      },{

      	"name":"回家过年",
           "sub_button":[	               
	            {	
	              "type":"view",
	          	  "name":"每日签到",
	          	  "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.sign&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
	            },{	
	              "type":"view",
	          	  "name":"幸福大巴",
	          	  "url":"http://mgs.momoday.net/s/20160122/"
	            } 
            ]
      },
      {
           "name":"贴心服务",
           "sub_button":[ 
           {	
               "type":"view",
               "name":"宠物蛋糕",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbd92752eaebee0b5&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.cake.main&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect"
            },          
            {
               "type":"view",
               "name":"上门磨剪刀",
               "url":"http://mgs.momoday.net/tmp.php?tpl=v1.mjd"
            }
            ]
       }]
 }';