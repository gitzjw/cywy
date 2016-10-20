<?php
include_once 'public/config.inc.php';
include_once 'public/config.route.php';

//Run::checkBrowser();
//Run::set_login_user('ocunGs7to419J25zokpRA2eA9zIM');

Run::loadStart ( 'v1.header' );
$view = Run::req ( 'tpl' );
if ($view != '') {
	Run::loadStart ( $view );
} else {
	Run::loadStart ( 'v1.index' );
}
Run::loadStart ( 'v1.footer' );