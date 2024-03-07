<?
$MenuType = "D";
$PageName = "exam_bank";
?>
<? include "./include/include_top.php"; ?>
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
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>문제 등록 | 엑셀파일로 문제 등록</h2>

            <div class="conZone">
            	<!-- ## START -->

                <!-- 입력 -->
				<form name="ExcelUpForm" method="post" action="exam_bank_excel_upload.php" enctype="multipart/form-data" target="ScriptFrame">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>등록 샘플</th>
                    <td>
						<button type="button" onclick="location.href='./sample/문제은행.xlsx'" class="btn round btn_Green line"><i class="xi-download"></i>양식 다운로드</button>&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" onclick="location.href='./sample/문제은행(샘플).xlsx'" class="btn round btn_Green line"><i class="xi-download"></i>샘플 다운로드</button>
					</td>
                  </tr>
                  <tr>
                    <th>파일 등록</th>
                    <td><input name="file" id="file" type="file"  size="60">&nbsp;&nbsp;&nbsp;&nbsp;
							<span id="UploadSubmitBtn"><button type="button" class="btn round btn_Blue line" onclick="UploadSubmitOk()"><i class="xi-upload"></i> 업로드 하기</button></span>
							<span id="UploadWaiting" style="display:none"><strong>처리중입니다. 잠시만 기다려 주세요...</strong></span></td>
                  </tr>
                </table>
                </form>
				<div id="ExcelUploadList"><br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center></div>
				<script type="text/javascript">
				<!--
				$(window).load(function() {
					ExamExcelUploadListRoading('A');
				});

				//-->
				</script>

            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>