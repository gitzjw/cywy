<?php
include_once '../public/config.inc.php';
include_once '../public/config.route.php';

final class CakeOrderPayCallbackController {
	public function __construct() {
		$r = file_get_contents ( "php://input" );
		$payObj = new CakeOrderController ();
		$payObj->payCallBack ( $r );
	}
}
new CakeOrderPayCallbackController ();