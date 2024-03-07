<?
$sCookieName = $cname;
$sPopup_no = $idx;


//팝업의 이미지정보를 구한다.
$Sql2 = "SELECT * FROM Popup WHERE idx=$sPopup_no";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$img_name = $Row2['ImgName'];
$wd = $Row2['ImgWidth'];
$ht = $Row2['ImgHeight'];
$PopupLeft = $Row2['PopupLeft'];
$PopupTop = $Row2['PopupTop'];

$mapyn = "";

$Sql1 = "SELECT COUNT(*) FROM Popup_Link WHERE idx=$sPopup_no";
$Result1 = mysqli_query($connect, $Sql1);
$Row1 = mysqli_fetch_array($Result1);
$link_count = $Row1[0];


$QUERY3 = "SELECT * FROM Popup_Link WHERE idx=$sPopup_no";
$QUERY3 = mysqli_query($connect, $QUERY3);
if($QUERY3 && mysqli_num_rows($QUERY3) )
	{
		$i = 1;
	while($row3 = mysqli_fetch_array($QUERY3) )
		{

			$tmp = $row3['ImgArea'];

			if(trim($tmp)=="") {
				$mapyn = "N";
			}else{
				$mapyn = "Y";
			}
			$link_array[$i][0] = $tmp;
			$link_array[$i][1] =$row3['LinkURL'];

		$i++;
		}
	}
	else
	{
	}
?>
document.write("<DIV style='BORDER-RIGHT: #a2a2a2 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #a2a2a2 1px solid; PADDING-LEFT: 2px; FILTER: alpha(opacity=100); PADDING-BOTTOM: 2px; BORDER-LEFT: #a2a2a2 1px solid; PADDING-TOP: 2px; BORDER-BOTTOM: #a2a2a2 1px solid; POSITION: absolute; BACKGROUND-COLOR: white; left:<?=$PopupLeft?>");
document.write("px; top: <?=$PopupTop?>px; width:<?=$wd+6?>px; height:<?=$ht+30 ?>px;z-index:100; visibility: visible;' id='<?=$sCookieName?>'>");
<?if($mapyn) {?>
document.write("<map name='links<?=$sCookieName?>'>");
<?for($i=1; $i<=$link_count; $i++) {?>
<?if(preg_match("/"."Javascript"."/i",$link_array[$i][1])) { ?>
document.write("<area shape='rect' coords='<?= $link_array[$i][0] ?>' href='<?=$link_array[$i][1] ?>'>");
<?}else{?>
document.write("<area shape='rect' coords='<?= $link_array[$i][0] ?>' href='javascript:goLink(\"<?=$link_array[$i][1] ?>\")'>");
<?}?>
<?}?>
document.write("</map>");
 <?}?>
document.write("<table border='0' align='center' cellpadding='0' cellspacing='0' ><tr><td>");
<? if(($mapyn == "N") && ($link_count == 1)) {  //이미지맵을 사용하지않으면서 링크가 있는것 ?>
document.write("<a href='javascript:goLink(\"<?= $link_array[1][1] ?>\")'><img width='<?=$wd ?>' height='<?=$ht ?>' src='/upload/upload_popup/<?= $img_name ?>' border='0'></a>");
<?} elseif($mapyn == "Y") {?>
document.write("<img width='<?=$wd ?>' height='<?=$ht ?>' src='/upload/upload_popup/<?=$img_name ?>' border='0' usemap='#links<?=$sCookieName?>'>");
<? }else{?>
document.write("<img width='<?=$wd ?>' height='<?=$ht ?>' src='/upload/upload_popup/<?=$img_name ?>' border='0'>");
<? } ?>
document.write("</td></tr><tr><td height='24' align='center' valign='top' bgcolor='707070'><table width='98%'  border='0' cellspacing='0' cellpadding='0'><tr><td align='right' class='fs12'><input type='checkbox' name='chk' onClick='CloseLayerDay(\"<?=$sCookieName?>\")' style='display:initial'><FONT COLOR='#FFFFFF'>오늘 하루 창 열지 않기</FONT>&nbsp;&nbsp;&nbsp;<img src='/popup/img/close01.gif' border='0' align='absbottom' onclick='CloseLayer(\"<?=$sCookieName?>\")' style='cursor:pointer'>&nbsp;</font></td></tr></table></td></tr></table>");
document.write("</div>");
