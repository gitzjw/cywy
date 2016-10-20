<?php
final class InsModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f='*'){
		$this->_f = $f;
	}
	
	public function getIns($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `insurance` ';
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
	
	public function getInsUsersIdUnionData($uid){
		$sql = 'select i.*,im.*,(SELECT sName FROM `website_type` wt WHERE wt.id=i.wType) AS wTypeName,im.id as imId from `insurance` i inner join insurance_member im on i.iInsuerId=im.id where i.iUserId="'.$uid.'" and i.iStatus="1" limit 1';
		$res = $this->get_one($sql);
		return $res;
	}
	
	public function addIns($data) {
		
		$dataArray ['id'] = $data ['id'];
		$dataArray ['iInsId'] = $data ['iInsId'];
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['smIdOne'] = $data ['smIdOne'];
		$dataArray ['smIdTwo'] = $data ['smIdTwo'];
		$dataArray ['iStart'] = $data ['iStart'];
		$dataArray ['iEnd'] = $data ['iEnd'];
		$dataArray ['iStatus'] = $data ['iStatus'];
		$dataArray ['iUserId'] = $data ['iUserId'];
		$dataArray ['iInsuerId'] = $data ['iInsuerId'];
		$dataArray ['iCreateDate'] = $data ['iCreateDate'];
		$dataArray ['iUpdateDate'] = $data ['iUpdateDate'];
		
		$res = $this->insert ( 'insurance', $dataArray );
		return $res;
	}
	
	public function setIns($id, $dataArray) {
		$res = $this->update ( 'insurance', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delIns($id) {
		$res = $this->delete ( 'insurance', ' id="' . $id . '" ' );
		return $res;
	}
}
