<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$url = Replace_Check($url);
$sel = Replace_Check($sel);

if($sel=="A") {
	$MoviePath = $MovieServerURL.$url;
}else{
	$MoviePath = $url;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title>:: <?=$SiteName?> ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="./css/style.css" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
</head>

<body>
<table border="0" width="800" height="600">
<tr>
	<td style="text-align:center; vertical-align:bottom;background:#fff;">
	<?if($sel=="A") {?>
	<video width="800" height="600" controls autoplay>
		<source src="<?=$MoviePath?>" type="video/mp4"> 
	</video>
	<?}else{?>
	<iframe src="<?=$MoviePath?>" width="800" height="600" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}?>
	</td>
</tr>
</table>
</body>
</html>
