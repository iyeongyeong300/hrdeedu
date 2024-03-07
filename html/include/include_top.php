<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="No-Cache">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta http-equiv="imagetoolbar" content="no" />

<meta property="og:title" content="HRDe평생교육원">
<meta property="og:image" content="https://www.hrdeedu.com/images/site/header.png?ver=230207" />
<meta property="og:description" content="스마트한 직무능력향상 HRDe평생교육원">
<meta property="og:url" content="https://www.hrdeedu.com">

<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/jquery.bxslider.css?t=20190126" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript">
<!--
var browser = "<?=$browser?>";
//-->
</script>
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<!-- <script type="text/javascript" src="/include/jquery-3.5.1.min.js"></script> -->
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>
<script type="text/javascript" src="/include/jquery.bxslider.min.js"></script>
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
//-->
</script>
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
<?
if(FolderDetect('/main')==true) {
	echo '<a href="#mainVisual" class="sknavi" title="본문 바로가기">본문 바로가기</a>';
}else{
	echo '<a href="#ContentGo" class="sknavi" title="본문 바로가기">본문 바로가기</a>';
}

if(FolderDetect('/main')==false && FolderDetect('/member')==false) {
	echo '<a href="#LeftMenuGo" class="sknavi" title="서브메뉴 바로가기">서브메뉴 바로가기</a>';
}
?>
    	<!-- Top -->
		<div id="header">

			<!-- top logo banner side -->
	    	<div class="topHead">

                <!-- banner -->
                <!-- <div class="banner"><a href="#" class="fsz"><img src="../images/imsi01.jpg" alt="" /></a></div> -->

                <!--logo -->
                <h1><a href="/"><img src="../images/site/header.png" alt="<?=$SiteName?>" /></a></h1>

                <!-- side -->
                <div class="side">
                    <ul class="area">
						<? if(empty($_SESSION['LoginMemberID'])) { ?>
                    	<li><a href="/member/login.php">로그인</a></li>
						<?}else{?>
						<li><a href="/member/logout.php">로그아웃</a></li>
						<?}?>
					
						<li><a href="http://tutor.hrdeedu.com/hrd_manager/">교강사모드</a></li>
                        <li><a href="/hrd_manager/">관리자모드</a></li>
					    <li><a href="/mypage/lecture.php">나의 학습실</a></li>
                    </ul>
                </div>
                <!-- side // -->

            </div>
            <!-- top logo banner side // -->

            <!-- top main menu -->
            <div class="topNavi">
                <!-- area -->
                <div class="area">

                	<!-- menu -->
                    <div class="topMenu" id="TopMenu">
                    	<ul class="menuArea">
                        	<li class="main">
                            	<h2><a href="/educps/course.php">법정의무교육</a></h2>
                            	<!-- submenu 1 -->
                       	  		<ul class="subArea" style="display:none;" id="SiteMenu1">
									<?
									$SQL = "SELECT * FROM CourseCategory WHERE Deep=2 AND ParentCategory=$Menu01ParentCategory AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
									//echo $SQL;
									$QUERY = mysqli_query($connect, $SQL);
									if($QUERY && mysqli_num_rows($QUERY))
									{
										while($ROW = mysqli_fetch_array($QUERY))
										{
									?>
                            		<li><a href="/educps/course.php?Category=<?=$ROW['idx']?>"><?=$ROW['CategoryName']?></a></li>
                            		<?
										}
									}
									?>
                            	</ul>
                            	<!-- submenu 1 // -->
                            </li>
                            <li class="main">
                            	<h2><a href="../edugrow/course.php">직무능력향상교육</a></h2>
                                <!-- submenu 2 -->
                                <ul class="subArea" style="display:none;" id="SiteMenu2">
                            		<?
									$SQL = "SELECT * FROM CourseCategory WHERE Deep=2 AND ParentCategory=$Menu02ParentCategory AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
									 echo $SQL;
									$QUERY = mysqli_query($connect, $SQL);
									if($QUERY && mysqli_num_rows($QUERY))
									{
										echo "in first if";
										while($ROW = mysqli_fetch_array($QUERY))
										{
											echo "in while";
									?>
                            		<li><a href="/edugrow/course.php?Category=<?=$ROW['idx']?>"><?=$ROW['CategoryName']?></a></li>
                            		<?
										}
									}
									?>
                            	</ul>
                            	<!-- submenu 2 // -->
                            </li>
							<li class="main">
                            	<h2><a href="/educard/course.php">근로자 내일배움카드</a></h2>
                                <!-- submenu 3 -->
                                <ul class="subArea" style="display:none;" id="SiteMenu3">
                            		<li><a href="/educard/course_01.php">내일배움카드 소개</a></li>
                            		<li><a href="https://www.hrd.go.kr/hrdp/ma/pmmao/indexNew.do">내일배움카드 발급</a></li>
                            	</ul>
                            	<!-- submenu 3 // -->
                            </li>
                            <li class="main">
                            	<h2><a href="/support/notice.php">학습지원센터</a></h2>
                                <!-- submenu 4 -->
                                <ul class="subArea" style="display:none;" id="SiteMenu4">
                            		<li><a href="/support/notice.php">공지사항</a></li>
                            		<li><a href="/support/faq.php">자주묻는 질문</a></li>
                            		<li><a href="/support/edudata.php">학습자료실</a></li>
                                    <li><a href="/support/ask.php">1:1 문의</a></li>
                                    <li><a href="/support/prodown.php">학습지원 다운로드</a></li>
                                    <li><a href="/support/remote.php">PC 원격지원</a></li>
                                    <li><a href="/support/mycheck.php">본인인증 안내</a></li>
                            	</ul>
                            	<!-- submenu 4 // -->
                            </li>
                            <li class="main">
                            	<h2><a href="/mypage/lecture.php">온라인 학습실</a></h2>
                                <!-- submenu 5 -->
                          		<ul class="subArea" style="display:none;" id="SiteMenu5">
                            		<li><a href="/mypage/lecture.php">수강관리</a></li>
                            		<li><a href="/mypage/appay_lecture.php">신청/결제 관리</a></li>
                            		<li><a href="/mypage/data_pick.php">자료/상담관리</a></li>
                            	</ul> 
                            	<!-- submenu 5 // -->
                            </li>
							
          				</ul>
          			</div>
                    <!-- menu // -->

                    <!-- total menu -->
                    <div class="tmenu"><a href="Javascript:SiteMenuShow();" id="SiteMenuBtn"><img src="../images/common/topnavi_btn_tmenu.png" alt="전체메뉴보기" /></a></div>

                </div>
                <!-- area // -->

                <!-- login -->
				<!--
				<? if(empty($_SESSION['LoginMemberID'])) { ?>
				<form name="TopLoginForm" target="ScriptFrame" autocomplete="off">
				<input type="hidden" name="TopLogin" id="TopLogin" value="Y">
                <div class="loginArea">
                	<div>
                        <span class="inpRadio mr7">
                            <input type="radio" name="MemberType" id="MemberType_1" value="A">
                            <label for="MemberType_1"><em>사업주훈련회원</em></label>
                        </span>
                        <span class="inpRadio mr7">
                            <input type="radio" name="MemberType" id="MemberType_2" value="B">
                            <label for="MemberType_2"><em>근로자 내일배움카드회원</em></label>
                        </span>
                        <span><input type="text" name="ID" id="ID_top" placeholder="아이디 입력" value="<?if (isset($_COOKIE["MemberSavedID"])) { echo $_COOKIE["MemberSavedID"];}?>" /></span>
                        <span><input type="password" name="Pwd" id="Pwd_top" placeholder="비밀번호 입력" /></span>
                        <span class="btn01"><a href="Javascript:TopLoginSubmit();">로그인</a></span>
                        <span class="btnSide01"><a href="/member/join_step01.php">회원가입</a></span>
                        <span class="btnSide02"><a href="/member/idpw.php">아이디/비밀번호 찾기</a></span>
                    </div>
                </div>
				</form>
				-->
                <!-- login // -->
                <?}else{?>
                <div class="loginArea">
                	<span class="txt mr10"><?=$LoginName?>(<?=$LoginMemberID?>)님 로그인중입니다. (자동로그아웃 : <span id="LogOutRemainTime">00분 00초</span>)</span>
                    <span class="btn01 mr10"><a href="/mypage/lecture.php">수강 중인 교육 바로가기</a></span>
                </div>
               <?}?>

    		</div>
            <!-- top main menu // -->

		</div>
		<!-- Top // -->
