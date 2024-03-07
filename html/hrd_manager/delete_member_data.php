
<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

if(!$connect){
    die("Connection failed : ". mysqli_connect_error());
}

$id = $_POST['id'];
$adminId = $_POST['adminId'];
$reason = mysqli_real_escape_string($connect, $_POST['reason']);

$insertSql =    "INSERT INTO MemberDeletionLog
                SELECT *, '$adminId' AS deletedBy, NOW() AS deletedDate, '$reason' AS reason4Deletion
                FROM Member
                WHERE id='$id'";
$row = mysqli_query($connect, $insertSql);

if($row){
    $deleteSql = "DELETE FROM Member WHERE id='$id'";
    $deleteRow = mysqli_query($connect, $deleteSql);
    if($deleteRow){
?>
<script type="text/javascript">
	alert("삭제되었습니다.");
	location.href='./member.php';
</script>
<?
    }else{ //delete는 안되고 insert문만 성공한 경우
?>
<script type="text/javascript">
	alert("삭제 중 오류가 발생했습니다. 다시 시도해주세요.");
	location.href=history.go(-1);
</script>
<?
    }
}else{//delete, insert 모두 실패한 경우
?>
<script type="text/javascript">
	alert("오류가 발생했습니다. 다시 시도해주세요.");
	location.href=history.go(-1);
</script>
<?
}

mysqli_close($connect);
?>