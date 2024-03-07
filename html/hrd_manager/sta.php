<?
$MenuType = "F";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>접속 통계</h2>
<?
$timeinfo = getdate(time());

if($s_year=="") {
	$s_year = $timeinfo["year"];
}else{
	$s_year = $s_year;
}

if($s_mon=="") {
	$s_mon = $timeinfo["mon"];
}else{
	$s_mon = $s_mon;
}
?>
            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->
				<form name="search" method="get">
                <div class="searchPan">
                	<select name="s_year">
						<option value="2017" <?if($s_year== "2017") {?>selected<?}?>>2017</option>
						<option value="2018" <?if($s_year== "2018") {?>selected<?}?>>2018</option>
						<option value="2019" <?if($s_year== "2019") {?>selected<?}?>>2019</option>
						<option value="2020" <?if($s_year== "2020") {?>selected<?}?>>2020</option>
						<option value="2021" <?if($s_year== "2021") {?>selected<?}?>>2021</option>
						<option value="2022" <?if($s_year== "2022") {?>selected<?}?>>2022</option>
						<option value="2023" <?if($s_year== "2023") {?>selected<?}?>>2023</option>
						<option value="2024" <?if($s_year== "2024") {?>selected<?}?>>2024</option>
						<option value="2025" <?if($s_year== "2025") {?>selected<?}?>>2025</option>
						<option value="2026" <?if($s_year== "2026") {?>selected<?}?>>2026</option>
						<option value="2027" <?if($s_year== "2027") {?>selected<?}?>>2027</option>
						<option value="2028" <?if($s_year== "2028") {?>selected<?}?>>2028</option>
						<option value="2029" <?if($s_year== "2029") {?>selected<?}?>>2029</option>
						<option value="2030" <?if($s_year== "2030") {?>selected<?}?>>2030</option>
					</select> 년&nbsp;&nbsp;
					<select name="s_mon">
					<option value="1" <?if($s_mon== "1") {?>selected<?}?>>1</option>
					<option value="2" <?if($s_mon== "2") {?>selected<?}?>>2</option>
					<option value="3" <?if($s_mon== "3") {?>selected<?}?>>3</option>
					<option value="4" <?if($s_mon== "4") {?>selected<?}?>>4</option>
					<option value="5" <?if($s_mon== "5") {?>selected<?}?>>5</option>
					<option value="6" <?if($s_mon== "6") {?>selected<?}?>>6</option>
					<option value="7" <?if($s_mon== "7") {?>selected<?}?>>7</option>
					<option value="8" <?if($s_mon== "8") {?>selected<?}?>>8</option>
					<option value="9" <?if($s_mon== "9") {?>selected<?}?>>9</option>
					<option value="10" <?if($s_mon== "10") {?>selected<?}?>>10</option>
					<option value="11" <?if($s_mon== "11") {?>selected<?}?>>11</option>
					<option value="12" <?if($s_mon== "12") {?>selected<?}?>>12</option>
					</select> 월&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTl02">
				<B><?=$s_year?>년 <?=$s_mon?>월  접속통계입니다.</B>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="60px" />
                    <col width="70px" />
                    <col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
					<col width="" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>일</th>
					<th>총카운터</th>
					<th>0</th>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
					<th>11</th>
					<th>12</th>
					<th>13</th>
					<th>14</th>
					<th>15</th>
					<th>16</th>
					<th>17</th>
					<th>18</th>
					<th>19</th>
					<th>20</th>
					<th>21</th>
					<th>22</th>
					<th>23</th>
                  </tr>
					<?
					$SQL = "SELECT * FROM Sta WHERE s_year=$s_year AND s_mon=$s_mon ORDER BY s_day ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							$t_count = $hour_0 + $hour_1 + $hour_2 + $hour_3 + $hour_4 + $hour_5 + $hour_6 + $hour_7 + $hour_8 + $hour_9 + $hour_10 + $hour_11 + $hour_12 + $hour_13 + $hour_14 + $hour_15 + $hour_16 + $hour_17 + $hour_18 + $hour_19 + $hour_20 + $hour_21 + $hour_22 + $hour_23;

							$T_hour_0 = $T_hour_0 + $hour_0;
							$T_hour_1 = $T_hour_1 + $hour_1;
							$T_hour_2 = $T_hour_2 + $hour_2;
							$T_hour_3 = $T_hour_3 + $hour_3;
							$T_hour_4 = $T_hour_4 + $hour_4;
							$T_hour_5 = $T_hour_5 + $hour_5;
							$T_hour_6 = $T_hour_6 + $hour_6;
							$T_hour_7 = $T_hour_7 + $hour_7;
							$T_hour_8 = $T_hour_8 + $hour_8;
							$T_hour_9 = $T_hour_9 + $hour_9;
							$T_hour_10 = $T_hour_10 + $hour_10;
							$T_hour_11 = $T_hour_11 + $hour_11;
							$T_hour_12 = $T_hour_12 + $hour_12;
							$T_hour_13 = $T_hour_13 + $hour_13;
							$T_hour_14 = $T_hour_14 + $hour_14;
							$T_hour_15 = $T_hour_15 + $hour_15;
							$T_hour_16 = $T_hour_16 + $hour_16;
							$T_hour_17 = $T_hour_17 + $hour_17;
							$T_hour_18 = $T_hour_18 + $hour_18;
							$T_hour_19 = $T_hour_19 + $hour_19;
							$T_hour_20 = $T_hour_20 + $hour_20;
							$T_hour_21 = $T_hour_21 + $hour_21;
							$T_hour_22 = $T_hour_22 + $hour_22;
							$T_hour_23 = $T_hour_23 + $hour_23;
					?>
                  <tr>
					<td><?=$s_day?></td>
					<td><?=$t_count?></td>
					<td><?=$hour_0?></td>
					<td><?=$hour_1?></td>
					<td><?=$hour_2?></td>
					<td><?=$hour_3?></td>
					<td><?=$hour_4?></td>
					<td><?=$hour_5?></td>
					<td><?=$hour_6?></td>
					<td><?=$hour_7?></td>
					<td><?=$hour_8?></td>
					<td><?=$hour_9?></td>
					<td><?=$hour_10?></td>
					<td><?=$hour_11?></td>
					<td><?=$hour_12?></td>
					<td><?=$hour_13?></td>
					<td><?=$hour_14?></td>
					<td><?=$hour_15?></td>
					<td><?=$hour_16?></td>
					<td><?=$hour_17?></td>
					<td><?=$hour_18?></td>
					<td><?=$hour_19?></td>
					<td><?=$hour_20?></td>
					<td><?=$hour_21?></td>
					<td><?=$hour_22?></td>
					<td><?=$hour_23?></td>
                  </tr>
                  <?
						$m_count = $m_count + $t_count;
						}
					}
					?>
					<tr>
						<td>합계</td>
						<td><strong><?=number_format($m_count)?></strong></td>
						<td><?=$T_hour_0?></td>
						<td><?=$T_hour_1?></td>
						<td><?=$T_hour_2?></td>
						<td><?=$T_hour_3?></td>
						<td><?=$T_hour_4?></td>
						<td><?=$T_hour_5?></td>
						<td><?=$T_hour_6?></td>
						<td><?=$T_hour_7?></td>
						<td><?=$T_hour_8?></td>
						<td><?=$T_hour_9?></td>
						<td><?=$T_hour_10?></td>
						<td><?=$T_hour_11?></td>
						<td><?=$T_hour_12?></td>
						<td><?=$T_hour_13?></td>
						<td><?=$T_hour_14?></td>
						<td><?=$T_hour_15?></td>
						<td><?=$T_hour_16?></td>
						<td><?=$T_hour_17?></td>
						<td><?=$T_hour_18?></td>
						<td><?=$T_hour_19?></td>
						<td><?=$T_hour_20?></td>
						<td><?=$T_hour_21?></td>
						<td><?=$T_hour_22?></td>
						<td><?=$T_hour_23?></td>
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