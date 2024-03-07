<?
$MenuType = "G";
?>
<? include "./include/include_top.php"; ?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#LectureCode").select2();
	changeSelect2Style();
});
//-->
</script>       
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>메인페이지 과정 관리</h2>

            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->

				<form name="DeleteForm" method="POST" action="main_course_script.php" target="ScriptFrame">
					<input type="hidden" name="mode" value="Delete">
					<input type="hidden" name="idx">
					<input type="hidden" name="LectureCode">
				</form>
				<form name="AddForm" method="POST" action="main_course_script.php" target="ScriptFrame">
					<input type="hidden" name="mode" id="mode" value="Add">
				<table border="0" width="90%">
					<tr>
						<td align="left">
						<select name="LectureCode" id="LectureCode">
							<option value="">번호 | 과정코드 | 과정구분 | 서비스 구분 | 과정명</option>
							<?
							$i = 1;
							$SQL = "SELECT * FROM Course AS a WHERE a.PackageYN='N' AND a.Del='N' AND a.UseYN='Y' AND (SELECT COUNT(idx) FROM MainCourseList WHERE LectureCode=a.LectureCode) < 1 ORDER BY a.ContentsName ASC";
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY))
							{
								while($ROW = mysqli_fetch_array($QUERY))
								{

									if($ROW['ctype']=="A") { 
										$ctype_view = "사업자";
									}else{ 
										$ctype_view = "근로자";
									}

									if($ROW['ctype'] == "A") {
										$ServiceType2 = $ServiceTypeCourse_array[$ROW['ServiceType']];
									}
									if($ROW['ctype'] == "B") {
										$ServiceType2 = $ServiceTypeCourse2_array[$ROW['ServiceType']];
									}
							?>
							<option value="<?=$ROW['LectureCode']?>"><?=$i?> | <?=$ROW['LectureCode']?> | <?=$ctype_view?> | <?=$ServiceType2?> | <?=$ROW['ContentsName']?></option>
							<?
								$i++;
								}
							}
							?>
						</select>&nbsp;&nbsp;<input type="button" name="Addbtn" value="과정 추가하기" class="btn_inputSm01" onclick="MainCourseAdd();">
						</td>
					</tr>
				</table>
				</form>
                <!--목록 -->
				<script type="text/javascript">
				$(document).ready(function() {
					// Initialise the table
					$("#table-1").tableDnD();
				});
				</script>
				<div class="btnAreaTl02">
					<input type="button" name="Btn" id="Btn" value="정렬하기" class="btn_inputLine01" onclick="MainCourseOrderBy();">&nbsp;&nbsp;&nbsp;[각행을 상하로 드래그하여 정렬하세요.]
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="40px" />
                    <col width="80px" />
                    <col width="100px" />
                    <col width="80px" />
					<col width="100px" />
					<col width="" />
					<col width="100px" />
					<col width="80px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>정렬순서</th>
					<th>과정 코드</th>
					<th>과정 구분</th>
					<th>서비스 구분</th>
					<th>과&nbsp;&nbsp;정&nbsp;&nbsp;명</th>
					<th>사이트 노출</th>
					<th>삭제</th>
                  </tr>
				  </table>
				  <form name="OrderByForm" method="POST" action="main_course_script.php" target="ScriptFrame">
					<input type="hidden" name="mode" id="mode" value="OrderByProc">
					<input type="hidden" name="idx_value" id="idx_value">
				  <table id="table-1" width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
				   <colgroup>
                    <col width="40px" />
                    <col width="80px" />
                    <col width="100px" />
                    <col width="80px" />
					<col width="100px" />
					<col width="" />
					<col width="100px" />
					<col width="80px" />
                  </colgroup>
					<?
					##-- 검색 조건
					$where = array();

					$where[] = "b.PackageYN='N'";
					$where[] = "b.Del='N'";
					//$where[] = "b.UseYN='Y'";

					$where = implode(" AND ",$where);
					if($where) $where = "WHERE $where";


					##-- 정렬조건
					if($orderby=="") {
						$str_orderby = "ORDER BY a.OrderByNum ASC, a.idx ASC";
					}else{
						$str_orderby = "ORDER BY $orderby";
					}

					$SQL = "SELECT a.*, b.ServiceType, b.ContentsName, b.ctype, b.Del, b.UseYN FROM 
								MainCourseList AS a 
								LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
								$where $str_orderby";
					//echo $SQL;
					$i = 1;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
                  <tr id="<?=$i?>">
					<td><?=$i?><input type="hidden" name="course_idx" id="course_idx" value="<?=$idx?>"></td>
					<td><?=$OrderByNum?></td>
					<td><strong><?=$LectureCode?></strong></td>
					<td>
					<?if($ctype == "A") {?>
					<?=$ServiceTypeCourse_array[$ServiceType]?>
					<?}?>
					<?if($ctype == "B") {?>
					<?=$ServiceTypeCourse2_array[$ServiceType]?>
					<?}?>
					</td>
					<td><?if($ctype=="A") { echo "사업자";}else{ echo "근로자";}?></td>
					<td align="left"><?=$ContentsName?></td>
					<td><?=$UseYN_array[$UseYN]?></td>
					<td><input type="button" name="Deletebtn" value="삭제" class="btn_inputSm01" onclick="MainCourseDelete('<?=$idx?>','<?=$LectureCode?>');"></td>
                  </tr>
                  <?
						$i++;
						}
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 과정이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
				</form>
 

                <div class="btnAreaTl02">
					<input type="button" name="Btn" id="Btn" value="정렬하기" class="btn_inputLine01" onclick="MainCourseOrderBy();">
              	</div>
            	<!-- 버튼 -->

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>


<DIV style='BORDER-RIGHT: #a2a2a2 1px solid; PADDING-RIGHT: 5px; BORDER-TOP: #a2a2a2 1px solid; PADDING-LEFT: 5px; FILTER: alpha(opacity=100); PADDING-BOTTOM: 5px; BORDER-LEFT: #a2a2a2 1px solid; PADDING-TOP: 5px; BORDER-BOTTOM: #a2a2a2 1px solid; POSITION: absolute; BACKGROUND-COLOR: white; left:300px; top: 90px;z-index:100; visibility: hidden;' id='popup'><table border='0' align='center' cellpadding='0' cellspacing='0' onmousedown="select('popup')"><tr><td><img src='/popup/upload_popup/' border='0' name="popupimg"></td></tr><tr><td height='24' align='center' valign='top' bgcolor='707070'><table width='98%'  border='0' cellspacing='0' cellpadding='0'><tr><td align='right'><font color='#EAEAEA'>오늘 하루 창 열지 않기&nbsp;&nbsp;&nbsp;<a href='javascript:CloseLayer()'><img src='./images/close01.gif' border='0' align='absmiddle' ></a></font></td></tr></table></td></tr></table></div>