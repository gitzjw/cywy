<?php
final class ShopMainInfoModel extends Mysql {

    public $_f = '*';
    
    public function setField($f = '*') {
        $this->_f = $f;
    }
    
    public function getShopMainPics() {
        $sql = 'select * from `main_pictures`';

        return $this->get_all($sql);
    }

    public function setShopMainPic($data){
        
        $_struct = array(
            'id',
            'linkPic',
            'linkUrl',
            'status',
            );

        foreach ($data as $key=>$v) {
            if(!in_array($key, $_struct)){
                return -1;
            }
        }

        
        $ref = 0;
        
        if(empty($data['id'])){
            //insert
            unset($data['id']);
            $ref = $this->insert ( 'main_pictures', $data );
            
        }else{
            //update
            $_id = $data['id'];
            unset($data['id']);
            $ref = $this->update ( 'main_pictures', $data, ' id="' . $_id. '" ' );
        }
        return $ref;
    }

    

}
?>