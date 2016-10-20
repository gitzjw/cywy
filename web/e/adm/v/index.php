<?php 
	include_once 'left_nav.php';
	$cObj = new ChartController();
	$_mduDate = Run::req('date')?Run::req('date'):date('m');
	$_mduDateRes = date('Y').'-'.$_mduDate;
	$mduRes = $cObj->getMonthDayUser($_mduDateRes);	
?>
<section id="main" class="column">
<h4 class="alert_info">Welcome to Mgs beijing office.</h4>
		
		<article class="module width_full">
			<header><h3>欢迎</h3></header>
			<div class="module_content">
				<article class="stats_graph">
					<div style="border:solid 1px;border-color:#BFBFBF;">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
					<select onchange="locationHref(this.value)" name="month">
						<option value="1">1月</option><option value="2">2月</option><option value="3">3月</option>
						<option value="4">4月</option><option value="5">5月</option><option value="6">6月</option>
						<option value="7">7月</option><option value="8">8月</option><option value="9">9月</option>
						<option value="10">10月</option><option value="11">11月</option><option value="12">12月</option>
					</select>
					<script>
					var _mduMonth='<?php echo $_mduDate;?>';
					$('select[name="month"] option').each(function(){
						if($(this).val()==_mduMonth){
							$(this).attr('selected','true');
						}
					});
					function locationHref(val){		
						window.location.href='?date='+val;
					}
					</script>
    				<div id="user_day" style="height:400px;"></div>
    				</div>
    				<!-- ECharts单文件引入 -->
    				<script src="js/chart/echarts.js"></script>
    				<script type="text/javascript">
			        function getDaysStr(){
				        var _iC = getDays();
				        var _str = new Array();
				        for(i=0;i<_iC;i++){
				        	_str[i] = i+1;
				        }
				        return _str;
			        }
			        function getDaysData(){
			        	var _mduRes = eval('('+'<?php echo $mduRes;?>'+')');
				        var _iC = getDays();
				        var _str = new Array();
				        for(i=0;i<_iC;i++){
				        	_str[i] = _mduRes[i+1];
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
			                	        text: '每月每天的注册量',
			                	        subtext: ''
			                	    },
			                	    tooltip : {
			                	        trigger: 'axis'
			                	    },
			                	    legend: {
			                	        data:['最高注册量']
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
			                	            data : getDaysStr()
			                	        }
			                	    ],
			                	    yAxis : [
			                	        {
			                	            type : 'value',
			                	            axisLabel : {
			                	                formatter: '{value} 人'
			                	            }
			                	        }
			                	    ],
			                	    series : [
			                	        {
			                	            name:'最高注册量',
			                	            type:'line',
			                	            data:getDaysData(),
			                	            markPoint : {
			                	                data : [
			                	                    {type : 'max', name: '最大值'},
			                	                    {type : 'min', name: '最小值'}
			                	                ]
			                	            },
			                	            markLine : {
			                	                data : [
			                	                    {type : 'average', name: '平均值'}
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
    				<br>
    				点击查看相应的统计图表
    				<br><br>
    				<a href="index.php" class="alt_btn">每天的注册量</a> | 
    				<a href="?v=chart.ins.day.service" class="alt_btn">每人每天的保险单统计</a> |
    				<a href="?v=chart.ins.sync.user" class="alt_btn">绑定与非绑定保单统计</a> |
    				<a href="?v=chart.sign.user" class="alt_btn">每天签到统计</a> |    
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