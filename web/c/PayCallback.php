<?php
include_once '../public/config.inc.php';
include_once '../public/config.route.php';

final class PayCallbackController {
	public function __construct() {
		$r = file_get_contents ( "php://input" );
		$payObj = new PayController ();
		$payObj->payCallBack ( $r );
	}
}
new PayCallbackController ();