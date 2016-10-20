<?php
include_once '../public/config.inc.php';
include_once '../public/config.route.php';

final class ActivityPayCallbackController {
	public function __construct() {
		$r = file_get_contents ( "php://input" );
		$payObj = new ActivityController();
		$payObj->payCallBack ( $r,'20160105' );
	}
}
new ActivityPayCallbackController ();