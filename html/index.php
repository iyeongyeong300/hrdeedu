<?
include "./include/include_function.php"; //DB���� �� ���� �Լ� ����

if($UserDevice=="Mobile") { //������� ���
	$url = "http://m.hrdeedu.com";
}else{ //PC�� ���
//	$url = "/main/main.php";
	$url = "/new/main/main.html";
}

header( "Location: $url" );
?>
