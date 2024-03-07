<?
//카카오톡 DB연결
$db_kakao['host'] ="112.175.249.12";
$db_kakao['user'] = "hrd";
$db_kakao['pass'] = "qwer1234!@#$";
$db_kakao['db'] = "hrd";

$connect_kakao = mysqli_connect($db_kakao['host'], $db_kakao['user'], $db_kakao['pass'], $db_kakao['db']);
mysqli_query($connect_kakao,"SET NAMES utf8");

if (!$connect_kakao) {
	echo "<BR>Error: Unable to connect to KAKAO MySQL." . PHP_EOL;
	echo "<BR>Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	echo "<BR>Debugging error: " . mysqli_connect_error() . PHP_EOL;
	exit;
}
?>