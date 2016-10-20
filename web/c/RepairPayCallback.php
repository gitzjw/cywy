<?php
include_once '../public/config.inc.php';
include_once '../public/config.route.php';

final class RepairPayCallbackController {
	public function __construct() {
		$r = file_get_contents ( "php://input" );
		$payObj = new RepairPayController ();
		$payObj->payCallBack ( $r );
	}
}
new RepairPayCallbackController ();