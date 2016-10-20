<?php
include_once 'public/config.inc.php';
include_once 'public/config.route.php';

//Run::checkBrowser();
//Run::set_login_user('oBBd7xO_-5_bTVN4mwNBq_-49L-Y');

Run::loadStart ( 'v1.shop.header' );
$view = Run::req ( 'tpl' );
if ($view != '') {
	Run::loadStart ( $view );
} else {
	Run::loadStart ( 'v1.shop.index' );
}
Run::loadStart ( 'v1.shop.footer' );