<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일
$SubmitFunction = Replace_Check($SubmitFunction); //submit할 함수명


//영업사원의 경우 본인과 하부 조직의 내용만 체크====================================================================================================================
if($LoginAdminDept=="B") {

	$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE ID='$LoginAdminID'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$DeptString = $Row['DeptString'];
		$Dept_idx = $Row['Dept_idx'];
	}

	if($DeptString) {

	//현재 해당 조직이 하부에 조직이 존재하면 팀장급 이상이므로 하부 조직 모두, 하부조직이 없으면 말단 영업사원이므로 본인것만 나오게한다.
		$Sql2 = "SELECT COUNT(*) FROM DeptStructure WHERE DeptString LIKE '$DeptString%'";
		$Result2 = mysqli_query($connect, $Sql2);
		$Row2 = mysqli_fetch_array($Result2);

		$DeptCount = $Row2[0];

		if($DeptCount>1) { //하부조직이 있는 경우

			$Dept_String = "";
			$SQL = "SELECT REPLACE(DeptString,'$DeptString','') AS DeptString FROM DeptStructure WHERE DeptString LIKE '$DeptString%' ORDER BY Deep ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					if($ROW['DeptString']) {
						$Dept_String = $Dept_String.$ROW['DeptString'];
					}
				}
			}

			$DeptString_array = explode("|",$Dept_String);
			$DeptString_array = array_unique($DeptString_array);
			$DeptString_array_count = count($DeptString_array);

			$Dept_idx_query = "";
			$i = 0;
			foreach($DeptString_array as $DeptString_array_value) {

				if($DeptString_array_value) {
					if(!$Dept_idx_query) {
						$Dept_idx_query = "c.Dept_idx=$DeptString_array_value";
					}else{
						$Dept_idx_query = $Dept_idx_query." OR c.Dept_idx=$DeptString_array_value";
					}
				}
			$i++;
			}

			$Dept_idx_query  = " AND (c.Dept_idx=".$Dept_idx." OR ".$Dept_idx_query.")";

			$whereDept = $Dept_idx_query;

		}else{ //하부조직이 없는 경우
			$whereDept = " AND b.SalesManager='".$LoginAdminID."'";
		}

	}else{

		$whereDept = " AND b.SalesManager='".$LoginAdminID."'";

	}
}

//영업사원 ==========================================================================================================================================================
?>
&nbsp;<select name="CompanyCode" id="CompanyCode" <?if($SubmitFunction) {?>onchange="<?=$SubmitFunction?>"<?}?>>
	<option value="">-- 사업주 선택 --</option>
<?
	$SQL = "SELECT DISTINCT(a.CompanyCode) AS CompanyCode, b.CompanyName AS CompanyName FROM Study AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode LEFT OUTER JOIN StaffInfo AS c ON b.SalesManager=c.ID WHERE a.LectureStart='".$LectureStart."' AND a.LectureEnd='".$LectureEnd."' ".$whereDept." ORDER BY b.CompanyName ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY))
		{
	?>
	<option value="<?=$Row['CompanyCode']?>"><?=$Row['CompanyName']?>&nbsp;|&nbsp;<?=$Row['CompanyCode']?>&nbsp;</option>
	<?
		$i++;
		}
	}
	?>
</select>
<?
mysqli_close($connect);
?>