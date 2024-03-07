<?
$MenuType = "B";
$PageName = "study_ip";
$ReadPage = "study_ip_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>IP모니터링</h2>

            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->
				<form name="search" id="search" method="POST">
			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="StudyIPSearch(1)">
			<div class="neoSearch">
				<ul class="search">
					<li style="border:none;">
                    	<input type="radio" name="SearchGubun" id="SearchGubun1" value="A" checked onclick="SearchGubunChange('A')" style="width:15px; height:15px; background:none; border:none;">
                      	<span class="item01"><label for="SearchGubun1">기간 검색</label></span>&emsp;
						<input type="radio" name="SearchGubun" id="SearchGubun2" value="B" onclick="SearchGubunChange('B')" style="width:15px; height:15px; background:none; border:none;">
                      <span class="item01"><label for="SearchGubun2">사업주 검색</label></span>
                    </li>
					<li>
						<span id="SearchGubunResult1">
                        <select name="SearchYear" id="SearchYear" onchange="LectureTermeSearch()" style="width:100px">
							<?
							for($i=2018;$i<=date("Y");$i++) {
							?>
							<option value="<?=$i?>" <?if($i==date("Y")) {?>selected<?}?>><?=$i?>년</option>
							<?
							}
							?>
                      	</select>&nbsp;
						<select name="SearchMonth" id="SearchMonth" onchange="LectureTermeSearch()" style="width:80px">
							<option value="">전체</option>
							<?
							for($i=1;$i<=12;$i++) {
							?>
							<option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>" <?if($i==date("m")) {?>selected<?}?>><?=$i?>월</option>
							<?
							}
							?>
                      	</select>
                        <span id="LectureTermeResult"></span>
						<span id="LectureCompanyResult"></span>
						</span>
                        <!--<span id="SearchGubunResult2" style="display:none"><input type="text" name="CompanyName" id="CompanyName" style="width:450px" placeholder="사업주명 입력"></span>-->						
                        <span id="SearchGubunResult2" style="display:none"><input type="text" name="CompanyName" id="CompanyName" style="width:450px" placeholder="사업주명 입력" onfocus="CompanySearchAutoCompleteGo();" onKeyup="CompanySearchAutoCompleteGo();"></span>
						<div id="CompanyAutoCompleteResult" class="auto_complete_layer" style="display:none"></div>
						<span id="CompanySearchLectureTermeResult"></span>
					</li>
				</ul>
				<ul class="search">
					<li><span class="item01">이름,ID</span>
                    	<input type="text" name="ID" id="ID" style="width:150px">
					</li>
					<li><span class="item01">영업자 이름,ID</span>
                    	<input type="text" name="SalesID" id="SalesID" style="width:150px">
					</li>
					<li><span class="item01">영업자 소속</span>
                    	<input type="text" name="SalesTeam" id="SalesTeam" style="width:150px">
					</li>
					<li><span class="item01">진도율</span>
                   	  <input type="text" name="Progress1" id="Progress1" style="width:40px"> % ~ <input type="text" name="Progress2" id="Progress2" style="width:40px"> %
               	  </li>
				</ul>
                <ul class="search">
					<li><span class="item01">중간평가</span>
						<select name="MidStatus" id="MidStatus" style="width:150px">
							<option value="">전체</option>
							<option value="C">응시(채점완료)</option>
							<option value="Y">응시(채점대기중)</option>
							<option value="N">미응시</option>
						</select>
                    </li>
					<li><span class="item01">최종평가</span>
						<select name="TestStatus" id="TestStatus" style="width:150px">
							<option value="">전체</option>
							<option value="C">응시(채점완료)</option>
							<option value="Y">응시(채점대기중)</option>
							<option value="N">미응시</option>
						</select>
                    </li>
                    <li><span class="item01">과제</span>
						<select name="ReportStatus" id="ReportStatus" style="width:150px">
							<option value="">전체</option>
							<option value="C">응시(채점완료)</option>
							<option value="Y">응시(채점대기중)</option>
							<option value="N">미응시</option>
							<option value="R">반려</option>
						</select>
                    </li>
                    <li><span class="item01">평가 모사</span>
						<select name="TestCopy" id="TestCopy" style="width:150px">
							<option value="">전체</option>
							<option value="D">모사답안의심</option>
							<option value="Y">모사답안</option>
						</select>
                    </li>
                    <li><span class="item01">과제 모사</span>
						<select name="ReportCopy" id="ReportCopy" style="width:150px">
							<option value="">전체</option>
							<option value="D">모사답안의심</option>
							<option value="Y">모사답안</option>
						</select>
                    </li>
				</ul>
                
                <!-- btn -->
			  	<div class="mt10 tc pb5">
                	<button type="button" name="SearchBtn" id="SearchBtn" class="btn btn_Blue" style="width:200px;" onclick="StudyIPSearch(1)"><i class="fas fa-search"></i> 검색</button>&nbsp;&nbsp;	
					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="StudyIPExcel();"><i class="fas fa-file-excel"></i> 검색 결과 엑셀 출력</button>
					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="StudyIPExcelDetail();"><i class="fas fa-file-excel"></i> 검색 결과 엑셀 출력(상세)</button>
					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="StudyIPExcelDetail2();"><i class="fas fa-file-excel"></i> 검색 결과 엑셀 출력(상세2)</button>
	      		</div>
                <!-- btn // -->
			</div>
			</form>
            
                <!--목록 -->
                <div id="SearchResult"><br><br><center><strong>검색 조건을 선택하세요.</strong></center></div>

            	<!-- 버튼 -->

<script type="text/javascript">
<!--
$(window).load(function() {

	LectureTermeSearch();

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