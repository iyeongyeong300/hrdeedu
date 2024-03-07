<?
$MenuType = "A";
$PageName = "company";
$ReadPage = "company_read";
?>
<? include "./include/include_top.php"; ?>

        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>사업주 엑셀 등록</h2>

            <div class="conZone">
            	<!-- ## START -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function UploadSubmitOk() {

	val = document.Form1;

	if(val.file.value=="") {
		alert("엑셀 파일을 선택하세요.");
		val.file.focus();
		return;
	}

	Yes = confirm("업로드 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}

function CheckAll() {

	val = document.Form2;

	checkbox_count = $("input[id='check_seq']").length;
	//alert(checkbox_count);


	if(checkbox_count==0) {
		alert("등록된 엑셀파일이 없습니다.");
		return;
	}

	if(checkbox_count > 1) {
		for (i=0; i<val.check_seq.length; i++) {
		if (val.cj.checked == true) {
			if(val.check_seq[i].disabled == false) {
				val.check_seq[i].checked = true;
			}
		}else{
			val.check_seq[i].checked = false;
		}
	}

	}else{
		if (val.cj.checked == true) {
			if(val.check_seq.disabled == false) {
				val.check_seq.checked = true;
			}
		}else{
			val.check_seq.checked = false;
		}

	}

}

function CheckedDelete() {

	val = document.Form2;

	checkbox_count = $("input[id='check_seq']").length;
	//alert(checkbox_count);


	if(checkbox_count==0) {
		alert("등록된 엑셀파일이 없습니다.");
		return;
	}

	var idx_value = "";

	if(checkbox_count > 1) {
		for (i=0; i<val.check_seq.length; i++) {
			if(val.check_seq[i].checked == true) {
				idx_value += val.check_seq[i].value + "|";
			}
		}
	}else{
		if(val.check_seq.checked == true) {
			idx_value += val.check_seq.value + "|";
		}
	}

	if(idx_value=="") {
		alert("삭제하려는 항목을 선택하세요.");
		return;
	}

	Yes = confirm("선택한 항목을 삭제하시겠습니까?");
	if(Yes==true) {
		val.idx_value.value = idx_value;
		val.mode.value = "del";
		val.action = "company_excel_upload_complete.php";
		$("#BtnDelete").prop("disabled",true);
		$("#BtnSubmit").prop("disabled",true);
		$("#BtnList").prop("disabled",true);
		val.submit();
	}

}

function CompleteSubmitOk() {

	val = document.Form2;

	checkbox_count = $("input[id='check_seq']").length;
	//alert(checkbox_count);

	if(checkbox_count==0) {
		alert("등록된 엑셀파일이 없습니다.");
		return;
	}

	Yes = confirm("현재 내역을 사업주로 등록하시겠습니까?");
	if(Yes==true) {
		val.mode.value = "input";
		val.action = "company_excel_upload_complete.php";
		$("#BtnDelete").prop("disabled",true);
		$("#BtnSubmit").prop("disabled",true);
		$("#BtnList").prop("disabled",true);
		val.submit();
	}
}
//-->
</SCRIPT>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
                <!-- 입력 -->
				<form name="Form1" method="post" action="company_excel_upload.php" enctype="multipart/form-data" target="ScriptFrame">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>등록 샘플</th>
                    <td>
                		<button type="button" class="btn round btn_Green line" onclick="location.href='./sample/사업주정보.xlsx'"><i class="xi-download"></i> 양식 다운로드</button>
						<button type="button" class="btn round btn_Green line" onclick="location.href='./sample/사업주정보(샘플).xlsx'"><i class="xi-download"></i> 샘플 다운로드</button>
					</td>
                  </tr>
                  <tr>
                    <th>파일 등록</th>
                    <td><input name="file" id="file" type="file"  size="60">&nbsp;&nbsp;&nbsp;&nbsp;
                		<span id="SubmitBtn"><button type="button" name="SubmitBtn" id="SubmitBtn" class="btn round btn_Blue line" onclick="UploadSubmitOk()"><i class="xi-upload"></i> 업로드 하기</button></span>
						<span id="Waiting" style="display:none"><strong>처리중입니다. 잠시만 기다려 주세요...</strong></span>
					</td>
                  </tr>
                </table>
                </form>

				<div class="btnAreaTl02 pt50">
					<span class="fs16b fc333B sub_title2">업로드한 엑셀파일 데이터 확인</span>
				</div>
				<div class="tl pt15">
				* 붉은색으로 표시된 항목은 오류가 예상되는 항목입니다.<br>
				* 사업자 번호에 (중복DB) 표기시 : 기존 사업주 정보와 동일한 사업자번호가 존재합니다.<br>
				* 사업자 번호에 (중복Excel) 표기시 : 업로드한 엑셀파일에 중복되는 사업자번호가 존재합니다.(엑셀파일에 동일한 사업자번호 2건 이상)
				</div>
				<form name="Form2" method="post" target="ScriptFrame">
				<input type="hidden" name="idx_value" id="idx_value">
				<input type="hidden" name="mode" id="mode">
				<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="30px" />
					<col width="50px" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
                  </colgroup>
                  <thead>
					  <tr>
						<th rowspan="2"><input type="checkbox" name="cj" id="cj" onclick="CheckAll()" class="checkbox"></th>
						<th rowspan="2">번호</th>
						<th>회사명</th>
						<th>회사 아이디</th>
						<th>회사 규모</th>
						<th>사업자번호</th>
						<th>HRD코드</th>
						<th>대표자</th>
						<th>우편번호</th>
						<th>회사 주소</th>
						<th>상세 주소</th>
						<th>업태</th>
						<th>사이버교육센터</th>
						<th>기업관리코드</th>
					  </tr>
					  <tr>
						<th style="border-left:1px solid #fff;">회사 전화번호</th>
						<th>전자계산서 이메일</th>
						<th>회사 교육담당자</th>
						<th>회사 교육담당자 전화번호</th>
						<th>회사 교육담당자 이메일</th>
						<th>영업자ID</th>
						<th>메모</th>
						<th>고객센터 번호</th>
						<th>고객센터 팩스번호</th>
						<th>종목</th>
						<th>고객센터 사용여부</th>
						<th></th>
					  </tr>
				  </thead>
					<?
					$i = 1;
					$bgcolor = "";
					$SQL = "SELECT *, 
								(SELECT COUNT(idx) FROM Company WHERE CompanyCode=a.CompanyCode) AS CompanyCodeCount, 
								(SELECT COUNT(idx) FROM CompanyExcelTemp WHERE CompanyCode=a.CompanyCode AND ID='$LoginAdminID') AS CompanyCodeTempCount, 
								(SELECT COUNT(idx) FROM Company WHERE CompanyID=a.CompanyID) AS CompanyIdCount, 
								(SELECT COUNT(idx) FROM CompanyExcelTemp WHERE CompanyID=a.CompanyID AND ID='$LoginAdminID') AS CompanyIDTempCount, 
								(SELECT (idx) FROM StaffInfo WHERE ID=a.SalesManager AND Dept='B') AS SalesManagerCount 
								FROM CompanyExcelTemp AS a WHERE a.ID='$LoginAdminID' ORDER BY a.idx ASC";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if($i%2==0) {
								$bgcolor = "#f0f0f0";
							}else{
								$bgcolor = "#ffffff";
							}

							if($CompanyScale!="A" && $CompanyScale!="B" && $CompanyScale!="C") {
								$CompanyScale2 = "<font color='#ff0000'>".$CompanyScale."</font>";
							}else{
								$CompanyScale2 = $CompanyScale_array[$CompanyScale];
							}

							if(is_numeric($CompanyCode) && strlen($CompanyCode)==10) {
								$CompanyCode2 = $CompanyCode;
							}else{
								$CompanyCode2 = "<font color='#ff0000'>".$CompanyCode."</font>";
							}

							if($CompanyCodeCount>0) {
								$CompanyCode2 = $CompanyCode2." <font color='#ff0000'>(중복DB)</font>";
							}else{
								$CompanyCode2 = $CompanyCode2;
							}
							if($CompanyCodeTempCount>1) {
								$CompanyCode2 = $CompanyCode2." <font color='#ff0000'>(중복Excel)</font>";
							}else{
								$CompanyCode2 = $CompanyCode2;
							}

							if(is_numeric($Zipcode) && strlen($Zipcode)==5) {
								$Zipcode2 = $Zipcode;
							}else{
								$Zipcode2 = "<font color='#ff0000'>".$Zipcode."</font>";
							}

							if($SalesManager) {
								if($SalesManagerCount>0) {
									$SalesManager2 = $SalesManager;
								}else{
									$SalesManager2 = "<font color='#ff0000'>".$SalesManager."</font>";
								}
							}else{
								$SalesManager2 = "";
							}

							if($CompanyIDCount>0) {
								$CompanyID2 = $CompanyID." <font color='#ff0000'>(중복DB)</font>";
							}else{
								$CompanyID2 = $CompanyID;
							}
							if($CompanyIDTempCount>1) {
								$CompanyID2 = $CompanyID." <font color='#ff0000'>(중복Excel)</font>";
							}else{
								$CompanyID2 = $CompanyID;
							}
					?>
				  <tr bgcolor="<?=$bgcolor?>">
					<td rowspan="2"><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" class="checkbox"><br><img src="images/btn_edit04.gif" style="padding-top:5px; cursor:pointer" onclick="CompanyRegEdit('<?=$idx?>');"></td>
					<td rowspan="2"><?=$i?></td>
					<td><?=$CompanyName?></td>
					<td><?=$CompanyID2?></td>
					<td><?=$CompanyScale2?></td>
					<td><?=$CompanyCode2?></td>
					<td><?=$HRD?></td>
					<td><?=$Ceo?></td>
					<td><?=$Zipcode2?></td>
					<td><?=$Address01?></td>
					<td><?=$Address02?></td>
					<td><?=$Uptae?></td>
					<td><?=$CyberEnabled?></td>
					<td><?=$HomePage?></td>
                  </tr>
				  <tr bgcolor="<?=$bgcolor?>">
					<td><?=$Tel?></td>
					<td><?=$Email?></td>
					<td><?=$EduManager?></td>
					<td><?=$EduManagerPhone?></td>
					<td><?=$EduManagerEmail?></td>
					<td><?=$SalesManager2?></td>
					<td><?=$Remark?></td>
					<td><?=$Tel2?></td>
					<td><?=$Fax2?></td>
					<td><?=$Upjong?></td>
					<td><?=$CSEnabled?></td>
					<td></td>
                  </tr>
				  <?
						$i++;
						}
						mysqli_free_result($QUERY);
					}else{
				?>
				  <tr>
						<td height="50" class="tc" colspan="14">업로드한 엑셀파일이 없습니다.</td>
					</tr>
				<? } ?>
				</table>
				</form>

				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="mt20">
				<tr>
					<td class="tl" width="150">
						<button type="button" id="BtnDelete" class="btn btn_DGray line" onclick="CheckedDelete()">선택항목 삭제</button>
					</td>
					<td class="tc">
						<button type="button" id="BtnSubmit" class="btn btn_Blue" onclick="CompleteSubmitOk()">업로드 하기</button>
					</td>
					<td class="tr" width="150">
						<button type="button" id="BtnList" class="btn btn_DGray line" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'">목록</button>
					</td>
				</tr>
			</table>

            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>