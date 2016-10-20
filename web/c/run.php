<?php
include_once '../public/config.inc.php';
include_once '../public/config.route.php';
final class RunClass {
	
	public static function run($className, $methodName) {
		$className.='Controller';
		$obj = new $className ();
		$obj->$methodName ();
	}

}
RunClass::run ( Run::req ( 'action' ), Run::req ( 'run' ) );