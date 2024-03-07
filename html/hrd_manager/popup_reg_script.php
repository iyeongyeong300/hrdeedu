<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

$mode = Replace_Check($mode);
$idx = Replace_Check($idx);
$UseYN = Replace_Check($UseYN);
$EndDate = Replace_Check($EndDate);
$Title = Replace_Check($Title);
$ImgWidth = Replace_Check($ImgWidth);
$ImgHeight = Replace_Check($ImgHeight);
$PopupLeft = Replace_Check($PopupLeft);
$PopupTop = Replace_Check($PopupTop);

$timeinfo = getdate(time());

$YMDHIS = $timeinfo["year"];

if(strlen($timeinfo["mon"]) < 2) {
	$YMDHIS = $YMDHIS."0".$timeinfo["mon"];
}else{
	$YMDHIS = $YMDHIS.$timeinfo["mon"];
}
if(strlen($timeinfo["mday"]) < 2) {
	$YMDHIS = $YMDHIS."0".$timeinfo["mday"];
}else{
	$YMDHIS = $YMDHIS.$timeinfo["mday"];
}

if(strlen($timeinfo["hours"]) < 2) {
	$YMDHIS = $YMDHIS."0".$timeinfo["hours"];
}else{
	$YMDHIS = $YMDHIS.$timeinfo["hours"];
}

if(strlen($timeinfo["minutes"]) < 2) {
	$YMDHIS = $YMDHIS."0".$timeinfo["minutes"];
}else{
	$YMDHIS = $YMDHIS.$timeinfo["minutes"];
}

if(strlen($timeinfo["seconds"]) < 2) {
	$YMDHIS = $YMDHIS."0".$timeinfo["seconds"];
}else{
	$YMDHIS = $YMDHIS.$timeinfo["seconds"];
}

//파일 업로드-----------------------------------
$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

$file = $_FILES['file']['tmp_name']; 
$file_name = $_FILES['file']['name']; 
$file_size = $_FILES['file']['size'];

if($file_size > 0){
if($file_size > 20971520) {
?>
<script>
	alert('20MByte 이상은 올리실 수 없습니다.');
	history.back();
</script>
<?
	exit;
	}

$ext = strtolower(substr($file_name,strlen($file_name)-4)); //파일 확장자
$str_name = str_replace($ext,"",$file_name); //확장자를 제외한 파일명

$FileName = $YMDHIS.$ext;
$ROOT_UPLOAD = $ROOT_PATH."/upload/upload_popup/";
$RealFileName = $file_name;

copy($file,$ROOT_UPLOAD.$FileName); 

}else{ 
	$FileName = "";
	$RealFileName = "";
}
//-----------------------------------------------------------------------------

//echo $file_name;
Switch ($mode) {
	//새 글인 경우 ...  
	case "new":
	//##############################################################
	
	$Sql = "INSERT INTO Popup(Title, ImgName, ImgWidth, ImgHeight, PopupLeft, PopupTop, EndDate, UseYN, RegDate) VALUES('$Title', '$FileName', '$ImgWidth', '$ImgHeight', '$PopupLeft', '$PopupTop', '$EndDate', '$UseYN', now())";
	mysqli_query($connect, $Sql);
	//echo $Sql;
	break;


	 //글 수정인 경우 ...
	case "edit":
//###################################################################################
	if(!$FileName) {
	$Sql = "UPDATE Popup SET Title = '$Title', ImgWidth='$ImgWidth', ImgHeight='$ImgHeight', PopupLeft='$PopupLeft', PopupTop='$PopupTop', EndDate='$EndDate', UseYN='$UseYN' WHERE idx=$idx";
	}else{
	$Sql = "UPDATE Popup SET Title = '$Title', ImgWidth='$ImgWidth', ImgHeight='$ImgHeight', PopupLeft='$PopupLeft', PopupTop='$PopupTop', EndDate='$EndDate', UseYN='$UseYN', ImgName='$FileName' WHERE idx=$idx";
	}
	mysqli_query($connect, $Sql);
//################################################################################
	break;


//#####################################################################################
	//글 삭제 글인 경우 ...
	case "del":
//#####################################################################################

	$Sql = "DELETE FROM Popup WHERE idx=$idx";
	mysqli_query($connect, $Sql);

//####################################################################################
	break;

    }

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	location.href="popup.php";
//-->
</SCRIPT>