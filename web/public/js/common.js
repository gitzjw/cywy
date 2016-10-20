/**
 * MOMODA 公共函数
 */
$.ajaxSetup({
	async : false
});

var ComClass = {

	webSite : '',
	imgSite : 'http://img.chongyewuyou.com:4869/',

	setParams : function(params) {
		$.post("./c/run.php", params, function(data, textStatus) {
			 console.log(data);
		});
	},

	post : function(params, callback) {
		$.post("./c/run.php", params, function(data, textStatus) {
			callback(data);
		});
	},

	href : function(tpl) {
		window.location.href = this.webSite + tpl;
	}

}

var LocalUtils = {
	setParam : function(name, value) {
		localStorage.setItem(name, value);
		return true;
	},
	getParam : function(name) {
		return localStorage.getItem(name);
	}
}

var SessionUtils = {
	setParam : function(name, value) {
		sessionStorage.setItem(name, value);
		return true;
	},
	getParam : function(name) {
		return sessionStorage.getItem(name);
	},
	removeParam : function(name) {
		sessionStorage.removeItem(name);
		return true;
	}
}

function log(log) {
	console.log(log);
}

/**
 * 恢复滚动条
 */
function enableScroll() {
	$('body').css('overflow', 'auto');
}

/**
 * 禁用滚动条
 */
function disableScroll() {
	$('body').css('overflow', 'hidden');
}

/**
 * 获取当前URL参数值
 * 
 * @param name
 *            参数名称
 * @return 参数值
 */
function getUrlParam(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null)
		return unescape(r[2]);
	return null;
}
