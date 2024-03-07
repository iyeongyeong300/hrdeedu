<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$url = Replace_Check($url);
$play_mode = Replace_Check($play_mode);

if(!$play_mode) {
	$play_mode = "edge";
}

$FlashPath = $FlashServerURL.$url;
//echo $FlashPath;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title>:: <?=$SiteName?> ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?if($play_mode=="edge") {?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?}else{?>
<meta http-equiv="X-UA-Compatible" content="IE=8">
<?}?>
<link rel="stylesheet" href="./css/style.css" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
</head>

<body>
<?if($play_mode=="edge") {?>
<input type="button" value="IE8 모드로 보기" class="btn_inputLine01" onclick="location.href='./flase_player.php?url=<?=$url?>&play_mode=IE8'">
<?}else{?>
<input type="button" value="IE edge 모드로 보기" class="btn_inputLine01" onclick="location.href='./flase_player.php?url=<?=$url?>&play_mode=edge'">
<?}?>
<table border="0" width="1060" height="685">
<tr>
	<td style="text-align:center; vertical-align:bottom;background:#fff;"><iframe name="FlashPlayer" width="1040" height="665" src="<?=$FlashPath?>" border="0" frameborder="0"></iframe></td>
</tr>
</table>
</body>
</html>
