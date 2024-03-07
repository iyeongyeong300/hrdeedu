<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$idx = Replace_Check($Seq);

//등록된 엑셀정보 불러오기
$Sql = "SELECT * FROM ContentsExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
//echo $Sql."<BR>";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Gubun = $Row['Gubun']; //차시구분
	$ContentsTitle = $Row['ContentsTitle']; //차시명
	$LectureTime = $Row['LectureTime']; //수강시간
	$Expl01 = $Row['Expl01']; //차시목표
	$Expl02 = $Row['Expl02']; //훈련내용
	$Expl03 = $Row['Expl03']; //학습활동
}

$Gubun = addslashes($Gubun);
$ContentsTitle = addslashes($ContentsTitle);
$LectureTime = addslashes($LectureTime);
$Expl01 = addslashes($Expl01);
$Expl02 = addslashes($Expl02);
$Expl03 = addslashes($Expl03);


$maxno = max_number("idx","Contents");

$Sql2 = "INSERT INTO Contents 
				(idx, Gubun, ContentsTitle, LectureTime, Expl01, Expl02, Expl03, Del, RegDate) 
				VALUES ($maxno, '$Gubun', '$ContentsTitle', $LectureTime, '$Expl01', '$Expl02', '$Expl03', 'N', NOW())";
$Row2 = mysqli_query($connect, $Sql2);

if(!$Row2) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}


//등록 처리가 완료되면 엑셀 업로드 내역 삭제
if($error_count<1) {
	$Sql_d = "DELETE FROM ContentsExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
	mysqli_query($connect, $Sql_d);
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "<font color='red'>오류</font>";
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "<font color='blue'>등록</font>";
}

echo $msg;

mysqli_close($connect);
?>