<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$Dept = Replace_Check($Dept);

switch ($Dept) {
	case "A":
		$DeptTitle = "관리자";
	break;
	case "B":
		$DeptTitle = "영업자";
	break;
	case "C":
		$DeptTitle = "첨삭강사";
	break;
	default :
		$DeptTitle = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
<link rel="stylesheet" href="./lib/fontawesome-5.15.4/css/fontawesome.min.css">
<link rel="stylesheet" href="./lib/fontawesome-5.15.4/css/all.min.css">
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function DeptSelect(Dept_idx,DeptString,DeptName) {

		Yes = confirm("["+DeptName+"] 선택하시겠습니까?");
		if(Yes==true) {
			$("#Dept_idx").val(Dept_idx);
			$("#DeptString").val(DeptString);
			Form1.submit();
		}

	}
//-->
</SCRIPT>
</head>

<body leftmargin="0" topmargin="0">

<div id="wrap">

    
    <!-- Content -->
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2><?=$DeptTitle?> 카테고리 선택</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="POST" action="dept_category_select_script.php">
					<input type="hidden" name="Dept_idx" id="Dept_idx">
					<input type="hidden" name="DeptString" id="DeptString">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">

                    <td>
					<?
					$SQL = "SELECT *, (SELECT COUNT(idx) FROM DeptStructure WHERE ParentCategory=a.idx AND Dept='$Dept') AS SubCount FROM DeptStructure AS a WHERE Dept='$Dept' AND Deep=1 AND SiteCode='$SiteCode' ORDER BY idx ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
					?>
						<TABLE border="0" style="border:0px">
					<?
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
							<TR>
								<TD style="font-size:15px; border:0px">
									<i class="xi-folder" id="Folder<?=$idx?>"></i><!--img src="images/Folder.gif" align="absmiddle" id="Folder<?=$idx?>"-->
								</TD>
								<TD style="font-size:15px; border:0px">
									<?if($SubCount>0){?>
									<A HREF="Javascript:DeptSubCategoryViewSelect('<?=$Dept?>','<?=$Dept?>_Category<?=$idx?>',<?=$idx?>,<?=$Deep+1?>)"  style="font-size:15px"><?=$DeptName?>&nbsp;[<?=$SubCount?>]</A>
									<?}else{?>
									<?=$DeptName?>
									<?}?>
								</TD>
								<TD style="font-size:15px; border:0px">
									&nbsp;&nbsp;<button type="button" class="btn round btn_LBlue" onclick="DeptSelect('<?=$idx?>','<?=$DeptString?>','<?=$DeptName?>');">선택</button>
								</TD>
							</TR>
							<TR>
								<TD colspan="3" style="border:0px"><DIV id="<?=$Dept?>_Category<?=$idx?>" style="display:none"></DIV></TD>
							</TR>
					<?
						}
					?>
						</TABLE>
					<?
					}else{
						echo "<CENTER>등록된 관리자가 없습니다.</CENTER>";
					}
					?>
					</td>
                  </tr>
                </table>
				</form>
				<div class="btnAreaTc02">
					<button type="button" onclick="self.close();" class="btn btn_DGray line">닫기</button>
                </div>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>

</body>
</html>