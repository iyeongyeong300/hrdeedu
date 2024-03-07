<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
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

if(val.Title.value=="") {
	alert("제목을 등록하세요.");
	val.Title.focus();
	return;
}
if(val.Content.value=="") {
	alert("내용을 등록하세요.");
	val.Content.focus();
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
            <h2>쪽지 작성</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="message_write_script.php">
				<INPUT TYPE="hidden" NAME="ID" id="ID" value="<?=$ID?>">
				<INPUT TYPE="hidden" NAME="mode" id="mode" value="New">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>수신 ID</th>
                    <td><?=$ID?></td>
                  </tr>
                  <tr>
                    <th>제목</th>
                    <td><input name="Title" id="Title" type="text"  size="60" value="<?=$Title?>" maxlength="200"></td>
                  </tr>
				  <tr>
                    <th>내용</th>
                    <td><textarea name="Content" id="Content" style="width:450px; height:250px"><?=$Content?></textarea></td>
                  </tr>
                </table>
				</form>


				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center"><input type="button" value="등록 하기" onclick="SubmitOk();" class="btn_inputBlue01"></td>
						<td width="200" align="right"><input type="button" value="닫  기" onclick="self.close();" class="btn_inputLine01"></td>
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