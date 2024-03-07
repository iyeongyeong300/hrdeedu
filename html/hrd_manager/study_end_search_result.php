<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//$SearchGubun = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName = Replace_Check($CompanyName); //사업주명
//$SearchYear = Replace_Check($SearchYear); //검색 년도
//$SearchMonth = Replace_Check($SearchMonth); //검색 월
//$StudyPeriod = Replace_Check($StudyPeriod); //검색 기간
//$StudyPeriod2 = Replace_Check($StudyPeriod2); //검색 기간2(사업주검색)
//$CompanyCode = Replace_Check($CompanyCode); //사업자 번호
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일
$ServiceTypeA = Replace_Check($ServiceType); //환급여부
$pg = Replace_Check($pg); //페이지


##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 10;
$block_size = 10;


##-- 검색 조건
$where = array();

/*
 if($CompanyCode) {
 $where[] = "s.CompanyCode='".$CompanyCode."'";
 }*/

if($LectureStart) {
    $where[] = "s.LectureStart='".$LectureStart."'";
}

if($LectureEnd) {
    $where[] = "s.LectureEnd='".$LectureEnd."'";
}

if($CompanyName) {
    //$where[] = "c.CompanyName LIKE '%".$CompanyName."%'";
    $where[] = "c.CompanyName = '".$CompanyName."'";
}

if($ServiceTypeA) {
    $where[] = "s.ServiceType=".$ServiceTypeA;
}else{
    $where[] = "s.ServiceType IN (1,3,5,9)";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$str_orderby = "ORDER BY s.LectureStart ASC, s.LectureEnd ASC";

$Colume = "DISTINCT s.LectureStart, s.LectureEnd ";

//$JoinQuery = " Study AS a LEFT OUTER JOIN Company AS b ON s.CompanyCode=c.CompanyCode";
$JoinQuery = " Study s JOIN Company c JOIN Course f ON s.CompanyCode = c.CompanyCode and s.LectureCode = f.LectureCode";

$Sql2 = "SELECT COUNT($Colume) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

##-- 페이지 클래스 생성
$PageFun = "StudyEndSearch"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소

?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
    <tr>
        <th>번호</th>
        <th>수강기간</th>
        <th>과정명</th>
        <th>환급여부</th>
        <th>교육종료</th>
        <th>수강 마감</th>
        <th>수납</th>
        <th>수료증 출력</th>
        <th>교육보고서</th>
        <th>설문조사</th>
    </tr>
    <?
    $SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
    
    $QUERY = mysqli_query($connect, $SQL);    
    if($QUERY && mysqli_num_rows($QUERY)){
        while($ROW = mysqli_fetch_array($QUERY)){
            extract($ROW);
            //첨삭완료일
            $Tutor_limit_day = strtotime("$LectureEnd +4 days");
    ?>
    <tr>
        <td  height="28"><strong><?=$PAGE_UNCOUNT--?></strong></td>
        <td><strong><?=$LectureStart?> ~ <?=$LectureEnd?></strong></td>
        <td  colspan="2">&nbsp;</td>
        <td></td>
        <td>
        	<button style="color:#083bbe; font-weight:600;" type="button" name="StudyEnAllBtn" id="StudyEnAllBtn" class="btn round btn_LGray line" onclick="StudyEndAllComplete('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyName?>','<?=$ServiceTypeA?>')">마감(전체)</button>
        </td>
        <td></td>
        <td>
        	<button style="color:#083bbe; font-weight:600;" type="button" name="CertBtn04" id="CertBtn04" class="btn round btn_LGray line" onclick="StudyEndCertificatePrintAllPDF('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyName?>','<?=$ServiceTypeA?>')">수료증(전체)</button>
        </td>
        <td>
        	<button style="color:#083bbe; font-weight:600;" type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="StudyEndAllDocument03('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyName?>','<?=$ServiceTypeA?>')">교육결과보고서(전체)</button><br>
			<!-- <button type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="StudyEndAllDocument02('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyName?>','<?=$ServiceTypeA?>')">교육진행보고서(전체)</button>  -->
         </td>
        <td></td>
    </tr>
    <?
        $where2 = " AND s.LectureStart='$LectureStart' AND s.LectureEnd='$LectureEnd'";

        $SQL2 = "SELECT s.CompanyCode, c.CompanyName, s.LectureCode, f.ContentsName, s.ServiceType ,
                        SUM(s.Price) price, SUM(s.rPrice) rPrice, SUM(s.rPrice2) rPrice2, COUNT(*) StudyCount,f.MidRate, f.TestRate, f.ReportRate,
                        (CASE WHEN f.MidRate > 0 THEN COUNT(*) ELSE 0 END) TutorMid, (CASE WHEN f.TestRate > 0 THEN COUNT(*) ELSE 0 END) TutorTest,
                        (CASE WHEN f.ReportRate > 0 THEN COUNT(*) ELSE 0 END) TutorReport, 
                        COUNT(CASE WHEN s.MidStatus='C' THEN 1 END) AS StudyMidCount, COUNT(CASE WHEN s.TestStatus='C' THEN 1 END) AS StudyTestCount,
                        COUNT(CASE WHEN s.ReportStatus='C' THEN 1 END) AS StudyReportCount,
                        (SELECT CONCAT_WS('|',StudyEndInputID,StudyEndInputDate, LectureCode, ServiceType) FROM StudyEnd WHERE LectureStart=s.LectureStart AND LectureEnd=s.LectureEnd AND CompanyCode=s.CompanyCode AND StudyEndInputDate IS NOT NULL AND LectureCode IS NULL AND ServiceType IS NULL) AS StudyEndString,
                        (SELECT CONCAT_WS('|',StudyEndInputID,StudyEndInputDate, LectureCode, ServiceType) FROM StudyEnd WHERE LectureStart=s.LectureStart AND LectureEnd=s.LectureEnd AND CompanyCode=s.CompanyCode AND LectureCode=s.LectureCode AND ServiceType=s.ServiceType) AS NewStudyEndString
                FROM $JoinQuery
                $where $where2
                GROUP BY s.CompanyCode, s.LectureCode, s.ServiceType
                ORDER BY c.CompanyName, f.ContentsName, s.ServiceType";
        $QUERY2 = mysqli_query($connect, $SQL2);
        if($QUERY2 && mysqli_num_rows($QUERY2)){
            while($ROW2 = mysqli_fetch_array($QUERY2)){
                $CompanyCode = $ROW2['CompanyCode'];
                $CompanyName = $ROW2['CompanyName'];
                $LectureCode = $ROW2['LectureCode'];
                $ContentsName = $ROW2['ContentsName'];
                $ServiceType = $ROW2['ServiceType'];

                $ExamRate = $ROW2['ExamRate'];
                $ExamRate_array = explode('|',$ExamRate);
                $MidRate = $ExamRate_array[0];
                $TestRate = $ExamRate_array[1];
                $ReportRate = $ExamRate_array[2];

                $StudyCount = $ROW2['StudyCount'];
                
                $TutorMid = $ROW2['TutorMid'];
                $TutorTest = $ROW2['TutorTest'];
                $TutorReport = $ROW2['TutorReport'];

                $StudyMidCount = $ROW2['StudyMidCount'];
                $StudyTestCount = $ROW2['StudyTestCount'];
                $StudyReportCount = $ROW2['StudyReportCount'];
                $StudyEndString = $ROW2['StudyEndString'];
                $NewStudyEndString = $ROW2['NewStudyEndString'];

                $StudyEndInputID = '';
                $StudyEndInputDate = '';
                $NewStudyEndInputID = '';
                $NewStudyEndInputDate = '';
                
                if($StudyEndString){
                    $StudyEndString_array = explode('|',$StudyEndString);
                    $StudyEndInputID = $StudyEndString_array[0];
                    $StudyEndInputDate = $StudyEndString_array[1];
                }else if($NewStudyEndString){
                    $NewStudyEndString_array = explode('|',$NewStudyEndString);
                    $NewStudyEndInputID = $NewStudyEndString_array[0];
                    $NewStudyEndInputDate = $NewStudyEndString_array[1];
                }
                
                $LectureIsValid = false;

                $SQL3 = "SELECT * FROM Course WHERE LectureCode = '$LectureCode' AND ServiceType = '$ServiceType'";
                $QUERY3 = mysqli_query($connect, $SQL3);
                $Row3 = mysqli_fetch_array($QUERY3);

                if($Row3) {
                    $LectureIsValid = true;
                }
                
    ?>
    <tr>
        <td></td>
        <?
        $list_code = array("data");
        $list_cnt = array("data");
        $preCode;
        $preStart;
        $preEnd;
        
        $SQLA = "SELECT A.CompanyCode AS CompanyCodeA, count(A.CompanyCode) AS CodeCnt
                FROM(
                    SELECT  s.CompanyCode, c.CompanyName, s.LectureCode
                    FROM $JoinQuery
                    $where $where2
                    GROUP BY s.CompanyCode, s.LectureCode, s.ServiceType
                    ORDER BY c.CompanyName, f.ContentsName, s.ServiceType
                )A
                GROUP BY A.CompanyCode
                HAVING COUNT(A.CompanyCode) > 1";                    
        $QUERYA = mysqli_query($connect, $SQLA);
        while($ROWA = mysqli_fetch_array($QUERYA)){
            $CompanyCodeA = $ROWA['CompanyCodeA'];
            $CodeCnt      = $ROWA['CodeCnt'];
            //CompanyCode와 중복개수(CodeCnt)를 배열에 넣기
            array_push($list_code, $CompanyCodeA);
            array_push($list_cnt, $CodeCnt);
            
        }
        //현재 CompanyCode가 배열에 있는지 확인 
        if(in_array($CompanyCode, $list_code)){
            //CompanyCode가 배열의 몇번재 위치에 있는지 확인
            $cnt = array_search($CompanyCode, $list_code);
            //rowspan할 수를 배열에서 찾기
            $CodeCnt = $list_cnt[$cnt];
            
            //이전 CompanyCode와 현재CompanyCode가 일치하지 않은 경우에만 rowspan 사용
            if($preCode != $CompanyCode){
        ?>
        <td rowspan="<?=$CodeCnt?>"><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$CompanyName?><br><br><?=$CompanyCode?></a></td>
        <?
            }else{
                if($preStart != $LectureStart || $preEnd != $LectureEnd){
        ?>
        <td rowspan="<?=$CodeCnt?>"><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$CompanyName?><br><br><?=$CompanyCode?></a></td>
        <?                   
                }
            }
        }else{  
        ?>
        <td><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$CompanyName?><br><br><?=$CompanyCode?></a></td>
        <?
        }
        ?>
        <td><?=$ContentsName?></td>
        <td><?=$ServiceType_array[$ServiceType]?></td>
        <?
        $arrayCnt = 1;
        if(in_array($CompanyCode, $list_code)){
            $cnt = array_search($CompanyCode, $list_code);
            $CodeCnt = $list_cnt[$cnt];            
            if($preCode != $CompanyCode){
                $arrayCnt = $CodeCnt;
        ?>
        <td rowspan="<?=$CodeCnt?>">
        	<button type="button" name="studyFinishBtn" id="studyFinishBtn" class="btn round btn_LGray line" onclick="StudyFinish('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>','<?=$CompanyName?>','<?=$ServiceTypeA?>','<?=$arrayCnt?>')">교육종료</button>
        </td>
        <?
            }else{
                if($preStart != $LectureStart || $preEnd != $LectureEnd){
                    $arrayCnt = $CodeCnt;
        ?>
        <td rowspan="<?=$CodeCnt?>">
        	<button type="button" name="studyFinishBtn" id="studyFinishBtn" class="btn round btn_LGray line" onclick="StudyFinish('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>','<?=$CompanyName?>','<?=$ServiceTypeA?>','<?=$arrayCnt?>')">교육종료</button>
        </td>
        <? 
                }
            } 
        }else{
        ?>
        <td>
        	<button type="button" name="studyFinishBtn" id="studyFinishBtn" class="btn round btn_LGray line" onclick="StudyFinish('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>','<?=$CompanyName?>','<?=$ServiceTypeA?>','<?=$arrayCnt?>')">교육종료</button>
        </td>
        <?
        }
        ?>
        <td>
        <!-- 230905 : 마감처리시 점수확인 일괄 처리 -->
        <?if($StudyCount>0) {?>
            <?if($StudyEndString) {?>
                처리자 : <?=$StudyEndInputID?><br />
                처리일 : <?=$StudyEndInputDate?>
            <?}else if($NewStudyEndString){?>
                처리자 : <?=$NewStudyEndInputID?><br />
                처리일 : <?=$NewStudyEndInputDate?>
            <?}else{?>
            <button type="button" name="StudyEndBtn" id="StudyEndBtn" class="btn round btn_LGray line" onclick="StudyEndComplete('<?=$CompanyCode?>','<?=$ServiceType?>','<?=$LectureCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','StudyEnd')">마감</button>
            <?}?>
        <?}else{?>
        -
        <?}?>
        </td>
        <td>
        <? if($LectureIsValid && ($ServiceType == 1)) {?>
            <button type="button" name="CertBtn09" id="CertBtn09" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="location.href='receipt_confirm_excel.php?CompanyCode=<?=$CompanyCode?>&LectureStart=<?=$LectureStart?>&LectureEnd=<?=$LectureEnd?>&LectureCode=<?=$LectureCode?>'">수납 확인서</button><br>
            <button type="button" name="CertBtn05" id="CertBtn05" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="location.href='study_end_result01.php?CompanyCode=<?=$CompanyCode?>&LectureStart=<?=$LectureStart?>&LectureEnd=<?=$LectureEnd?>&LectureCode=<?=$LectureCode?>'">개설현황</button><br>
            <button type="button" name="CertBtn06" id="CertBtn06" class="btn round btn_LGray line" onclick="location.href='study_end_result02.php?CompanyCode=<?=$CompanyCode?>&LectureStart=<?=$LectureStart?>&LectureEnd=<?=$LectureEnd?>&LectureCode=<?=$LectureCode?>'">신청현황</button>
        <?}?>
        </td>
        <td>
            <button type="button" name="CertBtn04" id="CertBtn04" class="btn round btn_LGray line" onclick="StudyEndCertificatePrintPDF('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$ServiceType?>','<?=$LectureCode?>')">수료증</button>
        </td>
        <td>
        <? if($LectureIsValid) {
            if($ServiceType == 1){ ?>
                <button type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="StudyEndDocument02('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$ServiceType?>','<?=$LectureCode?>')">교육진행보고서</button><br>
            <?} ?>
                <button type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="StudyEndDocument03('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$ServiceType?>','<?=$LectureCode?>')">교육결과보고서</button><br>
        <?} ?>
        </td>           
        <td>
        <?if(($LectureIsValid &&($ServiceType == 1) && ($StudyCount>0))){?>
            <button type="button" name="CertBtn09" id="CertBtn10" class="btn round btn_LGray line" onclick="StudyEndDocumentPoll('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$LectureCode?>');">설문 결과</button>
        <?}?>
        	<button style="font-size:12px; min-width:5px; min-height:30px;" type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" onclick="StudyEndDocument('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$ServiceType?>','<?=$LectureCode?>')">결과</button>
        </td>
    </tr>
    <?
                   $preCode = $CompanyCode;
                   $preStart = $LectureStart;
                   $preEnd = $LectureEnd;
                }
            }
        }
    }else{
    ?>
    <tr>
        <td height="28" colspan="20">검색된 내용이 없습니다.</td>
    </tr>
    <? } ?> 
    </tr>
</table>

<!--페이지 버튼-->
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:15px;">
  <tr>
    <td align="center" valign="top"><?=$BLOCK_LIST?></td>
  </tr>
</table>
<?
mysqli_close($connect);
?>