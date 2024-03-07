<?
$MenuType = "A";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>관리자/영업자/첨삭강사 카테고리</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
            
                <!--목록 -->
				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">관리자</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Btn" id="Btn" value="하부 카테고리 추가" class="btn_inputLine01" onclick="DeptAdd('A','','0','0','','New');">
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 mt20">
                  <tr>
                    <td align="left">
					<?
					$SQL = "SELECT *, (SELECT COUNT(idx) FROM DeptStructure WHERE ParentCategory=a.idx AND Dept='A' AND SiteCode='$SiteCode') AS SubCount FROM DeptStructure AS a WHERE Dept='A' AND Deep=1 AND SiteCode='$SiteCode' ORDER BY idx ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
					?>
						<TABLE border="0" style="border:0px">
					<?
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
							<TR>
								<TD style="font-size:15px; border:0px">
									<img src="images/Folder.gif" align="absmiddle" id="Folder<?=$idx?>">
								</TD>
								<TD style="font-size:15px; border:0px">
									<?if($SubCount>0){?>
									<A HREF="Javascript:DeptSubCategoryView('<?=$Dept?>','<?=$Dept?>_Category<?=$idx?>',<?=$idx?>,<?=$Deep+1?>)"  style="font-size:15px"><?=$DeptName?>&nbsp;[<?=$SubCount?>]</A>
									<?}else{?>
									<?=$DeptName?>
									<?}?>
								</TD>
								<TD style="font-size:15px; border:0px">
									&nbsp;&nbsp;<input type="button" value="수정" class="btn_inputSm01" onclick="DeptAdd('<?=$Dept?>','<?=$idx?>','<?=$ParentCategory?>','<?=$Deep?>','<?=$DeptString?>','Edit');">&nbsp;<input type="button" value="하부 카테고리 추가" class="btn_inputSm03" onclick="DeptAdd('<?=$Dept?>','<?=$idx?>','<?=$idx?>','<?=$Deep?>','<?=$DeptString?>','New');">
								</TD>
							</TR>
							<TR>
								<TD colspan="3" style="border:0px"><DIV id="<?=$Dept?>_Category<?=$idx?>" style="display:none"></DIV></TD>
							</TR>
					<?
						}
					?>
						</TABLE>
					<?
					mysqli_free_result($QUERY);
					}else{
						echo "<CENTER>등록된 관리자가 없습니다.</CENTER>";
					}
					?>
					</td>
                </table>
                

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">영업자</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Btn" id="Btn" value="하부 카테고리 추가" class="btn_inputLine01" onclick="DeptAdd('B','','0','0','','New');">
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 mt20">
                  <tr>
                    <td align="left">
					<?
					$SQL = "SELECT *, (SELECT COUNT(idx) FROM DeptStructure WHERE ParentCategory=a.idx AND Dept='B' AND SiteCode='$SiteCode') AS SubCount FROM DeptStructure AS a WHERE Dept='B' AND Deep=1 AND SiteCode='$SiteCode' ORDER BY idx ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
					?>
						<TABLE border="0" style="border:0px">
					<?
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
							<TR>
								<TD style="font-size:15px; border:0px">
									<img src="images/Folder.gif" align="absmiddle" id="Folder<?=$idx?>">
								</TD>
								<TD style="font-size:15px; border:0px">
									<?if($SubCount>0){?>
									<A HREF="Javascript:DeptSubCategoryView('<?=$Dept?>','<?=$Dept?>_Category<?=$idx?>',<?=$idx?>,<?=$Deep+1?>)"  style="font-size:15px"><?=$DeptName?>&nbsp;[<?=$SubCount?>]</A>
									<?}else{?>
									<?=$DeptName?>
									<?}?>
								</TD>
								<TD style="font-size:15px; border:0px">
									&nbsp;&nbsp;<input type="button" value="수정" class="btn_inputSm01" onclick="DeptAdd('<?=$Dept?>','<?=$idx?>','<?=$ParentCategory?>','<?=$Deep?>','<?=$DeptString?>','Edit');">&nbsp;<input type="button" value="하부 카테고리 추가" class="btn_inputSm03" onclick="DeptAdd('<?=$Dept?>','<?=$idx?>','<?=$idx?>','<?=$Deep?>','<?=$DeptString?>','New');">
								</TD>
							</TR>
							<TR>
								<TD colspan="3" style="border:0px"><DIV id="<?=$Dept?>_Category<?=$idx?>" style="display:none"></DIV></TD>
							</TR>
					<?
						}
					?>
						</TABLE>
					<?
					mysqli_free_result($QUERY);
					}else{
						echo "<CENTER>등록된 영업자가 없습니다.</CENTER>";
					}
					?>
					</td>
                </table>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">첨삭강사</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Btn" id="Btn" value="하부 카테고리 추가" class="btn_inputLine01" onclick="DeptAdd('C','','0','0','','New');">
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 mt20">
                  <tr>
                    <td align="left">
					<?
					$SQL = "SELECT *, (SELECT COUNT(idx) FROM DeptStructure WHERE ParentCategory=a.idx AND Dept='C' AND SiteCode='$SiteCode') AS SubCount FROM DeptStructure AS a WHERE Dept='C' AND Deep=1 AND SiteCode='$SiteCode' ORDER BY idx ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
					?>
						<TABLE border="0" style="border:0px">
					<?
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
							<TR>
								<TD style="font-size:15px; border:0px">
									<img src="images/Folder.gif" align="absmiddle" id="Folder<?=$idx?>"> 
								</TD>
								<TD style="font-size:15px; border:0px">
									<?if($SubCount>0){?>
									<A HREF="Javascript:DeptSubCategoryView('<?=$Dept?>','<?=$Dept?>_Category<?=$idx?>',<?=$idx?>,<?=$Deep+1?>)"  style="font-size:15px"><?=$DeptName?>&nbsp;[<?=$SubCount?>]</A>
									<?}else{?>
									<?=$DeptName?>
									<?}?>
								</TD>
								<TD style="font-size:15px; border:0px">
									&nbsp;&nbsp;<input type="button" value="수정" class="btn_inputSm01" onclick="DeptAdd('<?=$Dept?>','<?=$idx?>','<?=$ParentCategory?>','<?=$Deep?>','<?=$DeptString?>','Edit');">&nbsp;<input type="button" value="하부 카테고리 추가" class="btn_inputSm03" onclick="DeptAdd('<?=$Dept?>','<?=$idx?>','<?=$idx?>','<?=$Deep?>','<?=$DeptString?>','New');">
								</TD>
							</TR>
							<TR>
								<TD style="border:0px" colspan="3"><DIV id="<?=$Dept?>_Category<?=$idx?>" style="display:none"></DIV></TD>
							</TR>
					<?
						}
					?>
						</TABLE>
					<?
					mysqli_free_result($QUERY);
					}else{
						echo "<CENTER>등록된 첨삭강사가 없습니다.</CENTER>";
					}
					?>
					</td>
                </table>

				<br><br><br><br>
				<script type="text/javascript">
				$(document).ready(function() {
					// Initialise the table
					$("#table-1").tableDnD();
				});
				</script>
				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">영업부서 정렬</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Btn" id="Btn" value="정렬 하기" class="btn_inputLine01" onclick="DeptOrderBy();">
              	</div>

				<form name="OrderByForm" method="POST" action="dept_category_orderby.php" target="ScriptFrame">
				<input type="hidden" name="idx_value" id="idx_value">
				<table id="table-1" width="100%" cellpadding="0" cellspacing="0" class="list_ty01 mt20">
					<?
					$i = 1;
					$SQL = "SELECT *, 
					(SELECT COUNT(idx) FROM DeptStructure WHERE DeptString LIKE CONCAT(a.DeptString,'%') AND Dept='B' AND idx!=a.idx) AS SubCount,  
					(SELECT COUNT(idx) FROM StaffInfo WHERE Dept_idx=a.idx AND Dept='B' AND UseYN='Y' AND Del='N') AS SalesCount 
					FROM DeptStructure AS a WHERE a.Dept='B' ORDER BY a.OrderByNum ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							switch($Deep) {
								case 1:
									$bgcolor = "#f2f2f2";
								break;
								case 2:
									$bgcolor = "#ffffe1";
								break;
								case 3:
									$bgcolor = "#ffdddd";
								break;
								case 4:
									$bgcolor = "#d9d9ff";
								break;
								case 5:
									$bgcolor = "#d9ecff";
								break;
								case 6:
									$bgcolor = "#d9ffd9";
								break;
								case 7:
									$bgcolor = "#e6ffe6";
								break;
								case 8:
									$bgcolor = "#ebf5f5";
								break;
								case 9:
									$bgcolor = "#e6f2f2";
								break;
								case 9:
									$bgcolor = "#d7ebff";
								break;

								default:
									$bgcolor = "#FFFFFF";
							}
					?>
					<tr>
						<td id="<?=$i?>" align="center" bgcolor="<?=$bgcolor?>" width="80"><?=$Deep?></td>
						<td bgcolor="<?=$bgcolor?>" width="300">&nbsp;&nbsp;<?=$DeptName?></td>
						<td align="center" bgcolor="<?=$bgcolor?>" width="150"><?=$SubCount?></td>
						<td align="center" bgcolor="<?=$bgcolor?>" width="150"><?=$SalesCount?></td>
						<td align="center" ><input type="hidden" name="sales_idx" id="sales_idx" value="<?=$idx?>"></td>
					</tr>
					<?
						$i++;
						}
						mysqli_free_result($QUERY);
					}
					?>
					<tr id="<?=$i?>" bgcolor="#FFFFFF">
						<td colspan="5">&nbsp;</td>
					</tr>
				</table>
				</form>
 
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>