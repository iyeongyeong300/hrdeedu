<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$ParentCategory = Replace_Check($ParentCategory);
$Deep = Replace_Check($Deep);
$mode = Replace_Check($mode);

if($mode=="Edit") {

	$Sql = "SELECT * FROM CourseCategory WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	if($Row) {
		$ParentCategory = $Row['ParentCategory'];
		$Deep = $Row['Deep'];
		$CategoryName = $Row['CategoryName'];
		$OrderByNum = $Row['OrderByNum'];
		$UseYN = $Row['UseYN'];
		$CategoryType = $Row['CategoryType'];
	}

}

if($ParentCategory) {
	$Sql = "SELECT * FROM CourseCategory WHERE idx=$ParentCategory";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	if($Row) {
		$Upper_CategoryName = $Row['CategoryName'];
		$Upper_CategoryType = $Row['CategoryType'];
	}
}else{
	$Upper_CategoryName = "없음";
}

$OrderByNumWhere = "";
if(!$OrderByNum) {
	if($Deep<2) {
		$OrderByNumWhere = " WHERE Deep=1";
	}else{
		$OrderByNumWhere = " WHERE Deep=2 AND ParentCategory=$ParentCategory";
	}
	$query_select = "SELECT MAX(OrderByNum) FROM CourseCategory $OrderByNumWhere";
	$result_select = mysqli_query($connect, $query_select);
	$row_select = mysqli_fetch_array($result_select);
	$max_no = $row_select[0];
	$OrderByNum = $max_no + 1;
}

if(!$mode) {
	$mode=="New";
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
function SubmitOk() {

	val = document.Form1;

	if(val.CategoryName.value=="") {
		alert("카테고리명을 등록하세요.");
		val.CategoryName.focus();
		return;
	}
	if(val.OrderByNum.value=="") {
		alert("정렬순서를 등록하세요.");
		val.OrderByNum.focus();
		return;
	}
	if(IsNumber(val.OrderByNum.value)==false) {
		alert("정렬순서는 숫자만 등록하세요.");
		val.OrderByNum.focus();
		return;
	}

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
            <h2>과정 카테고리 <?=$ModeScript?></h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="course_category_reg_script.php">
				<INPUT TYPE="hidden" NAME="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" NAME="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" NAME="ParentCategory" value="<?=$ParentCategory?>">
				<INPUT TYPE="hidden" NAME="Deep" value="<?=$Deep?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>카테고리 구분</th>
                    <td>
					<?if($ParentCategory) {?>
					<?=$CategoryType_array[$Upper_CategoryType]?><input type="hidden" name="CategoryType" id="CategoryType" value="<?=$Upper_CategoryType?>">
					<?}else{?>
					<select name="CategoryType" id="CategoryType">
						<?
						while (list($key,$value)=each($CategoryType_array)) {
							?>
						<option value="<?=$key?>" <?if($CategoryType==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($CategoryType_array);
						?>
					</select>
					<?}?>
					</td>
                  </tr>
                  <tr>
                    <th>상위 카테고리</th>
                    <td><?=$Upper_CategoryName?></td>
                  </tr>
				  <tr>
                    <th>카테고리명</th>
                    <td><input type="text" name="CategoryName" id="CategoryName" value="<?=$CategoryName?>" size="60"></td>
                  </tr>
				  <tr>
                    <th>정렬 순서</th>
                    <td><input type="text" name="OrderByNum" id="OrderByNum" value="<?=$OrderByNum?>" size="5"></td>
                  </tr>
				  <tr>
                    <th>사용 여부</th>
                    <td><input type="radio" name="UseYN" id="UseYN2" value="Y" <?if($UseYN=="Y" || !$UseYN) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN2">사용</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="UseYN" id="UseYN1" value="N" <?if($UseYN=="N") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN1">미사용</label></td>
                  </tr>
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