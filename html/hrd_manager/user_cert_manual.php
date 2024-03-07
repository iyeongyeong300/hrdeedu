<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);

$Sql = "SELECT MAX(CertDate) FROM HRD_UserCert WHERE ID='$ID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$CertDate = $Row[0];

if($CertDate) {
	$indate_str = strtotime($CertDate."1 day");
	$CertDate = date("Y-m-d",$indate_str);
}else{
	$CertDate = date('Y-m-d');
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

	$("#CertDate").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		defaultDate: "<?=$Birth?>",
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#CertDate').val("<?=$CertDate?>");

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});

function SubmitOk() {

val = document.Form1;

if(val.CertDate.value=="") {
	alert("인증일자를 등록하세요.");
	val.CertDate.focus();
	return;
}



Yes = confirm("등록 하시겠습니까?");
if(Yes==true) {

	val.submit();
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
            <h2>본인 인증 수동 처리</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="user_cert_manual_script.php">
				<INPUT TYPE="hidden" NAME="ID" value="<?=$ID?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                  </tr>
                  <tr>
                    <th>인증 일자</th>
                    <td><input name="CertDate" id="CertDate" type="text"  size="20" value="<?=$CertDate?>" maxlength="10" readonly></td>
                  </tr>
                </table>
				</form>
				<div class="btnAreaTc02">
					<input type="button" value="등록 하기" onclick="SubmitOk();" class="btn_inputBlue01">&nbsp;&nbsp;&nbsp;
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