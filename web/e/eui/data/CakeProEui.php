<?php
final class CakeProEuiController extends Base {
	
	public function getCakeProList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new CakeProModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getCakePro ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getCakePro ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_name = Run::req ( '_name' );
		if (! $_name) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_name) {
			$w .= ' and title="' . $_name . '" ';
		}
		return $w;
	}
	
	public function updateStatus() {
		$_s = Run::req ( '_s' );
		$_id = Run::req ( '_id' );
		$obj = new CakeProModel ();
		$data ['status'] = $_s;
		$res = $obj->setCakePro ( $_id, $data );
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
	
	public function updateTop() {
		$_top = Run::req ( '_top' );
		$_id = Run::req ( '_id' );
		$obj = new CakeProModel ();
		$data ['isTop'] = $_top;
		$res = $obj->setCakePro ( $_id, $data );
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
	
	public function saveCakePro() {
		$_id = Run::req ( 'id' );
		
		$_d ['title'] = Run::req ( 'title' );
		$_d ['dNum'] = Run::req ( 'dNum' );
		$_d ['oPrice'] = Run::req ( 'oPrice' );
		$_d ['dPrice'] = Run::req ( 'dPrice' );
		$_d ['nPrice'] = floatval ( $_d ['oPrice'] ) - floatval ( $_d ['dPrice'] );
		$_d ['createTime'] = date ( 'Y-m-d H:i:s' );
		$img1 = $this->uploadImg ( $_FILES ['upload1'] );
		$img2 = $this->uploadImg ( $_FILES ['upload2'] );
		$img3 = $this->uploadImg ( $_FILES ['upload3'] );
		if ($img1 || $img2 || $img3) {
			$_d ['imgPath'] = $img1 . '|' . $img2 . '|' . $img3;
		} else {
			$_d ['imgPath'] = Run::req ( 'imgPath' );
		}
		$listImg = $this->uploadImg ( $_FILES ['listimg'] );
		if ($listImg) {
			$_d ['listImgPath'] = $listImg;
		} else {
			$_d ['listImgPath'] = Run::req ( 'listImgPath' );
		}
		$_d ['isTop'] = Run::req ( 'isTop' );
		$_d ['QRcode'] = Run::req ( 'QRcode' );
		$_d ['htmlUrl'] = Run::req ( 'htmlUrl' );
		$_d ['status'] = Run::req ( 'status' );
		$_d ['content'] = Run::req ( 'content' );
		
		$sObj = new CakeProModel ();
		if ($_id) {
			$res = $sObj->setCakePro ( $_id, $_d );
		} else {
			$res = $sObj->addCakePro ( $_d );
		}
		
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
	
	public function writeHtml() {
		$_id = Run::req ( '_id' );
		$obj = new CakeProModel ();
		$res = $obj->getCakePro ( 'id="' . $_id . '"', '', '', '1' );
		if (! $res) {
			echo '生成失败，没有该数据';
			exit ();
		}
		$_a = explode ( '|', $res ['imgPath'] );
		$_lunbo = '';
		foreach ( $_a as $value ) {
			$_lunbo .= '<div class="swiper-slide red-slide"><img src="' . $value . '"  width="100%"></div>';
		}
		
		$dir = APP_PATH . 's/cake/';
		$_header = '<!DOCTYPE HTML>
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>萌工社</title>
					<meta name="author" content="">
					<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
					<meta name="apple-mobile-web-app-capable" content="yes">
					<meta name="apple-mobile-web-app-status-bar-style" content="black">
					<meta name="format-detection" content="telephone=no">
					<link rel="stylesheet" type="text/css" href="../../public/css/css1.css" />
					<link rel="stylesheet" href="../../public/css/swiper3.1.0.min.css" type="text/css" />
					<style>
					.swiper-container {width: 100%;}  
					.swiper-wrapper img{ width:100%;}
					.swiper-pagination-bullet-active{background:#fff;}
					</style>
					<script type="text/javascript" src="../../public/js/jquery-1.8.3.min.js"></script>
					</head>
					
					<body>';
		//<strong>￥' . $res ['oPrice'] . '</strong>
		$content = '<div class="swiper-container">
					    <div class="swiper-wrapper">
					    ' . $_lunbo . '
					    </div>
					    <div class="swiper-pagination">
					    </div>
					</div>
					<div class="cake_gou">
					<p>
					<span>月销' . $res ['dNum'] . '笔</span></p>
					<a href="javascript:void(0);" class="fenxiang">分享 <img src="../../public/images/icon_xd_fx.png"></a>
					</div>
					<div class="cake_gou">
					' . $res ['content'] . '
					</div>';
		
		$_footer = '<script  type="text/javascript">
					$(document).ready(function(){
						$(".fenxiang").click(function(){
							$(".box").show();
							})
					    $(".guanbi").click(function(){
							$(".box").hide();
							})	
						
						})
					
					</script>
					<script type="text/javascript" src="../../public/js/swiper3.1.0.min.js"></script>
					<script type="text/javascript">
					  var mySwiper = new Swiper(\'.swiper-container\',{
					    loop: true,
						autoplay: 3000,
						pagination: \'.swiper-pagination\',
					    paginationClickable: true,
					  });
					</script>
					<div class="box">
					<img src="../../public/images/share-bg-btn.png" width="100%;" class="guanbi">
					</div>
					</body>
					</html>';
		
		$_res = file_put_contents ( $dir . "cake_{$_id}_d.html", $_header . $content . $_footer );
		
		//更新记录
		$img = $this->_writeQRcode ( $dir, $_id );
		$obj = new CakeProModel ();
		$data ['htmlUrl'] = APP_WEBSITE . 's/cake/' . "cake_{$_id}_d.html";
		$data ['QRcode'] = $img;
		$res = $obj->setCakePro ( $_id, $data );
		
		echo '生成成功';
		exit ();
	}
	
	private function _writeQRcode($_dir = '', $_id = '') {
		require_once ('../ext/phpqrcode.php');
		$_file = $_dir . 'img_' . $_id . '.png';
		$_r_file = APP_WEBSITE. 's/cake/img_' . $_id . '.png';
		
		$value = APP_WEBSITE . 's/cake/' . "cake_{$_id}_d.html"; //二维码内容   
		

		$errorCorrectionLevel = 'L'; //容错级别   
		$matrixPointSize = 6; //生成图片大小   
		

		//生成二维码图片   
		QRcode::png ( $value, $_file, $errorCorrectionLevel, $matrixPointSize, 2 );
		return $_r_file;
	
	}
}