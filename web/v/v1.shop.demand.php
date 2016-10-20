<section class="margin lxdh">
 <div class="border_1 margin_20">
<textarea name="Content" rows="6" id="Content" style="color:#999;border:none;height:200px; line-height:25px;padding-top:5px;" placeholder="如果在商品目录内，没有找到您所需要采购的商品，请在此反馈。"></textarea>
</div>
 <div class="border_1 margin_20">
    <input   placeholder="您的联系方式" id="tel" type="text" style="" />
  </div></section>
<div class="Buy_btn4 submit_order" > <a href="#" id="yesBtn">确定</a> </div>
<script>
var __sub = 0;
$('#yesBtn').click(function(){
	if(__sub==0){		
		++__sub;
		var _params = 'action=ShopDemand&run=saveShopDemand&content=' + $('#Content').val()+'&tel='+$('#tel').val();
		ComClass.post(_params, callback);
	}
})	
function callback(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '1') {
		alert(_d.msg);
		window.location.reload();
	} else {
		--__sub;
		alert(_d.msg);
	}
}
</script>