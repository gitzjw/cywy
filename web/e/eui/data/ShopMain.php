<?php
final class ShopMainController extends Base {

    public function getMainPictures(){
        $obj = D('ShopMainInfo');

        $res = $obj->getShopMainPics();

        echo json_encode($res);
    }

    public function saveMainPic(){

        $data['id'] = Run::req ('id');
        $data['linkPic'] = Run::req('linkPic');
        $data['linkUrl'] = Run::req('linkUrl');
        $data['status'] = Run::req('status');

        $obj=D('ShopMainInfo');

        $res = $obj->setShopMainPic($data);

        $ref = intval($res);
        if($res === -1){
            echo 'error!';
        }elseif ($res === 0) {
            echo '提交数据失败';
        }else{
            echo '保存数据成功';
        }
        
        //echo json_encode($data);
    }

}
?>