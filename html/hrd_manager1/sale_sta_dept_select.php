<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
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
            <h2>영업부서 선택</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="POST" action="sale_sta_dept_select_script.php">
					<input type="hidden" name="Dept_idx" id="Dept_idx">
					<input type="hidden" name="DeptString" id="DeptString">
				</form>
                <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#c0d3de">
				<tr bgcolor="#FFFFFF">
					<td class="text01">
					<?
					$SQL = "SELECT *, (SELECT COUNT(idx) FROM DeptStructure WHERE ParentCategory=a.idx AND Dept='B') AS SubCount FROM DeptStructure AS a WHERE Dept='B' AND Deep=1 ORDER BY OrderByNum ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
					?>
						<TABLE border="0" width="90%" >
					<?
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
							<TR>
								<TD height="30" style="font-size:15px" align="left">
									<img src="images/Folder.gif" align="absmiddle" id="Folder<?=$idx?>"> 
									<?if($SubCount>0){?>
									<A HREF="Javascript:DeptSubCategoryViewSelect('<?=$Dept?>','<?=$Dept?>_Category<?=$idx?>',<?=$idx?>,<?=$Deep+1?>)"  style="font-size:15px"><?=$DeptName?>&nbsp;[<?=$SubCount?>]</A>
									<?}else{?>
									<?=$DeptName?>
									<?}?>&nbsp;&nbsp;<input type="button" value="선택" class="btn_inputSm01" onclick="DeptSelect('<?=$idx?>','<?=$DeptString?>','<?=$DeptName?>');">
								</TD>
							</TR>
							<TR>
								<TD><DIV id="<?=$Dept?>_Category<?=$idx?>" style="display:none"></DIV></TD>
							</TR>
					<?
						}
					?>
						</TABLE>
					<?
					}else{
						echo "<CENTER>등록된 영업부서가 없습니다.</CENTER>";
					}
					?>
					</td>
				</tr>
			</table>

				<div class="btnAreaTr02">
					<input type="button" value="닫  기" onclick="self.close();" class="btn_inputLine01">
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