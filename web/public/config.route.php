<?php
ini_set ( "display_errors", 1 );

include_once APP_PATH . 'public/config.token.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Params.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Base.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Admin.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Users.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'InsPrice.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'InsMember.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'WebType.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'SerMember.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Ins.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'InsPay.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Pay.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'InsPayRecord.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'SignDayConfig.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'SignMain.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'SignMainRecord.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'SignWinRecord.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'SignWinPro.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'SignNews.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Activity.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Chart.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'RepairPrice.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'RepairOrder.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'RepairOrderHistory.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'RepairOrderDetail.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'RepairPay.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'CakeShop.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'CakePro.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'CakeOrder.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ShopType.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ShopPro.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ShopMarketing.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ShopOrder.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ShopSpeUser.php';
include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ShopDemand.php';
//include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ShopMain.php'

//include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'Medicine.php';

include_once APP_PATH . 'c' . DIRECTORY_SEPARATOR . 'ThirdSendGoods.php';

include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'DB.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'Admin.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'Users.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'InsPrice.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'InsMember.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'WebType.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'SerMember.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'Ins.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'InsPay.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'InsPayRecord.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'InsImportFile.php';

include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'SignDayConfig.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'SignMain.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'SignMainRecord.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'SignWinRecord.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'SignWinPro.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'SignNews.php';

include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'Activity.php';

include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'RepairPrice.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'RepairOrder.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'RepairOrderHistory.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'RepairOrderDetail.php';

include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'CakeShop.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'CakePro.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'CakeOrder.php';

include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopOrder.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopOrderDetail.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopOrderHistory.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopPro.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopSpeUser.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopType.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopVendor.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopVendorPro.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopMarketing.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopDemand.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopInvCode.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopOrderExpress.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopOrderAllotBd.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopOrderProLack.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopOrderExpressMoney.php';
include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'ShopMainInfo.php';
//include_once APP_PATH . 'm' . DIRECTORY_SEPARATOR . 'Medicine.php';