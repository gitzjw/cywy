<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('InsPay');
	$_date = Run::req('keyword');
	$res = $obj->getInsPayDate($_date);
//	$wObj = C('WebType');
//	$wRes = $wObj->getWebTypeAll('1');
//	$iObj = C('InsMember');
//	$iRes = $iObj->getInsMemberAll();
//	$seObj = C('SerMember');
//	$seRes = $seObj->getSerMemberAll();
?>
<script language="javascript" type="text/javascript" src="<?php echo APP_WEBSITE,'public/js/';?>My97DatePicker/WdatePicker.js"></script>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">支付记录</h3>	
			<div class="submit_a_link">
				<input type="text"  id="d4311" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{\'2050-10-01\'}'})"  value="<?php echo Run::req('keyword')?Run::req('keyword'):Run::getFormatDate();?>" placeholder="查询支付日期" name="keyword">
				<a href="javascript:void(0);" onclick="window.location.href='?v=insurance.pay.record.search&keyword='+$(this).prev().val();" class="alt_btn">搜索</a>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>     				
    				<th class="header">创建时间</th>
    				<th class="header">支付金额</th>
    				<th class="header">交易流水</th>
    				<th class="header">支付时间</th> 
    				<th class="header">状态</th>
    				<th class="header">时长/月</th>
    				<th class="header">操作</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['id'];?></td>     				
    				<td><?php echo $v['rCreateTime'];?></td>    				
    				<td><?php echo $v['rPay'];?></td>
    				<td><?php echo $v['rPayCode'];?></td>
    				<td><?php echo $v['rPayTime'];?></td>        
    				<td><?php echo $v['rStatus']=='0'?'<font style="color:red">未支付</font>':'已支付';?></td>
    				<td><?php echo $v['rSpan'];?></td>
    				<td><a href="javascript:void(0)" onclick="see('<?php echo $v['id'];?>')">查看</a></td>
				</tr>
			<?php 
			}
			?>				 
			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
						
		</div><!-- end of .tab_container -->
		<footer>
				<div class="submit_link">
					
				</div>
			</footer>
		</article>
		
		
		<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved" id="detail_h3">详细</h3>	
		</header>
		<div id="html_div">
		</div>
		<footer>
				<div class="submit_link">
				</div>
			</footer>
		</article>
</section>
<script>
function see(id){
	$('#detail_h3').html('订单号： '+id+' 内容');
	$.ajax({
		url:'run.php',
		type:'post',
		data:'id='+id+'&action=InsPayRecord&run=seeInsPayRecordDetail',
		success:function(data){
			if(data!='0'){
				var _d = eval('('+data+')');
				var _html = '';
				for(i=0;i<_d.length;i++){
					var _tmp_html = '<i style="font-size: 9px;">保单人：</i>'+_d[i].iName+' <i style="font-size: 9px;">身份证：</i>'+_d[i].iIdCard+
					' <i style="font-size: 9px;">联系电话：</i>'+_d[i].iTelNumber+' <i style="font-size: 9px;">有效时长：</i>'+_d[i].iSpan+
					' <i style="font-size: 9px;">增加时长：</i>'+_d[i].rSpan+' <i style="font-size: 9px;">生效时间：</i>'+_d[i].iStart
					+' 至 '+_d[i].iEnd;
					_html += '<h4 class="alert_success">'+_tmp_html+'</h4>';
				}
				$('#html_div').html(_html+'<br/>');
			}else{
				$('#html_div').html('<h4 class="alert_error">查询失败</h4><br/>');
			}
		}
	});
}
</script>