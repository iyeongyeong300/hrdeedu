<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

if($UserDevice=="PC" && $UserIP!="218.154.17.221") { //PC인 경우
	$url = $SiteURL;
	header( "Location: $url" );
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.6, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META http-equiv="Expires" content="-1"> 
<META http-equiv="Pragma" content="no-cache"> 
<META http-equiv="Cache-Control" content="No-Cache"> 
<META http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta property="og:title" content="HRDe평생교육원">
<meta property="og:image" content="https://www.hrdeedu.com/images/site/header.png?ver=230207" />
<meta property="og:description" content="스마트한 직무능력향상 HRDe평생교육원">
<meta property="og:url" content="https://www.hrdeedu.com">
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/function.js?t=20200212"></script>
</head>

<body>
<form name="listScriptForm" method="GET" action="<?=$list_page?>">
<input type="hidden" name="col" value="<?=$col?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="pg" value="<?=$pg?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="FaqCate" value="<?=$FaqCate?>">
<input type="hidden" name="ParentCategory" value="<?=$ParentCategory?>">
<input type="hidden" name="Category" value="<?=$Category?>">
</form>
<form name="ReadScriptForm" method="GET" action="<?=$read_page?>">
<input type="hidden" name="idx">
<input type="hidden" name="col" value="<?=$col?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="pg" value="<?=$pg?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="FaqCate" value="<?=$FaqCate?>">
<input type="hidden" name="ParentCategory" value="<?=$ParentCategory?>">
<input type="hidden" name="Category" value="<?=$Category?>">
</form>

	<div id="wrap">
    
		<!-- Top  -->
		<div id="header">
            <!-- top content -->
            <div id="logoArea"><h1><a href="index.php"><img src="images/site/header_logo.png" alt="<?=$SiteName?>"></a></h1></div>
       	  	<div id="sidemenu">
                <span><a href="Javascript:MenuOpen();"><img src="images/common/btn_tmenu.png" alt="전체메뉴"></a></span>
       	  	</div>
			<!-- top content // -->
		</div>
		<!-- Top // -->






