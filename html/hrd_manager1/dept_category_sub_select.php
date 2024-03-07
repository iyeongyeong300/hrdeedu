<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$Deep = Replace_Check($Deep);
$Dept = Replace_Check($Dept);
?>
<TABLE border="0" style="border:0px">
<?
$SQL = "SELECT *, (SELECT COUNT(idx) FROM DeptStructure WHERE DeptString LIKE CONCAT(a.DeptString,'%') AND Dept='$Dept' AND idx!=a.idx) AS SubCount FROM DeptStructure AS a WHERE Deep=$Deep AND ParentCategory=$idx AND Dept='$Dept' ORDER BY idx ASC";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY) )
	{
	while($row = mysqli_fetch_array($QUERY) )
		{
		extract($row);
?>
<TR>
	<TD style="font-size:15px ;border:0px"><img src="images/none.gif" align="absmiddle" width="<?=$Deep*20?>" height="2">
		<img src="images/Folder.gif" align="absmiddle" id="Folder<?=$idx?>">
	</TD>
	<TD style="font-size:15px; border:0px">
		<?if($SubCount>0){?>
		<A HREF="Javascript:DeptSubCategoryViewSelect('<?=$Dept?>','<?=$Dept?>_Category<?=$idx?>',<?=$idx?>,<?=$Deep+1?>)" style="font-size:15px"><?=$DeptName?>&nbsp;[<?=$SubCount?>]</A>
		<?}else{?>
		<?=$DeptName?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?}?>
	</TD>
	<TD style="border:0px"><input type="button" value="선택" class="btn_inputSm01" onclick="DeptSelect('<?=$idx?>','<?=$DeptString?>','<?=$DeptName?>');"></TD>
</TR>
<TR>
	<TD colspan="3" style="border:0px"><DIV id="<?=$Dept?>_Category<?=$idx?>" style="display:none"></DIV></TD>
</TR>
<?
	}
}
?>
</TABLE>