<?php
final class SignNewsController extends Base {
	
	public function getSignNewsList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'SignNews' );
		$res = $obj->getSignNews ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getSignNewsAllCount() {
		$obj = D ( 'SignNews' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getSignNews ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getSignNewsDate($date = '') {
		if ($date == '') {
			$date = date ( 'Y-m-d' );
		}
		$obj = D ( 'SignNews' );
		$w = " sDate='{$date}' ";
		$res = $obj->getSignNews ( $w,'','','1' );
		if (empty ( $res )) {
			$w = " `status`='2' ";
			$res = $obj->getSignNews ( $w ,'','','1' );
			if (empty ( $res )) {
				return array ();
			}
		}
		return $res;
	}
	
	//发送新闻
	public function sendSignNews(){
		$uD = $this->getUserDetail();
		$res = $this->getSignNewsDate();
		$str = '{
				    "touser":"'.$uD['openId'].'",
				    "msgtype":"news",
				    "news":{
				        "articles": [
				         {
				             "title":"'.$res['title'].'",
				             "description":"'.$res['subTitle'].'",
				             "url":"'.$res['hrefUrl'].'",
				             "picurl":"'.$res['picUrl'].'"
				         }
				         ]
				    }
				}';
		$res = WechatToken::_sendWechatCustom($str);
	}
	
	public function getSignNewsId($id = '') {
		$obj = D ( 'SignNews' );
		$res = $obj->getSignNews ( "id='{$id}'", '', '1', '1' );
		return $res;
	}
	
	public function saveSignNews() {
		$_id = Run::req ( 'id' );
		
		$_d ['title'] = Run::req ( 'title' );
		$_d ['subTitle'] = Run::req ( 'subTitle' );
		$_d ['picUrl'] = Run::req ( 'picUrl' );
		$_d ['hrefUrl'] = Run::req ( 'hrefUrl' );
		$_d ['sDate'] = Run::req ( 'sDate' );
		$_d ['mId'] = Run::req ( 'mId' );
		$_d ['createDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['status'] = Run::req ( 'status' );
		
		$sObj = D ( 'SignNews' );
		if ($_id) {
			$res = $sObj->setSignNews ( $_id, $_d );
		} else {
			$res = $sObj->addSignNews ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=sign.news' );
		}
	}

}