<?
$MenuType = "C";
$PageName = "study_sms";
$ReadPage = "study_sms_read";
?>
<? include "./include/include_top.php"; ?>
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function() {

	$("#ID").bind("focus", function() {
		$(document).keydown(function(e) {
			if(e.keyCode===13) {
				StudySearch(1);
			}
		});
	});

});
//-->
</SCRIPT>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>학습참여독려 | <span class="fs12 fcfff">수강생들의 교육참여에 따라 직접 문자를 보낼 수 있습니다.</span></h2>

            <div class="conZone">
            	<!-- ## START -->
			<!-- serach -->
			<form name="search" id="search" method="POST">
			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="StudySmsSearch()">
			<div class="neoSearch">
				<ul class="search">
					<li>
                    	<input type="radio" name="SearchGubun" id="SearchGubun1" value="A" checked onclick="SearchGubunChange('A')" style="width:15px; height:15px; background:none; border:none;">
                      	<span class="item01"><label for="SearchGubun1">기간 검색</label></span>
                    </li>
					<li><input type="radio" name="SearchGubun" id="SearchGubun2" value="B" onclick="SearchGubunChange('B')" style="width:15px; height:15px; background:none; border:none;">
                      <span class="item01"><label for="SearchGubun2">사업주 검색</label></span>&nbsp;&nbsp;&nbsp;&nbsp;
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
                        <span id="SearchGubunResult2" style="display:none"><input type="text" name="CompanyName" id="CompanyName" style="width:450px" placeholder="사업주명 입력" onfocus="CompanySearchAutoCompleteGo();" onKeyup="CompanySearchAutoCompleteGo();"></span>
						<div id="CompanyAutoCompleteResult" class="auto_complete_layer" style="display:none"></div>
						<span id="CompanySearchLectureTermeResult"></span>
					</li>
				</ul>
				<ul class="search">
					<li><span class="item01">이름,ID</span>
                    	<input type="text" name="ID" id="ID" style="width:150px">
					</li>
					<li><span class="item01">진도율</span>
                   	  <input type="text" name="Progress1" id="Progress1" style="width:40px"> % ~ <input type="text" name="Progress2" id="Progress2" style="width:40px"> %
                	</li>
                    <li><span class="item01">총점</span>
                   	  <input type="text" name="TotalScore1" id="TotalScore1" style="width:40px"> 점 ~ <input type="text" name="TotalScore2" id="TotalScore2" style="width:40px"> 점
                    </li>
                    <li><span class="item01">첨삭정렬</span>
                    	<select name="TutorStatus" id="TutorStatus" style="width:150px">
							<option value="">전체</option>
							<option value="N">미첨삭만 보기</option>
						</select>
                    </li>
				</ul>
                <ul class="search">
					<li><span class="item01">과정명</span>
                    	<select name="LectureCode" id="LectureCode" >
							<option value="">-- 과정 전체 --</option>
						<?
							$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' ORDER BY ContentsName ASC";
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY))
							{
								$i = 1;
								while($Row = mysqli_fetch_array($QUERY))
								{

									if($Row['PackageYN']=="Y") {
										$PackageYN = " (패키지)";
									}else{
										$PackageYN = "";
									}
							?>
							<option value="<?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
							<?
								$i++;
								}
							}
							?>
						</select>
                    </li>
				</ul>
                <ul class="search">
					<li><span class="item01">수료여부</span>
                    	<select name="PassOk" id="PassOk" style="width:150px">
							<option value="">전체</option>
							<option value="Y">수료</option>
							<option value="N">미수료</option>
						</select>
                    </li>
					<li><span class="item01">환급여부</span>
                    	<select name="ServiceType" id="ServiceType" style="width:150px">
							<option value="">전체</option>
							<?
							while (list($key,$value)=each($ServiceType_array)) {
								?>
								<option value="<?=$key?>"><?=$value?></option>
							<?
							}
							reset($ServiceType_array);
							?>
						</select>
                    </li>
                    <li><span class="item01">과정구분</span>
						<select name="PackageYN" id="PackageYN" style="width:150px">
							<option value="">전체</option>
							<option value="Y">패키지</option>
							<option value="N">일반강의</option>
						</select>
                    </li>
                    <li><span class="item01">실명인증 여부</span>
						<select name="certCount" id="certCount" style="width:150px">
							<option value="">전체</option>
							<option value="Y">인증 완료</option>
							<option value="N">미인증</option>
						</select>
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
                    <li><span class="item01">모사답안</span>
						<select name="ReportCopy" id="ReportCopy" style="width:150px">
							<option value="">전체</option>
							<option value="D">모사답안의심</option>
							<option value="Y">모사답안</option>
						</select>
                    </li>
				</ul>
                
                <!-- btn -->
				<div class="mt10 tc pb5">
                	<input type="button" name="SearchBtn" id="SearchBtn" value="검 색" class="btn_inputBlue01" style="width:230px;" onclick="StudySmsSearch()">&nbsp;&nbsp;
					
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