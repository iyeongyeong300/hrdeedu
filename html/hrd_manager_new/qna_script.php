<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$Notice = Replace_Check($Notice);
$Title = Replace_Check($Title);
$UseYN = Replace_Check($UseYN);
$Content = Replace_Check2($Content);

$FileDel1 = Replace_Check($FileDel1);
$FileDel2 = Replace_Check($FileDel2);
$FileDel3 = Replace_Check($FileDel3);
$FileDel4 = Replace_Check($FileDel4);
$FileDel5 = Replace_Check($FileDel5);

$UserID = Replace_Check($UserID);

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;
$Folder = "/Counsel";

include "./include/include_upload_file.php";


if($mode=="reply") { //답글 작성---------------------------------------------------------------------------------------------------------

	if($FileDel1=="Y") {
		$FileQuery1 = ", FileName1='', RealFileName1=''";
	}else{
		if($FileName1) {
			$FileQuery1 = ", FileName1='$FileName1', RealFileName1='$RealFileName1'";
		}
	}

	if($FileDel2=="Y") {
		$FileQuery2 = ", FileName2='', RealFileName2=''";
	}else{
		if($FileName2) {
			$FileQuery2 = ", FileName2='$FileName2', RealFileName2='$RealFileName2'";
		}
	}

	if($FileDel3=="Y") {
		$FileQuery3 = ", FileName3='', RealFileName3=''";
	}else{
		if($FileName3) {
			$FileQuery3 = ", FileName3='$FileName3', RealFileName3='$RealFileName3'";
		}
	}

	if($FileDel4=="Y") {
		$FileQuery4 = ", FileName4='', RealFileName4=''";
	}else{
		if($FileName4) {
			$FileQuery4 = ", FileName4='$FileName4', RealFileName4='$RealFileName4'";
		}
	}

	if($FileDel5=="Y") {
		$FileQuery5 = ", FileName5='', RealFileName5=''";
	}else{
		if($FileName5) {
			$FileQuery5 = ", FileName5='$FileName5', RealFileName5='$RealFileName5'";
		}
	}

	$Sql = "UPDATE Counsel SET Name2='$Name2', Contents2='$Contents2', RegDate2=NOW(), Status='$Status' $FileQuery1 $FileQuery2 $FileQuery3 $FileQuery4 $FileQuery5 WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);
	echo $Status;
	
	if($Status=="B") { //처리상태 완료시 카카오톡 발송
		$Sql_m = "SELECT AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$UserID'";
		$Result_m = mysqli_query($connect, $Sql_m);
		$Row_m = mysqli_fetch_array($Result_m);
echo "A";
		if($Row_m) {
			echo "B";
			$Mobile = $Row_m['Mobile'];
			$msg_type = "mtm";
			$msg_mobile = str_replace("-","",$Mobile);
			$msg_var = "";
			$send_date = date('Y-m-d H:i:s');
		//	$kakaotalk_result = kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);
			
			
			//발송할 메세지 확인
			$Sql = "SELECT * FROM SendMessage WHERE MessageMode='qna'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);

			if($Row) {
				$Massage = $Row['Massage'];
				$TemplateCode 	= $Row['TemplateCode'];
				$TemplateMessage 	= $Row['TemplateMessage'];
			}


			$kakaotalk_result = kakaotalk_send2($TemplateCode,$msg_mobile,$Massage, $send_date);
			 //echo $kakaotalk_result;
		 
		}
	}

	$cmd = true;
	$url = "qna.php?col=".$col."&sw=".$sw;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Counsel SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "qna.php?col=".$col."&sw=".$sw;

} //글 삭제-------------------------------------------------------------------------------------------------------------------------

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
//-->
</SCRIPT>