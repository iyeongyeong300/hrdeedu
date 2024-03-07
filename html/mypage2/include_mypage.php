<?
include "../include/login_check.php";

$REQUEST_URI = explode("?",$_SERVER['REQUEST_URI']);
$PageUrl = $REQUEST_URI[0];
$PageUrl = str_replace("/mypage/","",$PageUrl);
$PageUrl = str_replace(".php","",$PageUrl);


$SubMenu01 = "none";
$SubMenu02 = "none";
$SubMenu03 = "none";
$SubMenu04 = "none";
$SubMenu05 = "none";

switch($PageUrl) {
	case "lecture":
		$HTML_TITLE = "학습중인 과정 > 수강관리 > 온라인 학습실";
		$TabCss01 = " class='show'";
		$SubMenu01 = "";
		$TabCss01_01 = " class='show'";
	break;
	case "lecture_detail":
		$HTML_TITLE = "학습중인 과정 > 수강관리 > 온라인 학습실";
		$TabCss01 = " class='show'";
		$SubMenu01 = "";
		$TabCss01_01 = " class='show'";
	break;
	case "lecture_review":
		$HTML_TITLE = "복습중인 과정 > 수강관리 > 온라인 학습실";
		$TabCss01 = " class='show'";
		$SubMenu01 = "";
		$TabCss01_02 = " class='show'";
	break;
	case "lecture_review_detail":
		$HTML_TITLE = "복습중인 과정 > 수강관리 > 온라인 학습실";
		$TabCss01 = " class='show'";
		$SubMenu01 = "";
		$TabCss01_02 = " class='show'";
	break;
	case "lecture_end":
		$HTML_TITLE = "학습종료 과정 > 수강관리 > 온라인 학습실";
		$TabCss01 = " class='show'";
		$SubMenu01 = "";
		$TabCss01_03 = " class='show'";
	break;


	case "appay_lecture":
		$HTML_TITLE = "수강신청 내역 > 수강신청 / 결제 관리 > 온라인 학습실";
		$TabCss02 = " class='show'";
		$SubMenu02 = "";
		$TabCss02_01 = " class='show'";
	break;
	case "appay_payment":
		$HTML_TITLE = "근로자 내일배움카드 > 수강신청 / 결제 관리 > 온라인 학습실";
		$TabCss02 = " class='show'";
		$SubMenu02 = "";
		$TabCss02_02 = " class='show'";
	break;


	case "data_pick":
		$HTML_TITLE = "찜한 학습자료 > 자료/상담관리 > 온라인 학습실";
		$TabCss03 = " class='show'";
		$SubMenu03 = "";
		$TabCss03_01 = " class='show'";
	break;
	case "data_ask":
		$HTML_TITLE = "1:1 상담 리스트 > 자료/상담관리 > 온라인 학습실";
		$TabCss03 = " class='show'";
		$SubMenu03 = "";
		$TabCss03_02 = " class='show'";
	break;
	case "data_ask_view":
		$HTML_TITLE = "1:1 상담 리스트 > 자료/상담관리 > 온라인 학습실";
		$TabCss03 = " class='show'";
		$SubMenu03 = "";
		$TabCss03_02 = " class='show'";
	break;
	case "data_qna":
		$HTML_TITLE = "학습 상담 리스트 > 자료/상담관리 > 온라인 학습실";
		$TabCss03 = " class='show'";
		$SubMenu03 = "";
		$TabCss03_03 = " class='show'";
	break;
	case "data_qna_view":
		$HTML_TITLE = "학습 상담 리스트 > 자료/상담관리 > 온라인 학습실";
		$TabCss03 = " class='show'";
		$SubMenu03 = "";
		$TabCss03_03 = " class='show'";
	break;


	case "myinfo_employer":
		$HTML_TITLE = "회원정보관리 > 온라인 학습실";
		$TabCss04 = " class='show'";
	break;
	case "myinfo_labor":
		$HTML_TITLE = "회원정보관리 > 온라인 학습실";
		$TabCss04 = " class='show'";
	break;


	case "manager_trainee":
		$HTML_TITLE = "자사수강생 리스트 > 교육담당자 > 온라인 학습실";
		$TabCss05 = " class='show'";
		$SubMenu05 = "";
		$TabCss05_01 = " class='show'";
	break;
	case "manager_payment":
		$HTML_TITLE = "자부담금 관리 > 교육담당자 > 온라인 학습실";
		$TabCss05 = " class='show'";
		$SubMenu05 = "";
		$TabCss05_02 = " class='show'";
	break;
	case "manager_complete":
		$HTML_TITLE = "수료 관리 > 교육담당자 > 온라인 학습실";
		$TabCss05 = " class='show'";
		$SubMenu05 = "";
		$TabCss05_03 = " class='show'";
	break;

}

$HTML_TITLE = $BOARD_TITLE.$HTML_TITLE." > ".$SiteName;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).attr("title","<?=$HTML_TITLE?>");
//-->
</SCRIPT>
<div class="leftArea" id="LeftMenuGo">
	<!-- title -->
	<h2>온라인 학습실</h2>
	<!-- menu -->
	<div class="submenuArea">
		<ul class="depth">
			<li><a href="lecture.php" <?=$TabCss01?>>수강관리</a>
				<!-- 3cate -->
				<ul class="depth2" style="display:<?=$SubMenu01?>">
					<li><a href="lecture.php" <?=$TabCss01_01?>>학습중인 과정</a></li>
					<li><a href="lecture_review.php" <?=$TabCss01_02?>>복습중인 과정</a></li>
					<li><a href="lecture_end.php" <?=$TabCss01_03?>>학습종료 과정</a></li>
				</ul>
				<!-- 3cate // -->
			</li>
			<li><a href="appay_lecture.php" <?=$TabCss02?>>수강신청 / 결제 관리</a>
				<!-- 3cate -->
				<ul class="depth2" style="display:<?=$SubMenu02?>">
					<li><a href="appay_lecture.php" <?=$TabCss02_01?>>수강신청 내역</a></li>
					<li><a href="appay_payment.php" <?=$TabCss02_02?>>근로자 내일배움카드 결제</a></li>
				</ul>
				<!-- 3cate // -->
			</li>
			<li><a href="data_pick.php" <?=$TabCss03?>>자료/상담관리</a>
				<ul class="depth2" style="display:<?=$SubMenu03?>">
					<li><a href="data_pick.php" <?=$TabCss03_01?>>찜한 학습자료</a></li>
					<li><a href="data_ask.php" <?=$TabCss03_02?>>1:1 상담 리스트</a></li>
					<li><a href="data_qna.php" <?=$TabCss03_03?>>학습 상담 리스트</a></li>
				</ul>
			</li>
			<li><a href="myinfo_employer.php" <?=$TabCss04?>>회원정보관리</a></li>
			<?if($LoginEduManager=="Y") {?>
			<li><a href="manager_trainee.php" <?=$TabCss05?>>교육담당자</a>
				<ul class="depth2" style="display:<?=$SubMenu05?>">
					<li><a href="manager_trainee.php" <?=$TabCss05_01?>>자사수강생 리스트</a></li>
					<li><a href="manager_payment.php" <?=$TabCss05_02?>>자부담금 관리</a></li>
					<li><a href="manager_complete.php" <?=$TabCss05_03?>>수료 관리</a></li>
				</ul>
			</li>
			<?}?>
		</ul>
	</div>
	<!-- menu // -->
	
	<!-- CS -->
	<?
	include "../support/include_cs.php";
	?>
	<!-- CS // -->
</div>