<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$Seq = Replace_Check($Seq);

$Sql = "UPDATE Message SET ReciveDate=NOW() WHERE ReciveDate IS NULL AND SendID='$ID' AND Seq=$Seq";
$Row = mysqli_query($connect, $Sql);

$Sql = "SELECT *, (SELECT Name FROM Member WHERE ID=Message.SendID) AS Name, (SELECT Name FROM Member WHERE ID=Message.ReciveID) AS Name2 FROM Message WHERE Seq=$Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ReciveID = $Row['ReciveID'];
	$SendID = $Row['SendID'];
	$Name = $Row['Name'];
	$Name2 = $Row['Name2'];
	$Title = $Row['Title'];
	$Content = $Row['Content'];
	$ReciveDate = $Row['ReciveDate'];
	$SendDate = $Row['SendDate'];
	$ReciveDelete = $Row['ReciveDelete'];
	$SendDelete = $Row['SendDelete'];

	if($SendID==$ID) {
		$Sender = $Name;
		$Reciver = "관리자";
	}else{
		$Sender = "관리자";
		$Reciver = $Name2;
	}
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

	Yes = confirm("삭제 하시겠습니까?");
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
            <h2>쪽지 내용</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="message_write_script.php">
				<INPUT TYPE="hidden" NAME="ID" id="ID" value="<?=$ID?>">
				<INPUT TYPE="hidden" NAME="Seq" id="Seq" value="<?=$Seq?>">
				<INPUT TYPE="hidden" NAME="mode" id="mode" value="Delete">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>발신자</th>
                    <td><?=$Sender?></td>
                  </tr>
                  <tr>
                    <th>수신자</th>
                    <td><?=$Reciver?></td>
                  </tr>
				  <tr>
                    <th>제목</th>
                    <td><?=$Title?></td>
                  </tr>
				  <tr>
                    <th>내용</th>
                    <td><?=nl2br($Content)?></td>
                  </tr>
                </table>
				</form>


				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center"><input type="button" value="삭제 하기" onclick="SubmitOk();" class="btn_inputBlue01"></td>
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