<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Seq = Replace_Check($Seq);
$send_mode = Replace_Check($send_mode);
$Massage 	= Replace_Check($Massage);
$TemplateCode 	= Replace_Check($TemplateCode);
$TemplateMessage 	= Replace_Check($TemplateMessage);


$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.PassOK, a.certCount, a.StudyEnd, a.LectureCode, a.CompanyCode, 
				b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, b.PassProgress, b.PassScore,
				c.Name, c.Depart, AES_DECRYPT(UNHEX(c.Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(c.Mobile),'$DB_Enc_Key') AS Mobile, 
				d.CompanyName, d.SendSMS, d.CyberEnabled, d.CyberURL, 
				e.Name AS TutorName 
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
						LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
						LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
					";

$where = "WHERE a.Seq=$Seq";

$Sql = "SELECT $Colume FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Seq = $Row['Seq'];
	$Name = $Row['Name'];
	$CompanyName = $Row['CompanyName'];
	$Email = $Row['Email'];
	$Mobile = $Row['Mobile'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$ID = $Row['ID'];
	$ContentsName = $Row['ContentsName'];
	$SendSMS = $Row['SendSMS'];
	$CyberEnabled = $Row['CyberEnabled'];
	$CyberURL = $Row['CyberURL'];
	$PassProgress = $ROW['PassProgress']; 
	$PassScore = $ROW['PassScore']; 
}

if($CyberEnabled=="Y" && $CyberURL) {
	$DomainURL = $CyberURL;
}else{
	$DomainURL = $SiteURL;
}

/*
$Massage = str_replace("{시작}",$LectureStart,$Massage);
$Massage = str_replace("{종료}",$LectureEnd,$Massage);
$Massage = str_replace("{회사명}",$SiteName,$Massage);
$Massage = str_replace("{소속업체명}",$CompanyName,$Massage);
$Massage = str_replace("{도메인}",$DomainURL,$Massage);
$Massage = str_replace("{아이디}",$ID,$Massage);
$Massage = str_replace("{이름}",$Name,$Massage);
$Massage = str_replace("{과정명}",$ContentsName,$Massage);

$TemplateMessage = str_replace("{시작}",$LectureStart,$TemplateMessage);
$TemplateMessage = str_replace("{종료}",$LectureEnd,$TemplateMessage);
$TemplateMessage = str_replace("{회사명}",$SiteName,$TemplateMessage);
$TemplateMessage = str_replace("{소속업체명}",$CompanyName,$TemplateMessage);
$TemplateMessage = str_replace("{도메인}",$DomainURL,$TemplateMessage);
$TemplateMessage = str_replace("{아이디}",$ID,$TemplateMessage);
$TemplateMessage = str_replace("{이름}",$Name,$TemplateMessage);
$TemplateMessage = str_replace("{과정명}",$ContentsName,$TemplateMessage);
*/

if($send_mode=="sms") {

	$mtype = "lms";
	$name = $Name;
	$phone = str_replace("-","",$Mobile);
	//$msg = $Massage;
	$callback = str_replace("-","",$SitePhone);
	$contents = "";
	$reserve = "";
	$reserve_time = "";
	//$etc1 = $maxno;
	$etc2 = "";

	//발송 로그 기록
	$maxno = max_number("idx","SmsSendLog");
	$etc1 = $maxno;
	$Sql = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate) VALUES($maxno, '$ID', $Seq, '$Massage', '', '$phone', '$LoginAdminID', NOW())";
	$Row = mysqli_query($connect, $Sql);

	$send = mts_mms_send($phone, $Massage, $callback, $etc1, $TemplateCode);

	if($send=="Y") {
		$code = "0000";
	}else{
		$code = "0001";
	}

	$Sql2 = "UPDATE SmsSendLog SET Code='$code' WHERE idx=$maxno";
	$Row2 = mysqli_query($connect, $Sql2);

}

if($send_mode=="email") {

	$subject = "[".$SiteName."] ".$ContentsName." 교육안내 메일입니다.";
	
	$message2 = nl2br($Massage);

	$Massage = "<div style='width:800px; margin:0 auto; padding-bottom:40px;'>
    	<p><img src='".$SiteURL."/images/visual_img01.jpg' /></p>
        <p style='font-size:21px; font-weight:bold;'>안녕하세요!<br />
        ".$SiteName." 교육지원팀입니다.</p>
        <div style='margin-top:40px; font-size:16px; line-height:1.8em;'>
        	".$message2."
        </div>
    </div>";

	$Massage_db = addslashes($Massage);

	//발송 로그 기록
	$maxno = max_number("idx","EmailSendLog");
	$Sql = "INSERT INTO EmailSendLog(idx, ID, Study_Seq, MassageTitle, Massage, Code, Email, InputID, RegDate) VALUES($maxno, '$ID', $Seq, '$subject', '$Massage_db', 'N', '$Email', '$LoginAdminID', NOW())";
	$Row = mysqli_query($connect, $Sql);

	$fromaddress = $SiteEmail;
	$toaddress = $Email;

	$body = $Massage."<img src='".$SiteURL."/lib/EmailRecive/email_recive.php?num=".$maxno."' width='0' height='0'>";
	$fromname = $SiteName;

	$send = nmail($fromaddress, $toaddress, $subject, $body, $fromname);

}


if($Row && $send) {
	$ProcessOk = "Y";
	$msg = "발송되었습니다.";
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
	top.DataResultClose();
	<?}?>
//-->
</SCRIPT>