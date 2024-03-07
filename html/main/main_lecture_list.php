<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$pg = Replace_Check_XSS2($page);


##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 8;
$block_size = 10;

##-- 검색 조건
$where = array();

$where[] = "b.PackageYN='N'";
$where[] = "b.Del='N'";
$where[] = "b.UseYN='Y'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
$str_orderby = "ORDER BY a.OrderByNum ASC, a.idx ASC";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM MainCourseList AS a LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

##-- 페이지 클래스 생성
include_once("../include/include_page_main_lecture.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<!-- 페이지 원 -->
<div class="page">
	<?=$BLOCK_LIST?>
</div>
<!-- 페이지 원 // -->

<!-- list -->
<ul class="list">
	<?
	$i = 1;
	$SQL = "SELECT b.*, (SELECT CategoryName FROM CourseCategory WHERE idx=b.Category2) AS CategoryName FROM 
	MainCourseList AS a LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
	//echo $SQL;
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		while($ROW = mysqli_fetch_array($QUERY))
		{
			extract($ROW);

			if($PreviewImage) {
				$PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' alt='".$ContentsName."'>";
			}else{
				$PreviewImageView = "<img src='/images/no_img.jpg' alt='".$ContentsName."'>";
			}

			if($Category1==1) {
				$LinkUrl = "/educps/course_detail.php?idx=".$idx."&ParentCategory=".$Menu01ParentCategory."&Category=".$Category2;
			}
			if($Category1==2) {
				$LinkUrl = "/edugrow/course_detail.php?idx=".$idx."&ParentCategory=".$Menu02ParentCategory."&Category=".$Category2;
			}
			if($Category1==3) {
				$LinkUrl = "/educard/course_detail.php?idx=".$idx."&ParentCategory=".$Menu03ParentCategory."&Category=".$Category2;
			}

			if($PackageYN=="Y") {
				$CateStyle="catePack";
			}else{
				$CateStyle="cateBase";
			}
	?>
	<li><a href="<?=$LinkUrl?>">
		<p class="cate"><?=$CategoryName?></p>
		<p class="headimg"><?=$PreviewImageView?></p>
		<p class="title"><?=$ContentsName?></p>
		<p class="modeMark">
			<?if($ServiceType=="1") {?><img src="../images/common/icon_show_refund.png" alt="사업주환급" /><?}?>
			<img src="../images/common/icon_show_pc.png" alt="PC" />
			<?if($Mobile=="Y") {?><img src="../images/common/icon_show_mobile.png" alt="모바일병행" /><?}?>
		</p>
		</a>
	</li>
	<?
	$i++;
		}
	}
	?>
</ul>
<!-- list // -->