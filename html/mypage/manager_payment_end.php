<?
include "../include/include_top.php";
?>
        
        <!-- Container -->
        <div id="container">
        	
			<!-- Content -->
            <div class="Content">
            
            	<!-- left -->
            	<?
				include "./include_mypage.php";
				?>
                <!-- left // -->
<?
if($LoginEduManager!="Y") {
?>
<script type="text/javascript">
<!--
	location.href="myinfo.php";
//-->
</script>
<?
exit;
}
?>
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3>자부담금 관리</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 교육담당자메뉴 > 자부담금 관리</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
                    
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="PageZone">
                        	
                            <!-- info -->
                            <div class="myManagerList">
                            	<!-- lecture info -->
                                <div class="term">
                                	<p class="title">[Compact CS-스킬편] 한국형 8大 고객불만 솔루션</p>
                                  	<strong class="mt20">2019년 10월 15일 ~ 2019년 11월 14일 개강</strong>
                                </div>
                            	
                                <!-- txt -->
                                <div class="mt50">
                                	<p class="tc"><img src="/images/sub/end_visual_img01.png" alt="" /></p>
                                  	<p class="tc mt30 fs28b fcSky01">자부담금 결제가 완료되었습니다.</p>
                                    <ul class="comment_1 mt30">
                                    	<li>블라블라~~신인가수들의 경우 쇼케이스라도 한 번 열어 다수의 매체를 통해 얼굴을 알려야 하나 첫 단추부터 제대로 채우지 못하는 상황이 됐다.</li>
                                        <li>한 해 평균 50팀의 데뷔하는 가요계에서 이름과 얼굴까지 알리는 아이돌로 자리잡는 것은 쉽지 않은 일이다. 연습생 시절부터 데뷔까지의 모든 과정이 소속사의 사전투자로 이뤄지는데 시작부터 계획과 어긋나니 적자만 쌓이게 된 상황이다.</li>
                                        <li>이번 주말 행정명령을 발동하지 않고 잘 지켜지면 더 바랄 것 없다. 지켜지지 않는 곳에 한정해 집회에 대해 제한명령을 하도록 했다.</li>
                                    </ul>
                                </div>
                                
                            	<!-- btn -->
                                <div class="btnAreaTc03">
                                    <span class="btnSky01"><a href="#">버튼</a></span>
                                </div>
                                <!-- btn // -->
                            </div>
                            <!-- info // -->
                           
                        </div>
                        
                        <!-- area // -->
                    </div>
                    <!-- info area // -->
                
                </div>
                <!-- content area -->
            
            </div>
            <!-- Content // -->
            
        </div>
        <!-- Container // -->
         
 <?
include "../include/include_bottom.php";
?>