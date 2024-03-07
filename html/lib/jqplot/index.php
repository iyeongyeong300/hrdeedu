<? include '../include/header.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<title>이상에듀 이벤트</title>
<!-- JQ-PLOT의 기본 설정 -->  
<script type="text/javascript" src="jquery.jqplot.js"></script>
<!-- 파이차트 관련 -->
<script type="text/javascript" src="jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="jqplot.donutRenderer.js"></script>
<!-- 바차트 관련 -->
<script type="text/javascript" src="jqplot.barRenderer.js"></script>
<script type="text/javascript" src="jqplot.categoryAxisRenderer.js"></script>
<!-- 포인트,라벨 관련 -->
<script type="text/javascript" src="jqplot.pointLabels.js"></script>
<script type="text/javascript" src="jqplot.canvasAxisLabelRenderer.js"></script>
<script type="text/javascript" src="jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//파이차트 데이터
	var pieData = [['수료', 35],['미수료', 65]];
	
	//혼합차트 데이터
	var s1 = [3, 2, 2, 2];
	var s2 = [12, 12, 12, 10];
	var s3 = [2, 3, 4, 6];
	var s4 = [1, 0, 0, 0];
	var s5 = [1, 2, 1, 1];
	
	//일반 차트1
	var b1 = [3, 12, 2, 1, 1];
	//일반 차트2
	var c1 = [2, 12, 3, 0, 2];
	//일반 차트3
	var d1 = [2, 12, 4, 0, 1];
	//일반 차트4
	var e1 = [2, 10, 6, 0, 1];
	
	
	//파이차트

	var plot1 = jQuery.jqplot ('piechart', [pieData], { 
		seriesDefaults: {
			renderer: jQuery.jqplot.PieRenderer, 
			rendererOptions: {
				showDataLabels: true,
				sliceMargin: 8
			}
		}, 
		legend: { show:true, location: 'e' }
		}
	);
	var ticks = ['매우그렇다', '그렇다', '보통이다', '그렇지 않다' , '매우 그렇지 않다'];
	
	//바챠트1
	var mixTicks = ['만족도', '학습 후<br />업무 도움', '사례 적절성', '교육서비스'];
	 
	var plot2 = $.jqplot('barchart01', [s1, s2, s3, s4, s5], {
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: mixTicks
			}
		},
		highlighter: { show: false },
		legend: {
			show:true,
			renderer: $.jqplot.EnhancedLegendRenderer,
			labels: ticks
		}
	});

	//바차트 공통
	$.jqplot.config.enablePlugins = true;

	//바차트2
	 
	var plot3 = $.jqplot('barchart02', [b1], {
		seriesColors:['#85802b'],
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		},
		highlighter: { show: false },
		trendline: { color: '#ff0000'}
	});
	
	//바차트3
	var plot4 = $.jqplot('barchart03', [c1], {
		seriesColors:['#00749F'],
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		},
		highlighter: { show: false }
	})
	
	//바차트4
	var plot5 = $.jqplot('barchart04', [d1], {
		seriesColors:['#C7754C'],
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		},
		highlighter: { show: false }
	})
	
	//바차트4
	var plot6 = $.jqplot('barchart05', [e1], {
		seriesColors:['#17BDB8'],
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		},
		highlighter: { show: false }
	})
	
});
</script>
<!-- JQ-PLOT의 CSS를 설정 -->  
<link rel="stylesheet" type="text/css" href="jquery.jqplot.css"/>  
<style type="text/css">
  body { width:19cm; margin:0 auto; }
  body > h1, body > h2, body > h3, body > ul, body > ul li { overflow:hidden; margin:0; padding:0; text-align:center; }
  body > h1 { margin:15pt 0; font-size:20pt; }
  body > h2 { margin-bottom:6pt; font-size:14pt; }
  body > h3 { margin-bottom:20pt; font-size:16pt; }
  body > ul li { overflow:hidden; float:left; width:48%; margin:0 1% 15pt; }
  body > ul li > div { height:5.6cm; }
  body > ul li > h1 { overflow:hidden; height:30pt; margin:8pt 5pt 2pt; font-size:10pt; line-height:15pt; }
</style>
</head>
<body style="background:#fff;">
  <h1>메디시크</h1>
  <h2>2016년 12월 01일자 수강 설문조사 결과</h2>
  <h3>[설문참여자 19명]</h3>
  <ul>
    <li>
      <h1>수료율 원형통계</h1>
      <div id="piechart"></div>
    </li>
    <li>
      <h1>유형별 만족도</h1>
      <div id="barchart01"></div>
    </li>
    <li>
      <h1>1. 본 과정의 전반적인 학습내용에 만족하십니까?</h1>
      <div id="barchart02"></div>
    </li>
    <li>
      <h1>2. 본 과정의 학습내용이 본인의 업무 활용에<br />도움이 되십니까?</h1>
      <div id="barchart03"></div>
    </li>
    <li>
      <h1>3. 본 과정의 차시에서 제공되는 보기와<br />사례 구성이 적절합니까?</h1>
      <div id="barchart04"></div>
    </li>
    <li>
      <h1>4. 학습 시 교육에 대한 안내, 질의 응답, 학습 독려 등이<br />적절하게 이루어졌다고 생각하십니까?</h1>
      <div id="barchart05"></div>
    </li>
  </ul>
</div>
</body>