<?php
final class InsImportFileEuiController extends Base {
	
	public function getInsImportFileList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new InsImportFileModel ();
		$res = $ueObj->getInsImportFile ( '', '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getInsImportFile ( '', '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	public function uploadInsImportFile() {
		$f = $_FILES ['fileUpload'];
		$obj = new InsImportFileModel ();
		$fRes = $this->uploadFile ( $f, date ( 'Ymd' ) );
		if(!$fRes){
			echo '请选择上传的文件';exit;
		}
		$_d ['filePath'] = $fRes;
		$_d ['createTime'] = date ( 'Y-m-d H:i:s' );
		$_d ['status'] = '1';
		$_d ['oUser'] = $_SESSION [APP_NAME . '_admin_'] ['uName'];
		$res = $obj->addInsImportFile ( $_d );
		if ($res) {
			echo '上传成功';
		} else {
			echo '上传失败';
		}
	}

}