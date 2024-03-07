<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$pg = Replace_Check($pg);
$col = Replace_Check($col);
$sw = Replace_Check($sw);
$StartDate = Replace_Check($StartDate);
$EndDate = Replace_Check($EndDate);
$orderby = Replace_Check($orderby);
$FaqCate = Replace_Check($FaqCate);
$Gubun = Replace_Check($Gubun);
$ExamType = Replace_Check($ExamType);
$ServiceType = Replace_Check($ServiceType);
$str_TestType = Replace_Check($str_TestType);

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 30;
$block_size = 10;


//접근권한 배열 처리
$LoginAdminTopMenuGrant_array = explode(',',$LoginAdminTopMenuGrant);
$LoginAdminSubMenuGrant_array = explode(',',$LoginAdminSubMenuGrant);

$Top_Link_A =  array();
$Top_Link_B =  array();
$Top_Link_C =  array();
$Top_Link_D =  array();
$Top_Link_E =  array();
$Top_Link_F =  array();
$Top_Link_G =  array();

foreach($LoginAdminSubMenuGrant_array as $LoginAdminSubMenuGrant_array_value) {

	if(substr($LoginAdminSubMenuGrant_array_value,0,1)=="A") {
		$Top_Link_A[] = $LoginAdminSubMenuGrant_array_value;
	}
	if(substr($LoginAdminSubMenuGrant_array_value,0,1)=="B") {
		$Top_Link_B[] = $LoginAdminSubMenuGrant_array_value;
	}
	if(substr($LoginAdminSubMenuGrant_array_value,0,1)=="C") {
		$Top_Link_C[] = $LoginAdminSubMenuGrant_array_value;
	}
	if(substr($LoginAdminSubMenuGrant_array_value,0,1)=="D") {
		$Top_Link_D[] = $LoginAdminSubMenuGrant_array_value;
	}
	if(substr($LoginAdminSubMenuGrant_array_value,0,1)=="E") {
		$Top_Link_E[] = $LoginAdminSubMenuGrant_array_value;
	}
	if(substr($LoginAdminSubMenuGrant_array_value,0,1)=="F") {
		$Top_Link_F[] = $LoginAdminSubMenuGrant_array_value;
	}
	if(substr($LoginAdminSubMenuGrant_array_value,0,1)=="G") {
		$Top_Link_G[] = $LoginAdminSubMenuGrant_array_value;
	}

}

$Top_Link_A_page = $Manager_Top_Link_array[$Top_Link_A[0]];
$Top_Link_B_page = $Manager_Top_Link_array[$Top_Link_B[0]];
$Top_Link_C_page = $Manager_Top_Link_array[$Top_Link_C[0]];
$Top_Link_D_page = $Manager_Top_Link_array[$Top_Link_D[0]];
$Top_Link_E_page = $Manager_Top_Link_array[$Top_Link_E[0]];
$Top_Link_F_page = $Manager_Top_Link_array[$Top_Link_F[0]];
$Top_Link_G_page = $Manager_Top_Link_array[$Top_Link_G[0]];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title><?=$SiteName?> (<?=$ServerIP?>)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js?t=<?=date('YmdHis')?>"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="./include/jquery.tablednd_0_5.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
//로그 아웃 시간 처리
var TimeCheckNo = "Y";

function LogOutTimeView() {

	parselimit = 7200 - parseInt($("#NowTime").val());

	curmin=Math.floor(parselimit/60)
	cursec=parselimit%60

	if(curmin<10) {
		curmin2 = "0" + curmin;
	}else{
		curmin2 = curmin;
	}

	if(cursec<10) {
		cursec2 = "0" + cursec;
	}else{
		cursec2 = cursec;
	}

	if (curmin!=0) {
		curtime=curmin2+"분 "+cursec2+"초";
	}else{
		curtime="<font color='red'>00분 " + cursec2+"초</font>";
	}

	//남은시간 : 145분 30초
	$("span[id='LogOutRemainTime']").html("자동 로그아웃 까지 남은시간 : <B>"+curtime+"</B>");

}

$(document).ready(function() {

	var ScreenHeight = $(window).height();
	var BodyHeight =  $('html body').height();

	var LeftMenuHeight = ScreenHeight - BodyHeight + 40;

	if(LeftMenuHeight>0) {
		$("td[id='BottonHeight']").css({  
			"height": LeftMenuHeight
		})
	}

});
//-->
</SCRIPT>
</head>

<body leftmargin="0" topmargin="0">
<form name="listScriptForm" method="GET" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="col" value="<?=$col?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="pg" value="<?=$pg?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="StartDate" value="<?=$StartDate?>">
<input type="hidden" name="EndDate" value="<?=$EndDate?>">
<input type="hidden" name="FaqCate" value="<?=$FaqCate?>">
<input type="hidden" name="Gubun" value="<?=$Gubun?>">
<input type="hidden" name="ExamType" value="<?=$ExamType?>">
<input type="hidden" name="ServiceType" value="<?=$ServiceType?>">
<input type="hidden" name="str_TestType" value="<?=$str_TestType?>">
</form>


<form name="ReadScriptForm" method="GET" action="<?=$ReadPage?>.php">
<input type="hidden" name="idx">
<input type="hidden" name="col" value="<?=$col?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="pg" value="<?=$pg?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="StartDate" value="<?=$StartDate?>">
<input type="hidden" name="EndDate" value="<?=$EndDate?>">
<input type="hidden" name="FaqCate" value="<?=$FaqCate?>">
<input type="hidden" name="Gubun" value="<?=$Gubun?>">
<input type="hidden" name="ExamType" value="<?=$ExamType?>">
<input type="hidden" name="ServiceType" value="<?=$ServiceType?>">
<input type="hidden" name="str_TestType" value="<?=$str_TestType?>">
</form>
<div id="wrap">

	<!-- Header -->
    <div class="Header">
    	<!-- top -->
		<?
		switch (date("w")) {
			case "0": 
			$Weekend = "일요일";
			break;
			case "1": 
			$Weekend = "월요일";
			break;
			case "2":
			$Weekend = "화요일";
			break;
			case "3": 
			$Weekend = "수요일";
			break;
			case "4":
			$Weekend = "목요일";
			break;
			case "5": 
			$Weekend = "금요일";
			break;
			case "6": 
			$Weekend = "토요일";
			break;
		}
		?>
        <div class="topSide">
        	<ul class="adminInfo">
            	<li><strong><?=$LoginAdminName?> (부서명:<?=$LoginAdminDepart?>)</strong>님 안녕하세요.</li>
                <li><?=date("Y")?>년 <?=date("m")?>월 <?=date("d")?>일(<?=$Weekend?>)</li>
                <li><span id="LogOutRemainTime"></span></li>
                <li class="btn">
                	<span><a href="logout.php">로그아웃</a></span>
                    <span><a href="my_info.php">정보수정</a></span>
                </li>
            </ul>
        </div>
        <!-- top // -->
        <!-- menu -->
  		<div class="mainMenu">
        	<ul class="area">
				<?if(in_array('A',$LoginAdminTopMenuGrant_array)){?>
            	<li><a href="<?=$Top_Link_A_page?>" <?if($MenuType=="A") {?>class="show"<?}?>>회원 관리</a></li>
				<?}?>
				<?if(in_array('B',$LoginAdminTopMenuGrant_array)){?>
                <li><a href="<?=$Top_Link_B_page?>" <?if($MenuType=="B") {?>class="show"<?}?>>수강 관리</a></li>
				<?}?>
				<?if(in_array('C',$LoginAdminTopMenuGrant_array)){?>
                <li><a href="<?=$Top_Link_C_page?>" <?if($MenuType=="C") {?>class="show"<?}?>>독려 관리</a></li>
				<?}?>
				<?if(in_array('D',$LoginAdminTopMenuGrant_array)){?>
                <li><a href="<?=$Top_Link_D_page?>" <?if($MenuType=="D") {?>class="show"<?}?>>컨텐츠관리</a></li>
				<?}?>
				<?if(in_array('E',$LoginAdminTopMenuGrant_array)){?>
                <li><a href="<?=$Top_Link_E_page?>" <?if($MenuType=="E") {?>class="show"<?}?>>커뮤니티관리</a></li>
				<?}?>
				<?if(in_array('F',$LoginAdminTopMenuGrant_array)){?>
                <li><a href="<?=$Top_Link_F_page?>" <?if($MenuType=="F") {?>class="show"<?}?>>통계관리</a></li>
				<?}?>
				<?if(in_array('G',$LoginAdminTopMenuGrant_array)){?>
                <li><a href="<?=$Top_Link_G_page?>" <?if($MenuType=="G") {?>class="show"<?}?>>사이트관리</a></li>
				<?}?>
            </ul>
        </div>
        <!-- menu // -->
    </div>
    <!-- Header // -->
    
    <!-- Content -->
	<div class="Content">
    	<!-- Left -->
        <? include "./include/include_submenu.php"; ?>
    	<!-- Left // -->