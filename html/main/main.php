<?
//리뉴얼 홈페이지 이동
header("Location: https://www.hrdeedu.com/new/main/main.html");

include "../include/include_top.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function() {

	$('.bxslider').bxSlider({
		mode:'horizontal', //vertical, fade
		auto: true,
		autoControls: false,
		speed:300,
		pause : 3000,
		startSlide:0,
		pager:true,
		controls:true
	});

	//메인 페이지 강의 목록 로딩
	MainLectureView(1);
	$(".copyArea").css("margin-bottom","80px");

});
//-->
</SCRIPT>
        <!-- Visual -->
		<div id="mainVisual">
			<ul class="visual">
				<div class="slider1" id="slider1">
					<ul class="bxslider">
						<li style="background:url(../images/main/visual01_back.jpg) no-repeat center; ">
						<img src="../images/main/visual01_img.jpg" alt="미래 지식기반 사회의 선두주자를 양성하는 교육기관 - 지식기반 사회의 기틀을 마련하기 위해 노력하는 교육기관이 될 수 있도록 최선을 다하겠습니다." />
						</li>
						<li style="background:url(../images/main/visual02_back.jpg) no-repeat center;">
						<img src="../images/main/visual02_img.jpg" alt="미래 지식기반 사회의 선두주자를 양성하는 교육기관 - 지식기반 사회의 기틀을 마련하기 위해 노력하는 교육기관이 될 수 있도록 최선을 다하겠습니다." />
						</li>
						<li style="background:url(../images/main/visual03_back.jpg) no-repeat center;">
						<img src="../images/main/visual03_img.jpg" alt="미래 지식기반 사회의 선두주자를 양성하는 교육기관 - 지식기반 사회의 기틀을 마련하기 위해 노력하는 교육기관이 될 수 있도록 최선을 다하겠습니다." />
						</li>
					</ul>
				</div>
			</ul>
		</div>
        <!-- Visual // -->


		<!-- cont_01 -->
		
		<div id="cont_01">
			<ul class="visual">
				<li style="background:url(../images/main/cont_01_BG.jpg) no-repeat center; ">
					<img src="../images/main/cont_01.png" alt="컨텐츠 소개">
				</li>
			</ul>
		</div>

		<!-- cont_01 // -->

		<!-- cont_02 -->

		<div id="cont_02_wrap">
			<ul class="visual">
				<div style="background:url(../images/main/cont_02_BG.jpg) no-repeat center;">
					<ul>
						<li class="visual_1" style="padding-top:80px;"><img src="../images/main/cont_02_title.png" alt="법정의무교육" /></li>
						<li class="visual_2" style="padding-top:80px; "><img src="../images/main/cont_02_A.png" alt="법정의무교육" /></li>
						<li class="visual_3" style="padding-top:80px; padding-bottom:54px;"><img src="../images/main/cont_02_B.png" alt="법정의무교육" /></li>
					</ul>
				</div>
			</ul>
		</div>

		<!-- cont_02 // -->

		<!-- cont_03 -->
		
		<div id="cont_03">
			<ul class="visual">
				<li style="background:url(../images/main/cont_03_BG.jpg) no-repeat center; ">
					<img src="../images/main/cont_03.png" alt="컨텐츠 소개">
				</li>
			</ul>
		</div>

		<!-- cont_03 // -->

		<!-- cont_04 -->
		
		<div id="cont_04">
			<ul class="visual">
				<li style="background:url(../images/main/cont_04_BG.jpg) no-repeat center; ">
					<img src="../images/main/cont_04.png" alt="컨텐츠 소개">
				</li>
			</ul>
		</div>

		<!-- cont_04 // -->


		<!-- Banner //-->
       
		<!-- Content -->
        <div id="mainContent">

        	<!-- 과정 -->
          	<div class="Course" id="MainLecture"></div>
            <!-- 과정 // -->

        	<!-- 교육상담센터 - 새글 -->
			<div class="CsNew">
            
            	<!-- 상담 -->
                <div class="csPhone">
                	<p class="title">교육상담센터</p>
                	<ul>
                    	<li><span class="item">학습설계</span>
                        	<p class="number">031-217-4002</p>
                        </li>
                    	<li><span class="item">학습지원</span>
                        	<p class="number">031-217-4002</p>
                            <div class="time">
                                <p><span>평일(월~금) </span>09:00 ~ 18:00</p>
                                <p><span>점심시간 </span>12:00 ~ 13:00</p>
                            </div>
                        </li>
                    	<li><span class="item">학습장애</span>
                        	<p class="number">031-217-4002</p>
                            <div class="time">
                                <p><span>평일(월~금) </span>09:00 ~ 18:00</p>
                                <p><span>점심시간 </span>12:00 ~ 13:00</p>
                                <p>※ 이후 시간은 1:1 학습상담</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- 상담 // -->
            
            	<!-- 새글 -->
   		  		<div class="newInfo" id="NewsList">
                    <!-- tab Menu -->
                    <div class="tabMenu">
                    	<ul>
                        	<li><a href="Javascript:MainNewsList(0);" class="show">공지사항</a></li>
                            <li><a href="Javascript:MainNewsList(1);">자주묻는 질문</a></li>
                            <div class="more"><a href="/support/notice.php">더보기</a></div>
                        </ul>
                    </div>
                    <!-- list -->
                    <ul class="list">
						<?
						$SQL = "SELECT * FROM Notice WHERE Del='N' AND UseYN='Y' AND Notice='N' ORDER BY RegDate DESC, idx DESC LIMIT 0,6";
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($ROW = mysqli_fetch_array($QUERY))
							{
								extract($ROW);

								$Title = strcut_utf8($Title,45);
						?>
                    	<li><a href="/support/notice_view.php?idx=<?=$idx?>"><?=$Title?></a><span class="date"><?=substr($RegDate,0,10)?></span></li>
                        <?
							}
						}
						?>
                    </ul>
                	<!-- list // -->
                    
              		<!-- banner -->
                    <div><a href="/support/remote.php"><img src="../images/main/remote_banner.png" alt="동영상을 보는데 문제가 있으세요? - 원격지원" /></a></div>
                	<!-- banner -->
                </div>

				<div class="newInfo" id="NewsList" style="display:none">
                    <!-- tab Menu -->
                    <div class="tabMenu">
                    	<ul>
                        	<li><a href="Javascript:MainNewsList(0);" >공지사항</a></li>
                            <li><a href="Javascript:MainNewsList(1);" class="show">자주묻는 질문</a></li>
                            <div class="more"><a href="/support/faq.php">더보기</a></div>
                        </ul>
                    </div>
                    <!-- list -->
                    <ul class="list">
						<?
						$i = 0;
						$SQL = "SELECT * FROM Faq WHERE Del='N' AND UseYN='Y' ORDER BY OrderByNum ASC, RegDate ASC LIMIT 0,6";
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($ROW = mysqli_fetch_array($QUERY))
							{
								extract($ROW);

								$Title = strcut_utf8($Title,45);
						?>
                    	<li><a href="/support/faq.php?MainSend=Y&view_num=<?=$i?>"><?=$Title?></a><span class="date"><?=substr($RegDate,0,10)?></span></li>
                        <?
						$i++;
							}
						}
						?>
                    </ul>
                	<!-- list // -->
                    
              		<!-- banner -->
                    <div><a href="/support/remote.php"><img src="../images/main/remote_banner.png" alt="동영상을 보는데 문제가 있으세요? - 원격지원" /></a></div>
                	<!-- banner -->
                </div>
                <!-- 새글 -->
                
            </div>
            <!-- 교육상담센터 - 새글 // -->

			<!-- 하단 교육상담 배너 -->
        <div ID="bottomBanner" class="btoom-bn-wrap" style="display: block;">
			<div class="bn-wrap">
			<?=$SiteName?>의 교육을 원하신다면?
			<p class="btn"><a href="/support/ask.php">문의하기</a></p>
			<p class="btn-close" onclick="closePopupNotToday();"></p>
			</div>
		</div>
			<!-- 하단 교육상담 배너 -->
      </div>
        <!-- Content // -->
         
<? include "../popup/include_popup.php"; ?>
<?
include "../include/include_bottom.php";
?>