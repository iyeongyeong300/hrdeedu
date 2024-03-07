<?

switch ($MenuType) {
	case "A" :
?>
<?if(in_array('A',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-user"></i> 회원 관리</h1>
	<ul class="area">
		<?if(in_array('A1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="company.php">사업주 관리</a></li>
		<?}?>
		<?if(in_array('A2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="member.php">수강생 관리</a></li>
		<?}?>
		<?if(in_array('A3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="lecture_reg.php">수강 등록</a></li>
		<?}?>
		<?if(in_array('A4',$LoginAdminSubMenuGrant_array)){?>
		<!-- <li><a href="#">휴면회원 관리</a></li> -->
		<?}?>
		<?if(in_array('A5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="member_out.php">탈퇴회원 관리</a></li>
		<?}?>
		<?if(in_array('A6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="dept_category.php">관리자/영업자/첨삭강사 카테고리</a></li>
		<?}?>
		<?if(in_array('A7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="staff01.php">관리자 리스트</a></li>
		<?}?>
		<?if(in_array('A8',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="staff02.php">영업자 리스트</a></li>
		<?}?>
		<?if(in_array('A9',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="staff03.php">첨삭강사 리스트</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "B";
?>
<?if(in_array('B',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-document"></i> 수강 관리</h1>
	<ul class="area">
		<?if(in_array('B1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study.php">학습관리(사업주)</a></li>
		<li><a href="study2.php">학습관리(근로자)</a></li>
		<?}?>
		<?if(in_array('B2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="lecture_request.php">학습신청</a></li>
		<?}?>
		<?if(in_array('B3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_ip.php">IP모니터링</a></li>
		<?}?>
		<?if(in_array('B4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_correct.php">첨삭관리(사업주)</a></li>
		<li><a href="study_correct2.php">첨삭관리(근로자)</a></li>
		<?}?>
		<?if(in_array('B5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_end.php">수강마감(사업주)</a></li>
		<?}?>
		<?if(in_array('B6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_payment.php">결제관리(사업주)</a></li>
		<li><a href="study2_payment.php">결제관리(근로자)</a></li>
		<?}?>
		<?if(in_array('B7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="blacklist.php">블랙리스트 관리</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission(); 
//-->
</script>
<?}?>
<?
	break;
	
	case "C";
?>
<?if(in_array('C',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-mobile"></i> 독려 관리</h1>
	<ul class="area">
		<?if(in_array('C1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_sms.php">학습참여독려</a></li>
		<?}?>
		<?if(in_array('C2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_sms_log.php">문자발송내역</a></li>
		<?}?>
		<?if(in_array('C3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_email_log.php">메일발송내역</a></li>
		<?}?>
	<!--	<?if(in_array('C4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_sms_setting.php">독려내용 관리</a></li>
		<?}?>-->
		<?if(in_array('C5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="kakaotalk.php">알림톡 발송내역</a></li>
		<?}?>
		<?if(in_array('C6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="kakaotalk_replace.php">알림톡 전환전송 내역(LMS)</a></li>
		<?}?>
		<?//if(in_array('C7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="smsdata.php">문자/템플릿관리</a></li>
		<?//}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "D";
?>
<?if(in_array('D',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-lightbulb"></i> 컨텐츠 관리</h1>
	<ul class="area">
		<?if(in_array('D1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="teacher.php">강사 관리</a></li>
		<?}?>
		<?if(in_array('D2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="exam_bank.php">문제은행 관리</a></li>
		<?}?>
		<?if(in_array('D3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course_category.php">과정카테고리 관리</a></li>
		<?}?>
		<?if(in_array('D4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="contents.php">기초차시 관리</a></li>
		<?}?>
		<?if(in_array('D5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course.php?ctype=A">단과 컨텐츠 관리(사업자)</a></li>
		<li><a href="course.php?ctype=B">단과 컨텐츠 관리(근로자)</a></li>
		<?}?>
		<?if(in_array('D6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course_package.php">패키지 컨텐츠 관리</a></li>
		<?}?>
		<?if(in_array('D7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="poll_bank.php">설문 관리</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "E":
?>
<?if(in_array('E',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-group"></i> 커뮤니티 관리</h1>
	<ul class="area">
		<?if(in_array('E1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="notice.php">공지사항</a></li>
		<?}?>
		<?if(in_array('E2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="faq.php">자주 묻는 질문</a></li>
		<?}?>
		<?if(in_array('E3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="qna.php">1:1 문의</a></li>
		<?}?>
		<?if(in_array('E4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="after.php">수강후기</a></li>
		<?}?>
		<?if(in_array('E5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="edudata.php">학습자료실</a></li>
		<?}?>
		<?if(in_array('E6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="simple_ask.php">간편문의</a></li>
		<?}?>
		<?if(in_array('E7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_qna.php">학습상담</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "F":
?>
<?if(in_array('F',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-chart-line"></i> 통계 관리</h1>
	<ul class="area">
		<?if(in_array('F1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="sta.php">접속통계 관리</a></li>
		<?}?>
		<?if(in_array('F3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="sale_sta.php">영업통계관리(사업주)</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "G":
?>
<?if(in_array('G',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-browser"></i> 사이트 관리</h1>
	<ul class="area">
		<?if(in_array('G1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="popup.php">팝업 관리</a></li>
		<?}?>
		<?if(in_array('G2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="main_course_list.php">메인페이지 과정 관리</a></li>
		<?}?>
		<?if(in_array('G3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="work_request.php">작업 요청 게시판</a></li>
		<?}?>
		<?if(in_array('G4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="site_info.php">사이트 정보 관리</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;
	
	case "Z":
?>
<div class="subMenu">
	<h1><i class="xi-profile"></i> 정보 변경</h1>
	<ul class="area">
		<li><a href="my_info.php">정보 변경</a></li>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?
	break;

	default :
?>
<div class="subMenu">
	<h1><i class="xi-home"></i> 메인</h1>
	<ul class="area">
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?
}
?>