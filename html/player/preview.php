<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
<meta http-equiv="X-UA-Compatible" content="IE=8">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>

</head>

<body>
<?
$LectureCode = Replace_Check_XSS2($LectureCode);

## 과정 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$Course_idx = $Row['idx']; //과정 고유번호
	$ContentsName = $Row['ContentsName']; //과정명
	$attachFile = $Row['attachFile']; //학습자료
	$Professor = $Row['Professor']; //내용전문가 
	$CompleteTime = $Row['CompleteTime'] * 60; //진도시간 기준 

}
## 과정 정보 구하기 ########################################################################

//첫번째 차시 구하기
$Sql = "SELECT Sub_idx FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='A' ORDER BY OrderByNum ASC";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

$Contents_idx = $Row[0];

## 차시 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Contents WHERE idx='$Contents_idx'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsTitle = $Row['ContentsTitle']; //차시명
	$Expl01 = nl2br($Row['Expl01']); //차시 목표
	$Expl02 = nl2br($Row['Expl02']); //훈련 내용
	$Expl03 = nl2br($Row['Expl03']); //학습 활동

}
## 차시 정보 구하기 ########################################################################

## 컨텐츠 정보 구하기 ###################################################################
$Sql = "SELECT * FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND (ContentsType='A' OR ContentsType='B') ORDER BY OrderByNum ASC, Seq ASC LIMIT 0,1";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsDetail_Seq = $Row['Seq'];
	$ContentsType = $Row['ContentsType'];
	$ContentsURL = $Row['ContentsURL'];

}
## 컨텐츠 정보 구하기 ###################################################################



if($ContentsType=="A") { //플레쉬 강의의 경우
	$PlayPath = $FlashServerURL.$ContentsURL ;
	$PlayerFunction = "<div class='flashArea' style='background-color:#fff; text-align:center'><input type='hidden' name='ContentsType' id='ContentsType' value='A'><iframe name='mPlayer' id='mPlayer' width='1020' height='655' src='".$PlayPath."' border='0' frameborder='0'></iframe></div>";
}

if($ContentsType=="B") { //동영상 강의의 경우
	$PlayPath = $MovieServerURL.$ContentsURL ;
	$PlayerFunction = "<div class='flashArea' style='background-color:#000; text-align:center'><input type='hidden' name='ContentsType' id='ContentsType' value='B'><video id='mPlayer' width='1020' height='655' controls autoplay><source src='".$PlayPath."' type='video/mp4'></video></div>";
}



## 플레쉬 또는 동영상 정보 구하기 ########################################################################

?>
	<div id="wrap">

        <!-- Content -->
		<div class="player_flash">
        	<!-- vod -->
            <?=$PlayerFunction?>
            <!-- vod // -->
            
            <div class="wideArr"><a href="Javascript:PreviewPlayerResize();"><img src="/images/player/flash_btn_close.png" alt="학습정보 닫기" id="PlayerResizeImg" /></a></div>
            
            <!-- lec info -->
    		<div class="infoArea" id="RightWindow">
            	<!-- scroll -->
                <div class="scbox">
                	
                    <!-- time area -->

                    
                    
					<!-- btn -->
					<div class="btnEnd"><a href="Javascript:self.close();">창닫기</a></div>
					<!-- title -->
                    <div class="lecTitle">
                    	<p class="title"><?=$ContentsName?></p>
                    </div>
                    
                    

                    
                    <!-- info area -->
                    <div class="infoTab">
                    	<!-- tab -->
 
                        <!-- info -->
                        <ul class="tablecInfo" id="PlayerTab">
                        	<li><p class="item">학습자료 받기</p>
                            	<p class="txt"><?if($attachFile) {?><a href="/include/download.php?idx=<?=$Course_idx?>&code=Course&file=CourseAttachFile" target="ScriptFrame"><?=$attachFile?></a><?}?></p></li>
                            <li><p class="item">내용전문가</p>
                            	<p class="txt"><?=$Professor?></p></li>
                            <li><p class="item">차시 목표</p>
                            	<p class="txt"><?=$Expl01?></p></li>
                            <li><p class="item">훈련 내용</p>
                            	<p class="txt"><?=$Expl02?></p></li>
							<li><p class="item">학습 활동</p>
                            	<p class="txt"><?=$Expl03?></p></li>
                        </ul>

                    </div>
                    <!-- info area // -->
    			</div>
                <!-- scroll // -->
    		</div>
            <!-- lec info // -->
            
        </div>
        <!-- Content // -->
         
	</div>


<script type="text/javascript">
<!--
$(window).load(function() {

	PlayerFrameWidth = 1370;
	PlayerFrameHeight = 645;

});
//-->
</script>


</body>
</html>