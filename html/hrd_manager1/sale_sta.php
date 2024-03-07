<?
$MenuType = "F";
$PageName = "sale_sta";
$ReadPage = "sale_sta_read";
?>
<? include "./include/include_top.php"; ?>
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function() {

	$("#ID").bind("focus", function() {
		$(document).keydown(function(e) {
			if(e.keyCode===13) {
				SaleSearch();
			}
		});
	});


	$("#LectureStart").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#LectureStart').val("<?=date('Y')?>-01-01");

	$("#LectureEnd").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#LectureEnd').val("<?=date('Y-m-').get_end_day(date('Y'),date('m'))?>");

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용


});
//-->
</SCRIPT>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>영업통계(사업주)</h2>

            <div class="conZone">
            	<!-- ## START -->
			<!-- serach -->
			<form name="search" id="search" method="POST">
				<input type="hidden" name="Dept_idx" id="Dept_idx">
				<input type="hidden" name="DeptString" id="DeptString">
				<input type="hidden" name="TOT_NO" id="TOT_NO">
			<div class="neoSearch">
				<ul class="search">
					<li>
						<span class="item01">기간 검색</span>
                    </li>
					<li>
					<select name="StartColume" id="StartColume">
						<option value="LectureStart" selected>시작일</option>
						<option value="LectureEnd">종료일</option>
						<option value="InputDate">등록일</option>
					</select>
					<input name="LectureStart" id="LectureStart" type="text"  size="12" value="" readonly>  ~ 
					<select name="EndColume" id="EndColume">
						<option value="LectureStart">시작일</option>
						<option value="LectureEnd" selected>종료일</option>
						<option value="InputDate">등록일</option>
					</select>
					<input name="LectureEnd" id="LectureEnd" type="text"  size="12" value="" readonly></li>
					<li>
						<span class="item01">영업자 검색</span>
                    </li>
					<li><input type="text" name="SalesID" id="SalesID" style="width:250px" placeholder="영업자 ID 또는 이름"></li>
				</ul>
				<ul class="search">
					<li>
						<span class="item01">부서 선택</span>
                    </li>
					<li>
						<span id="DeptValueSelectResult"></span>
						<input type="button" value="영업부서 선택" onclick="SaleStaDeptSelect();" class="btn_inputSm01" style="cursor:pointer;width:115px;height:25px">
					</li>
				</ul>
                <!-- btn -->
				<div class="mt10 tc pb5" style="width:1250px; margin:10px auto 0 auto">
                	<input type="button" name="SearchBtn" id="SearchBtn" value="검 색" class="btn_inputBlue01" style="width:230px;" onclick="SaleStaSearch()">&nbsp;&nbsp;
					<input type="button" name="ExcelBtn" id="ExcelBtn" value="검색 결과 엑셀 출력" class="btn_inputLine01" style="width:240px;" onclick="SaleStaDeptExcel();">
				</div>
                <!-- btn // -->
			</div>
			</form>
			<!-- serach // -->
            
			<!--목록 -->
			<div id="SearchResult"><br><br><center><strong>검색 조건을 선택하세요.</strong></center></div>
            

          <!--컨텐츠 e--></td>
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