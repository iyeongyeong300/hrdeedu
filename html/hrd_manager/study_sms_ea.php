<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$MessageMode = Replace_Check($MessageMode);
$Seq = Replace_Check($Seq);

//발송할 메세지 확인
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='$MessageMode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage = $Row['Massage'];
	$TemplateCode 	= $Row['TemplateCode'];
	$TemplateMessage 	= $Row['TemplateMessage'];
}

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

$Email = InformationProtection($Email,'Email','S');
$Mobile = InformationProtection($Mobile,'Mobile','S');

$Massage = str_replace("#{시작}",$LectureStart,$Massage);
$Massage = str_replace("#{종료}",$LectureEnd,$Massage);
$Massage = str_replace("#{회사명}",$SiteName,$Massage);
$Massage = str_replace("#{소속업체명}",$CompanyName,$Massage);
$Massage = str_replace("#{도메인}",$DomainURL,$Massage);
$Massage = str_replace("#{아이디}",$ID,$Massage);
$Massage = str_replace("#{이름}",$Name,$Massage);
$Massage = str_replace("#{과정명}",$ContentsName,$Massage);
$Massage = str_replace("#{진도율}",$PassProgress,$Massage);
$Massage = str_replace("#{합격점}",$PassScore,$Massage);

$TemplateMessage = str_replace("#{시작}",$LectureStart,$TemplateMessage);
$TemplateMessage = str_replace("#{종료}",$LectureEnd,$TemplateMessage);
$TemplateMessage = str_replace("#{회사명}",$SiteName,$TemplateMessage);
$TemplateMessage = str_replace("#{소속업체명}",$CompanyName,$TemplateMessage);
$TemplateMessage = str_replace("#{도메인}",$DomainURL,$TemplateMessage);
$TemplateMessage = str_replace("#{아이디}",$ID,$TemplateMessage);
$TemplateMessage = str_replace("#{이름}",$Name,$TemplateMessage);
$TemplateMessage = str_replace("#{과정명}",$ContentsName,$TemplateMessage);
$TemplateMessage = str_replace("#{진도율}",$PassProgress,$TemplateMessage);
$TemplateMessage = str_replace("#{합격점}",$PassScore,$TemplateMessage);
?>
<script type="text/javascript">
<!--
function SmsEaSubmitOk() {

	Yes = confirm("발송하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		Form1.submit();
	}

}
//-->
</script>

	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>메시지 개별 발송</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="study_sms_ea_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="Seq" id="Seq" value="<?=$Seq?>">
                <INPUT TYPE="hidden" name="TemplateCode" id="TemplateCode" value="<?=$TemplateCode?>">
                <INPUT TYPE="hidden" name="TemplateMessage" id="TemplateMessage" value="<?=$TemplateMessage?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>발송 대상</th>
                    <td><?=$Name?> (<?=$ID?>)</td>
                  </tr>
				  <tr>
                    <th>발송 방법</th>
                    <td>
					<select name="send_mode" id="send_mode">
						<option value="sms">휴대폰</option>
						<option value="email">이메일</option>
					</select>
					</td>
                  </tr>
                  <tr>
                    <th>휴대폰</th>
                    <td><?=$Mobile?></td>
                  </tr>
				   <tr>
                    <th>이메일</th>
                    <td><?=$Email?></td>
                  </tr>
				  <tr>
                    <th>메세지</th>
                    <td><textarea name="Massage" id="Massage" style="width:400px;height:200px"><?=$TemplateMessage?></textarea></td>
                  </tr>
                </table>
				</form>

				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center">
						<span id="SubmitBtn"><button type="button" onclick="SmsEaSubmitOk()" class="btn btn_Blue">발송 하기</button></span>
						<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
						</td>
						<td width="200" align="right"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
					</tr>
				</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
<?
mysqli_close($connect);
?>