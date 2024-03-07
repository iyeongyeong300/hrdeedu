<?
$MenuType = "D";
?>
<? include "./include/include_top.php"; ?>

        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>과정 카테고리</h2>

            <div class="conZone">
            	<!-- ## START -->

                <!-- 입력 -->
				<div class="btnAreaTl02">
					<input type="button" value="1차 카테고리 추가" class="btn_inputLine01" onclick="CourseAdd('','0','1','New');">
              	</div>

				<?
				$SQL = "SELECT * FROM CourseCategory WHERE Deep=1 AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY))
				{
					while($ROW = mysqli_fetch_array($QUERY))
					{

						$idx = $ROW['idx'];
				?>
				<table border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;margin-bottom:10px;">
				<tr>
				  <td width="30"><img src="images/sub_title2.gif" align="absmiddle"></td>
				  <td><span class="fs12 fc000B">[ <?=$CategoryType_array[$ROW['CategoryType']]?> ]</span> <span class="fs16 redB"><?=$ROW['CategoryName']?></span><?if($ROW['UseYN']=="N") {?>&nbsp;&nbsp;<span class="fs12 redB">[미사용]</span><?}?></td>
				  <td>&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="button"  value="수정" class="btn_inputSm01" onclick="CourseAdd('<?=$ROW['idx']?>','<?=$ROW['ParentCategory']?>','<?=$ROW['Deep']?>','Edit');">&nbsp;
				  <input type="button"  value="하부 카테고리 추가" class="btn_inputSm03" onclick="CourseAdd('','<?=$ROW['idx']?>','<?=$ROW['Deep']+1?>','New');">
					</td>
				</tr>
			  </table>

                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                  <tr>
                    <td>
					<?
					$SQL2 = "SELECT * FROM CourseCategory WHERE Deep=2 AND Del='N' AND ParentCategory=$idx ORDER BY OrderByNum ASC, idx ASC";
					$QUERY2 = mysqli_query($connect, $SQL2);
					if($QUERY2 && mysqli_num_rows($QUERY2))
					{
					?>
						<TABLE border="0" style="border-top:0px; border-right:0px; border-bottom:0px; border-left:0px">
							<TR>
					<?
						$i = 1;
						while($ROW2 = mysqli_fetch_array($QUERY2))
						{
					?>
								<TD  height="30" style="border-top:0px; border-right:0px; border-bottom:0px; border-left:0px">
									<img src="images/none.gif" align="absmiddle" width="10"><?=$ROW2['OrderByNum']?>. <?=$ROW2['CategoryName']?><?if($ROW2['UseYN']=="N") {?>&nbsp;&nbsp;<span class="fs12 redB">[미사용]</span><?}?>
									&nbsp;&nbsp;<input type="button"  value="수정" class="btn_inputSm01" onclick="CourseAdd('<?=$ROW2['idx']?>','<?=$ROW2['ParentCategory']?>','<?=$ROW2['Deep']?>','Edit');">
								</TD>
					<?
					if($i%5==0) {
					?>
						</TR>
						<TR>
					<?
					}
					?>
					<?
						$i++;
						}
					?>
							</TR>
						</TABLE>
					<?
					}else{
						echo "<CENTER>등록된 하부 카테고리가 없습니다.</CENTER>";
					}
					?>
					</td>
                  </tr>
                </table>
				<?
					}
				}
				?>
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