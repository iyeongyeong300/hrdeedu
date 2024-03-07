<?
$MenuType = "B";
$PageName = "study_end";
$ReadPage = "study_end_read";
?>
<? include "./include/include_top.php"; ?>

        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>수강마감<span class="fs12 description">마감을 통해 수강생에게 결과를 통보하거나 최종결과를 확정짓습니다.</span></h2>

            <div class="conZone">
            	<!-- ## START -->
				
				<script type="text/javascript">
				<!--
				$(document).ready(function(){
					$("#LectureStart, #LectureEnd").datepicker({
						changeMonth: true,
						changeYear: true,
						showButtonPanel: true,
						showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
						buttonImage: "images/icn_calendar.gif", //이미지 주소
						buttonImageOnly: true //이미지만 보이기
					});
					$("#LectureStart, #LectureEnd").val("");
					$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
				});
				//-->
				</script>
				
			<!-- serach -->
			<form name="search" id="search" method="POST">
			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="StudyEndSearch(1)">
			<div class="neoSearch">
				<ul class="search">
					<li>
						<span class="item01"><label>수강기간</label></span>
						<input name="LectureStart" id="LectureStart" type="text" size="12" value="" autocomplete='off'>  ~  <input name="LectureEnd" id="LectureEnd" type="text" size="12" value="" autocomplete='off'>
					</li>
					<li>
						<span class="item01"><label>사업주명</label></span>
						<input type="text" name="CompanyName" id="CompanyName" style="width:390px" placeholder="사업주명 입력" onfocus="CompanySearchAutoCompleteGo();" onKeyup="CompanySearchAutoCompleteGo();" autocomplete="off">
						<div id="CompanyAutoCompleteResult" class="auto_complete_layer" style="display:none; left:440px"></div>
						<span id="CompanySearchLectureTermeResult"></span>
					</li>
					<li>
						<span class="item01"><label>환급여부</label></span>
						<select name="ServiceType" id="ServiceType" style="width:150px">
							<option value="">전체</option>
							<?
							while (list($key,$value)=each($ServiceType1_array)) {
								?>
								<option value="<?=$key?>"><?=$value?></option>
							<?
							}
							reset($ServiceType1_array);
							?>
						</select>
					</li>
				</ul>
                
                <!-- btn -->
				<div class="mt10 tc pb5">
					<button type="button" name="SearchBtn" id="SearchBtn" class="btn btn_Blue" style="width:200px;" onclick="StudyEndSearch()"><i class="fas fa-search"></i> 검색</button>
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