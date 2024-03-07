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

$Colume = "  da.idx, da.UserAnswer, da.TutorRemark, T.Topic, L.ContentsName ";

$JoinQuery = " DiscussionAnswer AS da 
				INNER JOIN Chapter AS C on da.Chapter_Seq=C.Seq
				INNER JOIN DiscussionTopic AS T ON C.Sub_idx=T.idx
				INNER JOIN Study AS S ON da.Study_Seq = S.Seq
				INNER JOIN Course AS L ON da.LectureCode = L.LectureCode 
					";

$where = "WHERE da.idx=$Seq";

$Sql = "SELECT $Colume FROM $JoinQuery $where";



$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Seq 				= $Row['idx'];
	$UserAnswer 		= $Row['UserAnswer'];
	$Topic 				= $Row['Topic'];
	$ContentsName 		= $Row['ContentsName']; 
	$TutorRemark 		= $Row['TutorRemark']; 
}

if($CyberEnabled=="Y" && $CyberURL) {
	$DomainURL = $CyberURL;
}else{
	$DomainURL = $SiteURL;
}

?>
<script type="text/javascript">
<!--
function TutorRemarkSubmitOk() {

	Yes = confirm("답변을 등록하시겠습니까?");
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
            <h2>답변하기</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="discuss_remark_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="idx" id="idx" value="<?=$Seq?>">
					<INPUT TYPE="hidden" name="send_mode" id="send_mode" value="update">
                
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
				   <tr>
                    <th>과정</th>
                    <td><?=$ContentsName?>  </td>
                  </tr>
                  <tr>
                    <th>TOPIC</th>
                    <td><?=$Topic?> </td>
                  </tr>
				   <tr>
                    <th>훈련생답변</th>
                    <td><?=$UserAnswer?>  </td>
                  </tr>
				
				  <tr>
                    <th>답변</th>
                    <td><textarea name="TutorRemark" id="TutorRemark" style="width:400px;height:200px"><?=$TutorRemark?> </textarea></td>
                  </tr>
                </table>
				</form>

				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center">
						<span id="SubmitBtn"><button type="button" onclick="TutorRemarkSubmitOk()" class="btn btn_Blue">등록하기</button></span>
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