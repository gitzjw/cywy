<?php
final class ThirdProEuiController extends Base {
	
	private $_url = 'http://180.167.66.14:8097/GetData.aspx?';
	
	public function checkThirdPro() {
		$_num = Run::req ( 'txm' );
		
		$_num = trim($_num);
		
		$_html = '';
		
		$_url = $this->_url . 'action=getbjonhands&key=meng&sptm=' . $_num;
		$_res_bj = Run::getHttpRes ( $_url );
		$_res_bj = json_decode ( $_res_bj, true );
		if (empty ( $_res_bj )) {
			$_html .= $_num . ' <b>北京仓</b> 无货 <br><br>';
		} else {
			$_html .= $_num . ' <b>北京仓</b> 剩余：' . $_res_bj ['0'] ['minkys'].'<br><br>';
		}
		
		$_url = $this->_url . 'action=getshonhands&key=meng&sptm=' . $_num;
		$_res_sh = Run::getHttpRes ( $_url );
		$_res_sh = json_decode ( $_res_sh, true );
		if (empty ( $_res_sh )) {
			$_html .= $_num . ' <b>上海仓</b> 无货 <br><br>';
		} else {
			$_html .= $_num . ' <b>上海仓</b> 剩余：' . $_res_sh ['0'] ['minkys'].'<br><br>';
		}
		
		echo $_html;
		exit ();
	}

}