<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

if($mode!="New") {

	$Sql = "SELECT * FROM CounselPhone WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$ID = $Row['ID'];
		$Name = $Row['Name'];
		$Category = $Row['Category'];
		$Contents = $Row['Contents'];
		$Status = $Row['Status'];
	}

}

if(!$Name) {
	$Name = $LoginAdminName;
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

	if(val.Category.value=="") {
		alert("문의 종류를 선택하세요.");
		val.Category.focus();
		return;
	}
	if(val.Name.value=="") {
		alert("상담자명을 입력하세요.");
		val.Name.focus();
		return;
	}
	if(val.Contents.value=="") {
		alert("상담 내용을 등록하세요.");
		val.Contents.focus();
		return;
	}
	if(val.Status.value=="") {
		alert("처리 상태를 선택하세요.");
		val.Status.focus();
		return;
	}


	Yes = confirm("등록 하시겠습니까?");
	if(Yes==true) {

		val.submit();
	}

}

function Delete() {

	Yes = confirm("삭제하시겠습니까?");
	if(Yes==true) {
		$("#mode").val('Delete');
		Form1.submit();
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
            <h2>전화상담 내역 작성</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="counsel_phone_write_script.php">
				<INPUT TYPE="hidden" NAME="ID" id="ID" value="<?=$ID?>">
				<INPUT TYPE="hidden" NAME="mode" id="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" NAME="idx" id="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>문의 종류</th>
                    <td>
					<select name="Category" id="Category">
					<option value="">선택하세요</option>
						<?
						while (list($key,$value)=each($CounselPhone_array)) {
						?>
					   <option value="<?=$key?>" <?if($Category==$key){?>selected<?}?>><?=$value?></option>
						<?
						}
						?>
					</select>
					</td>
                  </tr>
                  <tr>
                    <th>상담자명</th>
                    <td><input name="Name" id="Name" type="text"  size="30" value="<?=$Name?>" maxlength="50"></td>
                  </tr>
				  <tr>
                    <th>상담 내용</th>
                    <td><textarea name="Contents" id="Contents" style="width:450px; height:250px"><?=$Contents?></textarea></td>
                  </tr>
				  <tr>
                    <th>처리 상태</th>
                    <td>
					<select name="Status" id="Status">
						<option value="">선택하세요</option>
						<?
						while (list($key,$value)=each($CounselPhoneStatus_array)) {
						?>
					   <option value="<?=$key?>" <?if($Status==$key){?>selected<?}?>><?=$value?></option>
						<?
						}
						?>
					</select>
					</td>
                  </tr>
                </table>
				</form>


				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200"><?if($mode!="New") {?><button type="button" onclick="Delete();" class="btn btn_DGray line">삭제</button><?}?></td>
						<td align="center"><button type="button" onclick="SubmitOk();" class="btn btn_Blue">등록 하기</button></td>
						<td width="200" align="right"><button type="button" onclick="self.close();" class="btn btn_DGray line">닫기</button></td>
					</tr>
				</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>

</body>
</html>