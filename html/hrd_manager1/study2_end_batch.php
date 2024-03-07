<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$seq_value = Replace_Check($seq_value);

$seq_array = explode('|',$seq_value);


$where = array();

foreach($seq_array as $seq) {
	$where[] = "a.Seq=$seq";
}


$where = implode(" OR ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.Seq DESC";

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
				a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, a.PackageRef, a.PackageGroupNo, a.OpenChapter, a.SalesID, 
				b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, 
				c.Name, c.Depart, 
				d.CompanyName, 
				e.Name AS SalesName 
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
						LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
						LEFT OUTER JOIN StaffInfo AS e ON a.SalesID=e.ID 
					";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title>:: <?=$SiteName?> ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
<!--
var totalcount = 0;
var batching = false;

function ChangeBatch() {

	totalcount = $("input[name='check_seq']").length; //전체 건수
	var checkedbox_count = $(":checkbox[name='check_seq']:checked").length; //체크된 건수

	if(totalcount<1) {
		alert('검색된 항목이 없습니다.');
		return;
	}
	if(checkedbox_count<1) {
		alert('선택된 항목이 없습니다.');
		return;
	}


	$("#ProcesssRatio").show();
	Yes = confirm('체크된 항목을 수강마감처리 하시겠습니까?\n\n처리작업은 1번항목부터 '+totalcount+'번 항목까지 순차적으로 진행됩니다.\n\n작업이 완료 될 때 까지 기다려 주세요.\n\n\n\n작업을 진행하시려면 [확인]을 클릭하세요.');
	if(Yes==true) {
		batching = true;
		BatchProcess(0);
	}else{
		batching = false;
		$("#ProcesssRatio").hide();
	}

}

function BatchProcess(i) {

	ProcesssRatioCal = i / totalcount * 100;
	var newNum = new Number(ProcesssRatioCal);
	ProcesssRatioCal = newNum.toFixed(2);
	$("#ProcesssRatio").html("<span style='font-size:25px;'>진행률</span> "+ProcesssRatioCal+" %");

	if(i<totalcount) {

		i2 = i + 1;

		if ($("input:checkbox[id='check_seq_"+i+"']").is(":checked") == false){

			$("div[id='status']:eq("+i+")").html('제외');
			setTimeout('BatchProcess('+i2+')', 200);

		}else{

			$("div[id='status']:eq("+i+")").load('./study2_end_batch_process.php',
			{ 'Seq': $("input:checkbox[id='check_seq_"+i+"']").val()
			});

			setTimeout(function(){
				BatchProcess(i2);
			},200);

		}

	}else{
		batching = false;

		opener.StudySearch2(1);
		alert("수강마감 일괄처리가 완료되었습니다.");
		$("#ProcesssRatio").hide();
	}


}

$(document).ready(function(){

	$(document).bind("scroll", function() {
		if(batching==true) {
			ProcesssRatioTop = $(window).scrollTop() + 300;
			$("div[id='ProcesssRatio']").animate({ top : ProcesssRatioTop }, 200);
		}
	});

});

function CheckAll() {

	totalcount = $("input[name='check_seq']").length; //전체 건수

	for(i=0;i<totalcount;i++) {
		if($("#check_All").is(":checked")==true) {
			$("input[name='check_seq']:eq("+i+")").prop('checked',true);
		}else{
			$("input[name='check_seq']:eq("+i+")").prop('checked',false);
		}
	}

}

//-->
</script>
</HEAD>
<BODY leftmargin="0" topmargin="0">

<div id="wrap">

    
    <!-- Content -->
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>수강마감 일괄처리</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                <div class="tl pt5">
					<span class="fs14 fc333"><img src="images/sub_title.gif" align="absmiddle"> 일괄변경 대상 | 변경을 원하지 않는 항목은 체크를 해제하세요.</span>
				</div>

				<P style="text-align:right"><input type="button" value="체크항목 수강마감 처리하기" class="btn_inputBlue01"  onclick="ChangeBatch()"><P>

                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <tr>
                    <th><input type="checkbox" name="check_All" id="check_All" value="Y" checked onclick="CheckAll();" style="width:17px; height:17px; background:none; border:none;"></th>
					<th>번호</th>
					<th>ID</th>
					<th>성명</th>
					<th>기간</th>
					<th>실시회차</th>
					<th>과정명</th>
					<th>진도율 (%)</th>
					<th>수료여부</th>
					<th>개설용도</th>
					<th>영업담당자</th>
					<th>수강마감</th>
					<th>진행상태</th>
                  </tr>
					<?
					$i = 1;
					$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							switch($PassOK) {
								case "N":
									$PassOK_View = "미수료";
								break;
								case "Y":
									$PassOK_View = "<span class='fcSky01B'>수료</span>";
								break;
								default :
									$PassOK_View = "";
							}

							if($StudyEnd=="Y") {
								$StudyEndView = "<font color='blue'>수강 마감</font>";
								$checked = "";
							}else{
								$StudyEndView = "<font color='red'>진행중</font>";
								$checked = "checked";
							}
					?>
                  <tr>
                    <td><input type="checkbox" name="check_seq" id="check_seq_<?=$i-1?>" value="<?=$Seq?>" checked style="width:17px; height:17px; background:none; border:none;" /></td>
					<td><?=$i?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
					<td><?=$OpenChapter?></td>
					<td align="left"><?if($PackageRef>0) {?><span class="fcOrg01B">[패키지 No. <?=$PackageGroupNo?>] </span><?}?><?=$ContentsName?></td>
					<td><?=$Progress?>%</td>
					<td><?=$PassOK_View?></td>
					<td><?=$ServiceType_array[$ServiceType]?></td>
					<td><?=$SalesName?> (<?=$SalesID?>)</td>
					<td><?=$StudyEndView?></td>
					<td><div id="status">-</div></td>
                  </tr>
					<?
						$i++;
						}
					}else{
					?>
					<tr>
						<td height="28" align="center" colspan="20">검색된 내용이 없습니다.</td>
					</tr>
					<? } ?>
					</table>
					</td>
                  </tr>
                </table>

				<div class="btnAreaTr02">
					<input type="button" value="닫  기" onclick="self.close();" class="btn_inputLine01">
                </div>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>

<div id="ProcesssRatio" style="position:absolute; left:500px;top:400px; width:400px; background-color:#fff;font-size:60px; padding-top:15px;padding-bottom:15px; text-align:center; opacity:0.7; display:none"><span style="font-size:25px;">진행률</span> 0.00 %</div>
</body>
</html>
<?
mysqli_close($connect);
?>