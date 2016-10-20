<?php
final class ActivityEuiController extends Base {
	
	public function getActivityList($_t = '') {
		if ($_t == '') {
			$_t = Run::req ( '_t' );
		}
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$obj = D ( 'Activity' );
		$obj->setTable ( $_t );
		$w = $this->getWhere ();
		$res = $obj->getActivity ( $w, '', $limit );
		$obj->setField ( 'count(id) as total' );
		$totalRes = $obj->getActivity ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_area = Run::req ( '_area' );
		$_city = Run::req ( '_city' );
		$_xl = Run::req('_xl');
		if (! $_area && ! $_city && ! $_xl) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_area) {
			$w .= ' and area="' . $_area . '" ';
		}
		if ($_city) {
			$w .= ' and city="' . $_city . '" ';
		}
		if ($_xl) {
			$w .= ' and xl="' . $_xl . '" ';
		}
		return $w;
	}

}