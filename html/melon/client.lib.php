<?php
//===================================================================================//
// NAME		: client.lib.php
// MEMO		: 클라이언트 함수 모음
// AUTHOR	: DECODE
// EMAIL	: decode@decodelab.co.kr
// Copyright (c) 2012, DECODE Co., Ltd. All rights reserved.
//===================================================================================//



function getBrowser()
{

    $value = strtolower($_SERVER['HTTP_USER_AGENT']);

    if (preg_match("/msie 5.0[0-9]*/", $value))         { $result = "InternetExplorer 5.0"; }
    else if(preg_match("/msie 5.5[0-9]*/", $value))     { $result = "InternetExplorer 5.5"; }
    else if(preg_match("/msie 6.0[0-9]*/", $value))     { $result = "InternetExplorer 6.0"; }
    else if(preg_match("/msie 7.0[0-9]*/", $value))     { $result = "InternetExplorer 7.0"; }
    else if(preg_match("/msie 8.0[0-9]*/", $value))     { $result = "InternetExplorer 8.0"; }
    else if(preg_match("/msie 9.0[0-9]*/", $value))     { $result = "InternetExplorer 9.0"; }
    else if(preg_match("/msie 10.0[0-9]*/", $value))    { $result = "InternetExplorer 10.0"; }
    else if(preg_match("/trident*/", $value))			{ $result = "InternetExplorer 11.0"; }
    else if(preg_match("/msie 4.[0-9]*/", $value))      { $result = "InternetExplorer 4.x"; }
    else if(preg_match("/msie/", $value))				{ $result = "InternetExplorer"; }
    else if(preg_match("/internet explorer/", $value))  { $result = "InternetExplorer"; }
    else if(preg_match("/mobile/", $value))      		{ $result = "Mobile"; }
    else if(preg_match("/firefox/", $value))            { $result = "FireFox"; }
	else if(preg_match('/Edg/i', $value))				{ $result='Edge';}
    else if(preg_match("/chrome/", $value))             { $result = "Chrome"; }
    else if(preg_match("/safari/", $value))      		{ $result = "Safari"; }
    else if(preg_match("/x11/", $value))                { $result = "Netscape"; }
    else if(preg_match("/opera mobi/", $value))         { $result = "Opera Mobile"; }
    else if(preg_match("/opera mini/", $value))         { $result = "Opera Mobile"; }
    else if(preg_match("/opera/", $value))              { $result = "Opera"; }
    else if(preg_match("/gec/", $value))                { $result = "Gecko"; }
    else if(preg_match("/bot|slurp/", $value))          { $result = "Robot"; }
    else if(preg_match("/mozilla/", $value))            { $result = "Mozilla"; }
    else { $result = $value; }

    return $result;
}
function getOS()
{
	 $value = strtolower($_SERVER['HTTP_USER_AGENT']);

	if (preg_match("/windows 98/", $value))					{ $result = "Windows98"; }
	else if(preg_match("/windows 95/", $value))				{ $result = "Windows95"; }
	else if(preg_match("/windows nt 4\.[0-9]*/", $value))	{ $result = "WindowsNT"; }
	else if(preg_match("/windows nt 5\.0/", $value))		{ $result = "Windows2000"; }
	else if(preg_match("/windows nt 5\.1/", $value))		{ $result = "WindowsXP"; }
	else if(preg_match("/windows nt 5\.2/", $value))		{ $result = "Windows2003"; }
	else if(preg_match("/windows nt 6\.0/", $value))		{ $result = "WindowsVista"; }
	else if(preg_match("/windows nt 6\.1/", $value))		{ $result = "Windows7"; }
	else if(preg_match("/windows nt 10/", $value))			{ $result = "Windows10"; }
	else if(preg_match("/windows 9x/", $value))				{ $result = "WindowsME"; }
	else if(preg_match("/windows ce/", $value))				{ $result = "WindowsCE"; }
	else if(preg_match("/iphone os4/", $value))				{ $result = "iPhoneOS4"; }
	else if(preg_match("/iphone/", $value))					{ $result = "iPhoneOS"; }
	else if(preg_match("/android 2\.4/", $value))			{ $result = "Android2.4"; }
	else if(preg_match("/android 2\.3/", $value))			{ $result = "Android2.3"; }
	else if(preg_match("/android 2\.2/", $value))			{ $result = "Android2.2"; }
	else if(preg_match("/android 2\.1/", $value))			{ $result = "Android2.1"; }
	else if(preg_match("/android 2\.0/", $value))			{ $result = "Android2.0"; }
	else if(preg_match("/android 1/", $value))				{ $result = "Android1.X"; }
	else if(preg_match("/android/", $value))				{ $result = "Android"; }
	else if(preg_match("/mac/", $value))					{ $result = "MAC"; }
	else if(preg_match("/linux/", $value))                  { $result = "Linux"; }
	else if(preg_match("/sunos/", $value))                  { $result = "sunOS"; }
	else if(preg_match("/irix/", $value))                   { $result = "IRIX"; }
	else if(preg_match("/phone/", $value))                  { $result = "Phone"; }
	else if(preg_match("/bot|slurp/", $value))              { $result = "Robot"; }
	else if(preg_match("/internet explorer/", $value))      { $result = "IE"; }
	else if(preg_match("/mozilla/", $value))                { $result = "Mozilla"; }
	else { $result = "unknown"; }
	
	return $result;
}
function isMobile()
{
	$mobile_agent = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/';
	if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
	   return true;
	} else {
		return false;
	}
}
?>