<?
include "./include/include_function.php"; //DB연결 및 각종 함수 정의

if($UserDevice=="Mobile") { //모바일인 경우
	$url = "http://m.hrdeedu.com";
}else{ //PC인 경우
//	$url = "/main/main.php";
	$url = "/new/main/main.html";
}

header( "Location: $url" );
?>
