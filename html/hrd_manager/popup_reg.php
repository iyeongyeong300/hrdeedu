<?
$MenuType = "G";
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
            <h2>팝업 관리 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM Popup WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	$Title = str_replace(chr(34),"&#34",$Row['Title']);
	$ImgWidth = str_replace(chr(34),"&#34",$Row['ImgWidth']);
	$ImgHeight = str_replace(chr(34),"&#34",$Row['ImgHeight']);
	$PopupLeft = str_replace(chr(34),"&#34",$Row['PopupLeft']);
	$PopupTop = str_replace(chr(34),"&#34",$Row['PopupTop']);
	$EndDate = str_replace(chr(34),"&#34",$Row['EndDate']);
	$UseYN = str_replace(chr(34),"&#34",$Row['UseYN']);

}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function send_ok() {

	val = document.send;

	if(val.EndDate.value=="") {
		alert("마감일을 입력하세요.");
		val.EndDate.focus();
		return;
	}

	//숫자체크
	if (document.layers||document.all||document.getElementById)
	{
	var x=val.EndDate.value
	var anum=/(^\d+$)|(^\d+\.\d+$)/
	if (anum.test(x))
	testresult=true
	else{
	alert("마감일은 숫자만 입력 하세요")
	val.EndDate.focus();
	val.EndDate.value=""

	return;
		}
	}

	if(val.Title.value=="") {
		alert("제목을 입력하세요.");
		val.Title.focus();
		return;
	}

	if(val.ImgWidth.value=="") {
		alert("이미지 사이즈를 입력하세요.");
		val.ImgWidth.focus();
		return;
	}

	//숫자체크
	if (document.layers||document.all||document.getElementById)
	{
	var x=val.ImgWidth.value
	var anum=/(^\d+$)|(^\d+\.\d+$)/
	if (anum.test(x))
	testresult=true
	else{
	alert("이미지 사이즈는 숫자만 입력 하세요")
	val.ImgWidth.focus();
	val.ImgWidth.value=""

	return;
		}
	}

	if(val.ImgHeight.value=="") {
		alert("이미지 사이즈를 입력하세요.");
		val.ImgHeight.focus();
		return;
	}
	//숫자체크
	if (document.layers||document.all||document.getElementById)
	{
	var x=val.ImgHeight.value
	var anum=/(^\d+$)|(^\d+\.\d+$)/
	if (anum.test(x))
	testresult=true
	else{
	alert("이미지 사이즈는 숫자만 입력 하세요")
	val.ImgHeight.focus();
	val.ImgHeight.value=""

	return;
		}
	}

	if(val.PopupLeft.value=="") {
		alert("팝업 좌측 위치를 입력하세요.");
		val.PopupLeft.focus();
		return;
	}

	//숫자체크
	if (document.layers||document.all||document.getElementById)
	{
	var x=val.PopupLeft.value
	var anum=/(^\d+$)|(^\d+\.\d+$)/
	if (anum.test(x))
	testresult=true
	else{
	alert("팝업 좌측 위치는 숫자만 입력 하세요")
	val.PopupLeft.focus();
	val.PopupLeft.value=""

	return;
		}
	}

	if(val.PopupTop.value=="") {
		alert("팝업 상단 위치를 입력하세요.");
		val.PopupTop.focus();
		return;
	}

	//숫자체크
	if (document.layers||document.all||document.getElementById)
	{
	var x=val.PopupTop.value
	var anum=/(^\d+$)|(^\d+\.\d+$)/
	if (anum.test(x))
	testresult=true
	else{
	alert("팝업 상단 위치는 숫자만 입력 하세요")
	val.PopupTop.focus();
	val.PopupTop.value=""

	return;
		}
	}

	val.submit();
}
//-->
</SCRIPT>
                <!-- 입력 -->
				<form name="send" method="post" action="popup_reg_script.php" enctype="multipart/form-data">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
					<th>사용 여부</font></th>
					<td><input name="UseYN" type="radio" value="Y" <?if(($UseYN=="Y") || ($UseYN=="")){ echo "checked";}?>>사용 &nbsp;&nbsp;&nbsp;<input name="UseYN" type="radio" value="N" <?if($UseYN=="N"){ echo "checked";}?>>미사용 &nbsp;&nbsp;&nbsp;</td>
				  </tr>
				 <tr>
					<th>마감일</th>
					<td><input name="EndDate" type="text" size="8" maxlength="8" value="<?=$EndDate?>">&nbsp;&nbsp;예) 20100510 숫자 8자리로 입력</td>
				  </tr>
				  <tr>
					<th>제 목</th>
					<td><input name="Title" type="text" size="75" value="<?=$Title?>"></td>
				  </tr>
				  <tr>
					<th>크기</th>
					<td><input name="ImgWidth" maxlength="4" type="text" size="4" value="<?=$ImgWidth?>">(W) X <input name="ImgHeight" maxlength="4" type="text" size="4" value="<?=$ImgHeight?>">(H)  (이미지 사이즈를 등록)</td>
				  </tr>
				  <tr>
					<th>위치</th>
					<td>좌측 : <input name="PopupLeft" maxlength="4" type="text" size="4" value="<?=$PopupLeft?>">&nbsp;&nbsp;상단 : <input name="PopupTop" maxlength="4" type="text" size="4" value="<?=$PopupTop?>"> (팝업위치를 등록하세요. 좌측:200, 상단:50)</td>
				  </tr>
				  <tr>
					<th>첨부파일</th>
					<td><input name="file" type="file" size="50"></td>
				  </tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="send_ok()">
          			<input type="button" name="ResetBtn" id="ResetBtn" value="목록" class="btn_inputLine01" onclick="location.href='popup.php'">
                </div>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>