<?php 
	include_once 'left_nav.php';
	$cObj = new ChartController();
	$_date = Run::req('day')?Run::req('day'):date('Y-m-d');
	$idsRes = $cObj->getInsDayService($_date);
?>
<script language="javascript" type="text/javascript" src="<?php echo APP_WEBSITE,'public/js/';?>My97DatePicker/WdatePicker.js"></script>
<section id="main" class="column">
<h4 class="alert_info">Welcome to Mgs beijing office.</h4>
		
		<article class="module width_full">
			<header><h3>欢迎</h3></header>
			<div class="module_content">
				<article class="stats_graph">
					<div style="border:solid 1px;border-color:#BFBFBF;">
					<input type="text" name="day" id="day" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{\'2050-10-01\'}'})" value="<?php echo $_date;?>"/>
					<input type="button" onclick="window.location.href='?v=chart.ins.day.service&day='+$('#day').val()" value="查询"/>
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    				<div id="user_day" style="height:400px;"></div>
    				</div>
    				<!-- ECharts单文件引入 -->
    				<script src="js/chart/echarts.js"></script>
    				<script type="text/javascript">
			        function getX(){
				        var _tmpRes = eval('('+'<?php echo json_encode($idsRes['x']);?>'+')');
				        var _str = new Array();
				        for(i=0;i<_tmpRes.length;i++){
				        	_str[i] = _tmpRes[i];
				        }
				        return _str;
			        }
			        function getY(){
			        	var _tmpRes = eval('('+'<?php echo json_encode($idsRes['y']);?>'+')');
				        var _str = new Array();
				        for(i=0;i<_tmpRes.length;i++){
				        	_str[i] = _tmpRes[i];
				        }
				        return _str;
			        }
			        require.config({
			            paths: {
			                echarts: 'js/chart/'
			            }
			        });			        
				     // 使用
			        require(
			            [
			                'echarts',
			                'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
			                'echarts/chart/line' // 使用柱状图就加载bar模块，按需加载
			            ],
			            function (ec) {
			                // 基于准备好的dom，初始化echarts图表
			                var myChart = ec.init(document.getElementById('user_day'));
			                var option = {
			                	    title : {
			                	        text: '每天的签单量',
			                	        subtext: ''
			                	    },
			                	    tooltip : {
			                	        trigger: 'axis'
			                	    },
			                	    legend: {
			                	        data:['最高签单量']
			                	    },
			                	    toolbox: {
			                	        show : true,
			                	        feature : {
			                	            magicType : {show: true, type: ['line', 'bar']}
			                	        }
			                	    },
			                	    calculable : true,
			                	    xAxis : [
			                	        {
			                	            type : 'category',
			                	            boundaryGap : false,
			                	            data : getX()
			                	        }
			                	    ],
			                	    yAxis : [
			                	        {
			                	            type : 'value',
			                	            axisLabel : {
			                	                formatter: '{value} 单'
			                	            }
			                	        }
			                	    ],
			                	    series : [
			                	        {
			                	            name:'最高签单量',
			                	            type:'line',
			                	            data:getY(),
			                	            markPoint : {
			                	                data : [
			                	                    {type : 'max', name: '最大值'},
			                	                    {type : 'min', name: '最小值'}
			                	                ]
			                	            }
			                	        }
			                	    ]
			                	};
			        
			                // 为echarts对象加载数据 
			                myChart.setOption(option); 
			            }
			        );
			    	</script>
    				
    				
    				
    				<div style="height:100px;">    				
	    				<div class="submit_a_link">
							<a href="javascript:history.go(-1);" class="alt_btn">返回</a>
						</div>			
    				</div>
    				
    				<div id="resultLoad"></div>
    				
				</article>
				
				<article class="stats_overview">
					<div class="overview_today">
						<p class="overview_day">Date</p>
						<p class="overview_count"><?php echo Run::getFormatDate();?></p>
						<p class="overview_type">Today</p>
						<p class="overview_count"><?php // 第二种写法 
												$ga = date("w"); 
												switch( $ga ){ 
												case 1 : echo "星期一";break; 
												case 2 : echo "星期二";break; 
												case 3 : echo "星期三";break; 
												case 4 : echo "星期四";break; 
												case 5 : echo "星期五";break; 
												case 6 : echo "星期六";break; 
												case 0 : echo "星期日";break; 
												default : echo "你输入有误！"; 
												}; ?></p>						
					</div>
					<div class="overview_previous">
						<p class="overview_day">Time</p>
						<p class="overview_count"><?php echo Run::getFormatDate(null,'H:i:s');?></p>
						<p class="overview_type">-------</p>
						<p class="overview_count"></p>
					</div>
				</article>
				<div class="clear"></div>
			</div>
		</article><!-- end of stats article -->
</section>