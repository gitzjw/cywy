<?php
final class InsImportFileModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getInsImportFile($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `insurance_import_file` ';
		if (! empty ( $where )) {
			$sql .= ' where ' . $where;
		}
		if (! empty ( $orderby )) {
			$sql .= ' order by ' . $orderby;
		} else {
			$sql .= ' order by id desc ';
		}
		if (! empty ( $limit )) {
			$sql .= ' limit ' . $limit;
		}
		if (empty ( $solo )) {
			$res = $this->get_all ( $sql );
		} else {
			$res = $this->get_one ( $sql );
		}
		return $res;
	}
	
	public function addInsImportFile($data) {
		
		$dataArray ['filePath'] = $data ['filePath'];
		$dataArray ['createTime'] = $data ['createTime'];
		$dataArray ['status'] = $data ['status'];
		$dataArray ['oUser'] = $data ['oUser'];
		
		$res = $this->insert ( 'insurance_import_file', $dataArray );
		return $res;
	}
	
	public function setInsImportFile($id, $dataArray) {
		$res = $this->update ( 'insurance_import_file', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delInsImportFile($id) {
		$res = $this->delete ( 'insurance_import_file', ' id="' . $id . '" ' );
		return $res;
	}
}