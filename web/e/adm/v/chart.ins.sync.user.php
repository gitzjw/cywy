<?php 
	include_once 'left_nav.php';
	$cObj = new ChartController();
	$idsRes = $cObj->getInsSyncUser();
?>
<script language="javascript" type="text/javascript" src="<?php echo APP_WEBSITE,'public/js/';?>My97DatePicker/WdatePicker.js"></script>
<section id="main" class="column">
<h4 class="alert_info">Welcome to Mgs beijing office.</h4>
		
		<article class="module width_full">
			<header><h3>欢迎</h3></header>
			<div class="module_content">
				<article class="stats_graph">
					<div style="border:solid 1px;border-color:#BFBFBF;">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    				<div id="user_day" style="height:400px;"></div>
    				</div>
    				<!-- ECharts单文件引入 -->
    				<script src="js/chart/echarts.js"></script>
    				<script type="text/javascript">
			        require.config({
			            paths: {
			                echarts: 'js/chart/'
			            }
			        });			        
				     // 使用
			        require(
			            [
			                'echarts',
			                'echarts/chart/pie',
			                'echarts/chart/funnel'
			            ],
			            function (ec) {
			                // 基于准备好的dom，初始化echarts图表
			                var myChart = ec.init(document.getElementById('user_day'));
			                option = {
			                	    title : {
			                	        text: '绑定用户与非绑定用户',
			                	        subtext: '',
			                	        x:'center'
			                	    },
			                	    tooltip : {
			                	        trigger: 'item',
			                	        formatter: "{a} <br/>{b} : {c} ({d}%)"
			                	    },
			                	    legend: {
			                	        orient : 'vertical',
			                	        x : 'left',
			                	        data:['绑定用户','非绑定用户']
			                	    },
			                	    toolbox: {
			                	        show : true,
			                	        feature : {
			                	            mark : {show: true},
			                	            dataView : {show: true, readOnly: false},
			                	            magicType : {
			                	                show: true, 
			                	                type: ['pie', 'funnel'],
			                	                option: {
			                	                    funnel: {
			                	                        x: '25%',
			                	                        width: '50%',
			                	                        funnelAlign: 'left',
			                	                        max: <?php echo $idsRes['syncNoNum']>$idsRes['syncNum']?$idsRes['syncNoNum']:$idsRes['syncNum'];?>
			                	                    }
			                	                }
			                	            },
			                	            restore : {show: true},
			                	            saveAsImage : {show: true}
			                	        }
			                	    },
			                	    calculable : true,
			                	    series : [
			                	        {
			                	            name:'保单量',
			                	            type:'pie',
			                	            radius : '55%',
			                	            center: ['50%', '60%'],
			                	            data:[
			                	                {value:<?php echo $idsRes['syncNum'];?>, name:'绑定用户'},
			                	                {value:<?php echo $idsRes['syncNoNum'];?>, name:'非绑定用户'}
			                	            ]
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