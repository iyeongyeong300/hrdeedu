<?php
//===================================================================================//
// NAME		: secu.lib.php
// MEMO		: 보안 기능
// AUTHOR	: DECODE
// EMAIL	: decode@decodelab.co.kr
// Copyright (c) 2012, DECODE Co., Ltd. All rights reserved.
//===================================================================================//

function sqlInjectionClean($data)
{
	if( !get_magic_quotes_gpc() && is_array($data) )
	{
		foreach($data as $index=>$value){
			if(is_array($value)){
				 $data[$index]= sqlInjectionClean($value);
				
				
			}
			else{
				$data[$index] = addSlashes($value);
			
			}
		}
	}

	return $data;
}

function xssClean(&$param) 
{
	$patterns = Array();
	$replacements = Array();
	$tags = Array('javascript','vbscript','expression','applet','meta','xml','blink','link','style','script','embed','object','iframe','frame','frameset','ilayer','layer','bgsound','title','base');
	$attributes = Array('onabort','onactivate','onafterprint','onafterupdate','onbeforeactivate','onbeforecopy','onbeforecut','onbeforedeactivate','onbeforeeditfocus','onbeforepaste','onbeforeprint','onbeforeunload','onbeforeupdate','onblur','onbounce','oncellchange','onchange','onclick','oncontextmenu','oncontrolselect','oncopy','oncut','ondataavailable','ondatasetchanged','ondatasetcomplete','ondblclick','ondeactivate','ondrag','ondragend','ondragenter','ondragleave','ondragover','ondragstart','ondrop','onerror','onerrorupdate','onfilterchange','onfinish','onfocus','onfocusin','onfocusout','onhelp','onkeydown','onkeypress','onkeyup','onlayoutcomplete','onload','onlosecapture','onmousedown','onmouseenter','onmouseleave','onmousemove','onmouseout','onmouseover','onmouseup','onmousewheel','onmove','onmoveend','onmovestart','onpaste','onpropertychange','onreadystatechange','onreset','onresize','onresizeend','onresizestart','onrowenter','onrowexit','onrowsdelete','onrowsinserted','onscroll','onselect','onselectionchange','onselectstart','onstart','onstop','onsubmit','onunload');
	$css = array('behavior','behaviour','content','expression','include-source','moz-binding');
	
	$len = count($tags);
	for($iu=0;$iu<$len;$iu++){
		array_push($patterns,"/<([\W\/]*)(".$tags[$iu].")([^<>]*)>/i");
		array_push($replacements,"<$1xss-$2$3>");
	}
	$len = count($attributes);
	for($iu=0;$iu<$len;$iu++){
		array_push($patterns,"/(".$attributes[$iu]."[\W]*=[\W]*\"[^\"]*\")/i");
		array_push($replacements,"xss-$1");
		array_push($patterns,"/(".$attributes[$iu]."[\W]*=[\W]*'[^']*')/i");
		array_push($replacements,"xss-$1");
	}
	$len = count($css);
	for($iu=0;$iu<$len;$iu++){
		array_push($patterns,"/(".$css[$iu]."):([^;]*;)/i");
		array_push($replacements,"xss-$1:$2");
	}

	if(is_array($param)){
		foreach($param as $key=>$value){
			xssClean($param[$key]);
		}
	}else if(is_string($param)){
		$param = preg_replace($patterns, $replacements, $param);
	}
}
?>