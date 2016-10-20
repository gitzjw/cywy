<?php 
	$uRes = Run::c();
	$Obj = C('Ins');
	$res = $Obj->getInsUsersId($uRes['id']);
	if(empty($res)){
		$uObj = C('Users');
		$res = $uObj->bindingOtherReg($uRes);
		if(!$res){
			Run::show_msg('','1','?tpl=v1.not');
		}		
	}
	$seObj = C('SerMember');
	$seRes = $seObj->getSerMemberAll();
?>
<div class="x_inst">
			<img src="<?php echo IMG_PATH;?>toubao.jpg" />
			<p><span class="active">保险介绍</span><span>我的保单</span><span>理赔记录</span></p>
		</div>
<div class="background1 height1"></div>
		<div class="service_z1">
			<div class="service_b1">
				<ul class="ser_jx">
					<li>
						<span>1</span>
						填补行业空白：为宠物店内工作人员量身定制的意外医疗保险，全面保障从业者。
					</li>
					<li>
						<span>2</span>
						免费参保：只要成为宠业无忧的高级合作伙伴，宠物店内所有店员即可免费参保。
					</li>
					<li>
						<span>3</span>
						凡是工作过程中发生的猫爪狗咬问题，均可享受0元起赔，100%报销（打疫苗、住院、输液、化验、治疗……）。
					</li>
					<li>
						<span>4</span>
						投保后48小时内保险生效；出险确认后，理赔款10个工作日即可到账。
					</li>
					<li>
						<span>5</span>
						宠业无忧，真正用心关怀从业者，为宠物服务行业的生态建设而努力。
					</li>
				</ul>
			</div>			
			<div class="service_b1">
			<table width="100%" class="tbg" cellpadding="0" cellspacing="0">
			<td width="80" >保单号</td><td colspan="4"><span><?php echo $res['iInsId'];?></span></td>
			</tr>
			<tr>
			<td>投保人</td><td  width="80"><p><?php echo $res['iName'];?></p></td>
			<td width="60">险种</td><td><p><?php echo $res['wTypeName'];?></p></td>
			</tr>
			<tr>
			<td width="80" >状态</td><td colspan="4"><span><?php echo $res['iStatus']=='0'?'未投保':'投保中';?></span></td>
			</tr>
			<tr>
			<td width="80" >生效日期</td><td colspan="4"><span><?php $a = explode(' ', $res['iStart']);echo $a[0];?></span></td>
			</tr>
			<tr>
			<td width="80" >终止日期</td><td colspan="4"><span><?php $a = explode(' ', $res['iEnd']);echo $a[0];?></span></td>
			</tr>
			<tr>
			<td colspan="4">售后服务人员  </td></tr>
			<tr>
			<tr>
			<td>客户经理</td><td ><p><?php echo isset($seRes[$res['smIdOne']]['sName'])?$seRes[$res['smIdOne']]['sName']:'';?></p></td>
			<td width="60">电话</td><td><p><a  href="tel:<?php echo isset($seRes[$res['smIdOne']]['sTelNumber'])?$seRes[$res['smIdOne']]['sTelNumber']:'';?>"><?php echo isset($seRes[$res['smIdOne']]['sTelNumber'])?$seRes[$res['smIdOne']]['sTelNumber']:'';?></a></p></td>
			</tr>
			<tr>
			<td>保险专员</td><td ><p><?php echo isset($seRes[$res['smIdTwo']]['sName'])?$seRes[$res['smIdTwo']]['sName']:'';?></p></td>
			<td width="60">电话</td><td><p><a  href="tel:<?php echo isset($seRes[$res['smIdTwo']]['sTelNumber'])?$seRes[$res['smIdTwo']]['sTelNumber']:'';?>"><?php echo isset($seRes[$res['smIdTwo']]['sTelNumber'])?$seRes[$res['smIdTwo']]['sTelNumber']:'';?></a></p></td>
			</tr>
			
			</table>
			</div>
			<div class="service_b1">
				<div class="zwbd">
                	暂无理赔记录
                </div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
			$(".service_z1 .service_b1:first").show().siblings(".service_b1").hide();
				$(".x_inst p  span").click(function(){
					$(this).addClass("active").siblings().removeClass("active");
					nums=$(this).index();
					$(".service_z1 .service_b1").eq(nums).show().siblings().hide();
					});
				})
		</script>