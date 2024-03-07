<?
$MenuType = "D";
$PageName = "teacher";
$ReadPage = "teacher_read";
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
            <h2>강사 관리 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM Teacher WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Name = $Row['Name']; //이름
		$Photo = $Row['Photo']; //사진
		$Profile = $Row['Profile']; //약력
	}

	if($Photo) {
		$PhotoView = "<img src='../upload/Course/".$Photo."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('Photo','PhotoArea') class='btn_inputLine01'>";
	}

}
?>

                <!-- 입력 -->
				<form name="Form1" method="post" action="teacher_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>이름</th>
                    <td><input name="Name" id="Name" type="text"  size="40" value="<?=$Name?>"></td>
                  </tr>
                  <tr>
                    <th>사진<br>(400 X 257)</th>
                    <td>
						<input name="Photo" id="Photo" type="hidden" value="<?=$Photo?>"><span id="PhotoArea"><?=$PhotoView?></span>&nbsp;
						<button type="button" onclick="UploadFile('Photo','PhotoArea','img');" class="btn round btn_Blue line"><i class="xi-upload"></i> 파일 첨부</button>
					</td>
                  </tr>
                  <tr>
                    <th>약력</th>
                    <td><textarea name="Profile" id="Profile" style="width:80%; height:260px;"><?=$Profile?></textarea></td>
                  </tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
					<button type="button" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue" onclick="SubmitOk()"><?=$ScriptTitle?></button>
					<button type="button" name="ResetBtn" id="ResetBtn" class="btn btn_DGray line" onclick="location.href='<?=$PageName?>.php'">목록</button>
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

	if(val.Name.value=="") {
		alert("이름을 입력하세요.");
		val.Name.focus();
		return;
	}
	if(val.Photo.value=="") {
		alert("사진을 등록하세요.");
		//val.Photo.focus();
		return;
	}
	if(val.Profile.value=="") {
		alert("약력을 등록하세요.");
		val.Profile.focus();
		return;
	}


	Yes = confirm("등록 하시겠습니까?");
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