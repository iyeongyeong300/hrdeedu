<?
include "/home/LMS/include/include_function_cron.php";

//▶ 학습시작 : 개강당일 ( 학습시작 알림톡은 2번 발송 )---------------------------------------------------------------------------------------------

$SQL = "SELECT DISTINCT(b.Mobile), b.Name FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			WHERE a.ServiceType=4  AND DATEDIFF(NOW(),a.LectureStart)=0 ORDER BY a.Seq ASC";
//echo $SQL;
$QUERY = mysql_query($SQL);
$i = 1;
if($QUERY && mysql_num_rows($QUERY))
{
	while($ROW = mysql_fetch_array($QUERY))
	{

		$Mobile = $ROW['Mobile'];
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];

		$msg_type = "cronStart1";
		$msg_var = $SiteName."|".$SiteURL;

		$msg_type2 = "cronStart2";
		$msg_var2 = $SiteName;


		$send_date = date('Y-m-d H:i:s');

		//echo $i.":".$msg_var."<BR>";

		if($msg_mobile) {
			$kakaotalk_result = Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);
			$kakaotalk_result2 = Work_kakaotalk_send($msg_type2,$msg_mobile,$msg_var2,$send_date);

			//echo $kakaotalk_result2."<BR>";
		}


$i++;
	}
}

//▶ 학습시작 : 개강당일 ( 학습시작 알림톡은 2번 발송 )---------------------------------------------------------------------------------------------


//▶ 0% 미만 : 개강 후 7일차---------------------------------------------------------------------------------------------

$SQL = "SELECT DISTINCT(b.Mobile), b.Name FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			WHERE a.ServiceType=4  AND DATEDIFF(NOW(),a.LectureStart)=7 AND Progress < 1 ORDER BY a.Seq ASC";
//echo $SQL;
$QUERY = mysql_query($SQL);
$i = 1;
if($QUERY && mysql_num_rows($QUERY))
{
	while($ROW = mysql_fetch_array($QUERY))
	{

		$Mobile = $ROW['Mobile'];
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];

		$msg_type = "cronProgress00";
		$msg_var = $SiteName."|".$SiteURL;

		$send_date = date('Y-m-d H:i:s');

		//echo $i.":".$msg_var."<BR>";

		if($msg_mobile) {
			$kakaotalk_result = Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);

			//echo $kakaotalk_result."<BR>";
		}


$i++;
	}
}

//▶ 0% 미만 : 개강 후 7일차---------------------------------------------------------------------------------------------

//▶ 30% 미만 : 개강 후 14일차---------------------------------------------------------------------------------------------

$SQL = "SELECT DISTINCT(b.Mobile), b.Name FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			WHERE a.ServiceType=4  AND DATEDIFF(NOW(),a.LectureStart)=14 AND Progress < 30 ORDER BY a.Seq ASC";
//echo $SQL;
$QUERY = mysql_query($SQL);
$i = 1;
if($QUERY && mysql_num_rows($QUERY))
{
	while($ROW = mysql_fetch_array($QUERY))
	{

		$Mobile = $ROW['Mobile'];
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];

		$msg_type = "cronProgress30";
		$msg_var = $SiteName;

		$send_date = date('Y-m-d H:i:s');

		//echo $i.":".$msg_var."<BR>";

		if($msg_mobile) {
			$kakaotalk_result = Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);

			//echo $kakaotalk_result."<BR>";
		}


$i++;
	}
}

//▶ 30% 미만 : 개강 후 14일차---------------------------------------------------------------------------------------------


//▶ 50% 미만 : 개강 후 28일차---------------------------------------------------------------------------------------------

$SQL = "SELECT DISTINCT(b.Mobile), b.Name FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			WHERE a.ServiceType=4  AND DATEDIFF(NOW(),a.LectureStart)=28 AND Progress < 50 ORDER BY a.Seq ASC";
//echo $SQL;
$QUERY = mysql_query($SQL);
$i = 1;
if($QUERY && mysql_num_rows($QUERY))
{
	while($ROW = mysql_fetch_array($QUERY))
	{

		$Mobile = $ROW['Mobile'];
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];

		$msg_type = "cronProgress50";
		$msg_var = $SiteName;

		$send_date = date('Y-m-d H:i:s');

		//echo $i.":".$msg_var."<BR>";

		if($msg_mobile) {
			$kakaotalk_result = Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);

			//echo $kakaotalk_result."<BR>";
		}


$i++;
	}
}

//▶ 50% 미만 : 개강 후 28일차---------------------------------------------------------------------------------------------


//▶ 80% 미만 : 개강 후 42일차---------------------------------------------------------------------------------------------

$SQL = "SELECT DISTINCT(b.Mobile), b.Name FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			WHERE a.ServiceType=4  AND DATEDIFF(NOW(),a.LectureStart)=42 AND Progress < 80 ORDER BY a.Seq ASC";
//echo $SQL;
$QUERY = mysql_query($SQL);
$i = 1;
if($QUERY && mysql_num_rows($QUERY))
{
	while($ROW = mysql_fetch_array($QUERY))
	{

		$Mobile = $ROW['Mobile'];
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];

		$msg_type = "cronProgress80";
		$msg_var = $SiteName;

		$send_date = date('Y-m-d H:i:s');

		//echo $i.":".$msg_var."<BR>";

		if($msg_mobile) {
			$kakaotalk_result = Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);

			//echo $kakaotalk_result."<BR>";
		}


$i++;
	}
}

//▶ 80% 미만 : 개강 후 42일차---------------------------------------------------------------------------------------------


//▶ 최종독려 : 개강 후 43일차 80%이상 수강한 학습자에게만 발송---------------------------------------------------------------------------------------------

$SQL = "SELECT DISTINCT(b.Mobile), b.Name FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			WHERE a.ServiceType=4  AND DATEDIFF(NOW(),a.LectureStart)=43 AND Progress >= 80 ORDER BY a.Seq ASC";
//echo $SQL;
$QUERY = mysql_query($SQL);
$i = 1;
if($QUERY && mysql_num_rows($QUERY))
{
	while($ROW = mysql_fetch_array($QUERY))
	{

		$Mobile = $ROW['Mobile'];
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];

		$msg_type = "cronProgressLast";
		$msg_var = $SiteName;

		$send_date = date('Y-m-d H:i:s');

		//echo $i.":".$msg_var."<BR>";

		if($msg_mobile) {
			$kakaotalk_result = Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);

			//echo $kakaotalk_result."<BR>";
		}


$i++;
	}
}

//▶ 최종독려 : 개강 후 43일차 80%이상 수강한 학습자에게만 발송---------------------------------------------------------------------------------------------

//▶ 수강종료 : 60일차 ( 종강 당일 ) ---------------------------------------------------------------------------------------------

$SQL = "SELECT DISTINCT(b.Mobile), b.Name FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			WHERE a.ServiceType=4  AND DATEDIFF(NOW(),a.LectureEnd)=0 ORDER BY a.Seq ASC";
//echo $SQL;
$QUERY = mysql_query($SQL);
$i = 1;
if($QUERY && mysql_num_rows($QUERY))
{
	while($ROW = mysql_fetch_array($QUERY))
	{

		$Mobile = $ROW['Mobile'];
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];

		$msg_type = "cronProgressEnd";
		$msg_var = $SiteName;

		$send_date = date('Y-m-d H:i:s');

		//echo $i.":".$msg_var."<BR>";

		if($msg_mobile) {
			$kakaotalk_result = Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date);

			//echo $kakaotalk_result."<BR>";
		}


$i++;
	}
}

//▶ 수강종료 : 60일차 ( 종강 당일 ) ---------------------------------------------------------------------------------------------


//echo "<BR><BR><BR><BR>".$Work_kakaotalk_array['cronProgressEnd'];


mysql_close($connect);
?>