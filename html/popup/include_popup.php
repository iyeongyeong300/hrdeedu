<script language="javascript">

function CloseLayer(sName) {
	document.getElementById(sName).style.visibility = "hidden";
}

function CloseLayerDay(sName) {


	var today  = new Date()
	var expire = new Date(today.getTime() + 1000*60*60*24)

		SetCookie(sName,'1',expire);
		CloseLayer(sName);

}

function goLink( url ){
	//location.href=url;
	window.open(url);
}


function SetCookie(sName, sValue, expire)
{
  document.cookie = sName + "=" + escape(sValue) + ( (expire) ? "; expires=" + expire.toGMTString() : "");
}

function GetCookie(sName)
{

  var aCookie = document.cookie.split("; ");

  for (var i=0; i < aCookie.length; i++)
  {

    var aCrumb = aCookie[i].split("=");
    if (sName == aCrumb[0])
      return unescape(aCrumb[1]);
  }

  return null;
}

var sReturn1 = GetCookie('popup_1');
var sReturn2 = GetCookie('popup_2');
var sReturn3 = GetCookie('popup_3');

<?
/*
==========================================
'자동 팝업창 로직
'==========================================
*/
$timeinfo = getdate(time());

$YMD = $timeinfo["year"];

if(strlen($timeinfo["mon"]) < 2) {
	$YMD = $YMD."0".$timeinfo["mon"];
}else{
	$YMD = $YMD.$timeinfo["mon"];
}

if(strlen($timeinfo["mday"]) < 2) {
	$YMD = $YMD."0".$timeinfo["mday"];
}else{
	$YMD = $YMD.$timeinfo["mday"];
}

?>
var left_point = 0;
var popup_count = 0;
<?
$SQL = "SELECT* FROM Popup WHERE EndDate >= '$YMD' AND UseYN='Y' ORDER BY idx ASc";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY) )
	{
	$i = 0;
	while($row = mysqli_fetch_array($QUERY) )
	{
		$cname = "Popup".$row['idx'];
		$idx = $row['idx'];

		if(!$row['ImgWidth']) {
			$imgwidth = 392;
		}else{
			$imgwidth = $row['ImgWidth'];
		}

		if(!$row['ImgHeight']) {
			$imgheight = 403;
		}else{
			$imgheight = $row['ImgHeight']+25;
		}

?>
var <?=$cname ?> = GetCookie('<?=$cname ?>');

if( popup_count == 0 ){
    popup_count++;
    left_point = 20;
}

if( left_point >= 1024 ){
    popup_count++;
    left_point = 20;
}

if(<?=$cname ?> == null || <?=$cname ?> == 0) {
<? include $_SERVER['DOCUMENT_ROOT'] . "/popup/popup_view.php"; ?>

left_point = left_point + <?=$imgwidth?>+10;

}
<?
	}
}
	else
{ }
?>
</script>
