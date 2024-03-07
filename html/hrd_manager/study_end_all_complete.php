<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$LectureStart = Replace_Check($LectureStart); //시작일
$LectureEnd   = Replace_Check($LectureEnd);   //종료일
$CompanyName  = Replace_Check($CompanyName);  //사업주명
$ServiceType  = Replace_Check($ServiceType);  //환급여부

if($LectureStart) {
    $StudyEndWhere[] = "s.LectureStart='".$LectureStart."'";
}
if($LectureEnd) {
    $StudyEndWhere[] = "s.LectureEnd='".$LectureEnd."'";
}
if($CompanyName) {
    $StudyEndWhere[] = "c.CompanyName = '".$CompanyName."'";
}
if($ServiceType) {
    $StudyEndWhere[] = "s.ServiceType=".$ServiceType;
}else{
    $StudyEndWhere[] = "s.ServiceType IN (1,3,5,9)";
}
$StudyEndWhere = implode(" AND ",$StudyEndWhere);
if($StudyEndWhere) $StudyEndWhere = "WHERE $StudyEndWhere";

//[1]해당 조건(수강기간.사업주명)에 해당되는 데이터 확인
$Sql = "SELECT s.LectureCode , s.LectureStart , s.LectureEnd , s.ServiceType , c.CompanyName , c.CompanyCode 
        FROM Study s
        LEFT JOIN Company c on s.CompanyCode = c.CompanyCode
        $StudyEndWhere";
$QUERY = mysqli_query($connect, $Sql);
//[2]데이터 개수만큼 while문
while($ROW = mysqli_fetch_array($QUERY)){
    $LectureCodeA   = $ROW['LectureCode'];
    $LectureStartA  = $ROW['LectureStart'];
    $LectureEndA    = $ROW['LectureEnd'];
    $ServiceTypeA   = $ROW['ServiceType'];
    $CompanyNameA   = $ROW['CompanyName'];
    $CompanyCodeA   = $ROW['CompanyCode'];
    
    $StudyEndWhereA = " WHERE s.LectureStart = '$LectureStartA' and s.LectureEnd = '$LectureEndA' AND c.CompanyName = '$CompanyNameA' AND s.ServiceType = '$ServiceTypeA' AND s.LectureCode = '$LectureCodeA' ";
    
    //[3]해당 데이터가 마감테이블(StudyEnd)에 존재하는지 확인
    $SqlA = "SELECT  COUNT(*) FROM StudyEnd s LEFT JOIN Company c on s.CompanyCode = c.CompanyCode $StudyEndWhereA";
    $ResultA = mysqli_query($connect, $SqlA);
    $ROWA = mysqli_fetch_array($ResultA);
    $TOT_NO = $ROWA[0];
    
    if($TOT_NO>0) {
        //[3-1]존재할 경우, Update
        $Sql1= "UPDATE StudyEnd SET StudyEndInputID='$LoginAdminID', StudyEndInputDate=NOW(), ResultViewInputID='$LoginAdminID', ResultViewInputDate=NOW()
                WHERE LectureStart = '$LectureStartA' AND LectureEnd = '$LectureEndA' AND  CompanyCode = '$CompanyCodeA' ";
        $Row1 = mysqli_query($connect, $Sql1);
        
        $Sql2 = "UPDATE Study SET StudyEnd='Y', ResultView='Y' WHERE LectureStart = '$LectureStartA' AND LectureEnd = '$LectureEndA' AND  CompanyCode = '$CompanyCodeA' ";
        $Row2 = mysqli_query($connect, $Sql2);        
    }else{
        //[3-2]없을 경우, Insert
        $Sql1 = "INSERT INTO StudyEnd(CompanyCode, ServiceType, LectureCode, LectureStart, LectureEnd, StudyEndInputID, StudyEndInputDate, ResultViewInputID, ResultViewInputDate)
                VALUES('$CompanyCodeA', '$ServiceTypeA','$LectureCodeA','$LectureStartA', '$LectureEndA', '$LoginAdminID', NOW(), '$LoginAdminID', NOW());  ";
        $Row1 = mysqli_query($connect, $Sql1);
        
        $Sql2 = "UPDATE Study SET StudyEnd='Y', ResultView='Y' WHERE LectureStart = '$LectureStartA' AND LectureEnd = '$LectureEndA' AND CompanyCode = '$CompanyCodeA' ";
        $Row2 = mysqli_query($connect, $Sql2);
    }
}


//쿼리 실패시 에러카운터 증
if(!$Row1) {
    $error_count++;
}
if(!$Row2) {
    $error_count++;
}

//error
if($error_count>0) {
    mysqli_query($connect, "ROLLBACK");
    echo "N";
}else{
    mysqli_query($connect, "COMMIT");
    echo "Y";
}

mysqli_close($connect);
?>