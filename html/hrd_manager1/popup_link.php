<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$mode = Replace_Check($mode);
$idx = Replace_Check($idx);
$num = Replace_Check($num);
$ImgArea = Replace_Check($ImgArea);
$LinkURL = Replace_Check($LinkURL);

Switch ($mode) {
	//새 글인 경우 ...  
	case "new":
	//##############################################################
	
	$Sql = "INSERT INTO Popup_Link(idx, ImgArea, LinkURL) VALUES($idx, '$ImgArea', '$LinkURL')";
	mysqli_query($connect, $Sql);
	//echo $Sql;
	break;


//#####################################################################################
	//글 삭제 글인 경우 ...
	case "del":
//#####################################################################################

	$Sql = "DELETE FROM Popup_Link WHERE idx=$idx AND num=$num";
	mysqli_query($connect, $Sql);

//####################################################################################
	break;

    }

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	location.href="popup_r.php?idx=<?=$idx?>";
//-->
</SCRIPT>