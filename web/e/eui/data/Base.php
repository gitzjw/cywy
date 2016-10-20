<?php
class Base {
	
	public function getUserDetail() {
		$parObj = new ParamsController ();
		$userDetail = $parObj->getSessionParams ( 'userDetail' );
		if (empty ( $userDetail )) {
			return null;
		}
		return $userDetail;
	}
	
	public function _getIp() {
		if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" ))
			$ip = getenv ( "HTTP_CLIENT_IP" );
		else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" ))
			$ip = getenv ( "HTTP_X_FORWARDED_FOR" );
		else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" ))
			$ip = getenv ( "REMOTE_ADDR" );
		else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" ))
			$ip = $_SERVER ['REMOTE_ADDR'];
		else
			$ip = "192.168.1.2";
		return ($ip);
	}
	
	/**
	 * 
	 * 获取随机字符串
	 * @param int $len
	 * @param string $type	1数字 2字符 3数字+字符	 默认1
	 */
	public function getRandomString($len = 6, $type = '1') {
		if ($type == '1') {
			$str = '0123456789';
		} elseif ($type == '2') {
			$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxzy';
		} elseif ($type == '3') {
			$str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxzy';
		}
		
		$n = $len;
		$len = strlen ( $str ) - 1;
		$s = '';
		for($i = 0; $i < $n; $i ++) {
			$s .= $str [rand ( 0, $len )];
		}
		
		return $s;
	}
	
	public function uploadImg($file) {
		$f = $file ['tmp_name'];
		if (! $f) {
			return false;
		}
		$imgtype = $file ['type'];
		$PSize = filesize ( $f );
		$picturedata = fread ( fopen ( $f, "r" ), $PSize );
		$param = $picturedata;
		$arr = explode ( '/', $imgtype );
		$h = array ("Content-Type:" . $arr ['1'] );
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, "http://img.momopet.cn:4869/upload" );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $h );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$s = curl_exec ( $ch );
		curl_close ( $ch );
		$r = json_decode ( $s );
		$md5 = $r->info->md5;
		if ($arr ['1'] == 'png') {
			$md5 = $md5 . '?f=png';
		}
		return IMG_WEBSITE . $md5;
	}
	
	public function uploadFile($file, $_files) {
		$_path = dirname ( dirname ( __FILE__ ) ) . '/public/file/' . $_files . '/';
		$f = $file ['tmp_name'];
		if (is_dir ( $_path )) {
			$res = true;
		} else {
			$res = mkdir ( $_path );
		}
		
		if ($res) {
			if (! $f) {
				return false;
			}
			$imgtype = $file ['type'];
			$arr = explode ( '/', $imgtype );
			$fileName = './public/file/' . $_files . '/' . time () . '.' . $arr ['1'];
			$pathFileName = $_path . time () . '.' . $arr ['1'];
			if (move_uploaded_file ( $f, $pathFileName )) {
				return $fileName;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function wlog($fileName = '', $str) {
		if (empty ( $fileName )) {
			$fileName = Run::getFormatDate ( '', 'Ymd' ) . '.log';
		} else {
			$fileName .= '.log';
		}
		$str = Run::getFormatDate ( '', 'Y-m-d H:i:s' ) . ' ' . $str;
		$_r = file_get_contents ( $fileName );
		file_put_contents ( $fileName, $str . "\n\r" . $_r );
	}
	
	public function Sysid($_prev = 'M') {
		$t = strval ( time () );
		$r = $this->getRandomString ( 3 );
		return $_prev . $t . strtoupper ( $r );
	}
	
	public function SysOrderId($_prev = 'M') {
		$t = date ( 'YmdHis', time () );
		$r = $this->getRandomString ( 6 );
		return $_prev . $t . strtoupper ( $r );
	}
	
	/**
	 * 验证身份证号
	 * @param $vStr
	 * @return bool
	 */
	public function isIdCardNo($vStr) {
		$vCity = array ('11', '12', '13', '14', '15', '21', '22', '23', '31', '32', '33', '34', '35', '36', '37', '41', '42', '43', '44', '45', '46', '50', '51', '52', '53', '54', '61', '62', '63', '64', '65', '71', '81', '82', '91' );
		
		if (! preg_match ( '/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr ))
			return false;
		
		if (! in_array ( substr ( $vStr, 0, 2 ), $vCity ))
			return false;
		
		$vStr = preg_replace ( '/[xX]$/i', 'a', $vStr );
		$vLength = strlen ( $vStr );
		
		if ($vLength == 18) {
			$vBirthday = substr ( $vStr, 6, 4 ) . '-' . substr ( $vStr, 10, 2 ) . '-' . substr ( $vStr, 12, 2 );
		} else {
			$vBirthday = '19' . substr ( $vStr, 6, 2 ) . '-' . substr ( $vStr, 8, 2 ) . '-' . substr ( $vStr, 10, 2 );
		}
		
		if (date ( 'Y-m-d', strtotime ( $vBirthday ) ) != $vBirthday)
			return false;
		if ($vLength == 18) {
			$vSum = 0;
			
			for($i = 17; $i >= 0; $i --) {
				$vSubStr = substr ( $vStr, 17 - $i, 1 );
				$vSum += (pow ( 2, $i ) % 11) * (($vSubStr == 'a') ? 10 : intval ( $vSubStr, 11 ));
			}
			
			if ($vSum % 11 != 1)
				return false;
		}
		
		return true;
	}
	
	public function _jsonEn($code = '999', $msg = '系统异常') {
		$res ['code'] = $code;
		$res ['msg'] = $msg;
		echo json_encode ( $res );
		exit ();
	}

}