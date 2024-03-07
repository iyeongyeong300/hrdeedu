<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$LectureCode = Replace_Check($LectureCode);
$Study_Seq = Replace_Check($Study_Seq);
$Chapter_Seq = Replace_Check($Chapter_Seq);
$Contents_idx = Replace_Check($Contents_idx);
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
	<tr>
		<th>순번</th>
		<th>전체 진도</th>
		<th>차시 진도</th>
		<th>학습시간</th>
		<th>수강 IP</th>
		<th>수강시간</th>
		<th>최종 강의 페이지</th>
		<th>트리거 전송 여부</th>
	</tr>
	<?
	$i = 1;
	$SQL = "SELECT * FROM ProgressLog WHERE ID='$ID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND Contents_idx=$Contents_idx ORDER BY RegDate ASC";
	//echo $SQL;
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		while($ROW = mysqli_fetch_array($QUERY))
		{
		extract($ROW);

		$StudyTime2 = Sec_To_His($StudyTime);
	?>
	<tr>
		<td ><?=$i?></td>
		<td><?=$TotalProgress?>%</td>
		<td><?=$Progress?>%</td>
		<td ><?=$StudyTime2?></td>
		<td ><?=$UserIP?></td>
		<td ><?=$RegDate?></td>
		<td ><?=$LastStudy?></td>
		<td ><?=$TriggerYN?></td>
	</tr>
	<?
	$i++;
		}
	}else{
	?>
	<tr>
		<td align="center" colspan="8">학습 내역이 없습니다.</td>
	</tr>
	<? } ?>
</table>
<?
mysqli_close($connect);
?>