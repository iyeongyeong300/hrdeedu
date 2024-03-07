<?
$file = $_FILES['file']['tmp_name']; 
$file_name = $_FILES['file']['name']; 
$file_size = $_FILES['file']['size'];

$file2 = $_FILES['file2']['tmp_name']; 
$file2_name = $_FILES['file2']['name']; 
$file2_size = $_FILES['file2']['size'];

$file3 = $_FILES['file3']['tmp_name']; 
$file3_name = $_FILES['file3']['name']; 
$file3_size = $_FILES['file3']['size'];

$file4 = $_FILES['file4']['tmp_name']; 
$file4_name = $_FILES['file4']['name']; 
$file4_size = $_FILES['file4']['size'];

$file5 = $_FILES['file5']['tmp_name']; 
$file5_name = $_FILES['file5']['name']; 
$file5_size = $_FILES['file5']['size'];

//첫번째 파일 업로드------------------------------------------------------------------------------------------------
if($file_size>0){

	if($file_size>52428800) {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("파일크기는 50M이하만 가능합니다.");
	history.back();
	//-->
	</SCRIPT>
<?
	exit;
	}


	$ext = substr(strrchr($file_name,"."),1); //확장자앞 .을 제거하기 위하여 substr()함수를 이용
	$ext = strtolower($ext); //확장자를 소문자로 변환
	$str_name = str_replace($ext,"",$file_name); //확장자를 제외한 파일명

	$filename = date('YmdHis')."01.".$ext;

	//파일 경로를 제외한 파일명 검출
	$file_name_arrary = explode("\\",$file_name);
	$file_name_arrary_count = count($file_name_arrary);
	$file_name2 = $file_name_arrary[$file_name_arrary_count-1];

	copy($file,$UPLOAD_DIR.$Folder."/".$filename); 

	$FileName1 = $filename;
	$RealFileName1 = $file_name2;

}else{

	$FileName1 = "";
	$RealFileName1 = "";

}
//첫번째 파일 업로드 끝=====================================================

//두번째 파일 업로드------------------------------------------------------------------------------------------------
if($file2_size>0){

	if($file2_size>52428800) {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("파일크기는 50M이하만 가능합니다.");
	history.back();
	//-->
	</SCRIPT>
<?
	exit;
	}


	$ext2 = substr(strrchr($file2_name,"."),1); //확장자앞 .을 제거하기 위하여 substr()함수를 이용
	$ext2 = strtolower($ext2); //확장자를 소문자로 변환
	$str2_name = str_replace($ext2,"",$file2_name); //확장자를 제외한 파일명

	$filename2 = date('YmdHis')."02.".$ext2;

	//파일 경로를 제외한 파일명 검출
	$file2_name_arrary = explode("\\",$file2_name);
	$file2_name_arrary_count = count($file2_name_arrary);
	$file2_name2 = $file2_name_arrary[$file2_name_arrary_count-1];

	copy($file2,$UPLOAD_DIR.$Folder."/".$filename2); 

	$FileName2 = $filename2;
	$RealFileName2 = $file2_name2;

}else{

	$FileName2 = "";
	$RealFileName2 = "";

}
//두번째 파일 업로드 끝=====================================================

//세번째 파일 업로드------------------------------------------------------------------------------------------------
if($file3_size>0){

	if($file3_size>52428800) {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("파일크기는 50M이하만 가능합니다.");
	history.back();
	//-->
	</SCRIPT>
<?
	exit;
	}


	$ext3 = substr(strrchr($file3_name,"."),1); //확장자앞 .을 제거하기 위하여 substr()함수를 이용
	$ext3 = strtolower($ext3); //확장자를 소문자로 변환
	$str3_name = str_replace($ext3,"",$file3_name); //확장자를 제외한 파일명

	$filename3 = date('YmdHis')."03.".$ext3;

	//파일 경로를 제외한 파일명 검출
	$file3_name_arrary = explode("\\",$file3_name);
	$file3_name_arrary_count = count($file3_name_arrary);
	$file3_name2 = $file3_name_arrary[$file3_name_arrary_count-1];

	copy($file3,$UPLOAD_DIR.$Folder."/".$filename3); 

	$FileName3 = $filename3;
	$RealFileName3 = $file3_name2;

}else{

	$FileName3 = "";
	$RealFileName3 = "";

}
//세번째 파일 업로드 끝=====================================================

//네번째 파일 업로드------------------------------------------------------------------------------------------------
if($file4_size>0){

	if($file4_size>52428800) {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("파일크기는 50M이하만 가능합니다.");
	history.back();
	//-->
	</SCRIPT>
<?
	exit;
	}


	$ext4 = substr(strrchr($file4_name,"."),1); //확장자앞 .을 제거하기 위하여 substr()함수를 이용
	$ext4 = strtolower($ext4); //확장자를 소문자로 변환
	$str4_name = str_replace($ext4,"",$file4_name); //확장자를 제외한 파일명

	$filename4 = date('YmdHis')."04.".$ext4;

	//파일 경로를 제외한 파일명 검출
	$file4_name_arrary = explode("\\",$file4_name);
	$file4_name_arrary_count = count($file4_name_arrary);
	$file4_name2 = $file4_name_arrary[$file4_name_arrary_count-1];

	copy($file4,$UPLOAD_DIR.$Folder."/".$filename4); 

	$FileName4 = $filename4;
	$RealFileName4 = $file4_name2;

}else{

	$FileName4 = "";
	$RealFileName4 = "";

}
//네번째 파일 업로드 끝=====================================================

//다섯번째 파일 업로드------------------------------------------------------------------------------------------------
if($file5_size>0){

	if($file5_size>52428800) {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("파일크기는 50M이하만 가능합니다.");
	history.back();
	//-->
	</SCRIPT>
<?
	exit;
	}


	$ext5 = substr(strrchr($file5_name,"."),1); //확장자앞 .을 제거하기 위하여 substr()함수를 이용
	$ext5 = strtolower($ext5); //확장자를 소문자로 변환
	$str5_name = str_replace($ext5,"",$file5_name); //확장자를 제외한 파일명

	$filename5 = date('YmdHis')."05.".$ext5;

	//파일 경로를 제외한 파일명 검출
	$file5_name_arrary = explode("\\",$file5_name);
	$file5_name_arrary_count = count($file5_name_arrary);
	$file5_name2 = $file5_name_arrary[$file5_name_arrary_count-1];

	copy($file5,$UPLOAD_DIR.$Folder."/".$filename5); 

	$FileName5 = $filename5;
	$RealFileName5 = $file5_name2;

}else{

	$FileName5 = "";
	$RealFileName5 = "";

}
//다섯번째 파일 업로드 끝=====================================================
?>