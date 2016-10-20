<?php
final class ParamsController {
	
	public function setParams() {
		
		foreach ( $_REQUEST as $k => $v ) {
			$_SESSION [APP_NAME] [$k] = strip_tags ( $v );
		}
	
	}
	
	public function localSetParams($k, $v) {
		$_SESSION [APP_NAME] [$k] = $v;
	}
	
	public function getSessionParams($str) {
		if (isset ( $_SESSION [APP_NAME] [$str] )) {
			return $_SESSION [APP_NAME] [$str];
		} else {
			return false;
		}
	}
	
	public function getSessionAll() {
		return $_SESSION [APP_NAME];
	}
	
	public function unsetSession($str) {
		unset ( $_SESSION [APP_NAME] [$str] );
	}
	
	public function unsetAll() {
		unset ( $_SESSION [APP_NAME] );
	}

}