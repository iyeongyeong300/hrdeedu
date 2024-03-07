<?
$MenuType = "D";
$PageName = "contents";
?>
<? include "./include/include_top.php"; ?>

        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>기초차시 엑셀 등록</h2>

            <div class="conZone">
            	<!-- ## START -->
<script type="text/javascript">
<!--
function UploadSubmitOk() {

	val = document.ExcelUpForm;

	if(val.file.value=="") {
		alert("엑셀 파일을 선택하세요.");
		val.file.focus();
		return;
	}

	Yes = confirm("업로드 하시겠습니까?");
	if(Yes==true) {
		$("#UploadSubmitBtn").hide();
		$("#UploadWaiting").show();
		val.submit();
	}
}
//-->
</script>
                <!-- 입력 -->
				<form name="ExcelUpForm" method="post" action="contents_excel_upload.php" enctype="multipart/form-data" target="ScriptFrame">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>등록 샘플</th>
                    <td>
                		<input type="button" value="양식 다운로드" class="btn_inputLine01" onclick="location.href='./sample/기초차시.xlsx'">&nbsp;&nbsp;&nbsp;&nbsp;
          				<input type="button" value="샘플 다운로드" class="btn_inputLine01" onclick="location.href='./sample/기초차시(샘플).xlsx'">
					</td>
                  </tr>
                  <tr>
                    <th>파일 등록</th>
                    <td><input name="file" id="file" type="file"  size="60">&nbsp;&nbsp;&nbsp;&nbsp;
                		<span id="SubmitBtn"><input type="button" name="SubmitBtn" id="SubmitBtn" value="업로드 하기" class="btn_inputBlue01" onclick="UploadSubmitOk()"></span>
						<span id="Waiting" style="display:none"><strong>처리중입니다. 잠시만 기다려 주세요...</strong></span>
					</td>
                  </tr>
                </table>
                </form>

				<div id="ContentsUploadList"><br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center></div>

            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<script type="text/javascript">
<!--
$(window).load(function() {
	ContentsExcelUploadListRoading('A');
});
//-->
</script>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>