<?
include "../include/include_top.php";
?>
        
        <!-- Container -->
        <div id="container">
        	
			<!-- Content -->
            <div class="Content">
            
            	<!-- left -->
            	<?
				include "../educps/include_educps.php";
				?>
                <!-- left // -->
                
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3><?=$CategoryName?></h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 법정의무교육 > <?=$CategoryName?></div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
<?
$NowDate = date("Y-m-d");

$where = array();

$where[] = "Del='N'";
$where[] = "UseYN='Y'";
$where[] = "PackageYN='N'";
$where[] = "Category1=$Menu01ParentCategory";

if($Category) {
$where[] = "Category2=$Category";
}

$where[] = "idx=$idx";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$Sql = "SELECT * FROM Course $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ctype = $Row['ctype']; //A 사업주과정, B 내일배움카드
	$ClassGrade = $Row['ClassGrade']; //등급
	$LectureCode = $Row['LectureCode']; //과정코드
	$UseYN = $Row['UseYN']; //사이트 노출
	$PassCode = $Row['PassCode']; //심사코드
	$HrdCode = $Row['HrdCode']; //HRD-NET 과정코드
	$Category1 = $Row['Category1']; //과정분류 대분류
	$Category2 = $Row['Category2']; //과정분류 소분류
	$ServiceType = $Row['ServiceType']; //서비스 구분
	$ContentsName = html_quote($Row['ContentsName']); //과정명
	$CompleteTime = $Row['CompleteTime']; //진도시간 기준
	$ProgressCheck = $Row['ProgressCheck']; //진도체크방식
	$Chapter = $Row['Chapter']; //차시수
	$ContentsTime = $Row['ContentsTime']; //교육시간
	$Price = $Row['Price']; //교육비용 일반
	$Price01View = $Row['Price01View']; //교육비용 우선지원 
	$Price02View = $Row['Price02View']; //교육비용 대규모 1000인 미만 
	$Price03View = $Row['Price03View']; //교육비용 대규모 1000인 이상 
	$Price01 = $Row['Price01']; //자부담금 교육비용 우선지원 
	$Price02 = $Row['Price02']; //자부담금 교육비용 대규모 1000인 미만 
	$Price03 = $Row['Price03']; //자부담금 교육비용 대규모 1000인 이상 
	$Professor = $Row['Professor']; //내용전문가 
	$Limited = $Row['Limited']; //학급정원
	$ContentsPeriod = substr($Row['ContentsPeriod'],0,10); //컨텐츠 유효기간
	$ContentsAccredit = substr($Row['ContentsAccredit'],0,10); //인정만료일 시작일
	$ContentsExpire = substr($Row['ContentsExpire'],0,10); //인정만료일 종료일
	$Cp = html_quote($Row['Cp']); //cp사
	$Commission = $Row['Commission']; //cp 수수료
	$Mobile = $Row['Mobile']; //모바일 지원
	$BookPrice = $Row['BookPrice']; //교재비
	$BookIntro = html_quote($Row['BookIntro']); //참고도서설명
	$attachFile = html_quote($Row['attachFile']); //학습자료
	$PreviewImage = html_quote($Row['PreviewImage']); //과정 이미지
	$BookImage = html_quote($Row['BookImage']); //교재 이미지
	$Mid01EA = $Row['Mid01EA']; //중간평가 객관식 문항수
	$Mid01Score = $Row['Mid01Score']; //중간평가 객관식 배점
	$Mid02EA = $Row['Mid02EA']; //중간평가 주관식 문항수
	$Mid02Score = $Row['Mid02Score']; //중간평가 주관식 배점
	$Test01EA = $Row['Test01EA']; //최종평가 객관식 문항수
	$Test01Score = $Row['Test01Score']; //최종평가 객관식 배점
	$Test02EA = $Row['Test02EA']; //최종평가 주관식 문항수
	$Test02Score = $Row['Test02Score']; //최종평가 주관식 배점
	$ReportEA = $Row['ReportEA']; //과제 문항수
	$ReportScore = $Row['ReportScore']; //과제 배점
	$TestTime = $Row['TestTime']; //시험제한시간
	$MidRate = $Row['MidRate']; //반영비율 중간평가 
	$TestRate = $Row['TestRate']; //반영비율 최종평가 
	$ReportRate = $Row['ReportRate']; //반영비율 과제
	$PassProgress = $Row['PassProgress']; //진도율  
	$TotalPassMid = $Row['TotalPassMid']; //중간평가 : 총점
	$TotalPassTest = $Row['TotalPassTest']; //최종평가 : 총점
	$PassTest = $Row['PassTest']; //최종평가 : 득점
	$TotalPassReport = $Row['TotalPassReport']; //과제 : 총점
	$PassReport = $Row['PassReport']; //과제 : 득점
	$PassScore = $Row['PassScore']; //반영비율을 적용한 총점
	$Intro = nl2br($Row['Intro']); //과정소개
	$EduTarget = nl2br($Row['EduTarget']); //교육대상
	$EduGoal = nl2br($Row['EduGoal']); //교육목표
	$Hit = $Row['Hit']; //인기 강의
}

if($PreviewImage) {
	$PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' alt='".$ContentsName."'>";
}else{
	$PreviewImageView = "<img src='/images/no_img.jpg' alt='".$ContentsName."'>";
}

if($IE8Compat=="Y") {
	//$PreviewFun = "CoursePreviewPopup";
	$PreviewFun = "CoursePreview";
}else{
	$PreviewFun = "CoursePreview";
}

if($ctype=="A") {
	$CompanyScaleTitle01 = "우선지원 기업";
	$CompanyScaleTitle02 = "대규모(1,000인 미만)";
	$CompanyScaleTitle03 = "대규모(10,000인 이상)";
}

if($ctype=="B") {
	$CompanyScaleTitle01 = "일반훈련생";
	$CompanyScaleTitle02 = "취업성공패키지";
	$CompanyScaleTitle03 = "근로장려금";
}
?>
<script type="text/javascript">
<!--
function LectureRequestSubmitOk2() {

	var checked_value = $(':radio[name="LectureDate"]:checked').val();
	var checked_length = $(':radio[name="LectureDate"]').length;

	if(checked_length==0) {
		alert("등록된 교육기간 존재하지 않아 학습신청을 할수 없습니다.");
		return;
	}

	if(checked_value==undefined) {
		alert("교육기간을 선택하세요.");
		return;
	}
	

	Yes = confirm("신청하시겠습니까?");
	if(Yes==true) {
		RequestForm2.submit();
	}

}

function InfoDesc(i) {

	$("a[id='InfoLink']").removeClass('show');
	$("div[id='Info']").hide();


	$("a[id='InfoLink']").eq(i).addClass('show');
	$("div[id='Info']").eq(i).show();

}
//-->
</script>
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="lectureViewZone">
                        	
                            <!-- title -->
                            <div class="titleArea">
                            	<strong><?=$ContentsName?></strong>
                            	<p class="modeMark">
									<?if($ServiceType=="1") {?><img src="../images/common/icon_show_refund.png" alt="사업주환급" /><?}?>
                                    <img src="../images/common/icon_show_pc.png" alt="PC" />
                                    <?if($Mobile=="Y") {?><img src="../images/common/icon_show_mobile.png" alt="모바일병행" /><?}?>
                            	</p>
                            </div>
                            <!-- title // -->
                            
                            <!-- Base info -->
                            <div class="baseInfo">
                            	<div class="imgArea"><?=$PreviewImageView?></div>
                                <!-- info -->
                                <div class="infoArea">
                                	<ul class="txt">
                                        <li><strong>교육시간</strong><?=$Chapter?>차시<em> / </em><?=$ContentsTime?>시간</li>
                                        <li><strong>내용전문가</strong><?=$Professor?></li>
                                        <li><strong>수강정원</strong><?=$Limited?>명</li>
                                	</ul>
                                    <!-- btn -->
                                    <div class="lecBtn">
                                    	<span class="btn01"><a href="Javascript:<?=$PreviewFun?>('<?=$LectureCode?>');">교육맛보기</a></span>
                                    	<span class="btn01"><a href="Javascript:SimpleAsk();">간편문의</a></span>
                                    </div>
                                    <!-- btn // -->
                                </div>
                                <!-- info // -->
                            </div>
                            <!-- Base info // -->
                            
                            <!-- Select Edu -->
							<form name="RequestForm2" method="POST" action="/include/lecture_request_ok.php" target="ScriptFrame">
							<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
							<input type="hidden" name="Price" id="Price" value="<?=$Price?>">
                            <div class="selectInfo">
                            	<h4>학습기간</h4>
                                <ul class="radioList">
									<?
									$i = 0;
									//$SQL = "SELECT DISTINCT(LectureStart), LectureEnd FROM LectureTerme WHERE LectureCode='$LectureCode' ORDER BY LectureStart ASC, LectureEnd ASC";
									$SQL = "SELECT DISTINCT(LectureStart), LectureEnd FROM LectureTerme WHERE LectureCode='$LectureCode' AND LectureStart>'$NowDate' ORDER BY LectureStart ASC, LectureEnd ASC";
									$QUERY = mysqli_query($connect, $SQL);
									if($QUERY && mysqli_num_rows($QUERY))
									{
										while($ROW = mysqli_fetch_array($QUERY))
										{
									?>
                                	<li><span class="inpRadio">
                                		<input type="radio" name="LectureDate" id="LectureDate<?=$i?>" value="<?=$ROW['LectureStart']?>|<?=$ROW['LectureEnd']?>">
                                		<label for="LectureDate<?=$i?>"><?=$ROW['LectureStart']?> ~ <?=$ROW['LectureEnd']?></label>
                                		</span>
                                	</li>
                                	<?
									$i++;
										}
									}else{
									?>
									<li>신청 가능한 교육 기간이 없습니다.</li>
									<?
									}
									?>
                                </ul>
                                <!-- btn -->
                                <div class="lecBtn">
                                	<span class="btn02"><a href="Javascript:LectureRequestSubmitOk2();">선택한 학습기간 신청하기</a></span>
                                </div>
                                <!-- btn // -->
                            </div>
							</form>
                            <!-- Select Edu // -->
                            
                            <!-- Edu Info -->
                            <div class="eduInfo">
                            	<!-- info -->
								<h4>수료기준</h4>
                                <div class="mt20">
                                	<table cellpadding="0" cellspacing="0" class="infoTable01">
                                	  <caption>수료기준</caption>
                                	  <colgroup>
                                	    <col width="16%" />
                                	    <col width="20%" />
                                	    <col width="20%" />
                                	    <col width="20%" />
										<col width="24%" />
                                	  </colgroup>
                                	  <tr>
                                	    <th>진도율</th>
                                	    <th>진행단계평가</th>
                                	    <th>최종평가</th>
                                	    <th>과제</th>
                                	    <th>수료기준</th>
                                	  </tr>
                                	  <tr>
                                	    <td class="tc"><?=$PassProgress?>% 이상</td>
                                	    <td class="tc"><?if($TotalPassMid>0) {?>총 <?=$TotalPassMid?>점 / <?=$MidRate?>% 반영<?}else{?>중간평가 없음<?}?></td>
                                	    <td class="tc"><?if($TotalPassTest>0) {?>총 <?=$TotalPassTest?>점 / <?=$TestRate?>% 반영<?}else{?>최종평가 없음<?}?></td>
                                	    <td class="tc"><?if($TotalPassReport>0) {?>총 <?=$TotalPassReport?>점 / <?=$ReportRate?>% 반영<?}else{?>과제 없음<?}?></td>
                                	    <td class="tc">반영된 평가 합산 <?=$PassScore?>점 이상</td>
                                	  </tr>
                                	</table>
                                </div>
                                <div class="comment_1 mt30">
                                	<p class="item">근로자카드 수강 유의사항</p>
                                	<ul class="ty_01">
                                    	<li>근로자카드 과정 구매 시, 지원금은 근로자카드 한도내에서 자동차감됩니다.</li>
                                        <li>근로자카드 과정 미수료 시, 고용노동부에서 규정한 패널티가 부여됨을 유의해주시기바랍니다.</li>
                                    </ul>
                                </div>
                                
                                <hr />
                                <h4>교육비 정보</h4>
                                <div class="mt20">
                                	<table cellpadding="0" cellspacing="0" class="infoTable01">
                                	  <caption>교육비 정보</caption>
                                	  <colgroup>
                                	    <col width="*" />
                                	    <col width="25%" />
                                	    <col width="25%" />
                                	    <col width="25%" />
                                	  </colgroup>
                                	  <tr>
                                	    <th>교육비</th>
                                	    <th>환급:<?=$CompanyScaleTitle01?></th>
                                	    <th>환급:<?=$CompanyScaleTitle02?></th>
                                	    <th>환급:<?=$CompanyScaleTitle03?></th>
                                	  </tr>
                                	  <tr>
                                	    <td class="tc"><span class="fs17b"><?=number_format($Price,0)?></span> 원</td>
                                	    <td class="tc"><span class="fs17b"><?=number_format($Price01View,0)?></span> 원</td>
                                	    <td class="tc"><span class="fs17b"><?=number_format($Price02View,0)?></span> 원</td>
                                	    <td class="tc"><span class="fs17b"><?=number_format($Price03View,0)?></span> 원</td>
                                	  </tr>
                                	</table>
                                </div>
                                <!-- info // -->
                            </div>
                            <!-- Edu Info // -->
                            
                            <!-- Tab -->
                            <div class="viewTab">
                            	<ul class="area">
                                	<li><a href="Javascript:InfoDesc(0);" class="show" id="InfoLink">강의설명</a></li>
                                    <li><a href="Javascript:InfoDesc(1);" id="InfoLink">강의목차</a></li>
                                    <li><a href="Javascript:InfoDesc(2);" id="InfoLink">학습후기</a></li>
                                </ul>
                            </div>
                            <!-- Tab // -->
                            
                            <!-- Detail Info -->
                            <div class="lecDetail" id="Info">
                            	<ul class="area">
                                	<li><strong>과정소개</strong>
                                    	<?=$Intro?>
                                    </li>
                                    <li><strong>교육대상</strong>
                                    	<?=$EduTarget?>
                                    </li>
                                    <li><strong>교육목표</strong>
                                    	<?=$EduGoal?>
                                    </li>
                                </ul>
                            </div>
                            <!-- Detail Info // -->
                            
                            <!-- List -->
                            <div class="mt30" id="Info" style="display:none">
                            	<table cellpadding="0" cellspacing="0" class="taList_ty01">
                            	  <caption>강의목차</caption>
                            	  <colgroup>
                            	    <col width="12%" />
                                    <col width="*" />
                            	  </colgroup>
                            	  <tr>
                            	    <th>차시</th>
                            	    <th>강의명</th>
                            	  </tr>
								  <?
									$i = 1;
									$SQL = "SELECT a.Seq AS Chapter_seq, a.ChapterType, a.OrderByNum, a.Sub_idx, b.Gubun AS ContentGubun, b.ContentsTitle, 
												(SELECT COUNT(Seq) FROM ContentsDetail WHERE Contents_idx=a.Sub_idx) AS ContentsCount 
												FROM Chapter AS a LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
												WHERE a.LectureCode='$LectureCode' AND a.ChapterType='A' ORDER BY a.OrderByNum ASC";
									//echo $SQL;
									$QUERY = mysqli_query($connect, $SQL);
									if($QUERY && mysqli_num_rows($QUERY))
									{
										while($ROW = mysqli_fetch_array($QUERY))
										{
									?>
                            	  <tr>
                            	    <td class="tc"><?=$i?>차시</td>
                            	    <td class="fc000"><?=$ROW['ContentsTitle']?></td>
                            	  </tr>
								  <?
									$i++;
										}
									}
									?>
                            	</table>
                            </div>
                            <!-- List // -->
                            
                            <!-- Review -->
							<?
							$Sql = "SELECT * FROM Review WHERE LectureCode='$LectureCode' AND UseYN='Y'";
							$Result = mysqli_query($connect, $Sql);
							$Row = mysqli_fetch_array($Result);
							$ReviewCount = $Row[0];

							$Sql = "SELECT AVG(StarPoint) FROM Review WHERE LectureCode='$LectureCode' AND UseYN='Y'";
							$Result = mysqli_query($connect, $Sql);
							$Row = mysqli_fetch_array($Result);
							$StarPoint = $Row[0];
							$Star = StarPointAVG($StarPoint);

							?>
                            <div class="reviewArea mt30" id="Info" style="display:none">
                            	<div class="starInfo">
                                	<span class="item">평점</span>
                                    <span class="star"><?=$Star?></span>
                                    <span>총 <?=number_format($ReviewCount,0)?>건의 수강후기가 등록되었습니다.</span>
                                </div>
                       	  		<ul class="list">
									<?
									$SQL = "SELECT * FROM Review WHERE LectureCode='$LectureCode' AND UseYN='Y' ORDER BY RegDate DESC, idx DESC";
									$QUERY = mysqli_query($connect, $SQL);
									if($QUERY && mysqli_num_rows($QUERY))
									{
										while($ROW = mysqli_fetch_array($QUERY))
										{
											extract($ROW);
				
											$ID_len = strlen($ID);
											$IDView = ReviewIDView($ID,$ID_len);
									?>
                                	<li><strong><?=$Name?><span><?=$IDView?></span></strong>
                                    	<p><?=$Contents?></p>
                                    </li>
									<?
										}
									}else{
									?>
									<li style="text-align:center">등록된 수강후기가 없습니다.</li>
									<? } ?>
                                </ul>
                            </div>
                            <!-- Review // -->
                           
                        </div>
                        
                        <!-- area // -->
                    </div>
                    <!-- info area // -->
                
                </div>
                <!-- content area -->
            
            </div>
            <!-- Content // -->
            
        </div>
        <!-- Container // -->
         
<?
include "../include/include_bottom.php";
?>