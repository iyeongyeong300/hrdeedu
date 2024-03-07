<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$Dept = Replace_Check($Dept);
$idx = Replace_Check($idx);
$ParentCategory = Replace_Check($ParentCategory);
$Deep = Replace_Check($Deep);
$DeptString = Replace_Check($DeptString);
$mode = Replace_Check($mode);

$TopMenuGrant_array = array();
$SubMenuGrant_array = array();

if($mode=="Edit") {

$Sql = "SELECT * FROM DeptStructure WHERE idx=$idx AND Dept='$Dept'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {

	$Dept = $Row['Dept'];
	$ParentCategory = $Row['ParentCategory'];
	$Deep = $Row['Deep'];
	$DeptName = $Row['DeptName'];
	$DeptString = $Row['DeptString'];
	$TopMenuGrant = $Row['TopMenuGrant'];
	$TopMenuGrant_array = explode(',',$TopMenuGrant);
	$SubMenuGrant = $Row['SubMenuGrant'];
	$SubMenuGrant_array = explode(',',$SubMenuGrant);

	}

}



if($ParentCategory) {
	$Sql = "SELECT * FROM DeptStructure WHERE idx=$ParentCategory";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	if($Row) {
		$Upper_DeptName = $Row['DeptName'];
	}
}else{
	$Upper_DeptName = "없음";
}

if(!$mode) {
	$mode=="New";
}

switch ($Dept) {
	case "A":
		$DeptTitle = "관리자";
	break;
	case "B":
		$DeptTitle = "영업자";
	break;
	case "C":
		$DeptTitle = "첨삭강사";
	break;
	default :
		$DeptTitle = "";
}

switch ($mode) {
	case "New":
		$ModeScript = "등록";
	break;
	case "Edit":
		$ModeScript = "수정";
	break;
	default :
		$ModeScript = "";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){

	//권한설정 회원관리-------------------------------------------
	$("#TopMenuGrant01").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant01']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant01").is(":checked")==true) {
				$("input[name='SubMenuGrant01']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant01']:eq("+i+")").prop('checked',false);
			}
		}

	});

	$("input[name='SubMenuGrant01']").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant01']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant01']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}

		if(checked_value>0) {
			$("#TopMenuGrant01").prop('checked',true);
		}else{
			$("#TopMenuGrant01").prop('checked',false);
		}

	});
	//권한설정 회원관리-------------------------------------------

	//권한설정 수강관리-------------------------------------------
	$("#TopMenuGrant02").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant02']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant02").is(":checked")==true) {
				$("input[name='SubMenuGrant02']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant02']:eq("+i+")").prop('checked',false);
			}
		}

	});

	$("input[name='SubMenuGrant02']").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant02']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant02']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}

		if(checked_value>0) {
			$("#TopMenuGrant02").prop('checked',true);
		}else{
			$("#TopMenuGrant02").prop('checked',false);
		}

	});
	//권한설정 수강관리-------------------------------------------

	//권한설정 독려관리-------------------------------------------
	$("#TopMenuGrant03").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant03']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant03").is(":checked")==true) {
				$("input[name='SubMenuGrant03']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant03']:eq("+i+")").prop('checked',false);
			}
		}

	});

	$("input[name='SubMenuGrant03']").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant03']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant03']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}

		if(checked_value>0) {
			$("#TopMenuGrant03").prop('checked',true);
		}else{
			$("#TopMenuGrant03").prop('checked',false);
		}

	});
	//권한설정 독려관리-------------------------------------------

	//권한설정 컨텐츠관리-------------------------------------------
	$("#TopMenuGrant04").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant04']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant04").is(":checked")==true) {
				$("input[name='SubMenuGrant04']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant04']:eq("+i+")").prop('checked',false);
			}
		}

	});

	$("input[name='SubMenuGrant04']").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant04']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant04']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}

		if(checked_value>0) {
			$("#TopMenuGrant04").prop('checked',true);
		}else{
			$("#TopMenuGrant04").prop('checked',false);
		}

	});
	//권한설정 컨텐츠관리-------------------------------------------

	//권한설정 커뮤니티관리-------------------------------------------
	$("#TopMenuGrant05").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant05']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant05").is(":checked")==true) {
				$("input[name='SubMenuGrant05']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant05']:eq("+i+")").prop('checked',false);
			}
		}

	});

	$("input[name='SubMenuGrant05']").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant05']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant05']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}

		if(checked_value>0) {
			$("#TopMenuGrant05").prop('checked',true);
		}else{
			$("#TopMenuGrant05").prop('checked',false);
		}

	});
	//권한설정 커뮤니티관리-------------------------------------------

	//권한설정 통계관리-------------------------------------------
	$("#TopMenuGrant06").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant06']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant06").is(":checked")==true) {
				$("input[name='SubMenuGrant06']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant06']:eq("+i+")").prop('checked',false);
			}
		}

	});

	$("input[name='SubMenuGrant06']").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant06']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant06']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}

		if(checked_value>0) {
			$("#TopMenuGrant06").prop('checked',true);
		}else{
			$("#TopMenuGrant06").prop('checked',false);
		}

	});
	//권한설정 통계관리-------------------------------------------

	//권한설정 사이트관리-------------------------------------------
	$("#TopMenuGrant07").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant07']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant07").is(":checked")==true) {
				$("input[name='SubMenuGrant07']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant07']:eq("+i+")").prop('checked',false);
			}
		}

	});

	$("input[name='SubMenuGrant07']").click(function() {

		var SubMenuGrant_length = $("input[name='SubMenuGrant07']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant07']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}

		if(checked_value>0) {
			$("#TopMenuGrant07").prop('checked',true);
		}else{
			$("#TopMenuGrant07").prop('checked',false);
		}

	});
	//권한설정 사이트관리-------------------------------------------


});



function SubmitOk() {

val = document.Form1;

if(val.DeptName.value=="") {
	alert("카테고리명을 등록하세요.");
	val.DeptName.focus();
	return;
}

var TopMenuGrant = "";
var SubMenuGrant = "";
var SubMenuGrant01 = "";
var SubMenuGrant02 = "";
var SubMenuGrant03 = "";
var SubMenuGrant04 = "";
var SubMenuGrant05 = "";
var SubMenuGrant06 = "";
var SubMenuGrant07 = "";

var TopMenuGrant01_length = $("input[name='TopMenuGrant01']").length;
for(i=0;i<TopMenuGrant01_length;i++) {
	if($("input[name='TopMenuGrant01']:eq("+i+")").is(":checked")==true) {
		if(TopMenuGrant=="") {
			TopMenuGrant = $("input[name='TopMenuGrant01']:eq("+i+")").val();
		}else{
			TopMenuGrant = TopMenuGrant + "," + $("input[name='TopMenuGrant01']:eq("+i+")").val();
		}
	}
}

$("#TopMenuGrant").val(TopMenuGrant);

var SubMenuGrant01_length = $("input[name='SubMenuGrant01']").length;
if(SubMenuGrant01_length>0) {
	for(i=0;i<SubMenuGrant01_length;i++) {
		if($("input[name='SubMenuGrant01']:eq("+i+")").is(":checked")==true) {
			if(SubMenuGrant01=="") {
				SubMenuGrant01 = $("input[name='SubMenuGrant01']:eq("+i+")").val();
			}else{
				SubMenuGrant01 = SubMenuGrant01 + "," + $("input[name='SubMenuGrant01']:eq("+i+")").val();
			}
		}
	}
}

var SubMenuGrant02_length = $("input[name='SubMenuGrant02']").length;
if(SubMenuGrant02_length>0) {
	for(i=0;i<SubMenuGrant02_length;i++) {
		if($("input[name='SubMenuGrant02']:eq("+i+")").is(":checked")==true) {
			if(SubMenuGrant02=="") {
				SubMenuGrant02 = $("input[name='SubMenuGrant02']:eq("+i+")").val();
			}else{
				SubMenuGrant02 = SubMenuGrant02 + "," + $("input[name='SubMenuGrant02']:eq("+i+")").val();
			}
		}
	}
}

var SubMenuGrant03_length = $("input[name='SubMenuGrant03']").length;
if(SubMenuGrant03_length>0) {
	for(i=0;i<SubMenuGrant03_length;i++) {
		if($("input[name='SubMenuGrant03']:eq("+i+")").is(":checked")==true) {
			if(SubMenuGrant03=="") {
				SubMenuGrant03 = $("input[name='SubMenuGrant03']:eq("+i+")").val();
			}else{
				SubMenuGrant03 = SubMenuGrant03 + "," + $("input[name='SubMenuGrant03']:eq("+i+")").val();
			}
		}
	}
}

var SubMenuGrant04_length = $("input[name='SubMenuGrant04']").length;
if(SubMenuGrant04_length>0) {
	for(i=0;i<SubMenuGrant04_length;i++) {
		if($("input[name='SubMenuGrant04']:eq("+i+")").is(":checked")==true) {
			if(SubMenuGrant04=="") {
				SubMenuGrant04 = $("input[name='SubMenuGrant04']:eq("+i+")").val();
			}else{
				SubMenuGrant04 = SubMenuGrant04 + "," + $("input[name='SubMenuGrant04']:eq("+i+")").val();
			}
		}
	}
}

var SubMenuGrant05_length = $("input[name='SubMenuGrant05']").length;
if(SubMenuGrant05_length>0) {
	for(i=0;i<SubMenuGrant05_length;i++) {
		if($("input[name='SubMenuGrant05']:eq("+i+")").is(":checked")==true) {
			if(SubMenuGrant05=="") {
				SubMenuGrant05 = $("input[name='SubMenuGrant05']:eq("+i+")").val();
			}else{
				SubMenuGrant05 = SubMenuGrant05 + "," + $("input[name='SubMenuGrant05']:eq("+i+")").val();
			}
		}
	}
}

var SubMenuGrant06_length = $("input[name='SubMenuGrant06']").length;
if(SubMenuGrant06_length>0) {
	for(i=0;i<SubMenuGrant06_length;i++) {
		if($("input[name='SubMenuGrant06']:eq("+i+")").is(":checked")==true) {
			if(SubMenuGrant06=="") {
				SubMenuGrant06 = $("input[name='SubMenuGrant06']:eq("+i+")").val();
			}else{
				SubMenuGrant06 = SubMenuGrant06 + "," + $("input[name='SubMenuGrant06']:eq("+i+")").val();
			}
		}
	}
}

var SubMenuGrant07_length = $("input[name='SubMenuGrant07']").length;
if(SubMenuGrant07_length>0) {
	for(i=0;i<SubMenuGrant07_length;i++) {
		if($("input[name='SubMenuGrant07']:eq("+i+")").is(":checked")==true) {
			if(SubMenuGrant07=="") {
				SubMenuGrant07 = $("input[name='SubMenuGrant07']:eq("+i+")").val();
			}else{
				SubMenuGrant07 = SubMenuGrant07 + "," + $("input[name='SubMenuGrant07']:eq("+i+")").val();
			}
		}
	}
}


if(SubMenuGrant01!="") {
	if(SubMenuGrant=="") {
		SubMenuGrant = SubMenuGrant01;
	}else{
		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant01;
	}
}

if(SubMenuGrant02!="") {
	if(SubMenuGrant=="") {
		SubMenuGrant = SubMenuGrant02;
	}else{
		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant02;
	}
}

if(SubMenuGrant03!="") {
	if(SubMenuGrant=="") {
		SubMenuGrant = SubMenuGrant03;
	}else{
		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant03;
	}
}

if(SubMenuGrant04!="") {
	if(SubMenuGrant=="") {
		SubMenuGrant = SubMenuGrant04;
	}else{
		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant04;
	}
}

if(SubMenuGrant05!="") {
	if(SubMenuGrant=="") {
		SubMenuGrant = SubMenuGrant05;
	}else{
		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant05;
	}
}

if(SubMenuGrant06!="") {
	if(SubMenuGrant=="") {
		SubMenuGrant = SubMenuGrant06;
	}else{
		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant06;
	}
}

if(SubMenuGrant07!="") {
	if(SubMenuGrant=="") {
		SubMenuGrant = SubMenuGrant07;
	}else{
		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant07;
	}
}

$("#SubMenuGrant").val(SubMenuGrant);


Yes = confirm("등록 하시겠습니까?");
if(Yes==true) {

	val.submit();
}

}

function DelOk() {

Yes = confirm("삭제 하시겠습니까?");
if(Yes==true) {
	document.Form1.mode.value="Del";
	document.Form1.submit();
}

}


//-->
</SCRIPT>
</head>

<body leftmargin="0" topmargin="0">

<div id="wrap">

    
    <!-- Content -->
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2><?=$DeptTitle?> <?=$ModeScript?></h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="dept_category_reg_script.php">
				<INPUT TYPE="hidden" NAME="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" NAME="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" NAME="Dept" value="<?=$Dept?>">
				<INPUT TYPE="hidden" NAME="ParentCategory" value="<?=$ParentCategory?>">
				<INPUT TYPE="hidden" NAME="Deep" value="<?=$Deep?>">
				<INPUT TYPE="hidden" NAME="DeptString" value="<?=$DeptString?>">
				<INPUT TYPE="hidden" NAME="TopMenuGrant" id="TopMenuGrant" value="<?=$TopMenuGrant?>">
				<INPUT TYPE="hidden" NAME="SubMenuGrant" id="SubMenuGrant" value="<?=$SubMenuGrant?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>상위 카테고리</th>
                    <td><?=$Upper_DeptName?></td>
                  </tr>
                  <tr>
                    <th>카테고리명</th>
                    <td><input type="text" name="DeptName" id="DeptName" value="<?=$DeptName?>" size="75"></td>
                  </tr>
				  <?if($Dept=="A") { //관리자일 경우 권한설정?>
                  <tr>
                    <th>권한 설정</th>
                    <td>
					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
						<tr>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant01" value="A" <?if(in_array('A',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant01"><strong>회원관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant02" value="B" <?if(in_array('B',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant02"><strong>수강관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant03" value="C" <?if(in_array('C',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant03"><strong>독려관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant04" value="D" <?if(in_array('D',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant04"><strong>컨텐츠관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant05" value="E" <?if(in_array('E',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant05"><strong>커뮤니티관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant06" value="F" <?if(in_array('F',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant06"><strong>통계관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant07" value="G" <?if(in_array('G',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant07"><strong>사이트관리</strong></label></td>
						</tr>
						<tr>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_01" value="A1" <?if(in_array('A1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_01">사업주관리</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_02" value="A2" <?if(in_array('A2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_02">수강생관리</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_03" value="A3" <?if(in_array('A3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_03">수강등록</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_04" value="A4" <?if(in_array('A4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_04">휴면회원관리</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_05" value="A5" <?if(in_array('A5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_05">탈퇴회원관리</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_06" value="A6" <?if(in_array('A6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_06">관리자/영업자 카테고리</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_07" value="A7" <?if(in_array('A7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_07">관리자 리스트</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_08" value="A8" <?if(in_array('A8',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_08">영업자 리스트</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_09" value="A9" <?if(in_array('A9',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_09">첨삭강사 리스트</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_01" value="B1" <?if(in_array('B1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_01">학습관리</label><br>
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_02" value="B2" <?if(in_array('B2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_02">학습신청</label><br>
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_03" value="B3" <?if(in_array('B3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_03">IP모니터링</label><br>
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_04" value="B4" <?if(in_array('B4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_04">첨삭관리</label><br>
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_05" value="B5" <?if(in_array('B5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_05">마감관리</label><br>
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_06" value="B6" <?if(in_array('B6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_06">결제관리</label><br>
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_07" value="B7" <?if(in_array('B7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_07">블랙리스트 관리</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_01" value="C1" <?if(in_array('C1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_01">학습참여독려</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_02" value="C2" <?if(in_array('C2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_02">문자발송내역</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_03" value="C3" <?if(in_array('C3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_03">메일발송내역</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_04" value="C4" <?if(in_array('C4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_04">독려내용관리</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_05" value="C5" <?if(in_array('C5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_05">알림톡 발송내역</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_06" value="C6" <?if(in_array('C6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_06">알림톡 전환전송 내역(LMS)</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_01" value="D1" <?if(in_array('D1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_01">강사 관리</label><br>
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_02" value="D2" <?if(in_array('D2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_02">문제은행관리</label><br>
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_03" value="D3" <?if(in_array('D3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_03">과정카테고리관리</label><br>
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_04" value="D4" <?if(in_array('D4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_04">기초차시관리</label><br>
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_05" value="D5" <?if(in_array('D5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_05">단과컨텐츠관리</label><br>
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_06" value="D6" <?if(in_array('D6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_06">패키지컨텐츠관리</label><br>
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_07" value="D7" <?if(in_array('D7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_07">설문관리</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_01" value="E1" <?if(in_array('E1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_01">공지사항</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_02" value="E2" <?if(in_array('E2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_02">자주 묻는 질문</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_03" value="E3" <?if(in_array('E3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_03">1:1 상담문의</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_04" value="E4" <?if(in_array('E4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_04">수강후기</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_05" value="E5" <?if(in_array('E5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_05">학습자료실</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_06" value="E6" <?if(in_array('E6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_06">간편문의</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_07" value="E7" <?if(in_array('E7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_07">학습상담</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_01" value="F1" <?if(in_array('F1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_01">접속통계관리</label><br>
							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_02" value="F2" <?if(in_array('F2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_02">수강생통계관리</label><br>
							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_03" value="F3" <?if(in_array('F3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_03">영업통계관리</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_01" value="G1" <?if(in_array('G1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_01">팝업관리</label><br>
							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_02" value="G2" <?if(in_array('G2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_02">메인디자인관리</label><br>
							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_03" value="G3" <?if(in_array('G3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_03">작업요청 게시판</label><br>
							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_04" value="G4" <?if(in_array('G4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_04">사이트 정보 관리</label>
							</td>
						</tr>
					</table>
					</td>
                  </tr>
				  <?}//관리자일 경우 권한설정?>
				  <?if($Dept=="B") { //영업자일 경우 권한설정?>
                  <tr>
                    <th>권한 설정</th>
                    <td>
					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
						<tr>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant01" value="A" <?if(in_array('A',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant01"><strong>회원관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant02" value="B" <?if(in_array('B',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant02"><strong>수강관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant03" value="C" <?if(in_array('C',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant03"><strong>독려관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant04" value="D" <?if(in_array('D',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant04"><strong>컨텐츠관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant05" value="E" <?if(in_array('E',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant05"><strong>커뮤니티관리</strong></label></td>
						</tr>
						<tr>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_01" value="A1" <?if(in_array('A1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_01">사업주관리</label><br>
							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_02" value="A2" <?if(in_array('A2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_02">수강생관리</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_01" value="B1" <?if(in_array('B1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_01">학습관리</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_02" value="C2" <?if(in_array('C2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_02">문자발송내역</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_03" value="C3" <?if(in_array('C3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_03">메일발송내역</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_05" value="C5" <?if(in_array('C5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_05">알림톡 발송내역</label><br>
							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_06" value="C6" <?if(in_array('C6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_06">알림톡 전환전송 내역(LMS)</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_05" value="D5" <?if(in_array('D5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_05">단과컨텐츠관리</label><br>
							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_06" value="D6" <?if(in_array('D6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_06">패키지컨텐츠관리</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_01" value="E1" <?if(in_array('E1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_01">공지사항</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_03" value="E3" <?if(in_array('E3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_03">1:1 상담문의</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_04" value="E4" <?if(in_array('E4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_04">수강후기</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_05" value="E5" <?if(in_array('E5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_05">학습자료실</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_06" value="E6" <?if(in_array('E6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_06">간편문의</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_07" value="E7" <?if(in_array('E7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_07">학습상담</label>
							</td>
						</tr>
					</table>
					</td>
                  </tr>
				  <?}//영업자일 경우 권한설정?>
				  <?if($Dept=="C") { //첨삭강사일 경우 권한설정?>
                  <tr>
                    <th>권한 설정</th>
                    <td>
					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
						<tr>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant02" value="B" <?if(in_array('B',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant02"><strong>수강관리</strong></label></td>
							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant05" value="E" <?if(in_array('E',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant05"><strong>커뮤니티관리</strong></label></td>
						</tr>
						<tr>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_04" value="B4" <?if(in_array('B4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_04">첨삭관리</label>
							</td>
							<td valign="top">
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_01" value="E1" <?if(in_array('E1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_01">공지사항</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_03" value="E3" <?if(in_array('E3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_03">1:1 상담문의</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_04" value="E4" <?if(in_array('E4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_04">수강후기</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_05" value="E5" <?if(in_array('E5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_05">학습자료실</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_06" value="E6" <?if(in_array('E6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_06">간편문의</label><br>
							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_07" value="E7" <?if(in_array('E7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_07">학습상담</label>
							</td>
						</tr>
					</table>
					</td>
                  </tr>
				  <?}//첨삭강사일 경우 권한설정?>
                </table>
				</form>
				<div class="btnAreaTc02">
					<?if($mode=="Edit") {?><input type="button" value="삭 제" onclick="DelOk();" class="btn_inputLine01">&nbsp;&nbsp;&nbsp;<?}?>
					<input type="button" value="<?=$ModeScript?> 하기" onclick="SubmitOk();" class="btn_inputBlue01">&nbsp;&nbsp;&nbsp;
					<input type="button" value="닫  기" onclick="self.close();" class="btn_inputLine01">
                </div>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>

</body>
</html>