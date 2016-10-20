<?php
include_once '../public/config.inc.php';
include_once '../public/config.route.php';

final class ShopOrderPayCallbackController {
	public function __construct() {
		$r = file_get_contents ( "php://input" );
		$payObj = new ShopOrderController ();
		$payObj->payCallBack ( $r );
	}
}
new ShopOrderPayCallbackController ();