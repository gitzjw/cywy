<?php
final class InsPayRecordModel extends Mysql {
	
	public function getInsPayRecord($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select * from `insurance_pay_record` ';
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
	
	public function getInsPayRecordPid($_pid) {
		$sql = 'SELECT im.iName,im.iIdCard,im.iTelNumber,im.iUserId,ipr.*,i.iStart,i.iEnd,i.iSpan FROM insurance_pay_record ipr
		 INNER JOIN insurance i ON ipr.iId=i.id
		  INNER JOIN insurance_member im ON im.id=i.iInsuerId
		   WHERE ipr.pId="' . $_pid . '" 
		   ';
		$res = $this->get_all ( $sql );
		if (! $res) {
			$res = array ();
		}
		return $res;
	}
	
	public function addInsPayRecord($data) {
		
		$dataArray ['pId'] = $data ['pId'];
		$dataArray ['rCreateDate'] = $data ['rCreateDate'];
		$dataArray ['rPay'] = $data ['rPay'];
		$dataArray ['rStatus'] = $data ['rStatus'];
		$dataArray ['iId'] = $data ['iId'];
		$dataArray ['rSpan'] = $data ['rSpan'];
		
		$res = $this->insert ( 'insurance_pay_record', $dataArray );
		return $res;
	}
	
	public function setInsPayRecordPid($pid, $dataArray) {
		$res = $this->update ( 'insurance_pay_record', $dataArray, ' pId="' . $pid . '" ' );
		return $res;
	}
	
	public function setInsPayRecord($id, $dataArray) {
		$res = $this->update ( 'insurance_pay_record', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delInsPayRecord($id) {
		$res = $this->delete ( 'insurance_pay_record', ' id="' . $id . '" ' );
		return $res;
	}
}