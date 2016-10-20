<?php
final class SignNewsEuiController extends Base {
	
	public function getSignNewsList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$aeObj = new SignNewsModel ();
		$res = $aeObj->getSignNews ( '', '', $limit );
		$aeObj->setField ( 'count(id) as total' );
		$totalRes = $aeObj->getSignNews ( '', '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
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
		$_d ['sDate'] = date('Y-m-d',strtotime(Run::req ( 'sDate' )));
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
			echo '操作成功';
		}else{
			echo '操作失败';
		}
	}

}