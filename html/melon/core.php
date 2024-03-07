<?php

//===================================================================================//
// NAME		: core.php
// MEMO		: 	핵심 파일 로드 및 기본 설정
// AUTHOR	: DECODE
// EMAIL	: decode@decodelab.co.kr
// Copyright (c) 2012, DECODE Co., Ltd. All rights reserved.
//===================================================================================//


include_once "configs.php";
include_once "db.lib.php";
include_once "helper.lib.php";
include_once "client.lib.php";
include_once "secu.lib.php";
include_once "custom.lib.php";


session_start();
header("Content-Type: text/html; charset=".$melon['charset']);

ini_set("display_errors", 0);

define('CURRENT_PAGE','current_page');
define('TABLE','table');
define('DATA','data');
define('LENGTH','length');
define('WHERE','where');
define('JOIN','join');
define('ORDER','order');
define('ITEM_NUMBER','item_number');
define('PAGE_NUMBER','page_number');
define('PAGING_TAGS','paging_tags');
define('DB','db');
define('VIEW_QUERY','view_query');
define('FIELD','field');
define('START','start');
define('LENGTH','length');
define('URL','url');
define('TYPE','type');
define('DATA','data');
define('HEADER','header');
define('REFERER','referer');
define('ENCODING','encoding');
define('COOKIE','cookie');
define('ROOT',$_SERVER['DOCUMENT_ROOT']);
define('USER_IP',$_SERVER['REMOTE_ADDR']);
define('SERVER_IP',$_SERVER['SERVER_ADDR']);
define('DOMAIN',$_SERVER['HTTP_HOST']);
define('URI',$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI']);
define('REFERER',$_SERVER['REFERER']);
define('DATE',date('Y-m-d'));
define('DATETIME',date('Y-m-d H:i:s'));

/*
	매개변수 정리
*/
if( !get_magic_quotes_gpc() )
{
	$_REQUEST = sqlInjectionClean($_REQUEST);
	$_COOKIE = sqlInjectionClean($_COOKIE);
}

unset($_GET);
unset($_POST);
unset($_REQUEST["PHPSESSID"]);
$param = &$_REQUEST;
$session = &$_SESSION;

/*
	데이터베이스 연결
*/
if($melon['db']['id']&&$melon['db']['pw']&&$melon['db']['name']&&$melon['db']['host']) {
	dbConnect();
}
set_error_handler("handleError");
register_shutdown_function('shutdownFunction');


function shutDownFunction() { 
	GLOBAL $melon;
    $error = error_get_last(); 
	
	if($error['type']!=8){
		if($error['type']==1){
			$severity='Fatal Error';
		}
		if($error['type']==4){
			$severity='Parse Error' ;
		}
		if($melon['debug']=='OPERATION'){
		//	writeLog('['.$severity.']'.$error['message'].', '.$error['file'].' line:'.$error['line']);

		}
		if($melon['debug']=='DEBUG'){
		//	writeLog('['.$severity.']'.$error['message'].', '.$error['file'].' line:'.$error['line']);
			errorMessage($severity,$error['message'],$error['file'],$error['line']);
			
		}
	
	}
	
	
	
    if ($error['type'] == 1) { 
        //do your stuff     
    } 
} 


if($melon['helper']['uri']){
	parseURI();
	if($melon['is_admin_page']==false){
		xssClean($param);
	}
		
}
else{
	xssClean($param);
}


function handleError($errno, $errstr, $errfile, $errline, array $errcontext){
	GLOBAL $melon;
	
	if(strpos($errstr,"mysql")!==false){
	
			throw new Exception($errstr);
			
		
	
	}
	else{
	


		if($errno!=8){
		
			if($errno ==2){
				$severity='Warning';			
			}

			if($melon['debug']=='OPERATION'){
				writeLog('['.$severity.']'.$errstr.', '.$errfile.' line:'.$errline);

			}
			if($melon['debug']=='DEBUG'){
				writeLog('['.$severity.']'.$errstr.', '.$errfile.' line:'.$errline);
				errorMessage($severity,$errstr,$errfile,$errline);
				
			}
			

		
		}
   


	}
}
/*
if( !function_exists( '_log' ) )
{
	function _log( $data )
	{
		echo '<script>';
		echo 'console.log( '.json_encode( $data ).' );';
		echo '</script>';
	}

}
*/
/**
 * 
 * URI를 SEGMENT기반의 URI로 변경함.
 */
function parseURI(){
	GLOBAL $param;
	GLOBAL $melon;
	GLOBAL $session;
	$URI = array();
	$URI_EXPLODE = explode('?', $_SERVER['REQUEST_URI']);
	if (is_array($URI_EXPLODE) === TRUE && count($URI_EXPLODE) > 1) {
		$URI['url'] = $URI_EXPLODE[0];
		$URI['params'] = $URI_EXPLODE[1];

	} else {

		$URI['url'] = $URI_EXPLODE[0];
		$URI['params'] = '';

	}
	$URI['path_info'] = $_SERVER['PATH_INFO'];
	$URI['self'] = $_SERVER['PHP_SELF'];
	$SEGMENT = explode('/', $URI['url']);
	while( !empty($SEGMENT)&&in_array($SEGMENT[0], array('', 'index')) === TRUE ) {
		array_shift($SEGMENT);
	}
	$melon['segment']=$SEGMENT;
	if(empty($SEGMENT)){
		$includePath='controllers/index.php';
	}
	else{

		$dir='controllers';
	
		while(!empty($SEGMENT)&&is_dir($dir.'/'.$SEGMENT[0])){
		
			if(!$SEGMENT[0]){
				break;
			}
			$dir.='/'.$SEGMENT[0];
			array_shift($SEGMENT);
		}
		
		$melon['dir']=str_replace('controllers','',$dir);
		$melon['parent']=array_pop(explode('/',$dir));
		if(is_file($dir.'/'.$SEGMENT[0].'.php')){
			$includePath=$dir.'/'.$SEGMENT[0].'.php';
			$melon['self']=$SEGMENT[0];
			array_shift($SEGMENT);
		}
		else{
			$includePath=$dir.'/index.php';
			$melon['self']='index';
		}
	}
	$melon['path'] = str_replace('/index','',$melon['dir'].'/'.$melon['self']);


	if($melon['singleParam'][$melon['dir'].'/'.$melon['self']]){
		$singleParam=$melon['singleParam'][$melon['dir'].'/'.$melon['self']]; //  /admin/main/test/index/ 전체경로+파일명이 index
		
	}	
	if($melon['singleParam'][$melon['dir']]){

		$singleParam=$melon['singleParam'][$melon['dir']];  //		/admin/main/test/       전체경로가같은 하위페이지

	}	
	if($melon['singleParam'][$melon['parent'].'/'.$melon['self']]){
		$singleParam=$melon['singleParam'][$melon['parent'].'/'.$melon['self']]; //		main/index       main밑에 index인 페이지

	}
	if($melon['singleParam'][$melon['parent'].'/']){
		$singleParam=$melon['singleParam'][$melon['parent'].'/']; //	main/    : 부모디렉토리가 main인 페이지

	}
	if($melon['singleParam'][$melon['self']]){
		$singleParam=$melon['singleParam'][$melon['self']]; // ex) index      파일명이 index

	}

	if($singleParam){
		$cnt = 0;
		foreach($singleParam as $key=>$value){
			$shift=$key-$cnt;
			$result=array_splice($SEGMENT,$shift,1);
			$param[$value]=urldecode($result[0]);
			$cnt++;
		}
	}
	$len=count($SEGMENT);

	for($iu=0;$iu<=$len;$iu++){
		if($iu%2==1){
			if(!in_array($SEGMENT[$iu-1],$melon['param'])&&$SEGMENT[$iu-1]&&!is_numeric($SEGMENT[$iu-1])){
				
				include 'errors/error_404.html';
				exit;
			}
			$param[$SEGMENT[$iu-1]]=urldecode($SEGMENT[$iu]);
		}
	}
	if(is_file($includePath)||!is_numeric($SEGMENT[$iu-1])){
		include'models/common.php';
		if($melon['segment'][0]=='admin'){
			include'models/admin.php';
			$melon['is_admin_page'] = true;
			
		}
		else{
			include'models/user.php';
			$melon['is_admin_page'] = false;
		}
		if(!is_file($includePath)){
			include 'errors/error_404.html';
			exit;
		}
		
		include $includePath;
	}
	else{
		include 'errors/error_404.html';
		exit;
	}
}
?>

<?php

//======================================================================
// CATEGORY LARGE FONT
//======================================================================

//-----------------------------------------------------
// Sub-Category Smaller Font
//-----------------------------------------------------

/* Title Here Notice the First Letters are Capitalized */

# Option 1
# Option 2
# Option 3

/*
* This is a detailed explanation
* of something that should require
* several paragraphs of information.
*/

// This is a single line quote.
/** 
  * @desc this class will hold functions for user interaction
  * examples include user_pass(), user_username(), user_age(), user_regdate()
  * @author Jake Rocheleau jakerocheleau@gmail.com
  * @required settings.php
*/
?>

