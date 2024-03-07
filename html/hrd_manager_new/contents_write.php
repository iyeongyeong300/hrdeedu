<?
$MenuType = "D";
$PageName = "contents";
$ReadPage = "contents_read";
?>
<? include "./include/include_top.php"; ?>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

Switch ($mode) {
	case "new":
		$ScriptTitle = "등록";
	break;
	case "edit":
		$ScriptTitle = "수정";
	break;
	case "del":
		$ScriptTitle = "삭제";
	break;
}
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>기초차시 관리 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM Contents WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Gubun = html_quote($Row['Gubun']); //차시 구분
		$ContentsTitle = html_quote($Row['ContentsTitle']); //차시명
		$LectureTime = $Row['LectureTime']; //수강시간
		$Expl01 = stripslashes($Row['Expl01']); //차시목표
		$Expl02 = stripslashes($Row['Expl02']); //훈련내용
		$Expl03 = stripslashes($Row['Expl03']); //학습활동
	}

}

if(!$LectureTime) {
	$LectureTime = 25;
}
?>

                <!-- 입력 -->
				<form name="Form1" method="post" action="contents_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>차시구분 선택</th>
                    <td>
					<select name="GubunSelect" id="GubunSelect" onchange="GubunSelected();">
						<option value="">-- 차시구분 선택 --</option>
						<?
						$SQL = "SELECT DISTINCT(Gubun) FROM Contents WHERE Del='N' ORDER BY Gubun ASC";
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($Row = mysqli_fetch_array($QUERY))
							{
						?>
						<option value="<?=$Row['Gubun']?>" <?if($Row['Gubun']==$Gubun) {?>selected<?}?>><?=$Row['Gubun']?></option>
						<?
							}
						}
						?>
					</select>
					</td>
                  </tr>
                  <tr>
                    <th>차시 구분</th>
                    <td><input name="Gubun" id="Gubun" type="text"  size="60" value="<?=$Gubun?>"> (차시구분 선택에 없는 경우 직접 입력하세요.)</td>
                  </tr>
				  <tr>
                    <th>차시명</th>
                    <td><input name="ContentsTitle" id="ContentsTitle" type="text"  size="120" value="<?=$ContentsTitle?>"></td>
                  </tr>
				  <tr>
                    <th>수강시간</th>
                    <td><input name="LectureTime" id="LectureTime" type="text"  size="5" value="<?=$LectureTime?>">분</td>
                  </tr>
                  <tr>
                    <th>차시 목표</th>
                    <td><textarea name="Expl01" id="Expl01" rows="10" cols="100" style="width:970px; height:220px;;"><?=$Expl01?></textarea></td>
                  </tr>
				  <tr>
                    <th>훈련 내용</th>
                    <td><textarea name="Expl02" id="Expl02" rows="10" cols="100" style="width:970px; height:220px;"><?=$Expl02?></textarea></td>
                  </tr>
				  <tr>
                    <th>학습 활동</th>
                    <td><textarea name="Expl03" id="Expl03" rows="10" cols="100" style="width:970px; height:220px;"><?=$Expl03?></textarea></td>
                  </tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="SubmitOk()">
          			<input type="button" name="ResetBtn" id="ResetBtn" value="목록" class="btn_inputLine01" onclick="location.href='<?=$PageName?>.php'">
                </div>
				<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function SubmitOk() {

	val = document.Form1;

	if(val.Gubun.value=="") {
		alert("차시구분을 입력하세요.");
		val.Gubun.focus();
		return;
	}

	if(val.ContentsTitle.value=="") {
		alert("차시명을 입력하세요.");
		val.ContentsTitle.focus();
		return;
	}

	if(val.LectureTime.value=="") {
		alert("수강시간을 입력하세요.");
		val.LectureTime.focus();
		return;
	}

	if(IsNumber(val.LectureTime.value)==false) {
		alert("수강시간은 숫자만 입력하세요.");
		val.LectureTime.focus();
		return;
	}


	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}
//-->
</SCRIPT>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>