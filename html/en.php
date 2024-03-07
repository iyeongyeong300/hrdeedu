<?php

if($_SERVER["REMOTE_ADDR"] !== "121.142.70.228") exit;

/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.8.1
*/function
adminer_errors($Ac,$Cc){return!!preg_match('~^(Trying to access array offset on value of type null|Undefined array key)~',$Cc);}error_reporting(6135);set_error_handler('adminer_errors',E_WARNING);$Yc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($Yc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Fi=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Fi)$$X=$Fi;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$g;return$g;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($v){if(!preg_match('~^[`\'"]~',$v))return$v;$ne=substr($v,-1);return
str_replace($ne.$ne,$ne,substr($v,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($qg,$Yc=false){if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){while(list($z,$X)=each($qg)){foreach($X
as$fe=>$W){unset($qg[$z][$fe]);if(is_array($W)){$qg[$z][stripslashes($fe)]=$W;$qg[]=&$qg[$z][stripslashes($fe)];}else$qg[$z][stripslashes($fe)]=($Yc?$W:stripslashes($W));}}}}function
bracket_escape($v,$Ma=false){static$ri=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($v,($Ma?array_flip($ri):$ri));}function
min_version($Wi,$Ae="",$h=null){global$g;if(!$h)$h=$g;$kh=$h->server_info;if($Ae&&preg_match('~([\d.]+)-MariaDB~',$kh,$C)){$kh=$C[1];$Wi=$Ae;}return(version_compare($kh,$Wi)>=0);}function
charset($g){return(min_version("5.5.3",0,$g)?"utf8mb4":"utf8");}function
script($vh,$qi="\n"){return"<script".nonce().">$vh</script>$qi";}function
script_src($Ki){return"<script src='".h($Ki)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($P){return
str_replace("\0","&#0;",htmlspecialchars($P,ENT_QUOTES,'utf-8'));}function
nl_br($P){return
str_replace("\n","<br>",$P);}function
checkbox($D,$Y,$cb,$ke="",$rf="",$gb="",$le=""){$I="<input type='checkbox' name='$D' value='".h($Y)."'".($cb?" checked":"").($le?" aria-labelledby='$le'":"").">".($rf?script("qsl('input').onclick = function () { $rf };",""):"");return($ke!=""||$gb?"<label".($gb?" class='$gb'":"").">$I".h($ke)."</label>":$I);}function
optionlist($xf,$dh=null,$Oi=false){$I="";foreach($xf
as$fe=>$W){$yf=array($fe=>$W);if(is_array($W)){$I.='<optgroup label="'.h($fe).'">';$yf=$W;}foreach($yf
as$z=>$X)$I.='<option'.($Oi||is_string($z)?' value="'.h($z).'"':'').(($Oi||is_string($z)?(string)$z:$X)===$dh?' selected':'').'>'.h($X);if(is_array($W))$I.='</optgroup>';}return$I;}function
html_select($D,$xf,$Y="",$qf=true,$le=""){if($qf)return"<select name='".h($D)."'".($le?" aria-labelledby='$le'":"").">".optionlist($xf,$Y)."</select>".(is_string($qf)?script("qsl('select').onchange = function () { $qf };",""):"");$I="";foreach($xf
as$z=>$X)$I.="<label><input type='radio' name='".h($D)."' value='".h($z)."'".($z==$Y?" checked":"").">".h($X)."</label>";return$I;}function
select_input($Ha,$xf,$Y="",$qf="",$cg=""){$Vh=($xf?"select":"input");return"<$Vh$Ha".($xf?"><option value=''>$cg".optionlist($xf,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$cg'>").($qf?script("qsl('$Vh').onchange = $qf;",""):"");}function
confirm($Ke="",$eh="qsl('input')"){return
script("$eh.onclick = function () { return confirm('".($Ke?js_escape($Ke):'Are you sure?')."'); };","");}function
print_fieldset($u,$se,$Zi=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$se</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($Zi?"":" class='hidden'").">\n";}function
bold($Ta,$gb=""){return($Ta?" class='active $gb'":($gb?" class='$gb'":""));}function
odd($I=' class="odd"'){static$t=0;if(!$I)$t=-1;return($t++%2?$I:'');}function
js_escape($P){return
addcslashes($P,"\r\n'\\/");}function
json_row($z,$X=null){static$Zc=true;if($Zc)echo"{";if($z!=""){echo($Zc?"":",")."\n\t\"".addcslashes($z,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$Zc=false;}else{echo"\n}\n";$Zc=true;}}function
ini_bool($Sd){$X=ini_get($Sd);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$I;if($I===null)$I=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$I;}function
set_password($Vi,$M,$V,$F){$_SESSION["pwds"][$Vi][$M][$V]=($_COOKIE["adminer_key"]&&is_string($F)?array(encrypt_string($F,$_COOKIE["adminer_key"])):$F);}function
get_password(){$I=get_session("pwds");if(is_array($I))$I=($_COOKIE["adminer_key"]?decrypt_string($I[0],$_COOKIE["adminer_key"]):false);return$I;}function
q($P){global$g;return$g->quote($P);}function
get_vals($G,$e=0){global$g;$I=array();$H=$g->query($G);if(is_object($H)){while($J=$H->fetch_row())$I[]=$J[$e];}return$I;}function
get_key_vals($G,$h=null,$nh=true){global$g;if(!is_object($h))$h=$g;$I=array();$H=$h->query($G);if(is_object($H)){while($J=$H->fetch_row()){if($nh)$I[$J[0]]=$J[1];else$I[]=$J[0];}}return$I;}function
get_rows($G,$h=null,$n="<p class='error'>"){global$g;$wb=(is_object($h)?$h:$g);$I=array();$H=$wb->query($G);if(is_object($H)){while($J=$H->fetch_assoc())$I[]=$J;}elseif(!$H&&!is_object($h)&&$n&&defined("PAGE_HEADER"))echo$n.error()."\n";return$I;}function
unique_array($J,$x){foreach($x
as$w){if(preg_match("~PRIMARY|UNIQUE~",$w["type"])){$I=array();foreach($w["columns"]as$z){if(!isset($J[$z]))continue
2;$I[$z]=$J[$z];}return$I;}}}function
escape_key($z){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$z,$C))return$C[1].idf_escape(idf_unescape($C[2])).$C[3];return
idf_escape($z);}function
where($Z,$p=array()){global$g,$y;$I=array();foreach((array)$Z["where"]as$z=>$X){$z=bracket_escape($z,1);$e=escape_key($z);$I[]=$e.($y=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):($y=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($p[$z],q($X))));if($y=="sql"&&preg_match('~char|text~',$p[$z]["type"])&&preg_match("~[^ -@]~",$X))$I[]="$e = ".q($X)." COLLATE ".charset($g)."_bin";}foreach((array)$Z["null"]as$z)$I[]=escape_key($z)." IS NULL";return
implode(" AND ",$I);}function
where_check($X,$p=array()){parse_str($X,$ab);remove_slashes(array(&$ab));return
where($ab,$p);}function
where_link($t,$e,$Y,$tf="="){return"&where%5B$t%5D%5Bcol%5D=".urlencode($e)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$tf:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($f,$p,$L=array()){$I="";foreach($f
as$z=>$X){if($L&&!in_array(idf_escape($z),$L))continue;$Fa=convert_field($p[$z]);if($Fa)$I.=", $Fa AS ".idf_escape($z);}return$I;}function
cookie($D,$Y,$ve=2592000){global$ba;return
header("Set-Cookie: $D=".urlencode($Y).($ve?"; expires=".gmdate("D, d M Y H:i:s",time()+$ve)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($ed=false){$Ni=ini_bool("session.use_cookies");if(!$Ni||$ed){session_write_close();if($Ni&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($z){return$_SESSION[$z][DRIVER][SERVER][$_GET["username"]];}function
set_session($z,$X){$_SESSION[$z][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($Vi,$M,$V,$l=null){global$ic;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($ic))."|username|".($l!==null?"db|":"").session_name()),$C);return"$C[1]?".(sid()?SID."&":"").($Vi!="server"||$M!=""?urlencode($Vi)."=".urlencode($M)."&":"")."username=".urlencode($V).($l!=""?"&db=".urlencode($l):"").($C[2]?"&$C[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($B,$Ke=null){if($Ke!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($B!==null?$B:$_SERVER["REQUEST_URI"]))][]=$Ke;}if($B!==null){if($B=="")$B=".";header("Location: $B");exit;}}function
query_redirect($G,$B,$Ke,$Ag=true,$Hc=true,$Rc=false,$di=""){global$g,$n,$b;if($Hc){$Ch=microtime(true);$Rc=!$g->query($G);$di=format_time($Ch);}$yh="";if($G)$yh=$b->messageQuery($G,$di,$Rc);if($Rc){$n=error().$yh.script("messagesPrint();");return
false;}if($Ag)redirect($B,$Ke.$yh);return
true;}function
queries($G){global$g;static$vg=array();static$Ch;if(!$Ch)$Ch=microtime(true);if($G===null)return
array(implode("\n",$vg),format_time($Ch));$vg[]=(preg_match('~;$~',$G)?"DELIMITER ;;\n$G;\nDELIMITER ":$G).";";return$g->query($G);}function
apply_queries($G,$S,$Dc='table'){foreach($S
as$Q){if(!queries("$G ".$Dc($Q)))return
false;}return
true;}function
queries_redirect($B,$Ke,$Ag){list($vg,$di)=queries(null);return
query_redirect($vg,$B,$Ke,$Ag,false,!$Ag,$di);}function
format_time($Ch){return
sprintf('%.3f s',max(0,microtime(true)-$Ch));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Nf=""){return
substr(preg_replace("~(?<=[?&])($Nf".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
pagination($E,$Nb){return" ".($E==$Nb?$E+1:'<a href="'.h(remove_from_uri("page").($E?"&page=$E".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($E+1)."</a>");}function
get_file($z,$Vb=false){$Xc=$_FILES[$z];if(!$Xc)return
null;foreach($Xc
as$z=>$X)$Xc[$z]=(array)$X;$I='';foreach($Xc["error"]as$z=>$n){if($n)return$n;$D=$Xc["name"][$z];$li=$Xc["tmp_name"][$z];$Bb=file_get_contents($Vb&&preg_match('~\.gz$~',$D)?"compress.zlib://$li":$li);if($Vb){$Ch=substr($Bb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$Ch,$Gg))$Bb=iconv("utf-16","utf-8",$Bb);elseif($Ch=="\xEF\xBB\xBF")$Bb=substr($Bb,3);$I.=$Bb."\n\n";}else$I.=$Bb;}return$I;}function
upload_error($n){$He=($n==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($n?'Unable to upload a file.'.($He?" ".sprintf('Maximum allowed file size is %sB.',$He):""):'File does not exist.');}function
repeat_pattern($Zf,$te){return
str_repeat("$Zf{0,65535}",$te/65535)."$Zf{0,".($te%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($P,$te=80,$Jh=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$te).")($)?)u",$P,$C))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$te).")($)?)",$P,$C);return
h($C[1]).$Jh.(isset($C[2])?"":"<i>??/i>");}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~[^a-z0-9_]~i','-',$X);}function
hidden_fields($qg,$Hd=array(),$ig=''){$I=false;foreach($qg
as$z=>$X){if(!in_array($z,$Hd)){if(is_array($X))hidden_fields($X,array(),$z);else{$I=true;echo'<input type="hidden" name="'.h($ig?$ig."[$z]":$z).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($Q,$Sc=false){$I=table_status($Q,$Sc);return($I?$I:array("Name"=>$Q));}function
column_foreign_keys($Q){global$b;$I=array();foreach($b->foreignKeys($Q)as$r){foreach($r["source"]as$X)$I[$X][]=$r;}return$I;}function
enum_input($T,$Ha,$o,$Y,$xc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$Ce);$I=($xc!==null?"<label><input type='$T'$Ha value='$xc'".((is_array($Y)?in_array($xc,$Y):$Y===0)?" checked":"")."><i>".'empty'."</i></label>":"");foreach($Ce[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$cb=(is_int($Y)?$Y==$t+1:(is_array($Y)?in_array($t+1,$Y):$Y===$X));$I.=" <label><input type='$T'$Ha value='".($t+1)."'".($cb?' checked':'').'>'.h($b->editVal($X,$o)).'</label>';}return$I;}function
input($o,$Y,$s){global$U,$b,$y;$D=h(bracket_escape($o["field"]));echo"<td class='function'>";if(is_array($Y)&&!$s){$Da=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$Da[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$Da);$s="json";}$Kg=($y=="mssql"&&$o["auto_increment"]);if($Kg&&!$_POST["save"])$s=null;$nd=(isset($_GET["select"])||$Kg?array("orig"=>'original'):array())+$b->editFunctions($o);$Ha=" name='fields[$D]'";if($o["type"]=="enum")echo
h($nd[""])."<td>".$b->editInput($_GET["edit"],$o,$Ha,$Y);else{$xd=(in_array($s,$nd)||isset($nd[$s]));echo(count($nd)>1?"<select name='function[$D]'>".optionlist($nd,$s===null||$xd?$s:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($nd))).'<td>';$Ud=$b->editInput($_GET["edit"],$o,$Ha,$Y);if($Ud!="")echo$Ud;elseif(preg_match('~bool~',$o["type"]))echo"<input type='hidden'$Ha value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Ha value='1'>";elseif($o["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$Ce);foreach($Ce[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$cb=(is_int($Y)?($Y>>$t)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$D][$t]' value='".(1<<$t)."'".($cb?' checked':'').">".h($b->editVal($X,$o)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$D'>";elseif(($bi=preg_match('~text|lob|memo~i',$o["type"]))||preg_match("~\n~",$Y)){if($bi&&$y!="sqlite")$Ha.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$Ha.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$Ha>".h($Y).'</textarea>';}elseif($s=="json"||preg_match('~^jsonb?$~',$o["type"]))echo"<textarea$Ha cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Je=(!preg_match('~int~',$o["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$o["length"],$C)?((preg_match("~binary~",$o["type"])?2:1)*$C[1]+($C[3]?1:0)+($C[2]&&!$o["unsigned"]?1:0)):($U[$o["type"]]?$U[$o["type"]]+($o["unsigned"]?0:1):0));if($y=='sql'&&min_version(5.6)&&preg_match('~time~',$o["type"]))$Je+=7;echo"<input".((!$xd||$s==="")&&preg_match('~(?<!o)int(?!er)~',$o["type"])&&!preg_match('~\[\]~',$o["full_type"])?" type='number'":"")." value='".h($Y)."'".($Je?" data-maxlength='$Je'":"").(preg_match('~char|binary~',$o["type"])&&$Je>20?" size='40'":"")."$Ha>";}echo$b->editHint($_GET["edit"],$o,$Y);$Zc=0;foreach($nd
as$z=>$X){if($z===""||!$X)break;$Zc++;}if($Zc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Zc), oninput: function () { this.onchange(); }});");}}function
process_input($o){global$b,$m;$v=bracket_escape($o["field"]);$s=$_POST["function"][$v];$Y=$_POST["fields"][$v];if($o["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($o["auto_increment"]&&$Y=="")return
null;if($s=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?idf_escape($o["field"]):false);if($s=="NULL")return"NULL";if($o["type"]=="set")return
array_sum((array)$Y);if($s=="json"){$s="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads")){$Xc=get_file("fields-$v");if(!is_string($Xc))return
false;return$m->quoteBinary($Xc);}return$b->processInput($o,$Y,$s);}function
fields_from_edit(){global$m;$I=array();foreach((array)$_POST["field_keys"]as$z=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$z];$_POST["fields"][$X]=$_POST["field_vals"][$z];}}foreach((array)$_POST["fields"]as$z=>$X){$D=bracket_escape($z,1);$I[$D]=array("field"=>$D,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($z==$m->primary),);}return$I;}function
search_tables(){global$b,$g;$_GET["where"][0]["val"]=$_POST["query"];$gh="<ul>\n";foreach(table_status('',true)as$Q=>$R){$D=$b->tableName($R);if(isset($R["Engine"])&&$D!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$H=$g->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$H||$H->fetch_row()){$mg="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$D</a>";echo"$gh<li>".($H?$mg:"<p class='error'>$mg: ".error())."\n";$gh="";}}}echo($gh?"<p class='message'>".'No tables.':"</ul>")."\n";}function
dump_headers($Fd,$Se=false){global$b;$I=$b->dumpHeaders($Fd,$Se);$Jf=$_POST["output"];if($Jf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Fd).".$I".($Jf!="file"&&preg_match('~^[0-9a-z]+$~',$Jf)?".$Jf":""));session_write_close();ob_flush();flush();return$I;}function
dump_csv($J){foreach($J
as$z=>$X){if(preg_match('~["\n,;\t]|^0|\.\d*0$~',$X)||$X==="")$J[$z]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$J)."\r\n";}function
apply_sql_function($s,$e){return($s?($s=="unixepoch"?"DATETIME($e, '$s')":($s=="count distinct"?"COUNT(DISTINCT ":strtoupper("$s("))."$e)"):$e);}function
get_temp_dir(){$I=ini_get("upload_tmp_dir");if(!$I){if(function_exists('sys_get_temp_dir'))$I=sys_get_temp_dir();else{$q=@tempnam("","");if(!$q)return
false;$I=dirname($q);unlink($q);}}return$I;}function
file_open_lock($q){$ld=@fopen($q,"r+");if(!$ld){$ld=@fopen($q,"w");if(!$ld)return;chmod($q,0660);}flock($ld,LOCK_EX);return$ld;}function
file_write_unlock($ld,$Pb){rewind($ld);fwrite($ld,$Pb);ftruncate($ld,strlen($Pb));flock($ld,LOCK_UN);fclose($ld);}function
password_file($i){$q=get_temp_dir()."/adminer.key";$I=@file_get_contents($q);if($I||!$i)return$I;$ld=@fopen($q,"w");if($ld){chmod($q,0660);$I=rand_string();fwrite($ld,$I);fclose($ld);}return$I;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$A,$o,$ci){global$b;if(is_array($X)){$I="";foreach($X
as$fe=>$W)$I.="<tr>".($X!=array_values($X)?"<th>".h($fe):"")."<td>".select_value($W,$A,$o,$ci);return"<table cellspacing='0'>$I</table>";}if(!$A)$A=$b->selectLink($X,$o);if($A===null){if(is_mail($X))$A="mailto:$X";if(is_url($X))$A=$X;}$I=$b->editVal($X,$o);if($I!==null){if(!is_utf8($I))$I="\0";elseif($ci!=""&&is_shortable($o))$I=shorten_utf8($I,max(0,+$ci));else$I=h($I);}return$b->selectVal($I,$A,$o,$X);}function
is_mail($uc){$Ga='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$hc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Zf="$Ga+(\\.$Ga+)*@($hc?\\.)+$hc";return
is_string($uc)&&preg_match("(^$Zf(,\\s*$Zf)*\$)i",$uc);}function
is_url($P){$hc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($hc?\\.)+$hc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$P);}function
is_shortable($o){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$o["type"]);}function
count_rows($Q,$Z,$ae,$qd){global$y;$G=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ",$Z):"");return($ae&&($y=="sql"||count($qd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$qd).")$G":"SELECT COUNT(*)".($ae?" FROM (SELECT 1$G GROUP BY ".implode(", ",$qd).") x":$G));}function
slow_query($G){global$b,$ni,$m;$l=$b->database();$ei=$b->queryTimeout();$sh=$m->slowQuery($G,$ei);if(!$sh&&support("kill")&&is_object($h=connect())&&($l==""||$h->select_db($l))){$ie=$h->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$ie,'&token=',$ni,'\');
}, ',1000*$ei,');
</script>
';}else$h=null;ob_flush();flush();$I=@get_key_vals(($sh?$sh:$G),$h,false);if($h){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$I;}function
get_token(){$yg=rand(1,1e6);return($yg^$_SESSION["token"]).":$yg";}function
verify_token(){list($ni,$yg)=explode(":",$_POST["token"]);return($yg^$_SESSION["token"])==$ni;}function
lzw_decompress($Qa){$ec=256;$Ra=8;$ib=array();$Mg=0;$Ng=0;for($t=0;$t<strlen($Qa);$t++){$Mg=($Mg<<8)+ord($Qa[$t]);$Ng+=8;if($Ng>=$Ra){$Ng-=$Ra;$ib[]=$Mg>>$Ng;$Mg&=(1<<$Ng)-1;$ec++;if($ec>>$Ra)$Ra++;}}$dc=range("\0","\xFF");$I="";foreach($ib
as$t=>$hb){$tc=$dc[$hb];if(!isset($tc))$tc=$kj.$kj[0];$I.=$tc;if($t)$dc[]=$kj.$tc[0];$kj=$tc;}return$I;}function
on_help($pb,$ph=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $pb, $ph) }, onmouseout: helpMouseout});","");}function
edit_form($Q,$p,$J,$Ii){global$b,$y,$ni,$n;$Oh=$b->tableName(table_status1($Q,true));page_header(($Ii?'Edit':'Insert'),$n,array("select"=>array($Q,$Oh)),$Oh);$b->editRowPrint($Q,$p,$J,$Ii);if($J===false)echo"<p class='error'>".'No rows.'."\n";echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$p)echo"<p class='error'>".'You have no privileges to update this table.'."\n";else{echo"<table cellspacing='0' class='layout'>".script("qsl('table').onkeydown = editingKeydown;");foreach($p
as$D=>$o){echo"<tr><th>".$b->fieldName($o);$Wb=$_GET["set"][bracket_escape($D)];if($Wb===null){$Wb=$o["default"];if($o["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$Wb,$Gg))$Wb=$Gg[1];}$Y=($J!==null?($J[$D]!=""&&$y=="sql"&&preg_match("~enum|set~",$o["type"])?(is_array($J[$D])?array_sum($J[$D]):+$J[$D]):(is_bool($J[$D])?+$J[$D]:$J[$D])):(!$Ii&&$o["auto_increment"]?"":(isset($_GET["select"])?false:$Wb)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$o);$s=($_POST["save"]?(string)$_POST["function"][$D]:($Ii&&preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Ii&&$Y==$o["default"]&&preg_match('~^[\w.]+\(~',$Y))$s="SQL";if(preg_match("~time~",$o["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$s="now";}input($o,$Y,$s);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($p){echo"<input type='submit' value='".'Save'."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Ii?'Save and continue edit':'Save and insert next')."' title='Ctrl+Shift+Enter'>\n",($Ii?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'Saving'."??, this); };"):"");}}echo($Ii?"<input type='submit' name='delete' value='".'Delete'."'>".confirm()."\n":($_POST||!$p?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$ni,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0?\0\n @\0?C??\"\0`E?¸àÿ??tvM'”Jd?d\\Œb0\0?"™Àf?¤îs5›ÏçÑA?XPaJ?„¥?8?RŠT©‘z`?.©Çc?Ãş???\0¡Im??«M?€\0È¯(???/(%?0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\n1?“ÙŒŞl7œ‡B1?vb0˜Ífs‘¼?2BÌÑ±Ù˜Şn:?(¼b.\rDc)ÈÈa7E?‘¤Âl¦Ã±”?1?s˜´?4™‡f?ÈÎi7?³¹¤Èt4…¦??f4?°i–AT«VVéf:Ï¦,:1¦Qİ¼?2`??:7G?1ÑØ?°™L—XD*bv<?#£e@?4ç§!fo·?:<??¾™oâÜ\niÃÅ?,é»a_?¹i?´ÁBv?N?.5Nfi¢vp?¸°l¨ê¡ÖšÜO¦‰î= ?OFQĞÄk\$¥Ói?™ÀÂd2Tã¡pàÊ6?‹ş‡¡-?€ƒ Ş6½£€?h:?a?£???8??’˜6nâî†ñJˆ¢h«t…Œ±Š?O42ô½ok??r ©€@p@??¾ÏÃô??6À‰r[ğLÁğ?2Bˆj?!HbóÃP?!1V?"ˆ²0…¿\nS?ÆÏD7ÃìD??C!?›à¦G????tCæ©.C¤À:+ÈÊ=ªªº²¡±?ªc?MR/?E?4„©?°ä± ??(áÓ?WäÑ=?ySb??Ü¹BS+É¯ÈÜı¥?pL4Yd?„qŠøã¦ğê??Ä¬?Ac?èÎ¨Œk?&>??ZÁpkm]—u-c:?¸ˆNt?Î´p?ŒŠ8??˜á[.ğÜŞ¯?~ m?‡PP?I????Q?v[–Q•„\n–Ùr?g?áT?…­VÁõz?£8?(	¾Ey*#j?]­•RÒÁ‘¥)ƒÀ[N­R\$?>:ó­>\$;? Ì\r»„?ÍÃT?nw¡N ?Ø£?<??wàö??\Y? Rt^??r}ŒÙS\rz?=?nL?J??",Z?¸™i?u?¨ûÑô¡s3#¨Ù‰ :ó¦?ã½?ÈŞE]xİÒs^8£K^É÷*0ÑŞw?àÈ?ã?íÑiØşv2w???7???£cİÑu+U%?{P?4Ì¼?X./!¼‰1CÅßqx!H??dù­L¨¤?Ä ?6??5?™f€¸Ä†¨=H? ŒV1“›\0a2?Ô6†àöş_??\0&?? d)KE'?nµ[X©³\0Z??[P‘Ş?àß!???`?\"Ú·Â0Ee9yF>ËÔ9bº–ŒæF5:??0}Ä´Š‡(\$Ó‡ë€37H?£è M¾A°²6R•ú{Mq?G ÚC™C?2?ŒCt>[?t?/&C??tGôÌ?4@r>ÇÂ?šSq?åú”Q?hmšÀĞÆôãôLÀÜ#èôK?®™?fKP?r%t??=\" SH\$? ¸)w?W\0F³ªu@???rr??¬DŒ”Xƒ³?OI?»…n†Ç¢%ãù?‹İ_?t\r?z?\1˜hl?Q5Mp6k†ĞÄqh?$£H~?|??*4Œñ??Sëı²S t?P\\g±è7?n-?è¢ªp´•”ˆl‹B¦?7Ó¨c?wO0\\:•Ğw”Á?p4ˆ“?TÚújO?6HÃŠ¶r??q\n¦É%%¶y']\$‚”a‘Z?fc?*-?Wºúk„z?°µj?°lg?:?$\"??r#?âÃ‚Âÿ?cá¬???"j?rÀ¶?¦ˆ?¼Ph?/?œDA) ²?ÀknÁp76ÁY´‰R{?¤Pû°?\n-¸a?şß[»zJH,–dl?B£ho³????Dr^?µÙeš¼E½½? ÄœaP‰ô?G£zàñt?2??¢´Á¿V¶×ßà?È³‰ÑB_%K=E©¸bå¼¾ßÂ§kU(.!Ü®8¸œüÉI.@K?nş¬?ÃP?32«”m?		C*?v??nR¹ƒ•µ?0uÂíƒæîÒ??¯˜Š”P/µJQd?L–Ş?YÁ2b¼œT ???†—?ê¥V=¿†L4ÎĞr?????­MeLŠª??öùiÀo?< G”¤??Mhm^¯U?ÀŒ??r5HiM?¬nƒí³T [-<__?/Xr(<‡¯Š†???u?GNX20?r\$^‡:'9è¶O…í;??¼†µf –N'a¶”?­b??¤ô…«1µïHI!%6@??$?G???mUªå…rÕ½?ßå`¡ĞiN+Ãœ?šœ?lØÒf0??UâøVÊè-:I^ ˜\$??b\re‡‘ug??9Ûßˆb˜µôÂ??0¬Ô hXrİ¬?\$—e,±w+„÷Œë?†Ì_?…kšù\nkÃrõÊ›cuWdYÿ\\?{.óÄ˜¢g»‰p8œt\rRZ¿vJ:?ş£Y|+?À‡ƒÛCt\r€?jt½6²ğ%?àô??>?¥ÍÇğ?F`?äòv~K¤áö??‹ğz??mªwL?Y?q¬xÄzñèSe?›³è÷?šDàÍ??x˜¾ëÉŸi7?Äø?İ»’û_{ñú53âút˜?Ÿõz??)‹C?\$?KÓªP?ÏÏT&??\0P?A??¢ƒ p? ???Ôõ\r\$ŞïĞÖ?*+D6ê¶¦ÏˆŞ?\$(?lŞÍh&”ìKBS>¸‹?z¶¦xÅoz>??oÄZ?n?[????µ°2?x?V?f???2Bl?k?Zk?hXcd?*ÂKTâ¯H=­•?‘p0ŠlVéõèâ\r¼Œ¥nm?)(??#¦âòE‰Ü:C¨CàÚ?\r¨G\rÃ©0?…iæÚ°ş:`Z1Q\n:€?r\0?çÈq?°ü:`?-?#}1;èş¹‹q?|?€¾¢hl™D?\0fiDp?L ``™°??y€?1?€?r?‘MQ\\¤³%oq–­\0?ñ£1?1?1°­ ?±§?bi:“í\r?Ñ¢?`)šÄ0??@?Â›?ÃI1?N?ØàŠµ?±¢Zñã1?±ïq1 ?Ñü??rdI?Ç¦v??1 t??°â’0:?ğğ? A2V„ñ? é?%²fi3!&Q?Rc%?&w%Ñì\ràV?#Êø™Qw`?% ¾„?*r??&i?r{*²»(rg(?(2?ğå)R@i?  ˆ?\"\0?²Rêÿ.e.r??,?ry(2ªCàè²b?B?3%Òµ,R?²Æ&èşt€??\rL“³-3? Ö ó\0??p??4³O'R?3*²³=\$??iI;/3i??&?17? Ñ¹8 ¿\"?Ñå8?*?3??!1\\\0?“­rk9?S?3?àÚ??q]5S<³Á#3?3?#e??~9S?³‘r?€?T*a???es???-?é?*;, Ø?!i´›‘LÒ²?#1 ?n??²ã@?i7?1?´_•F‘S;3??rA?3?´x:?\r?ÎÔ@??¬ÓwÓÛ7??‘J3??F?$O¤B’±?4?t?g?q\rJt‡JôËM2\rôÍ7ñÆT@“£??£dÉ2€P>Î°€Fià²´ş\nr\0?¸b?k(´D¶¿?Qƒ¤´ã1?"2t”ôôºP?rÃÀ,\$KCt?ôö#ôú)¢áP#Pi.?2?C??"?);}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…?1ĞÊx:\nOg#)Ğêr7\n\"†è??2?Si–H)N¦S‘ä?r‡\"0¹Ä@??(\$s6O!ÓèœV/=Œ' T4?„˜iS˜6IO G#?X·VCÆs¡ Z1.?p8,?¦Häµ~Cz§É?¹l¾c3šÍ?£‘?†b?\n?8T?I˜İ©U*fz??0E?À?¸?Y.:?ƒIŒÊ(?·á?!?l™í^?(¶šN{S–“)r?ÁY“–lÙ¦3??n?G¥Ó?ºí†Ëi¶Â?V3w³uh?rØÀ?´a?ú¹cØè\r“¨?.ÂˆºCh?\r)èÑ£¡`?£í?3'm5Œ£?\nP?2£P»ª‹q ?ÅC?Ä«ˆúÊÁ?8?B?hR‰Èr(?¥¡b\\0ŒHr44ŒÁB?¡p?$rZZ??.?(\\??|\nC(?"?€P?ğø.ĞN?T??Àæ>HN…8HP?\?Jp~?Üû2%¡ĞOC??ƒ§C8?HÈò*ˆj°…??(?¡ì?KUœÊ‡¡<2‰pOI„ô?`Ô?â³ˆdOH Ş5?üÆ4ŒãpX25-Ò¢òÛˆ°z7£¸\"(°P?\32:]U?èíâß?]?·A?Û¤’Ğ?Ú°‹l\r?0v²Î#J8«ÏwmíÉ¤?ŠÉ æ?m;p#?XDŒø?ZøN0Œ•È9ø¨? Á?…wJD???tŒ¢*øÎyìËNiIh\\9ÆÕèĞ:???ï­µyl*???? Ü‡ø?’W³â?µŞ?Ùğ?\"6?n[?\r?*\$¶Æ§¾nzx?\r?*3×£p?ï»¶:(p\\;ÔËmz??9?ĞÑÂŒ?N…Áj2½«Î\r??H&Œ²(Ãz„Á7i??‹Š¤‚c¤‹e?ı§tœÌ?:SHóÈ Ã/)–x?éåt‰ri9?õë?ÏÀËïyÒ·½°V?^WÚ¦?kZ?—l·Ê£Œ4ÖÈ?ª¶À¬‚ğ\\E??\0¹p?€?D€„i?TæşÚû0l?=Á ??9(??n\n€n,4?0?a}?.°öRs??02B\\?1ŸS?0003,?PHJsp??K?CA!?*W?Ôñ?\$?Âf^\n?1Œ´òzE?Iv?\?2??*A°™?E(d±á°Ãb?ÂÜ„?‡‚?ÁDh????H°sQ?’x~nÃJ‹T2?&ãàeRœ½™G?Twêİ‘»?ˆâ?\?6??Âòsh\\3?0R	?\r+*;R?????~?t< ??#Â‘??ßÌ?eŒ³??ÄÀ??$	Á½`?–CX???0Ö­å¼?³Ä:M?	çÚœGäÑ!&3 D?!?23„Ã?h?J©e Úğh?\r¡m•˜?i¸£´’†??l7¡®v‚êWI?´Á-?Ö§ey?\rEJ\ni*?$@?U0,\$U¿E†¦ÔÔÂªu)@(t?SJk?!€~­‚?`?¯•\n?#\rp9?jÉ¹?&Nc(r€ˆ•TQUª½S·Ú\08n`«—y•b¤Å?L?5‚î,¤ò‘>‚†x??±fä´’â??–\"?€{kM?\r%?[	?e?a?! ?í³Ô®©F@«b)RŸ£72ˆî0?nW¨™±L²Ü?Ò®td?í?0wgl?n@òêÉ¢??«ƒ\nA§M5n?$E?×±NÛál©İŸ×?? AÜû?ú÷???FB?Ïùol,muNx-? Ö¤C( f?l\r1p[9x(i?B?²ÛzQlüº8C??©XU Tb£İI?•p+V\0???CbÎÀX??sïü]H÷Ò[?‹x?G*??·awn??‚òâÛ?mSí¾“IŞÍK?/Ó?ŞùeeNÉòªS?;d??>}l~Ï? ?^?fçØ¢p?DEîÃa·‚t\nx=Ãk??*dºê?—ºüûj2ŸÉjœ\n‘ ?,˜e=‘†M84ôû?a•j@?ÃsÔ?f©İ\n??rd??Şí??%???	Ò¨†<??–A?–H¿G‚8?¿?\$z«ğ{¶»²u2*??–À>?w?K.bP?{…ƒo??Â´?z??2?=?8>ª¤³A,°e°À??è§x?Ãá?b=m‡™?‹a’Ãlzk?$W?mJiæÊ§á?+‹è???.R?KùÇ???ZLËç2??(??Z¡Ü?À¶?$×???H±ÖNxXôó)’îM¨‰\$?Í*\nÑ£\$<qÿÅŸh!¿¹S??ÀŸxsA!?´K¥Á}Á²“ù¬£œR?A2k·Xp\n<?ş¦ıël?§Ù3?¦È•VV?£g&Y?!??<¸YÇóŸYE3r³Ùñ›C?5¦Åù¢Õ³?k?ø°ÖÛ£«?t?U???ıßÁî}??´«lç¢:DŸø+? _o??140Öá?ø¯b?˜ã¬’ öşé?lGª„#ªš©ê?†¦©ì|Udæ¶IK«ê??ìà?@º®O\0H??i?\r‡Û©Ü\\cg\0öã?B?e?\n€?…zr?!nWz&? {H–ğ'\$X  w@??DGr*ëÄ?H?p#Ä?¦Ô\nd??,?¥—,?g~?\0?€?²EÂ\r?`??'??%E??`????%&Ğîm°ı\râŞ%4S„v?\n fH\$%?-???Bâí?ÀÂQ-?c2Š§?&?ÀÌ]? ?qh\r?]à®s Ğ??7±n#±‚‚Ú-?E¯Frç¤l&dÀØÙåz?6¸ˆÁ\" ?|¿§¢s@?±®?)0rp?\0‚X\0¤Ù?DL<!????D?.B<Eª‹?nB(??\r\n??à?h?‚Ö?\$§’(^?èŞÂ/p?q??¨ÅO?ˆğ?\\??RR??ëä??j?`? ô??V? bS’d§iE?øïoh´r<i/k\$-?$o”¼+ÆÅ‹Î?ÒŞO?ev?¼i?MPA'u'Î?( M(h/+«òWD¾So?n???ìê(?\"?À§h?p†¨/?1D??å¨?EèŞ&â¦€?'l\$/.,Äd¨…‚W€bbO3?³sH?J`!?€ª‚‡À?¥ ?,FÀÑ7(‡ÈÔ¿??Šl? ÖÒ‘²—Å¢q¢X\rÀš®ƒ~Ré°?`??ó®Y*?R¨ùrJ??L?n?"ˆø\r¦Î?H!qb??i?ÓŞ?¨Wj#9ÓÔObE.I:??7\0?+???…Ş³a7E8VS?(DG?Ó³B?;ò¬ùÔ/<’´ú¥?r ???À°@¶¾€H Ds?°Z[tH£Enx(?©R?x???GkjW?ÌÂ?T/8®c8?0Ëè_?IGII?!¥ğ?YEd??td?h?DV!C?¥\r?Ÿb??3?@?3N}?B?	??30ÚÜM(?‚Ê}?\??f?fŒË?\r?€?37 X?"td?\nbtNO`P???Ò­ÀÔ?$\n‚ßäZÑ­5U5WU?hoıà?t?M/5K4Ej³KQ&53GX“Xx)?5D??r??n??5b?\\J\">§è1S\r[-¦ÊDu?rÒâ§Ã)00?õÈË¢·k{\nµÄ#µŞ\r?·‹|?Ü»U?n?4??Yt?rIšÃ@?³™R ?3:?ePMS?TµwW?XÈò?¨ò¤KOUÜà•‡;U?n OYéY?Q,M[\0?ªDšÍ? ¾J*?rg(]à¨\r\"ZC‰©6u?+µY??Y6Ã´?ªq?Ùó8}ó3AX3T h9j?j??t?JbqMP5>ğÈø¶©Y‡k%&\\?d¢ØE4?µYnÊ?$<¥U]?1?mbÖ¶?Òõš ?\"NVéßp¶ëpõ±eMÚŞ?WéÜ?\\?\n ?nf7\n?2´õr8‹—=Ek7tVš‡µ7P¦¶LÉía6??@'?6iàïj&>±â;?`?a	\0pÚ¨(µJÑë)?\¿ªnûòÄ¬m\0¼¨2€?eqJö­PôtŒë±fjüÂ\"[\0¨·??X,<\\Œî¶×?÷æ?md†å~??…Ñs%o°´mn?,?æÔ??r4¶Â8\r±Î??E‚H]‚¦˜ü?W­M0Dïß€—å~Ë˜K??}??´à|f??Ü×\r>?z]2s‚xD˜d[s‡tS??0Qf-K`?‚tàØ„wT?€?€??nB? Nb–ã<??5o?J?ÀÏJNdåË\rh????"??HCàİ–:ø?Yn16Æôzr+z±ù?\??œôm ?±T öò ÷@Y2lQ<2O+?“Í.?h?AŞñ¸ŠÃZ??R¦À1£Š/¯hH\r¨X…ÈaNB&?ÄM@?x?‡Ê???&L??và±*šj¤ÛšGHåÈ\\Ù®	™²?s?\0Qš \\\"? °	àÄ\rBs›Éw‚	Ù?BN`??Co(ÙÃà¨\nÃ¨“???E??…ÓU?U?t?|”m™°?h[?$.#?	 ?p??B?R?£…?@|„§{™À?\0x??w?%¤EsBd¿§šCU?O×·??X???¨Z3?1¦¥{©eLY‰¡ŒÚ¢\\?*R`?à¦\n…Š?ºÌQCF?¹¹àéœ¬?†X|`N¨‚?$€[†‰???àğ¦¶??Zd\"\\\"…‚¢£)«‡I??šìoD?\0[²¨?±‚-©“ gí³‰™?`hu%?,€”¬??Ä«²Hóµm???NÖÍ?$»MµUYf&1?À›e]pz¥§?¤Åm¶G/??w ??\#5?I¥d¹EÂhq€å¦?Ñ¬k?|??qDšb…z?§º???†“[?ÒÆ¬Z°Xš®:¹?·ÚÇj?5	¶Y¾0 ©Â“­?\$\0C?†dSg¸ë‚ {??n`??ÃüC ?·»Mºµ?»²# t}x?„÷º‡{ºÛ?êûCƒÊFKZ?j™Â\0PFY”B?Fk–›0<??<JE™šg\r??2–ü8?@*?fkªÌJDìÈ?•TDU76?´è?·‚K+„Ã??ÃÂ??ŒÜWIOD?5MšN?$R?\0??ràù_ğªœìEœñ?«Ï³N?£Ò?\\?ˆÇqU€?? ª\n@’¨€ÛºÃpš¬¨PÛ±?Ô½N\r?{*qm?$\0R”×??Ååq?Ãˆ+U@?¤çOf*†CË¬ºMCä`_ ?üò½ËµNêæT?Ù¦C×»???\W?e&_X??h?ÂÆB?ÀŒ??FW£û?™G?'??‚À°Ù? Ğ#^\r?¦GR€¾˜€P±İFg¢ûî?Yi û¥?\nâ¨??/“¨€‚¼?\\?èßb¼dmh×â@q?ÕAh?,J?W–Çcm?m]Óe?Zb0ßå?Y?ymŠè‡f?e¹B;¹Ó?ÉÀwŸapDW?ÉÜ??\0˜À-2/bN¬sÖ½Ş¾Ra“Ï®h&qt\n\"?i?m?z??†à?S7µĞPPòä–¤âÜ:B§ˆâÕsm¶­Y düŞ?}3?*‚túòéÏlT??€„€?cı?ÖŞ?Ú3?T²L?*	?#µA•¾ƒ‘sx-7?f5`?\"N?÷¯G?Ÿ‹???ïø?¤Ìs‘˜€?-?˜M6§£qq? h€e5?0Ò¢À±???S?ÉÜFÎ®9}????{?±É–kP?T<„©Z9?<?\r?;!?ˆg?r\nK?\n•‡\0Á°*?nb7(??@,?2\r?]–K?\0?p C\\Ñ¢,0?^?Ğ§šº??@?X\r??\$\r‡j?+???BöæP ½‰ù¨J{\"a?˜ä‰œ?å£\n\0»à\\5“?156ÿ?.?ÂUØ¯\0d??Y?:!?²‘=ºÀX.²uCªŠŒö!Sº¸‡o…p?İü?¸­Å¯¡Rh?\h?E=?y:< :u³ó2?0“si¦ŸTsB?\$ ???	??¦.?‚T0M\\/?d+?\n‘¡=??d?ÅëA¢¸?\r@@Âh3€–Ù8.eZa|.??Yk?À˜?'D#‡¨Y?@Xq?M¡ï44?B AM¤¯dU\"‹Hw4?(>‚¬8?²ÃC?e_`ĞÅX:ÄA9Ã¸™?«GĞä‡Gy6½ÃF“Xr‰¡l?¡½Ø»B¢Ã?Rz©õhB?€?0ëå^‚Ã-??D?F\"\"àÚÜÊÂ™?i???Af?\"tDZ\"_?\$??/…D€?†ğ¿µ?´ˆÙ¦¡Ì€F,25?›Tëá—y\0…N¼x\r?l¦#‘ÆEq\nÍÈB2?n??·…?Ó×?/?\n?‰Q???)bR¸Z0\0ÄCDo???8À•´µ‡Ğe?nã¦S%\\?PIk??(0ÁŒu/?‹G²Æ¹ŠŒ¼\\??Fp‘G???)g?tº[vÖ\0°¸?b?;ªË`(•ÛŒà?NS)\n?=èĞ+@êÜ7?j?—,?Ã…z™“??0ˆ‰GcğãL…VX??Ûğ?%À…Á„Q+??ÆFõÈ?Ü¶?Q-?‘Ú?‰¡?¤wàÌz5G‘ê?(h‘c?HõÇr?ˆšNb??¨öÇø°îlx3‹U`„rwª©?UÃÔ???Àl#òõlÿä¨?¥E\"Œƒ˜™O6\n˜Â1e?\\hKf—V/Ğ·PaYK?Ìı ???‰Oj„ór7¥F;??B?‘ê£í?‡¼>?Ğ¦²V\rÄ–??Jµz«¼??’PB?’Y5\0NC?\n~LrR’Ô[?RÃ¬?ÀeZ\0x?»i<Q?)?@?’™fB²Hf?{%P?"\"½?@??)?‘“DE(iM2‚S?ƒy??"âñ??1Œ«?\n4`Ê©>??Q*¦Üy°n?’¥T???âä”Ñ~%?W²XK‹Œ£Q??àlPYy#DÙ¬D<«FLú³??']?‡û\rF???\n?cĞô?Ë©%c8WrpG?T?Do¾UL2??\$??Xt5?Y?Iˆp#??^\n???#D?@?\r*?K7?D\0??C’C£xBh?nK?,1\"?y[?!ó×™â?©Ê°l_?€??0àÉ???4\0005J?\"2ˆŒ?%Y…¦a®a1S??ˆÊ%ni?PŒàß´q?_Ê½6¤š???\\?š‘d?‰údÑøŒ?—DÜÈ?€?3g^ãü@^6??îå_ÀHD?.ksL´Ô@?ùÉˆæn­I¦Ä??r“b?@¸Ó€•Nt\0s?éÂ]:uğÎX€b@^?\0½©???Àó6dLNe???0?©Ğ²l¡ƒz6q=Ìºx“§?6 ÜO,%@s?\n?\)?L<??·¦P?¶b?˜¼?A>I‹…?"	ŒÜ^K4?gIXi@P…jE?/1@???áºx0coaß§Áª‰ó,C'?#6F@¡Ğ ‰H0?{z3t?cXMJ.*B?ZDQğå?0°ñ“T-v¥Xa*”İ,*?bÁ•?x??€PÆòKG8??y“K	\\#=???h?&?8])½C?nÃ´ñÀ9¼zˆW\\’g? 7Šˆ!?•¡???–¬,Åò9ñ²?©©\$T\"?,Š¨%.F!? A?àé?ø¹-???\0002R>KE???IĞ÷ì³9³Ë¼¡j(Q°@??/???J.?RT?0]KS¹D‡–Ap5?rÂH0!?Â´e	d@R?Òà¸´?¢S?7H‘BÀbx?J???vi?`@ˆµÃSAM…¯XËÏG?iÙÓU*?Úö€?õû?'??V?Jv£D¾ÿN'\$?zh\$d_y?œ“Z]•™??Y?°³8?ş¡?¨P?*h?ÔÖ§e;€ºpeû¢\$k?§ì*7N²DTx_ÔÔ§½Gi?Pÿ?t?¨b?\EÆH\$iE\"cr½å0l?>ÁñŒ‘C(ŠW@3ÈÁ?2a´?IÁà¹Õ?¥B`ÜÚ?iÅ¸Go^6E\r¡ºG˜M¤p1i?¼¤X?0003??Kü§Óô?l&??IL?\?"??¬j(>??G_?? 10I?A31=h q\0ÆFŠ«?„Ä·Š??J?Œ„Ô³V?º‡?qÙÕš¢?Âà(/?dOC?sm?g?x\0??"ğ\n@EkH\0¡Jˆ­?€(¬¨¯km[?‘ì¿ÁS4?nY40??L\nŠ¦À“‘ì#BÓ«bçÀ%R?°µ×­?ÀR:?<\$!Û¥r??…Ç	%|Ê¨?(€|«H?0??ÁĞ???ÂcÒ¡=0?Zá¨\"\"=?•˜)½f?Ÿ6V}FÕÚ=[?à§¢hu?ø±\0t¥åbW~ºõQ•ÕiJŠö—L?×­q#kb ?n««??T??Âe?cS?+Ö´E?-‡–a]ÅƒˆìYb?n\nJ~?|J?8??p?™Á??€Nä©Ü¨…J.?ÅƒS??c9Ãj©y?`a\0Äö*ìÖ?\0+??gÉÚ6?¤ÔMe\0ªËQ ?_?}!I?’GL€f)ÃX?,“Shx?\0000\"h?L¥M??ªÑ˜±?	j?0¶ ?˜\$’¨>u*?Z9”îZå®eõ«+Jœ‰™¸tz?ÈË?ÈşR¨KÔ¯?ÑâDyŞ??C?f¢Åm‚¶¹ªBI?’¹HB‰œsQlÀX°ƒ.İÅöÔ|¸cˆª?[–óZhZåÃl˜¨??'µ ml²KrQ?6½•]?·n§d[İö?©‡d??"GJ9uòûBƒo?©Z??¥²n@Áªn°lW|*gX?\nn2??|x`Dk›„uPP?Q\rr‹™`W/¹Œ?1?-o,71bUs?¢©??²ËÉÛGq?\\Q\"CCT\"??ÄÒ*?u¨ts¶‰”°?áÙ©Pz[?YFÏ¹¢›FD3?"–ºÇ]u?)wz?#¶Í?iwŠêp?»ñ{?o?0nğ¶?Õâ\\?¸°?0q·måãíª&?Âî??²øÀ¹9[¤H?dL•O?´v?B¯tæ?\Æ¤‰Hd???" òìN\n\0·©GÅg? ¸F?\"ì­&QEK¾‘{}\ry?¾˜r?t›À„ï??NuÃ³[A?h;S??‚š±Â?|yùÏ[?_b?È¨?+RñèZX?0NééşÁP€??¡jD£Â¯z	şà?[?\"?e?8?>”EL4JĞ½?0›¡??7 €?d·¬ ÀQ^`0`œ•?c?g@²hy8˜íp.ef\n??h‡ƒaXÚÃømSßßjB?Q\"?\rë×?3?>ÇªAX?,,\"'<µ›?%¶a€«Ó´Ã?\$?0?%\0?sV????M\$?já×?¤­?Ve?$@—Í?#§ª?3:??U?Y?¶u?¨û?Ïâ?@ÄV#E?G/¸üXD\$ˆhµƒav–¼xS\"]k18a?9dJRO?s?EJ°½?Uo³m{l¹B8¥ˆ?\n}ei±b?? ? N”ª???\?Ç¸I5yR?$!>\\?Œg?uj*?n°MÓŞ²hİø\r%Á³?(d€¦Nµd#}špA:¬¨?-\\?A??€2I€?\rÖ£»? 0h@\\Ôµ???‚rq]ò?8\"? ŒÿîÆ?cÆày?	Ïá‘šda?‡Î?>U??Ñ?½@?‹Ûÿ\$?h2´?F»§?N?’Œ?rşÔ€(?r‚°d*?0[?cjŠ??!(SğÈ?ˆe?TÉÆM	9\0W:?BDıø?JŒ¬?@sÇárue‡ø?ğ»ı?+?B«É}\"B\"?2î‹rël»xF[?ÙË²Ea9 Êcdb??,?C=/2»×ò¼øì/\$C?Ú÷8?DÀÛ??`^;6B0U7ó·_=	,??1V[?	H9(1ï±?±ÒLz¢C??$.A?h?«¾Íà?rY	??~o?r19?—Ù?\šß„P?\"ÃQ¹´,?òöL¾”w0?\0§—š–Ï;w?X³Ç¨‰çqo¹ï?Ÿ«öç?9?>}²òºdc?0åÊg¾¶fÎùq?&9—??#??¸ª3^4m/?™¯\0\0006?¦n8£·>??.??’cph±ËÙù•›??A@[‰•7?9\$pMh?‰Œ?°K?úÃE=h?šA?t????"?c£B;¤ö?…ÕQ?t?›ò?,\n??ˆs?Ÿ™???4´—‚„Ií£©‘íù?€??yeÊ¨—U?”Bî©v³¥3H?P??êï’s|·º\r???$0ãè??1½©l3€?*oF~PK´ª.?'·J/Ó²t?‹d?š—n?n©ğj†Y?z????“w?? Z?Z?Io?1ÆÎ?\$ïò±¦=VWz?nB?a?A»µq?@™´I€p	@??lH{UºÜoXõ¿f?Ó¿\\zµ×.§š?-\\?^y n^Å×?Bq·ş…¤zX?¡ƒ\$?J72?4.†Õ…!¤M0¶óDëìFŠàóã G??ˆm?*m?cI£å5??—t¿ª’jl??¿S¶Q ¢.i’éÖÔh???Ú±B6?h?? …l\\‰ğWeªc?%kj™Á ¦pÃR=Œäi?.õ¥(?klHUW\"™o¥j½§’p!S5Æè­pL'`\0¤O *¦Q3XÂ“‰ŞlJ\08\n?r·²?€añü?¼??<??XBh?!xš®&?Bht?$ÿ‡ş]??éó?L€€[Æµ?d¸á<`œ?0?¢Ï‚Şaw?%;‘?C»…Q?rÌ­??Œì€pŠ¤«ØPQ¶Z’¸?ÁAu=N&?ia\n?K6I}Ñ×n	šÅt\nd)í®?È÷bp?€\"ğg'??Ãu?@?7?X NÀxÄáö?\$BùßZB/¶M¯gB»i¦ÖÑ§?\?ƒmIÌÄ€Êç?;5=#&4˜ÌçşP??‰½éğq?A™ä?\?,q¤c?\nc?–‚¾×?\0BgjD?;?=0m“k?\rÄ²?À¤'5?•¶k-?{¢‰\0??Muîøƒ2“Ò?§»£Àq?¬ğ>)9?\n?d+…ÔÔ§?G\rıÃn4?‹äO?5?†Ş8»1???¥‡(yGgWK?\r??“—m5.œ‚eŒH?J«Ak#»ÓL?.?\?=??ÙĞ„˜ƒ??7ºW+^yD‚“œb?G¡‘OZ?4?r?|xµÆ?r¸£,y©?qaÜ©O2µkªn˜Š#p2¾û?ºØ?¼£c’–U—c”öäëÅ‚j?$ôí8Ä¬~š7ZR:ğ×??Î¨w(a”L??,?Èì¿Œ#??8şÉ|?‡‘¬œÚ×%X‘W?n}6’‘H?ñæ?¤¡#?J,'z“M??¢‰Œààº‘Ü†² ‘˜?y6YQ¯‘ì¶Úºd?dÁŞóÏ:õãô£E?Œp2gŸg???ËäÚÕ?8?^;´UWN…ÑÅŞ??C??¤ô¢z?KX¢’?NŒdG£RCJY?‘i²’?#>zS²MUc£õƒ¨??ORÔ¾???Êú]:=?™tƒ‘Áë?\$™s?Fö?7	=\$B??!qs	1\"?¬v??‘ŒI•l<?b!Û®6(Cd-?<H`~2¹KìÍzKİÙ?Ô±??,qA??0}‚İC¨pb€\\???ßù?(›áÓí|»Mëğ„ÀWÚÀ5;\$5µT|ºò;kõñ?î?@??9?½ò;i??›·?¥ê×ÌF??œDä¥M`H?“ƒ\0? N @?%w‡ªdèPb?$H|k?¾ÜdCI!:lÅü,§¨??u?t”ô?Ne?W^¡w?6•ŒD¿áf? ¬ihI?:ŸÑ~ı÷Ï£r¾…??3?¯uoC·s2??a”XğwWK?HÔ¶27>?ÏÍ??£¬??£rpT¼”L?|`f™…:ÊõšA?t?d|i½³[wüèj?„ŠW?7‘¤£au‹© ú? ò•šA5­Q' ?\0??‹Ò?$?çı?rk)a; ó?=??~?GŠIæ°<ù´?"ù¬?1'?™¢Gcm\0P\n?èü#?>Œ½?B\"ñÒEm|…ù2?$}<3PYXgo£dß¶€<?Ôş£¿qE\"`×ú??g?r?\nˆ¡—õ:?qVbTì£?°•?K&?Ä¤?m?)@¨ÀQz›Ã?¢½ßµÅ±?H\nÔë?O?}?rÙ£.¢¹v‹®p¾JW&??5?	?ÀîP?ŒÁ\n½Ûí¸³Ææ­l\0O5*=Şú	…P-??\0??Ìt??¥S:±t??€?øÈ‚Hâñ÷ºq4ˆĞK?”§@€Ô¬»Ü?O(±ë?Z?$ÏÊ??‚Åo?€n‹z«A?€t85<W?2[??¶ùn5\$I?µæµ•Z?Àé?'}ET\nŸú†Š??í¤&?¦ÏV???D?oÈı&J6°ß4iÃj\$ÈÒEL¢ä?u“Üt¢‰Ëä+I¡Ğ¢¢šûØ£~?±SZTX? ¾PYz½Å\"\$V?]ÿM(§ã7?ºü·ÚÌáÃÀ?t_??S‰ó?Ã???t…½“Ä‚ü¿âmH?\0?? _Z'#ö¥??P¿é?,?(Ÿ°~?\0???`-?\ne? (¿Êˆ `9OËú!Á;5?n?$?{??ğìUAü¨7ùá!¿ç?[??Yı¿ÅFæ¿´ÿƒı?>?8&€??!CL??H€???0'?2ûìd\r%????ûÀ_O??³ö?@DıÒ¼Ï?0VÃA€6' AY?¢¶?S?¿‚££rÔ¾??h@bÿãõ?´ş‚O?M\0Àå˜Àr??ÿ\rJùÓm0\08???;kÓ ÊëşA(6?|	`8 ?0??¿²E?Ïå\0VşãñÏ?wk…NÀ°KùÁ??xdpÀÒÿs?L§â«A?X??‘u\0?ïş„Ít ÀÔ?.?(N?ÅK'flï¢ªd?Š‚?++ğN“Œ~‚ ÿ²˜??¾²€ªPR\0èúx¡??ûè??‹BK]¦bU??\\??„d\0S@¿ä«QÀï?šb?0\0b?„Ö\0_\\?\nN—î äO???PfÁ?€ Œ¶ô?Aj ¨ÂM4<?“°??À¿¨Ÿ`S‰‹ ìü??3T?¬„7?X»Â†T!\0e?AI? 1!\0€??åà'?@??\0??? º!:K?,?AS?‘f®e©ÎMùı.:˜¼:òÆt?»¡àÃ?_ºd?‹°81v`B\"??.^?åáN.^‡š\n?\r(Ÿš.Á©§îO0Š«@÷ÙPŠ¹nj???#¡¼îäÓå&¹‚rH?¨†? ??3??i @?AaÁÅ{?Â¬#?©½?ğ¨˜¶F@©?¦ãY[O?? .???B?ËñÇó)L02B??ÁÆ€Øùqp¹‹J<??\0\n??0??@8C?P??r	PÂ•?)üğF?âå\$q.]?"B#‹Å	?\\£Â84\$Ãs:.(*Oi>?#T'`—Bu«a/??ÀÂT?a?8?`p ¸ÚÕ?0`?0");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜è?:™E‡CI´Êo:?C„”Xc‚\ræØ„J(:=ŸE?¦a28¡xğ¸??ƒi°SANN‘ù?s?NBáÌVl0›Œ?	œËUl?(D|?çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|?Ç÷d.¼x8EN¦ã!”Í2??©ˆ?r?ÑYÌ?6GFmY?o7\n\r?¤÷\0Dbc?¾Q7Ğ¨d8‹Á?~‘¬N)?Ğ³`?sßğ`?)??·ç/?<x?o»ÔåµÁì3n«®2?r?;??ˆCÈ¨®‰?n<?`Èó¯b?\???\r#`?<¯Be?#¤N Üã\r.D`¬«j?ÿp?ar°øã¢º÷>??$? ¾1?œ ¡c ê??n7ÀÃ??A??Li\r1À¾???jÂ´?Âê62?X?+?âà?\r????!x¼åƒh?ãâ?S?0RïÔôñO?n??(W0…ãœÇ7qœë:NÃE:68n+äÕ´5_(®s?\r??/m?P?ÃEQà?\n¨V-‹Á?"?:?Ï8we???³X?]µİY XÁe?Wâü ?âûZ1íhQfÙãu£j?Z{p\\AU?<?káÁ@¼ÉÃ??}&„ˆL7U°wuYhÔ2¸È@??P??†hèÌò°?Ã›??E?Z?­l?Mplv???ÁHW?‘Ôy>Y??Ÿè/«›ªÁî hC?*‹ûFã­#~???r#0P??—f ·?¡î?\?¶‡???B<?\?f?Ş±ÅáĞİ?/¦O‚ğL\\jF¨jZ??\:Æ´>N¹¯XaFÃA?³²ğÃØÍf?h{\"s\n?4‡ÜøÒ…¼???p?"?°ñÈ¸\\?(¸PƒNµìq[g¸Árÿ&?}PhÊà¡ÀWÙí*Şír_s?‡hà¼àĞ\nÛËÃomõ¿¥Ã???§¡.?0@?pdW ?\$Òº°QÛ½Tl0??ÃHdH?š‡???PÓÜ?gàıU?ªB?\r†t:‡Õ\0)\"Åt?´œ’Û??D?\nR8!†Æ¬Öšğ?A??? h?£Sq<à@}Ãë?K???]?90°'€?âøwA<‚ƒ???€?WšæƒD|A´†???2àéyÅŠŠ=¡p)?0P	˜s€µn??r„f\0¢F…·ºvÒÌG?ÁI@?¤”?Àö_I`?Ìô?r.ƒ N?ºËKI?”Ê–SJ?©¾aUf›Sz?«M??%¬·\"Q|9€?Bc§aÁq\0???a„³:z1Ufª·>?Z¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n?Ò°s¦„?gxL´pP?B???\?b?é¾’Q?7???¡Q?r:ƒtì¥:y(??\n?)?ĞÒ\nÁX; ‹??CaA?ráİ?P¨GH?¡ ??\n\nAl~H úªV\nsªÉÕ«Æ?bBr£ª?„’?ßû3?\rP?¢Ñ?r}b/‰Î?$?5§P??"w?_??U?Atë¤?å¤…é^QÄåU?ÄÖj™Á?Bvhì¡??¹ã+?<–j^?Lóà4U* õBg ëĞæ?n???ÿÜõ?	9O\$´‰Ø·zyM??\9Üè?oŠ¶šÌë¸E(i??œÄ?	t??-&?nj!\rÀyœy?1gğÒ?«ÜyR?\"ğæ?·ƒ?ÀíàÜ)TZ0E9M?ZtXe!???È¬yl	8?;¦ƒR{„ë8?Ä®Áe?UL??F??øæ8PE5-	?!?…ó?2‰J???HR²éÇ¹€8p?²İ?™£0,Õ®psK0\r?”¢\$sJ?Ã4?Z©ÕI¢™'\$cL”R–MpY&ü½Íi?z3G?z?J%ÁÌP????xç³T?p¶§z‹C??¥Ó:ƒV'?\–’KJa¨ÃM?º°£Ó?"à²eo^Q+h^??Tğ1ªOR??5[?\$¹·)?jL?U`£S?Z^?€‡r????»–˜TU	1Hyk›Çt+\0v??r	<œà?ìñjG?­t?3%k›YÜ²T*?|\"CŠülhE??\r?r‡×{??å²×ş??Œ‡.6Ğ¸?ãü‡„rBjƒO'?¥¥?\$¤Ô`^6™Ì9?¸¨??Xş¥mh8:êûc??ø×;??·¿¹Ø;?\'( î„t?+?™òı¯Ì·???N?¹ç#??ğ×ÃO?iÏ–©>·Ş<S?\\€\\îµ??*tl`??0p'?…P?9·bs?Àv?·ü7?"{ÛÆr???æ¼?÷úÿë¹gÒÜ/¡øU?g¶î?ÈÔ`?nL\n?)À†?A??" ?çØ	?&„P??O\nå¸?0?(M&©FJ'?! ???ëîÂçÆù?*?ìÆ*?Z?*n/b?ö®?ˆ¹.ìâ©o\0ÎÊdn???i?RÎ?2??0/v?X÷ğ?Ê³??Œè?"ñ®êöî¸???¬©?bËĞgjğğ\$??0}???=M?0n??/p?t?€÷°¨ğ.ÌÌ?g\0?o?n0È÷?rF¶é€ b¾i¶Ão}\n?Ì¯?NQ???Fa?îÎ?L??ğĞàÆ\rÀÍ\r€Öö?0??ğ¬?	oep??DĞÜ?¦q(~ÀÌ ?r‚E°Ûpr?VFHœl£‚Kj¦¿?&­j!?`?bh\r1? ºn!???z™°?ğ¥?\«¬\r???V_kÚÃ\"\\?'Vˆ«\0Ê¾`ACúÀ±Ï…¦V?\r%¢’?Åì?rñâƒ‚k@NÀ°?Bñíš™? ??n?0Z?6?$d Œ,%?la??n?¢S\$!\$@¶İ2±?I\$r€{!±°J?H?M\\ÉÇhb,?'||cj~g??¼Ä¼º\$ºÄ?+?1?E€?ÀÙ <???$?%-FDªŠd€L?³ ?n@?bVfè¾;2_(ëôLÄĞ¿Â?%@?,\"?ÄÀN‚er?0?`?¤Z€??'ld9-?`äóÅ–…à¶Ö?6ëÆ£ãv ¶?ÕÍf Ö@??’B\$å¶(?&„ß?78I à¿?\rk\\§?`?rdLb@E?2`P( B'?€?€?? ô{Â•“??dB???*\r\0c<K??sZ?ºÀÀO3?=@?ÀC>@ÂW*	=\0N<g?s67Sm7u?	{<&L?3~DÄê\rÅš¯x??,r?n? åO\0o{0k?3>m??\0”I@?T34+?@e”GFMC?rE3?tm!?1ÁD @‚H(‘Ón ÃÆ<g,V`R]@úÂÇÉ3Cr7s~ÅGI?@\0vÂÓ5\rV?¬ ? Î£PÀÔ\r?$<b?%(‡Ddƒ‹PWÄîĞÌb?fO ?\0? ??lb?‰vj4µLS¼¨Ö´Ô¶5&dsF M???".H?0?1uL?"ÂÂ/J`?Çş???Yu*\"U.I53Q?Qô»J„”g ’5?sàú?j?’Õu‚Ù?ªGQMTmGBƒtl-c?±ş\rŠ«Z7Ôõ?hs/RUV·ğôªBŸN?¸Ãóã???¨Lk?©´Ät?é¾©…rYi”Õ?Sµƒ3?\šT?M^­G>?ZQj?‡™\"¤¬i”ÖMsS?\$Ib	f?âÑuæ¦´™??SB|i¢ YÂ¦ƒà8	v??D?`‡†.€??ÅM?Õ¼ŠuÀ™U?`ZJ	eçº?Ceíëa?"m??Ô¯JR??‘T?Ô£XMZÜÍ?ÍòpèÒ¶ªQv¯jÿjV?¶¼ÅC?rµÕ7‰T??úí5{Pö¿]?r?Q?AÀè‹’Í2ñ¾ “V)Ji£Ü-N99f–l JmÍò;u?@?FşÑ ¾e†j€?Ä¦I?+CW@?çÀ¿Z‘l??2ÅiF?`KG?L&+NàYtWHé£‘w	?•ƒ?€?'gÉãq+L?biz«ÆÊÅ¢Ğ.??W²Ç ?d•W¦Û÷¹(y)v?4,\0?\"d¢¤\$B?²!)1U?bp#?m=×È@ˆw?P\0?r?¢·?`O|ëÆ?œÉüÅõ?ôæJ??×ÙOu??n`F`?}M?#1?¬f?´Õ?µ§  ¿z?c?—³ xf?kZR¯s2?-†’§Z2?Ê·¯(?U?DòÑ·Ê??!àÍu?-vPĞØ?\0'L?X ??¹Œˆo	??¸Õ??r@??\rxF×üE€ÌÈ????ì®?5N?ƒ¸???ËÃ…©w??X?8 ?ø¯q¬£zãÏd%6?t?…•˜ä¬ëLúÍl¾Ê,?a•N~?ÀÛìú,ÿ'íÇ€M\rf9£w˜!x÷x[ˆÏ‘ØG?;„xA˜ù-I?5\$–D\$ö¼?…ØxÑ¬Á”ÈÂ´À??›¤?&o?3??ù½zü§y6?u¹zZ èÑ8ÿ_•Éx\0D?šX7†™«’y±OY.#3?8 ™?˜e”Q??*˜™GŒwm ³Ú„Y?? À?YOY¨F¨íšÙ)„z#\$eŠš)?/Œz?£z;™—??ÛúF?g¤ù• Ì÷¥™§ƒ?^?¡­¦º#?“Ø?©?œ¸e?M£Ú3uÌåƒ0??"?Ÿö@?Xv?"?”Œ¹¬?Ô¢\r6v~‡ÃOV~?×¨?g?šÄ‘Ù‡'?€f6:-Z~¹šO6;zx²;&!?{9M?Ù³d?\r,9Öí°ä·W?Æİ??rúÙœù?@??¢·]œÌ-?g™?[s?iÙi?››y›éx??7?7?w?„¢?£E???Wk?J???xmˆ¸q xwyjŸ»?³˜e??²©‰¸Àß?Ã¾™†ò³ {èß? y“ »M»¸?«æ?“°Y?g?-ÿ©º©äí¡?¡ØJ(???;…y?S¼‡µY„Èp@??úo?;°ê¿ôõ¤??	?«Á?ˆZNÙ¯Âº§„?k¼V§·u?ñ¼x…|q?¤ON?€ÉÕ	?u????X¹¤­—Ø³|O?!??¨œ?Y]–¬¹™c•¬?r¹h?n?Á¬¬ë?€?'—ù‚ê??rS.1¿¢USÈ¸…¼X‰É+ËÉz]Éµ??œ©ÊÀC?r×Ë\\???$?ùÌ)U?Ë¤|Ñ¨x'?ØÌäÊ<àÌ™e?êÍ³ç??Ìé—LïÏ??€(Û§?Ğº¤O]{Ñ¾?FD??¡yu‹ÑÄ’?XL\\?xÆÈ;U×ÉWt€vŸÄ\\OxWJ9??5·WiMi[?K?€f(\0æ¾dÄšÒè¿©?r?MÄáÈÙ7?ÈÃÆóÒñçÓ6‰KÊ¦I?rÄÜÃxv\r²V3ÕÛßÉ???ùÂ??á|Ÿá?^2?0ß¾\$ QÍä[ã¿D÷áÜ£?1'^X~t?1\"6Lş??¾A?e?“æ??‘ç~Ÿåâ³â³@ßÕ?pM>?<´ÒSK??HÉÀ¼T76?Mfg??ÅGPÊ°›P?r¸é>?ö¾¡¥2Sb\$•C[Ø×??Ş%Q#G`uğ°?wp\rk?e—zhj?“zi(ôèrO«óÄŞÓş?=?³ò?ÿ4\"ef??™ô?ÿZ‰š???'VµJ?Z7Ûö?T‘£8.<¿RMÿ\$‰ôÛ??y?n5?İõ_??ñÎ???`eiŞ¿J?b©g??SÍë?Íå`öáì+¾Ï?M??`ùï?0???Ÿõ_????0“õ¸X?å´?²¯J?&~D#Áö{P?Øô4?½ù\"?\0??‹ı§??–¥\0F ?* ^ñï¹å¯wëĞ??¾uàÏ3xK??“¼¨ß¯‰y[?(æ???/zr_”g·æ??\0?€1wMR&M?†ù??St€T]İ´G?I·à??‡©B?? vô§’½1?<?tÈâ6??W{?Šôx:=Èî‘ƒ??óø:?!\0x›Õ˜£?&áè0}z\"]ÄŞo•z¥™?Ãw×ßÊÚ?6¸ÒJ¢P?[\\ }ûª`S?0à¤qHM?7B?P?ÂÄ]FT??8S5?/I?r?n îO?0aQ\n??­j?=Ú¬?A=­p£VL)X?nÂ¦`e\$˜TÆ¦QJÎk??O?? .‰ˆ…òÄ¡?röµ?$#p?T>!ªªv|¿¢}ë×?%??;¨ê›å…­?f*?«ç„˜ïô?0¸ÄpD›¸! ¶õ#:MRc??B/06©­?7@\0V¹vg€ ØÄhZ\nR\"@?F	‘Ê???°E?I?n8&2?X?Ä¬€Í¤=h[§¥?ÕÊ?r:ÄÍF?0:*åŞ\r}#?!\"¤c;hÅ¦/0ƒ·??j?Á‚??’ˆ‘?0?iW_–”®h?ŒVRb°ÚP%!?b]SBšƒ’õUl	åâ³érˆÜ\r?\0??"Q=ÀIhÒÍ€? F‘ù?èÎFxR‚Ñ?@?\0*?5Œ?\0?0'?	@El€O˜ÚÆH Cx?@\"G41?`Ï¼P(G91«\0??"f:Q??@?`'?7ÑÈädÀ¨ˆí?41??I?H?t\n€RH	ÀÄb?€?1»??)Dª„8 B`À†?V<Q?8c? 2€?€E?j\0?9¼\r‚Í?ÿ@?\0'F????!?H?? ˆE?(×Æ?Ñª&xd_H÷Ç¢E??£uÈßG\0RXıÀZ~P'U=Çß?@?èÏ?+A?n„h£Ii?ü±?PG€Z`\$?‡ş?À¤??ÀE?\0?€ §¸Q?¤“äÓ%èÑ?A’W’Ø?$?ıÉ3r1?{?%i=IfK?Œe\$???!?h#\\¹HF|Œi8tl\$??????*(??ñçL	 ?$€—x??\"Wzs{8d`&?Wô©\0&E´¯Íì15?jW?b?öÄ?ÊŞV©R?³™?#{\0ŠXi¤²Äg*?7?F3?å¦©p@õÅ#7??0€?Ò®–¬?øÃ©h?\\?o{Èá???²ï—Œ¼Å¦á?8l`f@?reh·¥\nÊŞW2?@\0€`K(?L•Ì?0vT??0?'L¯Š??„” 0˜¼@L1?T0b???W?\\?èï?N‡ó?\ns3ÀÚ\"?¥°`Ç¢ùè‚’?2ªå€&??rœU+?ÌèR‰eS‹n›i0??b	J˜’€?s¹Ípƒs^n<¸¥òâ™±Fl°a?\0¸š?0’mA2?|?6	‡¦nrÁ›?\0DÙ¼Íì7?mÜß?-)¸Ê?\©Æäİ?n=â¤??*???„?ˆÄT“‚y7c?|o?–Ô??‹?¡P?ÙÀY: K?C´ì'G/?ÎàQ????/‡À&?üòW?p.\0ªu3«ŒñBq:(eOP?	”é§²üÙ?rœ‹??(ac>ºN?£º	?t¹Ó\n6v?„îe?yÕÎ?f?Q;yúÎ?S?äëgöÇ°èO’ud¡dH€H? Z\r?ÚÊ?C*€) œîgÂÇE?? \"?ğ¨!k?'€`?nkhTùÄ*?ˆÄ5R¤E?\n#?1¡œ???0?ÆÇSÂiÈ¼@(?¦Á¸I??v\rœnj~Øç?3¿??:h°Ô??\n.‰«2pl?Bt?\$bº†p+”Ç€*‹tJ??¾s†JQ8;4P(?†Ò§Ñ?!?.Ppk@?6????(?\n+¦Ø{`=£¸H,?\\Ñ´€4?\"[²Cø»?“´??èÌluoµä??™±?E??"‹ôw] ???Te¢)?´A“E={ \n?`;???-ÀG?I¡í?.%Á¥²ş?%EŸ—?s?©gFˆ¹s	‰¦¸?KºGÑøn4i/,­i0·u?x)73ŒSzgŒâÁV[¢¯h?p'?<TM??P*oœâ‰´?nH???n?¨M-W??/???mH¢‚Rp€t?p„V?h*0ºÁ	?;\0uG‘ÊT6?s?0)??–Æ£T?\?\"èÅU,?C:‹¥5i?šl«?Û§¡E*?"?à¦Ô?@jR?–Q??¨½L@?Z”‘¥P?(jj?J¨«?ª?*ª¯?0§ª?r?ˆñQ*„Q?gª9?P@…Õ?³‘?n-e?0?Qw%^ ET? 2H?@Ş´??0? e#;öÖI‚T’l“¤?A+C*’YŒ¢ªh/?D\\ğ£!é¬?“Â?A?ÄĞEğÍE?}0tµJ|?Àİ1Qm«Øn%(¬p´ë!\nÈÑÂ±U?\rsEX??u%B- ´Àw]??»E?<+¾¦qyV?°mFH òÔšBN#?ÃYQ1¸Ö:?V#?$“æ şô<&ˆX?¡úÿ…x« t?@]GğíÔ¶¥j)-@—q?ˆL\nc?I°Y?qC?r?(@??X\0Ov?¬R?X©µ¬Q¾J?–É???lxCuÄ«d±± vT²Zkl\r???\o??”o6E? °?ªÉ?\r?÷«'3úËÉª?J??Y@?6?FZ50‡V?T²yŠ¬˜C`\0äİVS!????ÉÑ?rD§f`?¨Jvqz„¬?F¿ ÂÂò´@è¸İµ?šÒ…Z.\$kXkJ?\?"?"??i°ê??ÿ??roX?0>P–¥P?i]\0??µaV¨¸=¿ª?6¨´°Î?K3Úò?ZµQ¦m‰EÄèğb?:?32ºV4N6³´?!??Ú¦?hµhUĞ>:????jäèĞú?g?\|¡Sh?yÂŞ„\$•†,5aÄ—7&¡ë?[WX4ÊØq?‹?¹Æä×‚Şc8!?H?àØVD§Ä??+??‘¡¥°9,DUa!±X\$‘ÕĞ¯ÀÚ?GÁÜŒŠB?t9-+o?”L??Ä­?K‹‘x6&?%x”ÏtR¿–é?"ÕÏ€?‚IWA`c÷°?l6€??*?vk?«?Àë?8z+¡q?öäw*·EƒªIN›¶ªå¶ê*qPKFO\0???€|œ•‘”°k *YF5”å??6??QU?"??rb?AXÃvè÷v?H?o`ST?pbj1+Å‹¢e²Á??Qx8@¡‡ĞÈ?\\Q???¸Ä‰Nëİ?b#Y½H?p1›ÖÊøkB?8N??3,#UÚ©??"†é?ÂeeH#z›­q^rG[¸—:?r¸m‹ngòÜ??½¥V?«ñ-(?ğ¿0âë?kh\\?„ZŠå`ïél°êÄÜk ‚o?j??€.¯hFŠÔ?t?‡wê¿e¥Mà««¡?!¬µÍæ?nK_SF˜j©¿?-S?rœÌ€wä´?0^Áh„f?-´­ı°?‚›???±©???Y ÅV7²a€d ?°bq·µbƒn\n1YR?T±õ??+!Øıü¶NÀT£î2IÃß·ÄÄ?Çò?‡õ©K`K\"?½ô£÷O)\nY?4!}K?²êÂàD@??a?\$@?ƒÆ\$AŠ”jÉË??\\‹D[=?bHp?OAG—ho!F@l„U??Xn\$\\˜Í?†¢?`¶?HBÅÕ]??«¢\"z0i1?\\”ŞÇÂ??…fyŞ»K)£îíÂ‡? p?0ä¸XÂS>1	*,]’à\r\"ÿ??cQ??$t‹„qœ.‹ü	<ğ¬??t,?L??€gü?¤¶\$??v…˜ù?¡??G??ÄØœÈE ÒXÃÈ*Á‚0?)q?nC?I›û?"µåÚÅ??³¬`„KFçÁ’@??Œê»AÈÉp€{?\äÓÀpÉ¾N??£S(+5???"´Ä€?U0?i??›ú?nM??rKÀğ?Ãº¡r?ì¥â¬|aüÊÀˆ@?|?ka?WR4\"??5?¬pıÛ“•?„rÄ˜«¸¨ı?ğæ??Â—Hp†‹5YpW??G#?Ê¶AWD+`???\"??H?\p°“??©ß‹Ì)C3?sO:)??F/\r4éÀ?A¦…\nn?T?f7P1?ÓÄÙıOYĞ»Ï²‡¢?qì×;ìØÀæa?tS<???nws²x@1?xs?¬ï3Å@¹…?4?®oÜÈ?»Ş??pR\0?à¦„†Îù·ó?q??&S^:ÙÒQ?\\4OInƒZ?nçòv??3?P¨…L(÷Ä”ğ…À?x?$?Â«C??nªAk?:L?6?ÍÂr³w›Ó?°½ÙÈnr³Zêã=è»=jÑ’˜³‡6}MŸG?~??Äbg4Åù?6s??é±#:?g~v3¼????ô³?a}Ï§=???n)?cC???L=h?{i´±J?~??wg‹Dà»jLÓé?šœÒÁ=6Î§NÓ”êÅÁ?\\éÛDóÆ?”†??h?S?>„ô+¡u?h?´W›E1j†x²Ÿôí´Št??? îwS?¸ê?š¯Tö®[???“òÕît£¬A#T™¸Ôæ‚9ìèj‹K-õÒ?³¿¨Y?‹Qe??4?ÓÁ?WzßÎéó?JkWY?ÎÖpu®??|z4?˜õ	?˜ğm??5?\0>??É×–«µè½ öëgVyÒÔu´»?}gs_ºã?¹sÕ®{??@r?—õ???…?H'°İa?i???µ¨‹ë_{??Ï¨Üö?e??h-¢“Ul?Jî?O\0^?Hl?0.?„Z‚’œ¼??u€??"<	?7ÁŠ????:Ò\n?¡´?íÇ!?ÚÈ?0??0H`??\0€ŒH?#h€[¶P<í¦†‘×¢g¶Ü§m@~?(şÕ\0ßµk?Y»vÚæ?>??nz\n???\n(?İ\n?üà?k???“n?Û¨?@_`?_l€1Üş?p¿P?w›ª?0…cµĞoEl{Åİ¾é7“»¼¶o0ĞÛ??b??‹zÛÊŞÎï·›¼ ‹??8??=ëî??y?aíß?xqŸÛØò¿»@ï÷ka?ÿ\08d?m??[wv?RGp8? v?$Zü½¸m??ÜŞİÀ¥·½íô??û·Ç½Ôîûu€o??2ğãm|;#x»m??;ËáV?£ÂíØğÄ?O?r?~o¿w[òáNêø}ºş ›clyá¾ñ¸OÄÍŞñ;…œ???^j\"?z??xWÂŞ.?	Áu?¸ÅÃ?—‹<gâçv?hWq¿‰\\;?8¡Ã)M\\³š5vÚ·x=h?iºb-?ÀŞ|bÎğ?yD?Hh\rce?y7·p?xşÜG€@D=?Öù§1?!4Ra\r??\0'?ŒŸ¥@>iS>??¦Ÿo°óoòÎfsO 9?íşéâ\"?‚…l??0åğE!Qšá??D9d?W4ƒ›\0?y`RoF>F?a„‰0‘ù?ƒó0	??‚I?'?\\ñç??\0\$Ÿœ\n R?aU?‚s?«æ\"???…e?Y?¢„Z????Ç÷#¯G!±P’P\0|‰H?np>W?¢`YP%?Ä?\n?8‰ÃP>‘ÁÁè??]‘‹4?<?\0ùÃ›ç¨û?–z?4??¥Ë8?ùÎ??`m?:?Îª¬HDªãÀj?p>*?ÃÄ???0?—A¸È:€À»??w?Ãº?>9\n+???Àñ?—°ii?PoG0°Ö?ş¬)?Z°Ú–èn¤È’ì?R?Üí‡g£M??ÀŒgs‰LC½r???°†À‚?R)Îú0?Œôs¨IéJˆVPpK\n|9e[?ÖÇ?²’D0¡Õ àz4?ªo¥Ôéáèà?N8nåØs?{?·z3?¸BS?";?e5VD0±¬?\$7z0¬ºøÃËã=8?T 3÷»¨Q?'R’±—’Øn?¼L?yÅ‹ìö'?0oäÛ,»‰\0:[}(’¢?×ú‡X?xvqW??tB?1wG;????|??JI@??¢ˆ?Å†I??\p8?!'?ß®šl-€l??Øğ,?·»?]èñ?1‡Ô•H?ÿN?%%?Å/?FGSôò??\??c??²¡?2|??$t????Š¬+#¦B?N1ùç{??y?ò???\Z&)?d°b',Xxm?‚Hƒç@:d	>=-Ÿ¦lK?ŒÜşJ?\0ŸÌÌó@€rÏ¥?@\"?AÁñïª??Åh>?÷­?\Íæú¨#>??\0­ƒXr?YøïYxÅ?=:šÔ¹?rlŠo?m‡gbööÀ¿À˜?„D_?x·C³?.Šôy€†R]?İë?ZñÇ»W?àëG??MÉª(?|@\0SO?s? {î£”ˆ?k}äFXS?8àå=¾È_ŠÔ”¹l?0??ÁÊ{ Hÿ?GüÕáÛ s??\$hk?¼q??÷¢?4?ø»æÖ'ø½?v?¬ !_7?Vq?@1zë¤uSe…õjKdyuëÛÂS???"?úÌKşØ?˜s·ä?¦h’ßR?d??:y—Ù??Ú¾\nQ?ı·Ùßow’„'öïhS—î>ñ©¶‰L?}?e·§¸G¾â?9ıã?ˆüW?íøÏ¹??ˆ÷uZ=©‡,¸å?}??0?@ˆä#·¶\"??`¿Ò\\?Ìßpó·?Gú¯µı?_?'?G???ŸT†‚#?ŸÍH\r??"?ëúo????Oé¼??'ÎÁ?8³M±ñQ”y??€?±…ß®?³ÿ\0ÿ±öbUd?67şÁ¾I Oöäïû\"-?_ÿ0?r??«–? hO×¿?t\0\0002?şÂ?4?¢ÌK,??h¼Î	Pc£ƒ·z`@ÚÀ\"??Œà?; ,=??'S?bËÇS„¾øàCc—ƒêìšŒ¡R,~ƒñX? '…œ8Z0??np<pÈ£?32(??@R3ºĞ@^\r??@?, ö?\$	???E’ƒ?t«B,²¯?âª€Ê°h\r?<6]#ø¥?‚íC??€¢Ë?»P?ş°;@?ªL,+>½‰p(#?†f1Äz°Á?8»ß ÆÆP?9???·RğÛ³¯ƒ¹?)e\0Ú¢R???\nr{Æîe™Ò??A@*ÛÊn?D?6Á»ğòó?N?rR™Ô?QK?»àé¢½®?PN°Ü©IQ=r<?;&?°fÁNGJ;?Aõ?¦×A–P€&?şõØ?©ÁüÀ€);???\0?£Áp†p\r‹¶?¾n(?@?&	S²dY??ìïuC??8O??Á„óòo?šêRè¬v,€?è¯|7?\"Cp‰ƒ¡B??j¦X3??„R?¤Âv?ø¨£À9B#?¹ @\n?0?T?????€5??/?? ¾‚?E¯—Ç\n?“Â?d\"!?ŞÄp*n¬¼Z?08/?jX?r¨>F	P?e>À•OŸ¢L??¬O0?0?)kÀÂ?ã¦?	ÀÈÏ³Âê?L€??åñƒ‚?1 1\0ø¡C?1T?©„¾ìR?z¼Äš£î?p?°Á?¶ì?< .?î¨5İ\0???? Bn?<\"he?ĞººÃ??s?ºH???!\r?r?"¬ä| ‰>R?dàö?"U@?6ĞåÁ¢3£ç?>o\r³ç?¿vL:K???ì¾?€>°È\0äí ®‚?B?!r*H?î¹§’y;?8\0?ËØ?½dş³ûé\r?ÿÍÀ2AşÀ£î?°õ+?0ÛÃ?0A¯ƒwS??lÁ²¿°\r[Ô¡??co?¶ü¼ˆ0§z/J+ê†Œ?[·¬~C0‹ùe?0HQP?PY??#YD??p)	???&?-À†/F??T??„¦aH5?ƒëH.ƒA>Ğğ0;.¬­?“Ä???2?3?pBnuDw\n€!Äz?Q \0??Q4D?*ñ7\0?JÄñ%Ä±puD??=!?®u,7»ù1†ãTM+?3?:\"P¸Ä÷”RQ?¿“?°Š??1= ŒM\$ZÄ×lT7?,Nq%E!????U*>GDS&¼ªéó›ozh8881\\:??0hŠÁ? •C+#Ê±A%?¤D!\0ØïòñÁXDA?\0?\\?#h¼ª?b?‚T€!dª—ˆÏÄY‘j2?SëÈÅÊ\nA+Í½¤šH?wD`?(AB*÷ª+%??¬X.?B?ºƒÈ¿??ÙÄXe„Eo?"??©r¼ª8ÄW€2?8Da?ƒ‚ø÷‘Š”N?ô¥ÊJ8[¬Û³öÂö®Wz?Z\"L\0?\0??8?xŒÛ¶X@”À E£Íïë‘h;¿af??Âş;nÃÎhZ3¨E??«†0|??‘­??£tB,~?W?^»Ç ×ƒ‚?2/	??´¨?‚O+?P#Î®\n?»ß?½şe?ÁO\\]?7(#û©DÛ¾?!c) N?ºÑMF”E?DX?g??0A?0€:?BÆ×``  ??Q’³H>!\rB‡¨\0€‰V%ce¡HFH×ñ¤m2€B?IêµÄÙ?#??>?³n\n:LŒı?C???ãë\0“x(??(\n??ºL?"G?n@?ø`[Ãó€??ni'\0??ˆù€‚¼y)&¤Ÿ(p\0€N??"€®N:8±é.\r!'4|?~¬ç§ÜÙÊ€?´·\"…cúÇDlt‘Ó¨Ÿ0c«Å5kQQ×¨+‹ZGk?!F€?c?ˆÓRx@?>z=¹\$(????(\n???ëÒµ‚ÔéCq??Œt-}?,t?GW ’xq?f«b\0?0zÕìƒÁT9zw??Dmn'?cb?H\0z…‰???ÑÔ?H??z?Iy\",??0?"<?ˆî Ğ'?H`†d-?cljÄ`³­i(?¤?g?íÇ??j\r?0??6¶º??2?jã·<?q‘Ğ9àÄ†?\r\$C’AI\$x\r’H¶È7? ?Z²pZrR£ò?_²U\0?l\r‚®IRXi\0<?äÄ??x?S¬é%???%j@^ÆôT3??GH±z€?\$?…Éq\0Œšf&8+?r?%?2hC?™¥??šlb??h?ƒY&àBªÀŒ•’`”f•òx? n.L+??\"=I?0«d?$4?rŒæ¼A£„?4?gJ(D˜á=F„¡â´Èå(«‚?-'Ä ?G?2?Z=?’Ê,ÊÀr`);x\"Éä8;²–>?…?„ó',?¢¤2Ãpl?—ä:0ÃlI??rrœJD?ˆÀúÊ»°±’hA?22p?`O2hˆ±8H‚´Ä„wt?BF²Œg`7ÉÂä¥2{?Kl£ğ?Œß?C%?om?¾àÀ’´ƒ?X£íûÊ41ò¹¸\n?2pŠÒ	ZB!?VÆÜ¨è??H6²Ã?*??0?kÕà?%<??',3?ÄI?;¥ 8\0Z?EÜ­??ˆ²½Ê?l?ÏËW+¨YÒµ-t­f?¡Qò·?-???„· 95ŠLjJ.GÊ©,\\·ò?.\$???\? À1ÿ-c¨²‚Ë?l·fŒxBqK?d?èË€??¹Ko-ô¸²îÃæ?²°3K?¯r¾¸/|?ÊË?\\¸r¾Ë?¡HÏ¤??????Â„?|?ÿËâ+ÀéJ\0?P3J?ZQ??r&„‘Ãá\n???ËŞj?Ä‰|—ÒåË?Ô¾?"Ëº“AÊï/ä¹òû8?1#?\$\"?\n>\nô¢?L???9?\0B€Z»d?#©b:\0+A¹¾?2ÁÓ'?\nt ’ÄÌ????lÊ³.L?”HC\0™é2 ?L?\¼™r´Kk+¼¹?Ë³.?’ê?(D?¢Ê?s€ÕÌ?d?9Ìú•¼ P4ÊìŒœÏó@?.ìÄ?AäÅnhJ???K?„Ñ3J\$\0ìÒ2?k3???3”Ñn\0\0?,?I?Œûu/VA?œµ³UM??Le4D?şÍV? ¨Ap\nÈ¬2ÉÍ35?òĞA-´“T?5?òÛ?+fL~?nô°?„õ->£° ÖÒ¡M?XL???Ù²ÖÍ?\\?Í¨€˜Y?¤Š¤ÛSDM? Xf° ¬ªD³s¤äÀUs%	?Ì±p+K?ÄŞ/ÍÔüİ’ñ8X??=K?pH?’ñ%?3ƒÍ?l?£K0ú¤?íÎD»³uƒê?±½P\rüÙSO?&(;?L@Œ£?N>Sü¸2€?(ü³?J®E?r­F	2üåSE‰”M’†MÈá\$q?¶Ÿ\$ÔÃ?I\$\\“ã?D?\" †\nä±º½w.t?	€?„Ñ’Pğò#\nWÆõ-\0CÒµ?:jœRíÍ^Süí„Å8;d?”£?Ôªa?ÇôE¹+(Xr??Œì3?´•ó¼B,Œ˜*1&?ÃÎ?X?¼ˆ?<?­L9;?SN¼Ş£ÁgIs+ÜëÓ°K?¬ñsµLY-Z?A<áÓÂOO*œõ2v?7¹¹+|?€Ë»<TÖó??h’“²Ïy\$<ôÎ#?;ÔöÓá›v?$?O?0??Hkòü-äõàÏ?rÜú²ŸÏ£;„”¹O?ìù“·?>´§3@O{.4?O?T?ÃÏ??~O?ôÏSïÏ?1SS€?4¶PÈ£?ü·ÁÏ??0??´ô2??<ëó??4€?Œôt\nNÀÇ?AŒxpÜû%=P@????RÇË?x°ó\n˜´?N????TJC@???.d?·MêÌt?=?\?èÄAÈå:L???$Üé?ƒ­:Œ’\rÎÉI'?²–A?r??\r?€??ÈåB?Ó®Œi>L??:9¡??|©C\$ÊË)Ñù¡­¹z@´tl?>€??\n²Bi0G??\0±FD%p)o\0????n>ˆú`)QZI?G?M\0#\0D? ¦Q.H?\$?\n ?$?%4I?D?o?:L?$£Îm ±ƒ0???\(«¨8üÃ???h?«D???DX4TK€??ö£x?\n€,…¼\nE£ê:?p\n?€? ê¡o\0¬“?IÆ` -\0‹D??€®KP?/¤ê?H?$\n=?€??´U?P0£ë?G}4B\$?E?ÛÑ?”T€WD} *©H0??0t?´†‚Â?\"!o\0E?±ïR.??fRFu!?D?n?0‡F-4V€QH?4„Ñ0uN\0ŸD?QRuE?)ÍI\n?Q“m€)?’m ?\\˜“ÒD??\$?x4€€WFM&?R5H?qåÒ[F?Èù?F \nT«R3DºLÁo°Œ¼y4TQ/E???<?t^ÒËF?)Q??4°Q—I?´½‰IF?TiÑªXÿ?Ñ±F??R???ÑÇKm+?ÇÜ û£ïÒáI??RE?Ô©¤ÙM\0ûÀ(R??H?¥J?"T?D?ª\$˜Œ?4wQ?}Tz\0‹G?|?çÍ?R???R?	4XR6\n?4y?NôãQ?M?R?&?Q/?#èÒ???ÒÒ?|”’ÇÎ\n?.?0??Áo#1D?ÀÂĞ?U??J?€*€š¸j”ı€¯F’N¨Ò?J? #?%-?CôÇ???EP?`>Q????O?4?%I?Ôô%,?"?ÓùI?‘ëÓÏ?$?TP>?n?\0QP5Dÿ?OF?TY?Áo??T?0¬“x	5©D??0??i?x? ºmE}>?¤ÀŒÀ[Èç\0€?RL€?H«S9?G›I›§1?–…M4V?H?oT-S?Q?? [ÃùTQRjN±ã#x]N(??\nuU\n?5,Tm?????€?ÂU\n?u-€‹R?ãğU/S \nU3­IEStQYJu.µQ??´o\$&ŒÀ?	ÜKPC???µG\0uR€ÿu)U'R?”Ğ€¡DuIU…J@	Ô÷:?8*?Rf%&?\¿R??U9RøüfUAU[T°UQSe[¤µ\0KeZUa‚­UhúµmS<»®?R?s?&Tj@ˆçG?\\x??>¨ş\0&Àpÿ?Q¿Q?T˜U?s?%\0ŸW€	`\$Ôò?1???$C?p\nµO?¹ñX?ƒıV7X?u;?YBî°??şÑ+V£ÎÃñ#MU?•HÍU???U-+ôğVmY}\\??K¥Mƒì\$??ToV„Œ?TùÑ!!<{´RÓÍZA5œR?=3U™¤(?{@*Ratz\0)QƒP5H??“ÎÕ°­N5+•–??Ôí9?%\"µ²ÖØ\n°ıñäG•SL•µÔ?”ùÇÌ?l?£ˆ?rVˆØ¤Í[•ouºUIY…R_T©Y­p5OÖ§\\q`«U??u'Uw\\mRUÇÔ?\Es5?\\???\ÅS??Z%Oõ¼\$?¥FµÔ??5E?Vm`?Wd]& \$ÑÎŒÅ•Û?R¥Z}?]}v5?§ZUgôÔQ^y` ?^=F•áR?¥v?ÅKex@+¤Şr5???=”uÎ“s •¤×¥YšNµsS!^c??$.“u`µÜ\0«XE~1??…J?Z??#1_[?J??n?$VI?n?0??aªR?U~)&ÓòB>t’R????_EkTUS??µıUk_?€&€›E°ü(????××J??½JU?BQT}HV??j€¤Qx\ne?VsU=ƒÔ?‘N?Õ²?\\xèÒÖïR34?¿D\":	KQ???r?_?!?][j<6Ø®X	¨ì?‰•?KL}>`'\0??5”X?U?[\0??ÔÙ?Wt|t?R]p??H2I€QO‹­1?©Qj•Z€??´Hº´?m¨Ì?d?SXCY\rtu@J?üµ%?M??¨óµ“??Q?n?R?r:Ô¿E???G€\0\$ÑÇd½“??eh*ÃìQ‰Wt„öc€?•˜AªY=S\r??m-´‚?Mw??J?"ä´Ä?õş­f?"?#9Teœ‰ÙÍM?¹ñN?£òÙßD¥œ?ÙÜ??Ùñg??Ù×?¶e?a­L?Q&&uT??51Y??£ó?ıÖŠQ#?µ¥??0?œ£ÅW?PÑş?ub5FU?n?V5R?ãë\$!%o??PúÉ'€‰E?UÁÔP?†¶š¤Bp\nµF\$ŸS4…t±UF|{–qÖÈ???mjsÎÃ??øı\$´Ú›j…cëÚå¦Ö«€¿aZI5X€ƒj?6?&>vÑ\n\r)2?k??®TJÚÁeQ-c??M?½£z>?•a¹c£Ëc??t„”HÚÑj?6¹£+kŠM?\0?Œ„€##3l=?´?6?0?Ã¨v¦Z9Se?\"×Ê?bÎ¡?>??T?=?\0?P?$\0??0Úª•«äµ½k-?İÛ{küÖ?F\r|´SÑ¿J??Q¿D=??X?œV—a??¹éa?to€©l?¶ĞXj}C@\"ÀKPÛÎ??m?\0#HV”µ…v÷Ñ~?µ?gx	n|[?U¶ä?rê½h¶ŞG?`?#Gk%L£ê\0¿I?C?Şê? \"\0ˆŒÅ§¶°#cN?ßÚ¹fÂ??êº;Ñ¤ÃeeF??N\r:ôâQ??	\$ÔóI?Õ¼ºß]£®TİØWGs«ÔdW??ãèÑÙf’BcêÛ¤êõÂ?#cnu&(???£ùSf?&TšZ:…0C??N`Ü³Yj=??Å²ÃñZ!=€rV]gû	Ó£rµ ?lŒÉ-.¹U?uJuJ\0ƒs­J?W%·¶?\>??öëV?j4?ÏJ}I/-?rRLºS?3\0,RgqÓ­ôÇTf>?Õï\0??”Ç\\V8õ¡Z?…Ác???^\\?l´j\0?˜şT?CİÔw×Î“zI¶ÙZwN…¶¶pVW…jv»Y??2?o\$|U‡WÃL%{toX3_?¶òR‰J5~6\"×ãZl}??c?Ñî?R=^U?•¥1òÑ½w7e?dµİvÙb???0??€,³m?)ÕéGpûÕ-Ó¼?9L??|Ôë \"?èû???:›ô\0?€?@ºÄxº“??J?»b? à…½‰İaŞA\0Ø»AR?A»?\$qo—AàÊS???ø¬<@???"as.âÎä÷V^?•è?^?…—?0??Á?H@?bK—©Ş)z?r·¨¤¤=??¿zˆB\0º¿?¤äN?o<?t<?xî£\0Ú¬0*R ºI{¥í?^?µî·¸:?K??E?²ÓY?•›?ÕÑcêÀ\"\0„ê?4???'€??n?İÉ`U£Tù¤?MPÔÀ?lµÈ4ŒÓr(	´ÁZ?„€&†©t\"Iµ¿ÖÛL?w+?}…§?Wi\r>?__uÅ÷63?[??T-???¤xãô_~??Ùß{jM?_?Eù÷ØÓ?]?\$??aXG?9?0007Åƒ5?#?\0.?Àä\rË´_??áÀßÚ%şáÀÀ\n€\r#<MÅx?Ëù?|¸Ø2?\0¨–;o?a+F€í¸Îç?LkúÁ;?Ûİ?€¾M\\??¤pr@?“ÃµÆÔøÂşOR€??~zÇûAÁNE°YÁO	(1N?ˆRø¨8?€C¼?¨Én?O)ƒ¶1A?o\0?r»Ç??Jâî‘“?"?OFÈÌa…›ùª-b?]PS???xC?@j°€?L”?èÈL?:\"?»ÎŠ¤l#¢À?B??“ˆ›€ÖË@ •Nº:?>?B???«È?:Nıñ?$èéS?CB:j6???àÎ‰Jk?†uK?W›Í¢Ã˜I?@TvãÒ\n0^o?\???/Á‡&u???˜æ\r?î¥Cæì+Úøc??J¸b?6Óü?\0?óÑ?0wx?Á8j%S›À?VH@N'?\Û¯??N?n\r‹Òu?‰K?UÃB??f>G‡°\r¸»?@G¤Å?d?‚†\n???O?hÊ·›†ÃˆfC‡É…X|˜‡I?æğ3auy?i^?y?no^rt\r8À?#óîØâN	V????*?%V?›‰#?9r?rxc?(\raŸá??xja?`g?0?VÌ¼?Œ¿Q†©x(ÇëƒÀglÕ°{—Ægh`sW<Kj??)°Gnq\$¨p?ÎÉ?ŠÉdø¶^& ¯Š˜DÂx?!b??EjPV? ââÁ(??b?r?"–b¦İL?0€¿Ìbt?\n>J¬Ô?;üù¼ÖîÛˆ¿4^s¨QÁp`?fr`7‚ˆ«xª»E<lÑÏ?	8sş¯'PT?øÖºæ?¸°z_?[>?€:Ïó`?.???7?[????!?*\$`²•\0À„?,€“øÇàİÁ@°à?????\0?CÇ¸?R¸În™°/+?;CŠ£Õø\0ê½*€<F“„???„q MŒÁ?1ºK\n?b?j1™Ôl?c>?Yø?hôìŞ???;?´Ü3Öº?8???\Şï?\0XH·Â…¶«a???™M1?\?[YC?£vN??0+\0Ôät#?$??Øà!@*©l??F»dhdİı?F›‘?˜˜?fó¹)=˜¦0¡ 4…x\0004ED?KÍòä¢?±…?0?nN?;q?sj-?-8½ê?0?sÇ¨??D?f5p4Œà?©J?Öí?'?[úùH^·NR F˜Kw¼z??ÜĞE”º“ágF|!?©ô??dbÁê?x?0?åà6?,E??†í?u? ÇÂ/?z? ØexRaºH¼Y?eŠš5?d\0?0@2@???ey–Y?M?ºh??•Ö[?ez\rv\\0Áeƒ•?\¹c?†î[?e“—NY`•å??9hå§?^Yqe±–?™qe_|6!Ş?u?fÕî™J?{?7¸ºM{¶Y???‚eÆÌC»¢S6\0DuasFL}?\$????Mb…ÈàÆ?0BuÎ¯…ì¥Ñ?2?gxF?{a?n:i\rPj?eÏñ˜r?rØÏG?Y ˆM+q??iY”d??`0À,>6®fo?0ù©†o™ó ?f¢??0ÀV?!“«f?†l????ëæ?eƒ•\0?kbf?r??f?%?r??a&	?¨àY€??Òñ–mBg=@ƒĞ\r?; \r?phI?bm?$BY?ÿšÄgx??QEOÇæm9??0\"€ºç!t¨˜??¸®??* Ååÿ\0Âİ>%?\$?o?rN&s9¿f£4çù™gŠä~jM??wy??y?\`X1y5xÿŒù?z?_,& kÑæ?|?À¦1xçÏA?? \n????xÙïgg?r?ç·›ü-°½…®|t?3±šˆÈ?gHgK?¿¿¨õJ?C C° 1„î9?‡g???6!0Hâí›cdy´fÿ?DA;ƒ‚9?Tæ¢ÿ??\0?Øà?†!?6^??Â²???¦E(P??.æÂ?€ÄhŠé?EPJv‰ .‹•??\$?Œ>P+?~?¡g?6\r³öh¢¼p«z(?WÙÄ`Â•¨±\"y???adÅ¬?:ù¡f??\0?İØ?;?¢°àì¬ç^ÊÖwf?>y??ŠË?-\rŠÚ…á\0­hr\r??i\"_?££¼9¡CI¹fX?2¦‰?"ÍÅ¢‰… ?¢L~?"??V?!%Šxy?zyg?vx??Æ}qgÄÃZiŒä|Œ`? _?èò?™Ù£¾?ªÂÀÂè­?PA€?\$??9¢Œùà?‹¢|p’ ÿ¢ˆ?íè!¢.?”ş¶?ç§^œø?Ë¢?zVCÌù?Z\"€æä?(?¥›¹°9?)û¥!DgU\0Ãjÿã¿?`Çğ4?LTo@•B?¤§?†a??r?\n?“E„»8Ã¦&=??*Z:\n?˜¨g¢èÌ?£‹h?.•˜’ N?(ˆSƒhÑôi2?c„f?•“ÑŞ7?œz\"?|ÖúrP?.??8T'¿¸k¢ˆ?(¹q2&œÆED?~?ÿ¿Ø±şœŒ?9ûÒÂv£©?ÿƒ©–?úé^X=X`ªqZºĞQ«Ö?9j?^ˆ¹?ç«¸În¼qv?±á?±ÚÇè?I6ğªjšdT±Ú?\\?‚Ÿ3?™Ïh????¬‘‘P?u•V?\0ï§†U?;¢ÌJQ¶ã é. Ú	:J\rŠ1Ÿên?I\r\0É¬h@˜¼??N?nsh—®?"??¦r~7O?$ ú(?¤RÅè?èÊ½j??šØFYF š?£«~‰xŞ¾©f º\"?v?ošëË¨ººÂº#ŒÜaÒèŠõ¶®P“„?ãáh?3éº?Gx???n?@\"’G?ó?,?Zp?xX`v?XÆõóà???I¶œ7Ã¥Xc	îÅ!?bç¢}??¾¥9?qti?f»’°¸İ?5ÿ??FÆ¹?Ñ±©pX'?¡rƒ„?ÆÆºé§D,#G?2€ÌØâI??rl(£— €ì±£¦?=?¸a€ì©?8›dbS???~‚ô—H;°Â?0???é{ª„ŞºR?èÃs3zë¯ÃÀüNğŞ„?ÆË?ò¦­ 4<?aƒy°¬?}r°Â?´õãáû¸k?4@ˆÁ?~ÔäÅcE´Â??ˆLS@€Œéz^qqN¦°</H‚j^sC?èæsbgGy¹¤Ö^\n??n:G¶N}¼c\nîÚÕí?+£†?†p?º’NµTB[d?¶–š¶?¢¾Ü¹?³n?j;jÄ›whØõ?c9ƒ‚pÌ¡[y4«¨?5œÍ‹NßÁ+Î¿·Ğ`Xda??/zn*?À‡êÁ?t?èµ??W?šVâò~=?#Ùùn)¨î??2ÜÉ;…j:õ°J?„C?>x??š£==?»—????¨î?€??üÚv½ù«–?¸„???Î;:SA	??£me†ê?±ëúûª?«Ë?¦Ä?Ÿº6ma?Y.ç¥À?g¶ÔşÉ?€ù°Ğ;«Iß»x?”éI?J\0?ÂzaY®?ºî?T\\`–íV\n?P)?J¾©æ½üñğQ@İà[?{r?µD?B„v—ï|i-¹EæøK?^n?êó??Nh;–—?Á¨?pçÑ?“úƒ»ç½??¡¥öÖXÂhQ?—Û?A?D šj‡¥??zLV÷ïçÑ??•	8B??F}F¾Td?»á?±ÃzcîçŸFÅÀŠg??Ûê? 6?.EÂ£¼áÀÖÂ£¥ğS?J3¥ö5»¯KÉ¥?™§?¤—„n5¾¾:yS??C?oÕ½.?ñğ	d\\0?W\0!)?'?û¼?g??»\0?Y Ntbp+??cŒø“ş?0©B=\"?†T?:Bœ±Á¤úcğï?şîÆï¸P‘IÜÈD¸ÂV0ÊÇ!ROl‰O?N~aF?%Éßº³?¬…?Où¿	W?´?Q?¨È:?l?h@:ƒ«ÀÖ????Ànç¹FïÛp,Ã?@‡ºJT??½„(???ÃÆO\r??ùÚ?$m?HnP\$o^®U¡Ì\"»¿?Ä–?.îç?‹n¥q8\r?0;³n£ÄŞÔÛğç¡Ÿˆ+ÎŞ?¢¼n{ÃD\$7?Ez7\0…“l!{˜é8÷á¶x??.s8‡PA¹Fx??ÄÓ?Û®€¹†1?¸p+@???OP5¼lK?¾‘·¾?\mæú¸Äs‡q» ?ºQ????»¶??¾o?¿E??q???G¡HO?O?\$?¾š+?,?\r;ãç?¾¤??Ä?³é{?7|?ÿÄ‚Äà?'‰°Ji\rc+??+<&??W,Ã>¢»^??nÂJh??d¶æìè??Cƒi¶zX?Aÿ'D?É?¡Ek£Ê??B?(€.–¾\n99Aê¯hN??N?¾d`£Ğ?p`Âò?2ö¦?H†Ëb2&??¤R(òÀ?t?H??‘Ö'œ× ?oòÀ?4??rZ?ÊÓ‚ä??ºÈ??†µ³N‡ñŸé??'-IõÈ??(S¨r?,ü¹Ğå?K?rÍÌ'-2Hlo-ÁUòáËâ_?'W#'/üÉH?¤®j6“Ì‰¡¡?àÈ«?0?<??Úú??j1¤E’QŒT?­?ÁBcm?6ãÍˆgÙ«:w6Í¯›h@1ÅI:¤ÃÁ’Éş2??L/ÎÁŸÂwÿ:òÅ‘ÓÎøK<ğÌE<‚şJ?6?s?Ì²sZóß/\$?sEy???:w????³áêÇ™ĞZ“M?»Õ?0ÏÁ1?ARÍ¦%?>??Rr}s??)\\t-8=³öÍË?U??WOCs?„Ğ#w?5?¯ERlM*¯D³ç1ûÑ>]ÏÀgK¤²V?n?\èÜ?ˆÜ?Í¹seÍ§9­so?„ ìów4x?†’?@×Ğ??9€‡Î?¬\0	@.????9\0ŠC;K?y+??ÜÙ¥ƒ?<\\??{??E?ÿyÁJ=lŒüïá/?-?˜ş”ĞZ46¨uC5™‘PçÎ©´RVĞòæ¡ÜáĞıÊ³lVøÒaNx?`Õ´?U?(HP?jV??NQJ?–¸±s-gQ!a?V?SwR??am?ZXwZ???a­‰??Zµ“??[\n<?€µO¥Ò?ÇÅOmo?×Óa?Qºä>??T?nµ¨ç\0?=€??j?ATÃRÅbu(??´è:å×\$v¾Wõ×µÃ?ÅS?\V8Øçv?\??!MĞ¶¦uÅÖ_??s?\CÿRVM?tXT7\\UoT×Øo_Ô¯?S?a???LutZGe?Õái`	}XZ‹i}Q•yW[i­…TŠöYo¦?ZE\\?}n?i—f–‘?ÙÏW??T?u3u??5)vˆÛ]?R3VEY]¥X?n?½§VqS½S?X?Gf•Úv>­S?v»JMQšv?Š…Ô?\•g]´QYE“Îİµ#1Vÿl5U?K]ÕÉ\0³Ø??U?\\ºBwS•U?–´?Z½V5\\õ¹WfıÂÕ§[¥eUr?G\\µıUµÚ,„Éö‘W?]x?V?5mT???u7?0?¦UµØ'tı°w?msİÕÔÉ?VİÃv?q}Ùöáİu-Uq??c]?İØ?Tt:?ŠM”k¶“e]î¹[-p}^?[©XDãéºåY?V—dõÀ?]	seNõ£ÜßZ¯WY??????ŞÇµßM“öñİ?Ğût^w£d?qTL?@>]Áj\rF?vµİ-Lv´GKwi?wIPMo”ùÇ¹Mgv??[§Uss¦~	èõ…w:B?‘Ÿ?E??-ÔÃd?o\0´’}&?­hXÕÎA–5?Ù£fzL??d­” Y?%…v´Ó?mšÒ]Öë•Ø?Ì%üñßò€??B?>E [#^}?YF?a?ßÆ>{¡gS…¶?p[?÷¦?a?næ´À?x9«¥8L??«N–a=ˆS??Pk?™áNòøH?l\0?:àğ???#çÎ?¼í®v?O}€9ik]	&?? ø«???|a—·&?ãÔ???½¥ª±ÌîÎç?)Éñµo?“Ç?:?.\0?q\0J?½é?4hy€3?¢«¹˜a?ƒù‚Iz†ÁO‚—–ñ„æï®?"á¶yB»Ê????r(mØÈàÂáÇx.7r?%Á‡?^ e†M€»¢2?0x—½!‰b}.?Y6\$qS”Ï\"^|xE…äÈøaãş?¼À€?Ç¡5?†'T‚R	Ãc9Äã??1ßá??Pí¦Ÿ?h6'??àÖ??¾T(\nn\rËÅ“??„R?RUgÛéƒÈ?“çx¨•Pe#îé*¤âkT<??>b;‹“\0™Á?gL??<k©ZváÌ„ø?z³¶?~¬ğy7€Y¸ï?êÜ7w¨áOdn??€?E?ˆ¦wS”Û†œ@¾¡ë® o??…ñúñ¾Ò?¿z?eíŞ½è±å1?ˆz?0f=Øùc?¤g¹Ÿ{éŞ>nŒp\0±ÍèÎ?H?Bn?FèÆB¯r?=öãC>M.1~@3ºG???<S???QPâû`L[?z?Û«PÇí??{_-Ù®¥dO¸ùd-?B7ä4İîB?NÁí.Vº·?Æ¨Q?º{IcP\$§»ºhû¾<R yy…ì?ŞòGÒş:n™ã€??ÍÁ?;Ah!åÔşÁ&??>???MÁËŒŞ	ÍşşÃ?6SâîŠ·N¸?=#?ëëñ³???+???·r,‚Ç½ğ¦ÏX|#??\r? ï?\n?>?V???ÂÚe?~J?99…á?ns?S|r],~ÿË¹ñøé¿ µq??\"|wñ¦?%|?j?\0rE?kSnü¡íç¿øq??8B.ûñ?1«Ñü³\"™ß/|??€?]òü???·EüÏœèN²lüÌÕÆxÖËI°÷? Icó¿Å¸.|\$8D¹ŸF¨İ?“…˜P?Æò€3ƒô\\j¾¥xUÏC/äã³Ò—¿A{¹?Ğû?eüÚƒ€ÿÓæ?¶éÜ¾ÿŠÕôà\rp?\nçÕŸWloÂ­Y?ÿ??]'Öş?†?|¼o?×à3?Àrü}‹ö;?[?n?¹ûÿº—¿O?7??Éß£Ø¼q¾µq(ÏĞ_l?qsN?“yòûñÄçÕ;ŒiÀg?t—‡ÅÎ:ÿıåÈë?§qk‡¿íô???zı¿÷ÏŞûêñM??ıì'?j˜úïá†ãc?ñß„ıãøg?‡gkŒwÉâf8¼Vc?fA?Y‘³?Kx?=gKAk?,95rd??åÀºíÙ¯?…ñ?Òà%…A?w??µú?½å7ùßåà¬…?· {½míú8%_”şm?qˆàVËË? ş???ƒú¼i?‘ù²h ú~»ŸCªß???†„­µ—?¨şÙú?·rLkD«yÌúŒğ~?p1O!??®v?\ïä?Pm?\"¸Ì<??ŸÅ????ŸVğ³åÎ?zkîÇú¦9³z?ªß??/ìäÕº??Q?ÿ O£åNmèğ3rˆç F?l?Òúe;¤Mãß·…ŸºÏ½?a ´!~C»¼f€úå¼b}3?K¼føÜ? 	Ùä}.©ş»ƒDX	i5???ğÀ=\0õ±??»ø?£Ş@?Ã•£½fu~a?’Øn?áªy±Q;?q¹Ì??€s’S?\"G?nu%ÊÇU­Y?Kl\nÓëB?I?6VCcO\0?`}.x©ƒ?,-N?@~ºèœTÿG›ç?'üÄd?ƒ÷‚Ÿ?1ƒzl‡á½Ã¦f??·?B a?!?M\\<ƒg??4Æ¿ìÜ@/³ŞCÜÃ??@?¯Qq÷??????7inD?=?œ *79cÂF?ËÑd2(¶ .ÀV€?µ¿ùÚ\$g`ˆAá§‹rl|?˜²¶b§‚/¯qE²›ÕÃ?!bU@œ¿9i?pp?dííÛ×???y–x°x??€v=??(v±ï¬s_œ³Bo??ãÖ??\r n?ñî?\? ?˜PX?-3&?½›J&,F?9?v??@khZ??g?C?€z Á”Ãã¦hi=¡s9TñÂ eT>g????Fûö2b&:¾ğ\0?¡÷€B–š-¹Q??~?SÆM?™Ú·cgĞÎ?h'?(?³Ğ\$?EŒ«§VL?°·œA?I¼ãÃßŒñ?¹¼râ¦ãêg?rÜÙ??¶œ??TëÎ1P`1’dÔâôÕ?r?âÁ?6@FüÁ¼È F±Ì?=¿É???Â>?N¥AV?èÙ?\$?A/¦·ØÚõ¦;¦­??¾gŒf^	?n??O³Æn?]õĞg???¬Ò??–²Ï·Şı??nÈ7L?Œ¶‚t:ÒÑ ³hF°VO\r³èJ?)b?\"OB??oØß\$]T„SH?^½õK?©äw?\[A9('ÒÙ„c?â­Üàb0‚ØÙÄ K?à£åà²srB™x\n?Ba?6o?ry&tX1p'›??M·¹<?g???GH?zd?gX›†.@,?wÃï?:+ƒTiUX16?L¸Üs??ršL?‡Á±ƒf—r\r`??67~g?xˆgH9?À¿O=-\$??rÙª4½ƒ¨¡O›û?z¦§{ÈşD`ó¨‹?1FŒÜµ£?D?ÓÊ;???&?¡ÍÌ©ÔÚ?ƒU>??‹™cİÄ?ß¸@\r/?¸¶?ıó_H??n7zë ¶ü€“œ???É»[9D??„¿?Bÿ€O›R‡ô?¸B#s??z!(DÀ“?L^„ı	û³x£İ@o?¿u„OäïÁ¥D¸Ï?e`\na³k>?`???*™ ?E‡Z6=fÌé%¡™???°”K=???F?r?…ÂSh?N?v*v?rÁä??#ß¸?ªAh*?\$°À±AÀA\\”¢‚ú??	Äçp?r*==8?$W?r?[±“Jx0yñÛZ?&Y?A~A\n,\\(Öìp?F¶êÚ<6S?IP`6Xz?í£df?r¾ÏJÂ£€ŞÌi?s??5¼å?rE…À£M^\$R(R‘QÌÒEw3??lH*m\0Bq?aŒ¯rèêLB?ª¥Q¹z6~lË?‰\rIÂ®GøæXÙ¸XVbs¡mB·Hª×ó™óc?K?$p?:8„•Nj:ÂÑ…Œ?#¢F?\0’aiB?\\??.?Æİ\\?‰N??bIw8?Í¹t…øPjWä¨`?¶‚y\0??0?i?¡ˆ??:«Ia)=’C?a&ºM˜ap?\$?€IFc??\0!„ƒ?YÄxa)~¯C1†P?L3T¸j?C\0yˆ??`?\?Âü\\t\$??n?a?0aKbèí?n„˜]?@‚º?I\r??®Ks%???áË^°Ï?CL/š=%Û¨?hÉÆ:?&PşìEY?5???n[G??Vàá??<??gJ???d???^óÖ¢’OQ>%­s{½Ô????ö³‰ÖzÂGi??»ùRnìÑG9?°Š¢Ş,(u*°±?Ã—€ŠX?«àRŒ¦?:??”æ)°R¶¦???K?œR??¢œ?ğîÔé???<<3?%ºÙHV?S\n?L+{”o.>Z(´Qk¢ÖÂN?Ãì,?rH}nR?NkI		ª‡[ò´Ìë’Ó§gÎÎÖ¤;mYÒ³g??9V~-J_³ñg²­•©?\–É?Q\n®–!??\UY-tZn¨¡d:Bµ°Ê½??')t“²¥wÁù–É?[BUm*?4†Ø–Õ*yv¢¶ÁvZÀÕ?GH??n?PÂÜ?\nT?%#\\·AX\0}5b+wr«XwÜ²1uù×%Cg=I?v`cre?`..<?êğh?ŒH?^\\j­yFòİ%?¹B?0????€>?Zx¹š ?C.ªÃìÄ`Vn?KS¾¥?\rƒõ?|´õ[??H	U@©D:Ş»Mj	?ÛÊ?ıª]Ú¤?ˆb“A+ÔÅG?0thxbşÆL`”Å?4M?ÄôŠY#ºhfD=e€?=´c?H…ñ¡¡:?%?^\$?ZrAzjÿfLl?7’o¬Œı°?0¨-äÜ³EdäŞ‰yz'V ­“??W?Z?§K?°d(A?y??‡xR?^h??•æ?\0ˆ?p\r„d(V±Œ?½šd?	S?cH?¹]r?r?HY	X_?fƒŒİÍ?4 7e?D?,Ñèşê?<Z^´İj\"	éµ\n+?M…Y9…’A?<Pl¤lp	?>??E9??hšh{(ı±Agg8?@?T??€Z?ÙÅ°ÁJˆÁ?³x¦˜Œü?ic¶à??p?oJ0Mn???§³\r'\0??\rq??½°?)ı½cL??_?oJ?5ïÚc–o¨à?6„m?Qª£?QëÇb?·?[?«m( ???????Åf|I???”R?8?{	`øè?k`u»r`èWã¸?\"´)fI\n©Ô;?Zj?‡–g?¡šA??j¼Ä%ÄæT ÂE\\?r3E“j‚j?¢FXZ	âÏAy?H??d?gCQ??±´áÎ€???ü²??ïû?†út?œÇzk?`@\0001\0n”ŒøçH¸À\0€4\0g&.€\0?ú\0O(³ÈP@\r?E?0l\0??X» \râæE??8?x»¥?ÅÔ‹Ö\0??˜»±z@E??0??¨¸Qq\"éÅ??äÂD_p&?€3\0mZ.Pp?r€E???sˆñv\"éÅ??0?ø¿wâñ?,????\rcÅâ???x¸q?€3\0q?p˜ÂqŠâ?0002?ì³i„ˆÄÑŠ¢??0a??ÀÑwJ \0l\0?,`ˆº1y\0€9#?0T^ØÇq‘£\$F6Œ?\$d¨¸‘‚€FDŒyJ0b˜»\0	ªÆWŒ¾\0?œc¸Â?c E?0s?l]@\rb??"\0??˜Á‘’\"?7‹µ??\0±š?ÅÓa	^04e¨ºQ{c<ÅÑŒÉj/_˜Á?c\0001Œµ*28BA??\0000?x?iØ¾1˜£F??ljH¸‘?"??0\\_ˆ¾q?0?Œ¡T³l_0?£BEÄŒ#3?øÒ?€Æ½‹Ó?4_X??0Æ½‹ñ?d`ø×`\r£S?JMV/f€±­€1\0005I6tf€°ã4Fª‹??4f?‘ ?F-‹ß?Œd‘±\"?4k½„\$h¨Â± #EÅÌŒú\0??01—c@F‹á?d]X??G\n‹÷?¬g¹q‘ãEF\nŒm\\ÂDn˜Åq½£YFv?/4`øàq½ã€4??b?|?\0004‹‰?ÄmX?‹£e‘ö\0???\èàQ—cI?·.7?\x?\"íÆ\0i^3?(ç±’À?"Ev4l_ÈÈq®Œ\$F???œoÈ¾?r#UE??^9?ˆÁ‘¹???\0?|rÈÄ1?0Æöù69l^x¹Ñ¼PF-?\n0?ˆâQy\"?‹³2,sxÁQq#™F+?\0?DiÈëq}£À??6,jø»\0cm?×N5¼eh?v£«GL?H<T_???F??..\$føÛ??E?C2?¨Û1s#??D³lohÙÑ²£j?‹²?8?¸Å±Ôb?!õ??x?¨£?–C?Ähx?Ù£ÆÅ»??xÍñ?<?ƒ?,uØé±‘?G)??luàÀ#?????ÛÑ?şÆ?0sR.¬w¸Ö±#z?w?|x(?÷â?0001????0001‘ã¢G???|`øò?£‡ÆóÛ .2?XÜÀ#“G¨8K?<z?–£Æ¹?\"9|jˆÒÑĞ?G¤/??ˆŞÑö€GÁs??\0001‹büÇ???|???~F»W??˜Ì?#<F\rµ ??XÁQ?ÿFvk??x??ÎÅ???¬rhÜÑÀã?”?Z;¬fÈårc?y‹‘!\r	?x??"?1Ï?TwèÙ?c\rF? \n8dX»rãĞÆÔŒ§?Dbèı?d4HˆŒrA<~ÈÙ1±dBHI?J?¼¸Å?£q?k??ØØ?#„F\r??\\h¨î\r¤G?í’EttØè‘íc7?Œ¿!?D_ˆè?cN?0‘y?a?ñë?Fgç!v1?ØÈ1ØãK?»??è÷Ñ³cGoó\n/¬ŒøÆ??E??"?t`?ñö#cHµ??øÓqâ??%?Tbè¹±°d)?‹© r0‚øÌñqc¿E??>3\$tyQÒ£…ÉE’Cl`9)¤VFHMJ7”føö?$HHQ ;?i?#F³-F?HÆQ?\0G·!??Èş&4¤vG&‘û7?èà±ƒ\$\0G?rr/Äd?R?Æã‘s6@¤“?RA?Ç¬›?”Œ?‘¢¤–?\0k z=?HÙ±Éã‡Å??^J?ÀÑsd¤Ç,?\$?”¨à<cqÇ¦’Ÿ??øÏÁb?ˆQvJ´¸Ø±Ş?H5?¢F?ÜÀIc?[‹‹??ÈÏ¤vH???D”¨Çòc<I\$M.d—Ùr1c=F?.4„cˆÕ2b?.Œ!¦L|{X×Ñ³£{I«NF?x?scŞÆ???¼a)‘Ñ#¹G”?J¬m?‘û\$=Gh’AN=¬s?ÑÅ?E?G?\\a1?¤ÛH¡‘?F.tg8?Ã¤[Èò?¦Idn¸ş??F€‹Ù?T’¨ûñ?F3‘E?riq¸ãsF¼?ÄxºrãÚÆL?nFT??d Ç>????2\$?„‘= ?‘xc’H?I\"NP\$b¸ÛQ?$Fñ ®DÄ‚˜æÑï?F?%??(?£ê??\$‚O\$^x?T?Æñ??Œ¡?’‹???„òE?i/2Œ£XGˆ’??¬•??$H?¥?dš‰ è¤?’ù?laxäÑú¢?¦??X?J¤Ò???x?J#\nGG?!N¨?{cI???¬ ?R=?I\rŒù&j:?8ÃÒg#¸H‹á'3?x¸²b¤H}”£>7ƒèèñŠcÌÇ?\"&K<xØÊ2¡ã?†‹?"6@dbèë±­e;??!????d—Êm*f6,v?—ÉªÊ‹£ªL??qµ£AI8?7d?TtcôÊ?‚UL•XÈò%H¡”I*z:?IXqsá¨?-?BĞÅ?^(•R¼»aq(~eÑñ??9J?U?-eq*nTà­??$ÕÑ?er?•Î±¡p\nÅÕ¼Ë\$es+?£Išº??eq:?]•cc?r\n?f,gYø³TC?Œñ	??0?²©\\*?WP????&WòÆp)?¦Ëxl²MáÂ?3\0t\0?Iip?'\0	k\$T¤¬F??fºÍdMòÈ€K\$”¼?(@îÉ”‹?–zµnWÒ¤?ŠM?*?0?e?F?H	W*B––ZPe?ÅÖ˜‡?/dRÂ—R?\0Ku?yH)?"S?I'?Z?=?L??åÄÒ\n??kğ­?@;}R”í?²ò³ô?? w?[óÀ ?n?´n?ª¼ŒÊ“bBr?l,\$vÖíÍİÔ°‡ˆÀÕH©à‡…\\¢‹?*? º?.Qt’B…ºdˆb‘½???3¼S?a@¤K?\.«´à~?ª?¬«¨ï,?|&Ó¶KÀ£…Z9.??S‘â|ÀœØ\0PÊ¼¢ŒE“ò???0VëÖ^K?0\n-	:ËÉSØ²)×ª?j?9TX•åB?½K\"åÅ?•Â?2??Ëå?˜P,¡xŠô??ĞáK?ª´š›?"??TV²œD¿õ1?Ao;??9TH%V`WJ<9?¯aeÊ°?K/V^/¨Q†¤?nB?Z\"9íË?Ò¯M~\$?„ŠßÚ\$0dè½I€U“Í??X\n?*?7I\nV3?–…+?ŒÃIiÒÒN?K˜g0’aŒ°„z*“V©?bJyMÒ¦eõâZ?…V ¢?’ĞòĞU1?˜Ÿ.\rF²ª-j?LU˜p?s‚é¹Š+Q&1¨âRm¥ÕÓ±gZª²?,.XryZì²?¨Ï??˜A1©Ö‚’e‰N?©¸˜ú??Al ??,N?e²Ï\$|rùá_%²ñE05E}?$¡Ü…X2??ªe €\n\";<9a¾hã¶?a]úÊ?8±???åÁªL?¦¶±dR¿ğ0«¸Áª+?m.?,G??¦M?_???dBêÍİ¸,°S???UÕêëÔ°»4vl?e2©ò2¤eÄµ?Yg2nf?Àş\$?óÌ?Ffaìµ)‹ê§å”ÌfTÆ¶?¤Í?2ºW,[™šíÊX>)t?]œº™R*?Z·Å6j2|‘¥\0 °(©p	??ÌùuÒª?ôĞ`n??lZn?!H9²çæzL??VLÏ¹yÒĞİ¢Z?JhR›‰g“EfL?UŠ²~`4??çæx)\$B±QR#Ã•S?”¥ËË?6i#ÀY¦“,;C±šr¬âi???]èÍ\nw54­K‰x?n*&©T?£îWüÓ??¦©+SĞ»qNc·yóIWä¯?0W5cÔÒÉ«‹ğ&+š¶ğVr?¬ê?£Kgšª¾Ô??µŠ??«gR¦¯†hR?Kë¹?Z#??,Öµ–k…æ¼»`??l:?LsC?M‰UB?ld??J¦°ªŸ•ï1nl:ºù•j¦???0®hã¶ *)¥p/®šŞ§5\\?9´óV¦…/‹šŞ«®hT?djµårMbx\n?R¹çWªR?MaU?=??0³oÈË,Z™¬?lÀÅ}Èó¦m¨ì›”í²lôÎ??L?6?\’t?¹ò???îÉ\\?‘J¶”ƒK??oÑ©Ÿ¤ef€M?£’oC»Y¡“v?­NV?=R?¢sJİÉÍö¬¶*hÔÕ?näæ?m›é4‰ß4?¤óH??|îÊis¬U=ƒİÚÍA\$Ú­?¹Ï™¾“…ö?–êîÊpâ¼pûóQfø«?À§ªq,ÔÕ5sŠUL??}İ¬ÅÙª“??ÃXH±Ùİì?««î§?U??:³I»î?´ª???l?}Ğ÷f¹LY•ğ¬áN2Ş°?&?išê?c,???ÚÄRœ©6räØ‰Ì3b??œÇ6>lXY????+?,???lÍô™U\"ed??"Z?ªÚ–6’ZD?9°á%ÈÎ‚›Y9rmt?Ğó'.M?4¬‚^„åÉ·?;M»w?…×?¸Ò?a¬¦v+70lÍÉÓÓd%£Ì<œù3?<?lN²¦?€v+7YRl?Óª]?•Õ4©I³®)¼³=?N®T?]Û¹'U^??«¼?¾XC?©Ó¨Õ1?u?©E´ß™²k?;œ¤NhÌìÀS?NXk;1[„Ò??gpVœB?_¤á?ÎÅgs¬ š;­RlîÕEˆ×????,îéÅs¯•1?xr?q”ê‰ß3¦?ª;?Úı	yÓ¾'{O	_´¾??ÈªMg|?ó92eL?Êó”f¼O\rYŠnkÜåuŠ™”SN?9Vk?	?Ç§.?v9zyd??“¦???s\$ìù?d'6?œQ<?Üç)?e??›§:ÑØ¬êYjt¥¡Ãp‡u<±İ?Éß3?qM°Y:9XãµS³¾gI«Ã??mäÆÄCëù?v Gßì?@?Ö¯¬jT?¨:e?ÛÀ(\0_Vn??p?3??™¸¨‘?™??\r¬†•¼?\"??ºgT’nşP?¤°\n??,?f?Y?µQ A¼A?,ZÊÚeS?›˜sEÀ?r?v„T‹¬QŸZ?"pó²I??A?\0¾ëvZ?®r?¥K?tf?P?9??{¼¶^J€çß?Ÿ”?šø©•\n0%?NGÚ«*~l?D.»¦?eŸ¹6?,?ÀˆğO???ìµ•–óú¥j®ŸRO;?@	Ë¨en›b_?sK¿Å??‚Ã?ÿ?ºÎY?ü¥ÃL?ª¦jrßÕóèÏ† ë©!BšÙ??Pv´£fwÚ«Éø€çãMÃR2?€z?4r?;?M@??0?ëã?M?0??=å¡??!?6p??g[P4‚´†Ì???5:–‚\rµCt?ÍÃ u@ıÛ???f„ĞNu¼n[?u8j{&9Ku FQlR“i?(? ÇAä®™s4ˆë\0Y Í;fƒB<???¼R_I?š…6??MWTA?4?@J­e?|[ú¨–r5*??O??t?)¤ê??\0Pªjm	usá§}?Ÿ“Bi^©Ú*¦z?YK.?[¯Y?íÖĞ«??XBÑÅÁÓ????\$“l?’³,æÎX?DçÍ\n??æ¡OD?>_<¼¥??‡Ù\0š£ÙÕ¬¥Ás?\\…¡•ea\\?\0Êöe?™Y?`¼¥?U?"e¡ÇCYTìñ?t:V9P?š³…a‚Ğ•F??\0MŸ¢´†?“eúëHCéĞ???ò¼?'?¬å‡ä?c¾Y?õè„¬??Qh8	ğ´0?Q?CM`ºŸ«ó6æø,‹Ÿ¢J‘eZ¾Z\"G—Wª¡u?–u\r?49?K??%L–¹ÍİV9Ïü?İÖ‰´??VEOÄX;©áÑÏ??gP?$\n²RX@}!-Si€?ª¾¢qz?öêITH.?Ôí\nk\n??ndÏ®˜Tº‰²>?nîÂ– ?£E?²Ì5D+f?#z³…IZ?7T[?Qs#?ˆ?$«Õ?ù¢??	?¾×*??YI²ãH‹³??X???u7J¸–m? YB}Eª°?³¿—ç??r?8Q•ù\n}'P?â²	Q±Ğõáú¨‘?$§Å`R?^áõ(O€P\0?aK½µõôm?¬Š\$H.„ùX„ëñÔ??®™`”­? ?®Y™‘18â?UÁ’`X?‚?Œğäç\\Lcˆj°IE N?«ª?€W?D¦XB?Z??Ï¤:	E-P-?ÎÁè¿)?ğ§?Óú??PÂuŒy|R?³Lhÿ.p?§é_* QA †@ ?,Æ§?YêÖ)t???íÁP*êå?’VuQ?2\0L??JëçèÑ,TPHL²Á?%–?\0ª¢yP(YJZ¥î©úTHÅX\r	•Q4hO?\\vV?åÀTWw‡ï\\`õOÒ¡???R2³ò??óâ]»ĞŸI5TMjI??(Æ¤Dv|t?ŠWy-?z¨Úe‚Œ‰a,pQ6\$?-g=%‘S?#?P§Ü¤?«T&]ŞÑ?15j?”B8„„?ÏÓ?n?em y“”h?è¤ü»„?d?4??bd!0¤gR?J\\??tƒÀ1R\n\nï?è¡èÜÁª.?¾üu?+Æ¼?ı?4ˆÎ?]?\¡l?m\"?ƒQ†nT?*\0?`?H?2	6h??ÀcH_ÌÚ??°Ğa«–7=KKdeÂt???\0/\0?62@b~Ë`?0.?\0?v? !~?JPÄT—Á½ô½’–…µ¥?Â—??t??0005?¾˜/à¯€\r©ƒÁJ^???!?€8?K?PP4Åé~?H’˜á÷ĞÅô¼Üí\r+?Lb˜¥/24)“Ó¦GK?e0ŠeËé€S1?B?-0jfÔÄ?S¦wL?Äi? …é Ó?Lºš\r1ºhôÈ©œS ¦—MJJ?t?¨Ó+?L¶še5n”Ó?FHŒÉMN—õ5?ÔÉ©™SH“ÕL–—??TØé´ÓD“ÕMnš½6Zm@I@S`?'ª™?f?©ŸSz¦x~OU1k”¿¤õSF?MOU4ªpôÙ?\0000???Šk?xSl?K??\nl”Í?Su?LR7?šstßãxS}§GM7?*qt?xS†§OM\"7?ªuôë)ÆÓ?0?’š????r¦‰2šı;?ôğ)ŞÓ7§Nj›m/Šxç©ÕÓ¿¦sN?:jy4¿©?ª§gO:1?\ncTö©§SÍ§?’œ??ñ¥©îSÈ§/ORH\r=?TôéŠIİ§¥O˜?\zx4÷©Sò§‹M??j|T?ºS¶‘³O†™¼?ôĞ\$lÓú?O?š}t?ÈÙ§ßO?¤šzÔû*??PP?švU\"úÓİ§¯K??\no?j??P?>š1£éÿFd?P.5BØ¸??r??œuB??L#?¨QPEC?u*\nÅÛ¨yPN¡´lª‚?r?Óó?Kú¢mBZi?j?¨›O2?1J‰µ???Mş¢mDŠˆ€??¨ÇQ6¡­Fzv´ğ?Ó¹§éQjå;jµj)?¨Ş¾£mE??Fd¨ÅQv5eGØÉ?d¤Ô„¨EM\0+??\"j)SD?QÒ¤pZf???§mR&?HŠ’U’Û??Rv0m0z?¥ä§ŸLÆ¥@?'ÖÔ©ER?eJ?é¸?¨İM’¥µI??ªYT¦??¥B?.?T»©YRÎ¡L:?jN?©•Rš¡??5ji&,‰Oê¦mJD?,?ÔÀ©­Q¦©??1?Tf©›N?˜ÒÑŞ¥Q€'©Î7¾§Lih¸²\rcj?Œ‘Sz?ušŸ\0n?Ôº©g¶§?9?c??rT?LÅÕAªfT­MT9uQ\nŸÕ)¢çU©µSº¨uD:“±—jˆU	©­Æ¨…P?q?‚EÚªKSb¥l\\Ú¤µFª”ÔÅªGTz?gJ¤µHªSF?\"©½Q:?‘ê›Õ?†©½Rê¦µL*~EßªoTÒ¦\\z ‘„ª¥Õ:©­âª]S?±Ÿª¥?ª“U?^J©uR*kEõª	?T?Qtê¯?©g2?Uj«µV\$ÅÕ_ª¹Sˆ³mPH?\\ª±T?[UÊ«5JhÙµ\\ªµUpªÙ¢«•V?a_*€???R?\0I*¼¥?V«íX:hU8j??Z’¬\\:ƒÕ)j?·«8˜±	?Z³Ub’òJ8?R?Y³UVU–«R¬¤\\:™Õ-jËÔÑ«iV.¦¥[z´±ÒªÂÇ-?T²­ÅZªuoj?»«3 ¡Í[ª±?ªØ?«E ?\\º±µh#b?‹©WZ?\\º¸?êæ?«»W>¨­]Úºg4#¶ÕÀ«KTr?ZÊ¤wjãÕ\$«›z?Rj½õtj?*«ßWš¬tp\n??ğ'–N•Mº´?ªxU?™X32[x?+®“?$B°US*½õq?UÍªqXZ?SÊÂ?êÁ??W\n5?Z¨Õ…ªãÕJ«›U2?\\úª‰ëF+«ñV?]XXÁUŒªìÖ0«¬-VJ¹²+?«É‚±?Ê®5sj¹ÖD«ŸUŞ²%bØÉµªÁÇ÷?V?Y?u@d¤Õ¢’“WĞæ„”šÅ²Rk&œŒ?R¬\\¤Å’Rk?©cVÆO-\\š—	kdòÓ?oX²¥KÊÍ/??“ËVªO-U?µ™@İÉå¬¥VÎ³[???U¹­—?eŠÏµo?Tİ­Y?eHÆÕ¤ª\rÊÍ9?¢•??ó®•+7?b?I ??\0?FzğÉ?n…§|?œs<?R?JÓË??Fèµ3õ­Œ‰j¢Î£¹Y?Z“¾^<5X·IJòÅM`?O\\£B&¶r“õsÅçQˆuz¨¢x¼å¹è	¬Tˆ®¤Vw?J5¸g	?v¨qF4?9³Ó·??6ªzjùè?‡OV•¿\r????fT?œğïöy´³	€Ö«pKaXU9šm²³…­\nekMo›Ã5\nhT?†ê¦¦…V ®¬v€‚ı:?s®?\\p>???¦‹)ñ­O=nk}j¥Sõ«&·Ö®?µŠ¤y©àe”¬??Öµ?j?®”t?VR¢Vµ½sµr?+a?­‹,!T??U??n­›5¾¶\\??v+’M\\?]B???´¦l;4˜¯5?LÖùÓµØ¦7Li?~bmtÉæSe€\"»°?Bº½v©´d“ç@Í§S?)?—Z???$)?5ic!™µ´¢½?–ê?\\R??D¦’?\$??S?n?Gf??ÆîÊ¸´ßÚã*?KÍô­D·Vyû¹5?È¦J??\\šµC¹•\$??,¯M\\º»ôåÊæ5¬ë?–®k^•V?Šè5®k¡Ö»¯M^êµ??u°§Ï¤wFQ????WN¡k8şº?Šô?+¸»§˜?brÄíùË•ØëÓV??dL?í´YT™Îv?6–twy??ò×ë­à«vx=??»²??½ô8?ÊÁ‘ñË·x\"c|?fUÿƒş?0˜Ò??È©}”Pkn?Rl¾‰fÙª??“ÑÛ£‚¢>c4Æ×W+T?o???Ç÷qî¯?€SX’¨?}}Åhn?<??3º”-Ã¡h†°©qn‰ı???)S?P\r?ÛÍ?m-??°Š?€\\???? )ıç?Ydç«Ø¤46#Y>?3????m©ú\n09h;?˜°?‚Ã+?e\n?Ä°?!ÊÅü??@?¢x}?$¦Ö??FŒúÃ‘?N?R?º°şÓ„èiÜ¥ü¬U?½¡—b5?+×­\0G˜ı?{?îÓ¤—?lI ?’w-4;p8ÂÎØ¤;@\r\n\r­…?5Æ…F\\Ó¹hgPE il0?X??\nˆØLk??^‚???5F??‰I???³bM¬d'?¶Æ²D£â?Bma??Òö…ıOY?gg?¥çZV?%mf¬Ô%?F???\nƒ‘?ù¤F?fƒôs¹ç?0Gä¹???n	1?Jí??\"iP??´C¬–Ìû²t—z?ãÑ?;l??ÈÒ¡‚ƒJ‡”mLX?l??{??"?\n?ÁÀšÄ??$Y\0?\\?6›D9B´H±d%¦Ó?1ÛÁ˜6f ?"?TJ??/²‡>?=?c“ì¨±¼²?e!?*?l~ƒÃ?ÿ??‚z/d??¦MoìÅí´Ú²n?"É½„ÍÂëÆzTr}e?{MÀaC?‘fiTºõ—Ë/6W¢©P²ìÖÌ8†Fa`İì?5?ó©¹M…f2V]?'}cn4]h·í?«¦?Z€Å§\r™‹2ÉÈ½XllGa`(­™—Û(‚ŠÄò\0?ÄıšĞ_?O??&f?c8?{¼Q??S6?\0?Â˜?¹˜™î\0\r??m&*f???r^cŒÏ³¨?`Éµ&z€n^Ú±?DÈèSã¤oj^?¿L'g?5œ“?ƒì?Ef&ñŞ?\nK 6?bX*?f?Eƒû?&9?˜çdŒk@‰v\"F¬G?x\\????XP2[:Á¶\0??à¡ X~??·Í?X6?²œ??";B?nŞıX??y¹Ì&›D??Z?l\nKC–‰?šŸ†p?’Ä`mS?2??G??8¶´{’Ñ-”±WBm??$F€?r?&B‡Y2\r´¨mAÅ‘°wÄZ???¿Ğ%d´ŒİÂ?²œT?5?`Ba??´Õc?K?r¶˜\0?gN¼ù\\‘´?Nà¨àÄ?^\nŒÌu§ä?Ÿ­Ñ²VwzÄU F\"\0T-?^’Î\0‹Î?? /? óÂÏàEW?/\0Â¼?ÒÄ¾Ë4;\"?-NZ?½ĞMcÎ»RVNeœZ?wj–Â??¯a¶÷y?Ùç?‹KV®lN?±Ãjt2­–¶T/[?¤û±j|0t% #°”€??0ôÓ`£ø5F<–´ƒ X@\nÓ¢Áí•ËZF\\-m›¼³cd2Äp5Gºv'B??{k?*'L?ªZ|I±k?n-.C??«¹????©SÚú°÷k?]?_\$??Gò×?[^‡­­z]kÑÑ8?\ö¿F|§¢?BˆØ?^??B¨‰?|??????zP?W/R?[!bB–á?kÀ‰?'	(?:xf??\r_íâq?Ma?0#±ä7|?&\0?@)???1òë®†LA[Pt?0?™ı`??\e‘Ÿ¶zxÒÚS?v??U:Ú±¿T¼Á‡ˆ?>f?nq‹l€?K(|?\´?G›U???(??S?F?rR\$©•C¶¶LĞİÄö;?µìÄ¼g?\$m??h?Š3?PªY?0");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0?0001îî?0\0€™™?0\0\0!?\0\0\0,\0\0\0\0\0\0!„©Ë?MñÌ*)¾oú¯) q?¡eˆµ?ÄòL?\0;";break;case"cross.gif":echo"GIF89a\0\0?0001îî?0\0€™™?0\0\0!?\0\0\0,\0\0\0\0\0\0#„©Ë?#\na?o~y??wa”á1ç±J?GÂL?]\0\0;";break;case"up.gif":echo"GIF89a\0\0?0001îî?0\0€™™?0\0\0!?\0\0\0,\0\0\0\0\0\0 „©Ë?MQN\n??a8?yšaÅ¶?0Çò\0;";break;case"down.gif":echo"GIF89a\0\0?0001îî?0\0€™™?0\0\0!?\0\0\0,\0\0\0\0\0\0 „©Ë?MñÌ*)?W?\¢ÇL&?Æ¶?0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!?\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹?ªÓ²Ş?0\0;";break;}}exit;}if($_GET["script"]=="version"){$ld=file_open_lock(get_temp_dir()."/adminer.version");if($ld)file_write_unlock($ld,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$g,$m,$ic,$qc,$_c,$n,$nd,$td,$ba,$Td,$y,$ca,$me,$pf,$bg,$Gh,$yd,$ni,$ti,$U,$Hi,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");$Of=array(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba);if(version_compare(PHP_VERSION,'5.2.0')>=0)$Of[]=true;call_user_func_array('session_set_cookie_params',$Of);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$Yc);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);function
get_lang(){return'en';}function
lang($si,$ef=null){if(is_array($si)){$eg=($ef==1?0:1);$si=$si[$eg];}$si=str_replace("%d","%s",$si);$ef=format_number($ef);return
sprintf($si,$ef);}if(extension_loaded('pdo')){class
Min_PDO{var$_result,$server_info,$affected_rows,$errno,$error,$pdo;function
__construct(){global$b;$eg=array_search("SQL",$b->operators);if($eg!==false)unset($b->operators[$eg]);}function
dsn($nc,$V,$F,$xf=array()){$xf[PDO::ATTR_ERRMODE]=PDO::ERRMODE_SILENT;$xf[PDO::ATTR_STATEMENT_CLASS]=array('Min_PDOStatement');try{$this->pdo=new
PDO($nc,$V,$F,$xf);}catch(Exception$Fc){auth_error(h($Fc->getMessage()));}$this->server_info=@$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);}function
quote($P){return$this->pdo->quote($P);}function
query($G,$Bi=false){$H=$this->pdo->query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error='Unknown error.';return
false;}$this->store_result($H);return$H;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result($H=null){if(!$H){$H=$this->_result;if(!$H)return
false;}if($H->columnCount()){$H->num_rows=$H->rowCount();return$H;}$this->affected_rows=$H->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($G,$o=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch();return$J[$o];}}class
Min_PDOStatement
extends
PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(PDO::FETCH_ASSOC);}function
fetch_row(){return$this->fetch(PDO::FETCH_NUM);}function
fetch_field(){$J=(object)$this->getColumnMeta($this->_offset++);$J->orgtable=$J->table;$J->orgname=$J->name;$J->charsetnr=(in_array("blob",(array)$J->flags)?63:0);return$J;}}}$ic=array();function
add_driver($u,$D){global$ic;$ic[$u]=$D;}class
Min_SQL{var$_conn;function
__construct($g){$this->_conn=$g;}function
select($Q,$L,$Z,$qd,$zf=array(),$_=1,$E=0,$mg=false){global$b,$y;$ae=(count($qd)<count($L));$G=$b->selectQueryBuild($L,$Z,$qd,$zf,$_,$E);if(!$G)$G="SELECT".limit(($_GET["page"]!="last"&&$_!=""&&$qd&&$ae&&$y=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$L)."\nFROM ".table($Q),($Z?"\nWHERE ".implode(" AND ",$Z):"").($qd&&$ae?"\nGROUP BY ".implode(", ",$qd):"").($zf?"\nORDER BY ".implode(", ",$zf):""),($_!=""?+$_:null),($E?$_*$E:0),"\n");$Ch=microtime(true);$I=$this->_conn->query($G);if($mg)echo$b->selectQuery($G,$Ch,!$I);return$I;}function
delete($Q,$wg,$_=0){$G="FROM ".table($Q);return
queries("DELETE".($_?limit1($Q,$G,$wg):" $G$wg"));}function
update($Q,$N,$wg,$_=0,$hh="\n"){$Ti=array();foreach($N
as$z=>$X)$Ti[]="$z = $X";$G=table($Q)." SET$hh".implode(",$hh",$Ti);return
queries("UPDATE".($_?limit1($Q,$G,$wg,$hh):" $G$wg"));}function
insert($Q,$N){return
queries("INSERT INTO ".table($Q).($N?" (".implode(", ",array_keys($N)).")\nVALUES (".implode(", ",$N).")":" DEFAULT VALUES"));}function
insertUpdate($Q,$K,$kg){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($G,$ei){}function
convertSearch($v,$X,$o){return$v;}function
value($X,$o){return(method_exists($this->_conn,'value')?$this->_conn->value($X,$o):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($Xg){return
q($Xg);}function
warnings(){return'';}function
tableHelp($D){}}$ic["sqlite"]="SQLite 3";$ic["sqlite2"]="SQLite 2";if(isset($_GET["sqlite"])||isset($_GET["sqlite2"])){define("DRIVER",(isset($_GET["sqlite"])?"sqlite":"sqlite2"));if(class_exists(isset($_GET["sqlite"])?"SQLite3":"SQLiteDatabase")){if(isset($_GET["sqlite"])){class
Min_SQLite{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error,$_link;function
__construct($q){$this->_link=new
SQLite3($q);$Wi=$this->_link->version();$this->server_info=$Wi["versionString"];}function
query($G){$H=@$this->_link->query($G);$this->error="";if(!$H){$this->errno=$this->_link->lastErrorCode();$this->error=$this->_link->lastErrorMsg();return
false;}elseif($H->numColumns())return
new
Min_Result($H);$this->affected_rows=$this->_link->changes();return
true;}function
quote($P){return(is_utf8($P)?"'".$this->_link->escapeString($P)."'":"x'".reset(unpack('H*',$P))."'");}function
store_result(){return$this->_result;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetchArray();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;}function
fetch_assoc(){return$this->_result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->_result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$e=$this->_offset++;$T=$this->_result->columnType($e);return(object)array("name"=>$this->_result->columnName($e),"type"=>$T,"charsetnr"=>($T==SQLITE3_BLOB?63:0),);}function
__desctruct(){return$this->_result->finalize();}}}else{class
Min_SQLite{var$extension="SQLite",$server_info,$affected_rows,$error,$_link;function
__construct($q){$this->server_info=sqlite_libversion();$this->_link=new
SQLiteDatabase($q);}function
query($G,$Bi=false){$Pe=($Bi?"unbufferedQuery":"query");$H=@$this->_link->$Pe($G,SQLITE_BOTH,$n);$this->error="";if(!$H){$this->error=$n;return
false;}elseif($H===true){$this->affected_rows=$this->changes();return
true;}return
new
Min_Result($H);}function
quote($P){return"'".sqlite_escape_string($P)."'";}function
store_result(){return$this->_result;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetch();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;if(method_exists($H,'numRows'))$this->num_rows=$H->numRows();}function
fetch_assoc(){$J=$this->_result->fetch(SQLITE_ASSOC);if(!$J)return
false;$I=array();foreach($J
as$z=>$X)$I[idf_unescape($z)]=$X;return$I;}function
fetch_row(){return$this->_result->fetch(SQLITE_NUM);}function
fetch_field(){$D=$this->_result->fieldName($this->_offset++);$Zf='(\[.*]|"(?:[^"]|"")*"|(.+))';if(preg_match("~^($Zf\\.)?$Zf\$~",$D,$C)){$Q=($C[3]!=""?$C[3]:idf_unescape($C[2]));$D=($C[5]!=""?$C[5]:idf_unescape($C[4]));}return(object)array("name"=>$D,"orgname"=>$D,"orgtable"=>$Q,);}}}}elseif(extension_loaded("pdo_sqlite")){class
Min_SQLite
extends
Min_PDO{var$extension="PDO_SQLite";function
__construct($q){$this->dsn(DRIVER.":$q","","");}}}if(class_exists("Min_SQLite")){class
Min_DB
extends
Min_SQLite{function
__construct(){parent::__construct(":memory:");$this->query("PRAGMA foreign_keys = 1");}function
select_db($q){if(is_readable($q)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$q)?$q:dirname($_SERVER["SCRIPT_FILENAME"])."/$q")." AS a")){parent::__construct($q);$this->query("PRAGMA foreign_keys = 1");$this->query("PRAGMA busy_timeout = 500");return
true;}return
false;}function
multi_query($G){return$this->_result=$this->query($G);}function
next_result(){return
false;}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$K,$kg){$Ti=array();foreach($K
as$N)$Ti[]="(".implode(", ",$N).")";return
queries("REPLACE INTO ".table($Q)." (".implode(", ",array_keys(reset($K))).") VALUES\n".implode(",\n",$Ti));}function
tableHelp($D){if($D=="sqlite_sequence")return"fileformat2.html#seqtab";if($D=="sqlite_master")return"fileformat2.html#$D";}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b;list(,,$F)=$b->credentials();if($F!="")return'Database does not support password.';return
new
Min_DB;}function
get_databases(){return
array();}function
limit($G,$Z,$_,$hf=0,$hh=" "){return" $G$Z".($_!==null?$hh."LIMIT $_".($hf?" OFFSET $hf":""):"");}function
limit1($Q,$G,$Z,$hh="\n"){global$g;return(preg_match('~^INTO~',$G)||$g->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($G,$Z,1,0,$hh):" $G WHERE rowid = (SELECT rowid FROM ".table($Q).$Z.$hh."LIMIT 1)");}function
db_collation($l,$lb){global$g;return$g->result("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($k){return
array();}function
table_status($D=""){global$g;$I=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($D!=""?"AND name = ".q($D):"ORDER BY name"))as$J){$J["Rows"]=$g->result("SELECT COUNT(*) FROM ".idf_escape($J["Name"]));$I[$J["Name"]]=$J;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$J)$I[$J["name"]]["Auto_increment"]=$J["seq"];return($D!=""?$I[$D]:$I);}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){global$g;return!$g->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($Q){global$g;$I=array();$kg="";foreach(get_rows("PRAGMA table_info(".table($Q).")")as$J){$D=$J["name"];$T=strtolower($J["type"]);$Wb=$J["dflt_value"];$I[$D]=array("field"=>$D,"type"=>(preg_match('~int~i',$T)?"integer":(preg_match('~char|clob|text~i',$T)?"text":(preg_match('~blob~i',$T)?"blob":(preg_match('~real|floa|doub~i',$T)?"real":"numeric")))),"full_type"=>$T,"default"=>(preg_match("~'(.*)'~",$Wb,$C)?str_replace("''","'",$C[1]):($Wb=="NULL"?null:$Wb)),"null"=>!$J["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1),"primary"=>$J["pk"],);if($J["pk"]){if($kg!="")$I[$kg]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$T))$I[$D]["auto_increment"]=true;$kg=$D;}}$yh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$yh,$Ce,PREG_SET_ORDER);foreach($Ce
as$C){$D=str_replace('""','"',preg_replace('~^"|"$~','',$C[1]));if($I[$D])$I[$D]["collation"]=trim($C[3],"'");}return$I;}function
indexes($Q,$h=null){global$g;if(!is_object($h))$h=$g;$I=array();$yh=$h->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$yh,$C)){$I[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$C[1],$Ce,PREG_SET_ORDER);foreach($Ce
as$C){$I[""]["columns"][]=idf_unescape($C[2]).$C[4];$I[""]["descs"][]=(preg_match('~DESC~i',$C[5])?'1':null);}}if(!$I){foreach(fields($Q)as$D=>$o){if($o["primary"])$I[""]=array("type"=>"PRIMARY","columns"=>array($D),"lengths"=>array(),"descs"=>array(null));}}$Ah=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($Q),$h);foreach(get_rows("PRAGMA index_list(".table($Q).")",$h)as$J){$D=$J["name"];$w=array("type"=>($J["unique"]?"UNIQUE":"INDEX"));$w["lengths"]=array();$w["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($D).")",$h)as$Wg){$w["columns"][]=$Wg["name"];$w["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($D).' ON '.idf_escape($Q),'~').' \((.*)\)$~i',$Ah[$D],$Gg)){preg_match_all('/("[^"]*+")+( DESC)?/',$Gg[2],$Ce);foreach($Ce[2]as$z=>$X){if($X)$w["descs"][$z]='1';}}if(!$I[""]||$w["type"]!="UNIQUE"||$w["columns"]!=$I[""]["columns"]||$w["descs"]!=$I[""]["descs"]||!preg_match("~^sqlite_~",$D))$I[$D]=$w;}return$I;}function
foreign_keys($Q){$I=array();foreach(get_rows("PRAGMA foreign_key_list(".table($Q).")")as$J){$r=&$I[$J["id"]];if(!$r)$r=$J;$r["source"][]=$J["from"];$r["target"][]=$J["to"];}return$I;}function
view($D){global$g;return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',$g->result("SELECT sql FROM sqlite_master WHERE name = ".q($D))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
check_sqlite_name($D){global$g;$Oc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Oc)\$~",$D)){$g->error=sprintf('Please use one of the extensions %s.',str_replace("|",", ",$Oc));return
false;}return
true;}function
create_database($l,$d){global$g;if(file_exists($l)){$g->error='File exists.';return
false;}if(!check_sqlite_name($l))return
false;try{$A=new
Min_SQLite($l);}catch(Exception$Fc){$g->error=$Fc->getMessage();return
false;}$A->query('PRAGMA encoding = "UTF-8"');$A->query('CREATE TABLE adminer (i)');$A->query('DROP TABLE adminer');return
true;}function
drop_databases($k){global$g;$g->__construct(":memory:");foreach($k
as$l){if(!@unlink($l)){$g->error='File exists.';return
false;}}return
true;}function
rename_database($D,$d){global$g;if(!check_sqlite_name($D))return
false;$g->__construct(":memory:");$g->error='File exists.';return@rename(DB,$D);}function
auto_increment(){return" PRIMARY KEY".(DRIVER=="sqlite"?" AUTOINCREMENT":"");}function
alter_table($Q,$D,$p,$fd,$rb,$yc,$d,$Ka,$Tf){global$g;$Mi=($Q==""||$fd);foreach($p
as$o){if($o[0]!=""||!$o[1]||$o[2]){$Mi=true;break;}}$c=array();$Hf=array();foreach($p
as$o){if($o[1]){$c[]=($Mi?$o[1]:"ADD ".implode($o[1]));if($o[0]!="")$Hf[$o[0]]=$o[1][0];}}if(!$Mi){foreach($c
as$X){if(!queries("ALTER TABLE ".table($Q)." $X"))return
false;}if($Q!=$D&&!queries("ALTER TABLE ".table($Q)." RENAME TO ".table($D)))return
false;}elseif(!recreate_table($Q,$D,$c,$Hf,$fd,$Ka))return
false;if($Ka){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = ".q($D));if(!$g->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($D).", $Ka)");queries("COMMIT");}return
true;}function
recreate_table($Q,$D,$p,$Hf,$fd,$Ka,$x=array()){global$g;if($Q!=""){if(!$p){foreach(fields($Q)as$z=>$o){if($x)$o["auto_increment"]=0;$p[]=process_field($o,$o);$Hf[$z]=idf_escape($z);}}$lg=false;foreach($p
as$o){if($o[6])$lg=true;}$lc=array();foreach($x
as$z=>$X){if($X[2]=="DROP"){$lc[$X[1]]=true;unset($x[$z]);}}foreach(indexes($Q)as$ge=>$w){$f=array();foreach($w["columns"]as$z=>$e){if(!$Hf[$e])continue
2;$f[]=$Hf[$e].($w["descs"][$z]?" DESC":"");}if(!$lc[$ge]){if($w["type"]!="PRIMARY"||!$lg)$x[]=array($w["type"],$ge,$f);}}foreach($x
as$z=>$X){if($X[0]=="PRIMARY"){unset($x[$z]);$fd[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($Q)as$ge=>$r){foreach($r["source"]as$z=>$e){if(!$Hf[$e])continue
2;$r["source"][$z]=idf_unescape($Hf[$e]);}if(!isset($fd[" $ge"]))$fd[]=" ".format_foreign_key($r);}queries("BEGIN");}foreach($p
as$z=>$o)$p[$z]="  ".implode($o);$p=array_merge($p,array_filter($fd));$Yh=($Q==$D?"adminer_$D":$D);if(!queries("CREATE TABLE ".table($Yh)." (\n".implode(",\n",$p)."\n)"))return
false;if($Q!=""){if($Hf&&!queries("INSERT INTO ".table($Yh)." (".implode(", ",$Hf).") SELECT ".implode(", ",array_map('idf_escape',array_keys($Hf)))." FROM ".table($Q)))return
false;$zi=array();foreach(triggers($Q)as$xi=>$fi){$wi=trigger($xi);$zi[]="CREATE TRIGGER ".idf_escape($xi)." ".implode(" ",$fi)." ON ".table($D)."\n$wi[Statement]";}$Ka=$Ka?0:$g->result("SELECT seq FROM sqlite_sequence WHERE name = ".q($Q));if(!queries("DROP TABLE ".table($Q))||($Q==$D&&!queries("ALTER TABLE ".table($Yh)." RENAME TO ".table($D)))||!alter_indexes($D,$x))return
false;if($Ka)queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = ".q($D));foreach($zi
as$wi){if(!queries($wi))return
false;}queries("COMMIT");}return
true;}function
index_sql($Q,$T,$D,$f){return"CREATE $T ".($T!="INDEX"?"INDEX ":"").idf_escape($D!=""?$D:uniqid($Q."_"))." ON ".table($Q)." $f";}function
alter_indexes($Q,$c){foreach($c
as$kg){if($kg[0]=="PRIMARY")return
recreate_table($Q,$Q,array(),array(),array(),0,$c);}foreach(array_reverse($c)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($Q,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($S){return
apply_queries("DELETE FROM",$S);}function
drop_views($Yi){return
apply_queries("DROP VIEW",$Yi);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
move_tables($S,$Yi,$Wh){return
false;}function
trigger($D){global$g;if($D=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$v='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$yi=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(".implode("|",$yi["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",$g->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($D)),$C);$gf=$C[3];return
array("Timing"=>strtoupper($C[1]),"Event"=>strtoupper($C[2]).($gf?" OF":""),"Of"=>idf_unescape($gf),"Trigger"=>$D,"Statement"=>$C[4],);}function
triggers($Q){$I=array();$yi=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q))as$J){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$yi["Timing"]).')\s*(.*?)\s+ON\b~i',$J["sql"],$C);$I[$J["name"]]=array($C[1],$C[2]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ROWID()");}function
explain($g,$G){return$g->query("EXPLAIN QUERY PLAN $G");}function
found_rows($R,$Z){}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($ah){return
true;}function
create_sql($Q,$Ka,$Hh){global$g;$I=$g->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($Q));foreach(indexes($Q)as$D=>$w){if($D=='')continue;$I.=";\n\n".index_sql($Q,$w['type'],$D,"(".implode(", ",array_map('idf_escape',$w['columns'])).")");}return$I;}function
truncate_sql($Q){return"DELETE FROM ".table($Q);}function
use_sql($j){}function
trigger_sql($Q){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q)));}function
show_variables(){global$g;$I=array();foreach(array("auto_vacuum","cache_size","count_changes","default_cache_size","empty_result_callbacks","encoding","foreign_keys","full_column_names","fullfsync","journal_mode","journal_size_limit","legacy_file_format","locking_mode","page_size","max_page_count","read_uncommitted","recursive_triggers","reverse_unordered_selects","secure_delete","short_column_names","synchronous","temp_store","temp_store_directory","schema_version","integrity_check","quick_check")as$z)$I[$z]=$g->result("PRAGMA $z");return$I;}function
show_status(){$I=array();foreach(get_vals("PRAGMA compile_options")as$wf){list($z,$X)=explode("=",$wf,2);$I[$z]=$X;}return$I;}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Tc){return
preg_match('~^(columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Tc);}function
driver_config(){$U=array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0);return
array('possible_drivers'=>array((isset($_GET["sqlite"])?"SQLite3":"SQLite"),"PDO_SQLite"),'jush'=>"sqlite",'types'=>$U,'structured_types'=>array_keys($U),'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL"),'functions'=>array("hex","length","lower","round","unixepoch","upper"),'grouping'=>array("avg","count","count distinct","group_concat","max","min","sum"),'edit_functions'=>array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",)),);}}$ic["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){define("DRIVER","pgsql");if(extension_loaded("pgsql")){class
Min_DB{var$extension="PgSQL",$_link,$_result,$_string,$_database=true,$server_info,$affected_rows,$error,$timeout;function
_error($Ac,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($M,$V,$F){global$b;$l=$b->database();set_error_handler(array($this,'_error'));$this->_string="host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($F,"'\\")."'";$this->_link=@pg_connect("$this->_string dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->_link&&$l!=""){$this->_database=false;$this->_link=@pg_connect("$this->_string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->_link){$Wi=pg_version($this->_link);$this->server_info=$Wi["server"];pg_set_client_encoding($this->_link,"UTF8");}return(bool)$this->_link;}function
quote($P){return"'".pg_escape_string($this->_link,$P)."'";}function
value($X,$o){return($o["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
quoteBinary($P){return"'".pg_escape_bytea($this->_link,$P)."'";}function
select_db($j){global$b;if($j==$b->database())return$this->_database;$I=@pg_connect("$this->_string dbname='".addcslashes($j,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($I)$this->_link=$I;return$I;}function
close(){$this->_link=@pg_connect("$this->_string dbname='postgres'");}function
query($G,$Bi=false){$H=@pg_query($this->_link,$G);$this->error="";if(!$H){$this->error=pg_last_error($this->_link);$I=false;}elseif(!pg_num_fields($H)){$this->affected_rows=pg_affected_rows($H);$I=true;}else$I=new
Min_Result($H);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
pg_fetch_result($H->_result,0,$o);}function
warnings(){return
h(pg_last_notice($this->_link));}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=pg_num_rows($H);}function
fetch_assoc(){return
pg_fetch_assoc($this->_result);}function
fetch_row(){return
pg_fetch_row($this->_result);}function
fetch_field(){$e=$this->_offset++;$I=new
stdClass;if(function_exists('pg_field_table'))$I->orgtable=pg_field_table($this->_result,$e);$I->name=pg_field_name($this->_result,$e);$I->orgname=$I->name;$I->type=pg_field_type($this->_result,$e);$I->charsetnr=($I->type=="bytea"?63:0);return$I;}function
__destruct(){pg_free_result($this->_result);}}}elseif(extension_loaded("pdo_pgsql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_PgSQL",$timeout;function
connect($M,$V,$F){global$b;$l=$b->database();$this->dsn("pgsql:host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' client_encoding=utf8 dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",$V,$F);return
true;}function
select_db($j){global$b;return($b->database()==$j);}function
quoteBinary($Xg){return
q($Xg);}function
query($G,$Bi=false){$I=parent::query($G,$Bi);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$I;}function
warnings(){return'';}function
close(){}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$K,$kg){global$g;foreach($K
as$N){$Ii=array();$Z=array();foreach($N
as$z=>$X){$Ii[]="$z = $X";if(isset($kg[idf_unescape($z)]))$Z[]="$z = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Ii)." WHERE ".implode(" AND ",$Z))&&$g->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
slowQuery($G,$ei){$this->_conn->query("SET statement_timeout = ".(1000*$ei));$this->_conn->timeout=1000*$ei;return$G;}function
convertSearch($v,$X,$o){return(preg_match('~char|text'.(!preg_match('~LIKE~',$X["op"])?'|date|time(stamp)?|boolean|uuid|'.number_type():'').'~',$o["type"])?$v:"CAST($v AS text)");}function
quoteBinary($Xg){return$this->_conn->quoteBinary($Xg);}function
warnings(){return$this->_conn->warnings();}function
tableHelp($D){$we=array("information_schema"=>"infoschema","pg_catalog"=>"catalog",);$A=$we[$_GET["ns"]];if($A)return"$A-".str_replace("_","-",$D).".html";}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b,$U,$Gh;$g=new
Min_DB;$Kb=$b->credentials();if($g->connect($Kb[0],$Kb[1],$Kb[2])){if(min_version(9,0,$g)){$g->query("SET application_name = 'Adminer'");if(min_version(9.2,0,$g)){$Gh['Strings'][]="json";$U["json"]=4294967295;if(min_version(9.4,0,$g)){$Gh['Strings'][]="jsonb";$U["jsonb"]=4294967295;}}}return$g;}return$g->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");}function
limit($G,$Z,$_,$hf=0,$hh=" "){return" $G$Z".($_!==null?$hh."LIMIT $_".($hf?" OFFSET $hf":""):"");}function
limit1($Q,$G,$Z,$hh="\n"){return(preg_match('~^INTO~',$G)?limit($G,$Z,1,0,$hh):" $G".(is_view(table_status1($Q))?$Z:" WHERE ctid = (SELECT ctid FROM ".table($Q).$Z.$hh."LIMIT 1)"));}function
db_collation($l,$lb){global$g;return$g->result("SELECT datcollate FROM pg_database WHERE datname = ".q($l));}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT user");}function
tables_list(){$G="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support('materializedview'))$G.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$G.="
ORDER BY 1";return
get_key_vals($G);}function
count_tables($k){return
array();}function
table_status($D=""){$I=array();foreach(get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", ".(min_version(12)?"''":"CASE WHEN c.relhasoids THEN 'oid' ELSE '' END")." AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
".($D!=""?"AND relname = ".q($D):"ORDER BY relname"))as$J)$I[$J["Name"]]=$J;return($D!=""?$I[$D]:$I);}function
is_view($R){return
in_array($R["Engine"],array("view","materialized view"));}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Ba=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment".(min_version(10)?", a.attidentity":"")."
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($Q)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$J){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$J["full_type"],$C);list(,$T,$te,$J["length"],$wa,$Ea)=$C;$J["length"].=$Ea;$bb=$T.$wa;if(isset($Ba[$bb])){$J["type"]=$Ba[$bb];$J["full_type"]=$J["type"].$te.$Ea;}else{$J["type"]=$T;$J["full_type"]=$J["type"].$te.$wa.$Ea;}if(in_array($J['attidentity'],array('a','d')))$J['default']='GENERATED '.($J['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$J["null"]=!$J["attnotnull"];$J["auto_increment"]=$J['attidentity']||preg_match('~^nextval\(~i',$J["default"]);$J["privileges"]=array("insert"=>1,"select"=>1,"update"=>1);if(preg_match('~(.+)::[^,)]+(.*)~',$J["default"],$C))$J["default"]=($C[1]=="NULL"?null:idf_unescape($C[1]).$C[2]);$I[$J["field"]]=$J;}return$I;}function
indexes($Q,$h=null){global$g;if(!is_object($h))$h=$g;$I=array();$Ph=$h->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($Q));$f=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Ph AND attnum > 0",$h);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Ph AND ci.oid = i.indexrelid",$h)as$J){$Hg=$J["relname"];$I[$Hg]["type"]=($J["indispartial"]?"INDEX":($J["indisprimary"]?"PRIMARY":($J["indisunique"]?"UNIQUE":"INDEX")));$I[$Hg]["columns"]=array();foreach(explode(" ",$J["indkey"])as$Pd)$I[$Hg]["columns"][]=$f[$Pd];$I[$Hg]["descs"]=array();foreach(explode(" ",$J["indoption"])as$Qd)$I[$Hg]["descs"][]=($Qd&1?'1':null);$I[$Hg]["lengths"]=array();}return$I;}function
foreign_keys($Q){global$pf;$I=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($Q)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$J){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$J['definition'],$C)){$J['source']=array_map('idf_unescape',array_map('trim',explode(',',$C[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$C[2],$Be)){$J['ns']=idf_unescape($Be[2]);$J['table']=idf_unescape($Be[4]);}$J['target']=array_map('idf_unescape',array_map('trim',explode(',',$C[3])));$J['on_delete']=(preg_match("~ON DELETE ($pf)~",$C[4],$Be)?$Be[1]:'NO ACTION');$J['on_update']=(preg_match("~ON UPDATE ($pf)~",$C[4],$Be)?$Be[1]:'NO ACTION');$I[$J['conname']]=$J;}}return$I;}function
constraints($Q){global$pf;$I=array();foreach(get_rows("SELECT conname, consrc
FROM pg_catalog.pg_constraint
INNER JOIN pg_catalog.pg_namespace ON pg_constraint.connamespace = pg_namespace.oid
INNER JOIN pg_catalog.pg_class ON pg_constraint.conrelid = pg_class.oid AND pg_constraint.connamespace = pg_class.relnamespace
WHERE pg_constraint.contype = 'c'
AND conrelid != 0 -- handle only CONSTRAINTs here, not TYPES
AND nspname = current_schema()
AND relname = ".q($Q)."
ORDER BY connamespace, conname")as$J)$I[$J['conname']]=$J['consrc'];return$I;}function
view($D){global$g;return
array("select"=>trim($g->result("SELECT pg_get_viewdef(".$g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($D)).")")));}function
collations(){return
array();}function
information_schema($l){return($l=="information_schema");}function
error(){global$g;$I=h($g->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$I,$C))$I=$C[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($C[3]).'})(.*)~','\1<b>\2</b>',$C[2]).$C[4];return
nl_br($I);}function
create_database($l,$d){return
queries("CREATE DATABASE ".idf_escape($l).($d?" ENCODING ".idf_escape($d):""));}function
drop_databases($k){global$g;$g->close();return
apply_queries("DROP DATABASE",$k,'idf_escape');}function
rename_database($D,$d){return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($D));}function
auto_increment(){return"";}function
alter_table($Q,$D,$p,$fd,$rb,$yc,$d,$Ka,$Tf){$c=array();$vg=array();if($Q!=""&&$Q!=$D)$vg[]="ALTER TABLE ".table($Q)." RENAME TO ".table($D);foreach($p
as$o){$e=idf_escape($o[0]);$X=$o[1];if(!$X)$c[]="DROP $e";else{$Si=$X[5];unset($X[5]);if($o[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$c[]=($Q!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$c[]=($Q!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($e!=$X[0])$vg[]="ALTER TABLE ".table($D)." RENAME $e TO $X[0]";$c[]="ALTER $e TYPE$X[1]";if(!$X[6]){$c[]="ALTER $e ".($X[3]?"SET$X[3]":"DROP DEFAULT");$c[]="ALTER $e ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}}if($o[0]!=""||$Si!="")$vg[]="COMMENT ON COLUMN ".table($D).".$X[0] IS ".($Si!=""?substr($Si,9):"''");}}$c=array_merge($c,$fd);if($Q=="")array_unshift($vg,"CREATE TABLE ".table($D)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($vg,"ALTER TABLE ".table($Q)."\n".implode(",\n",$c));if($Q!=""||$rb!="")$vg[]="COMMENT ON TABLE ".table($D)." IS ".q($rb);if($Ka!=""){}foreach($vg
as$G){if(!queries($G))return
false;}return
true;}function
alter_indexes($Q,$c){$i=array();$jc=array();$vg=array();foreach($c
as$X){if($X[0]!="INDEX")$i[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$jc[]=idf_escape($X[1]);else$vg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($i)array_unshift($vg,"ALTER TABLE ".table($Q).implode(",",$i));if($jc)array_unshift($vg,"DROP INDEX ".implode(", ",$jc));foreach($vg
as$G){if(!queries($G))return
false;}return
true;}function
truncate_tables($S){return
queries("TRUNCATE ".implode(", ",array_map('table',$S)));return
true;}function
drop_views($Yi){return
drop_tables($Yi);}function
drop_tables($S){foreach($S
as$Q){$O=table_status($Q);if(!queries("DROP ".strtoupper($O["Engine"])." ".table($Q)))return
false;}return
true;}function
move_tables($S,$Yi,$Wh){foreach(array_merge($S,$Yi)as$Q){$O=table_status($Q);if(!queries("ALTER ".strtoupper($O["Engine"])." ".table($Q)." SET SCHEMA ".idf_escape($Wh)))return
false;}return
true;}function
trigger($D,$Q){if($D=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$f=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q)." AND trigger_name = ".q($D);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$J)$f[]=$J["event_object_column"];$I=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers '."$Z ORDER BY event_manipulation DESC")as$J){if($f&&$J["Event"]=="UPDATE")$J["Event"].=" OF";$J["Of"]=implode(", ",$f);if($I)$J["Event"].=" OR $I[Event]";$I=$J;}return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q))as$J){$wi=trigger($J["trigger_name"],$Q);$I[$wi["Trigger"]]=array($wi["Timing"],$wi["Event"]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE","INSERT OR UPDATE","INSERT OR UPDATE OF","DELETE OR INSERT","DELETE OR UPDATE","DELETE OR UPDATE OF","DELETE OR INSERT OR UPDATE","DELETE OR INSERT OR UPDATE OF"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($D,$T){$K=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($D));$I=$K[0];$I["returns"]=array("type"=>$I["type_udt_name"]);$I["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($D).'
ORDER BY ordinal_position');return$I;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($D,$J){$I=array();foreach($J["fields"]as$o)$I[]=$o["type"];return
idf_escape($D)."(".implode(", ",$I).")";}function
last_id(){return
0;}function
explain($g,$G){return$g->query("EXPLAIN $G");}function
found_rows($R,$Z){global$g;if(preg_match("~ rows=([0-9]+)~",$g->result("EXPLAIN SELECT * FROM ".idf_escape($R["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Gg))return$Gg[1];return
false;}function
types(){return
get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){global$g;return$g->result("SELECT current_schema()");}function
set_schema($Zg,$h=null){global$g,$U,$Gh;if(!$h)$h=$g;$I=$h->query("SET search_path TO ".idf_escape($Zg));foreach(types()as$T){if(!isset($U[$T])){$U[$T]=0;$Gh['User types'][]=$T;}}return$I;}function
foreign_keys_sql($Q){$I="";$O=table_status($Q);$cd=foreign_keys($Q);ksort($cd);foreach($cd
as$bd=>$ad)$I.="ALTER TABLE ONLY ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." ADD CONSTRAINT ".idf_escape($bd)." $ad[definition] ".($ad['deferrable']?'DEFERRABLE':'NOT DEFERRABLE').";\n";return($I?"$I\n":$I);}function
create_sql($Q,$Ka,$Hh){global$g;$I='';$Pg=array();$jh=array();$O=table_status($Q);if(is_view($O)){$Xi=view($Q);return
rtrim("CREATE VIEW ".idf_escape($Q)." AS $Xi[select]",";");}$p=fields($Q);$x=indexes($Q);ksort($x);$Ab=constraints($Q);if(!$O||empty($p))return
false;$I="CREATE TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." (\n    ";foreach($p
as$Vc=>$o){$Qf=idf_escape($o['field']).' '.$o['full_type'].default_value($o).($o['attnotnull']?" NOT NULL":"");$Pg[]=$Qf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$o['default'],$Ce)){$ih=$Ce[1];$xh=reset(get_rows(min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q($ih):"SELECT * FROM $ih"));$jh[]=($Hh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $ih;\n":"")."CREATE SEQUENCE $ih INCREMENT $xh[increment_by] MINVALUE $xh[min_value] MAXVALUE $xh[max_value]".($Ka&&$xh['last_value']?" START $xh[last_value]":"")." CACHE $xh[cache_value];";}}if(!empty($jh))$I=implode("\n\n",$jh)."\n\n$I";foreach($x
as$Kd=>$w){switch($w['type']){case'UNIQUE':$Pg[]="CONSTRAINT ".idf_escape($Kd)." UNIQUE (".implode(', ',array_map('idf_escape',$w['columns'])).")";break;case'PRIMARY':$Pg[]="CONSTRAINT ".idf_escape($Kd)." PRIMARY KEY (".implode(', ',array_map('idf_escape',$w['columns'])).")";break;}}foreach($Ab
as$xb=>$zb)$Pg[]="CONSTRAINT ".idf_escape($xb)." CHECK $zb";$I.=implode(",\n    ",$Pg)."\n) WITH (oids = ".($O['Oid']?'true':'false').");";foreach($x
as$Kd=>$w){if($w['type']=='INDEX'){$f=array();foreach($w['columns']as$z=>$X)$f[]=idf_escape($X).($w['descs'][$z]?" DESC":"");$I.="\n\nCREATE INDEX ".idf_escape($Kd)." ON ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." USING btree (".implode(', ',$f).");";}}if($O['Comment'])$I.="\n\nCOMMENT ON TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." IS ".q($O['Comment']).";";foreach($p
as$Vc=>$o){if($o['comment'])$I.="\n\nCOMMENT ON COLUMN ".idf_escape($O['nspname']).".".idf_escape($O['Name']).".".idf_escape($Vc)." IS ".q($o['comment']).";";}return
rtrim($I,';');}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
trigger_sql($Q){$O=table_status($Q);$I="";foreach(triggers($Q)as$vi=>$ui){$wi=trigger($vi,$O['Name']);$I.="\nCREATE TRIGGER ".idf_escape($wi['Trigger'])." $wi[Timing] $wi[Event] ON ".idf_escape($O["nspname"]).".".idf_escape($O['Name'])." $wi[Type] $wi[Statement];;\n";}return$I;}function
use_sql($j){return"\connect ".idf_escape($j);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
show_status(){}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Tc){return
preg_match('~^(database|table|columns|sql|indexes|descidx|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$Tc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){global$g;return$g->result("SHOW max_connections");}function
driver_config(){$U=array();$Gh=array();foreach(array('Numbers'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'Date and time'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'Strings'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'Binary'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'Network'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"txid_snapshot"=>0),'Geometry'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),)as$z=>$X){$U+=$X;$Gh[$z]=array_keys($X);}return
array('possible_drivers'=>array("PgSQL","PDO_PgSQL"),'jush'=>"pgsql",'types'=>$U,'structured_types'=>$Gh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL"),'functions'=>array("char_length","lower","round","to_hex","to_timestamp","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",)),);}}$ic["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){define("DRIVER","oracle");if(extension_loaded("oci8")){class
Min_DB{var$extension="oci8",$_link,$_result,$server_info,$affected_rows,$errno,$error;var$_current_db;function
_error($Ac,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($M,$V,$F){$this->_link=@oci_new_connect($V,$F,$M,"AL32UTF8");if($this->_link){$this->server_info=oci_server_version($this->_link);return
true;}$n=oci_error();$this->error=$n["message"];return
false;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){$this->_current_db=$j;return
true;}function
query($G,$Bi=false){$H=oci_parse($this->_link,$G);$this->error="";if(!$H){$n=oci_error($this->_link);$this->errno=$n["code"];$this->error=$n["message"];return
false;}set_error_handler(array($this,'_error'));$I=@oci_execute($H);restore_error_handler();if($I){if(oci_num_fields($H))return
new
Min_Result($H);$this->affected_rows=oci_num_rows($H);oci_free_statement($H);}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=1){$H=$this->query($G);if(!is_object($H)||!oci_fetch($H->_result))return
false;return
oci_result($H->_result,$o);}}class
Min_Result{var$_result,$_offset=1,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$z=>$X){if(is_a($X,'OCI-Lob'))$J[$z]=$X->load();}return$J;}function
fetch_assoc(){return$this->_convert(oci_fetch_assoc($this->_result));}function
fetch_row(){return$this->_convert(oci_fetch_row($this->_result));}function
fetch_field(){$e=$this->_offset++;$I=new
stdClass;$I->name=oci_field_name($this->_result,$e);$I->orgname=$I->name;$I->type=oci_field_type($this->_result,$e);$I->charsetnr=(preg_match("~raw|blob|bfile~",$I->type)?63:0);return$I;}function
__destruct(){oci_free_statement($this->_result);}}}elseif(extension_loaded("pdo_oci")){class
Min_DB
extends
Min_PDO{var$extension="PDO_OCI";var$_current_db;function
connect($M,$V,$F){$this->dsn("oci:dbname=//$M;charset=AL32UTF8",$V,$F);return
true;}function
select_db($j){$this->_current_db=$j;return
true;}}}class
Min_Driver
extends
Min_SQL{function
begin(){return
true;}function
insertUpdate($Q,$K,$kg){global$g;foreach($K
as$N){$Ii=array();$Z=array();foreach($N
as$z=>$X){$Ii[]="$z = $X";if(isset($kg[idf_unescape($z)]))$Z[]="$z = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Ii)." WHERE ".implode(" AND ",$Z))&&$g->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b;$g=new
Min_DB;$Kb=$b->credentials();if($g->connect($Kb[0],$Kb[1],$Kb[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT tablespace_name FROM user_tablespaces ORDER BY 1");}function
limit($G,$Z,$_,$hf=0,$hh=" "){return($hf?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= ".($_+$hf).") WHERE rnum > $hf":($_!==null?" * FROM (SELECT $G$Z) WHERE rownum <= ".($_+$hf):" $G$Z"));}function
limit1($Q,$G,$Z,$hh="\n"){return" $G$Z";}function
db_collation($l,$lb){global$g;return$g->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT USER FROM DUAL");}function
get_current_db(){global$g;$l=$g->_current_db?$g->_current_db:DB;unset($g->_current_db);return$l;}function
where_owner($ig,$Kf="owner"){if(!$_GET["ns"])return'';return"$ig$Kf = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($f){$Kf=where_owner('');return"(SELECT $f FROM all_views WHERE ".($Kf?$Kf:"rownum < 0").")";}function
tables_list(){$Xi=views_table("view_name");$Kf=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$Kf
UNION SELECT view_name, 'view' FROM $Xi
ORDER BY 1");}function
count_tables($k){global$g;$I=array();foreach($k
as$l)$I[$l]=$g->result("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($l));return$I;}function
table_status($D=""){$I=array();$bh=q($D);$l=get_current_db();$Xi=views_table("view_name");$Kf=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($l).$Kf.($D!=""?" AND table_name = $bh":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $Xi".($D!=""?" WHERE view_name = $bh":"")."
ORDER BY 1")as$J){if($D!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Kf=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($Q)."$Kf ORDER BY column_id")as$J){$T=$J["DATA_TYPE"];$te="$J[DATA_PRECISION],$J[DATA_SCALE]";if($te==",")$te=$J["CHAR_COL_DECL_LENGTH"];$I[$J["COLUMN_NAME"]]=array("field"=>$J["COLUMN_NAME"],"full_type"=>$T.($te?"($te)":""),"type"=>strtolower($T),"length"=>$te,"default"=>$J["DATA_DEFAULT"],"null"=>($J["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);}return$I;}function
indexes($Q,$h=null){$I=array();$Kf=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($Q)."$Kf
ORDER BY ac.constraint_type, aic.column_position",$h)as$J){$Kd=$J["INDEX_NAME"];$ob=$J["DATA_DEFAULT"];$ob=($ob?trim($ob,'"'):$J["COLUMN_NAME"]);$I[$Kd]["type"]=($J["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($J["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$I[$Kd]["columns"][]=$ob;$I[$Kd]["lengths"][]=($J["CHAR_LENGTH"]&&$J["CHAR_LENGTH"]!=$J["COLUMN_LENGTH"]?$J["CHAR_LENGTH"]:null);$I[$Kd]["descs"][]=($J["DESCEND"]&&$J["DESCEND"]=="DESC"?'1':null);}return$I;}function
view($D){$Xi=views_table("view_name, text");$K=get_rows('SELECT text "select" FROM '.$Xi.' WHERE view_name = '.q($D));return
reset($K);}function
collations(){return
array();}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
explain($g,$G){$g->query("EXPLAIN PLAN FOR $G");return$g->query("SELECT * FROM plan_table");}function
found_rows($R,$Z){}function
auto_increment(){return"";}function
alter_table($Q,$D,$p,$fd,$rb,$yc,$d,$Ka,$Tf){$c=$jc=array();$Ef=($Q?fields($Q):array());foreach($p
as$o){$X=$o[1];if($X&&$o[0]!=""&&idf_escape($o[0])!=$X[0])queries("ALTER TABLE ".table($Q)." RENAME COLUMN ".idf_escape($o[0])." TO $X[0]");$Df=$Ef[$o[0]];if($X&&$Df){$jf=process_field($Df,$Df);if($X[2]==$jf[2])$X[2]="";}if($X)$c[]=($Q!=""?($o[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($Q!=""?")":"");else$jc[]=idf_escape($o[0]);}if($Q=="")return
queries("CREATE TABLE ".table($D)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($Q)."\n".implode("\n",$c)))&&(!$jc||queries("ALTER TABLE ".table($Q)." DROP (".implode(", ",$jc).")"))&&($Q==$D||queries("ALTER TABLE ".table($Q)." RENAME TO ".table($D)));}function
alter_indexes($Q,$c){$jc=array();$vg=array();foreach($c
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$i=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($vg,"ALTER TABLE ".table($Q).$i);}elseif($X[2]=="DROP")$jc[]=idf_escape($X[1]);else$vg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($jc)array_unshift($vg,"DROP INDEX ".implode(", ",$jc));foreach($vg
as$G){if(!queries($G))return
false;}return
true;}function
foreign_keys($Q){$I=array();$G="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($Q);foreach(get_rows($G)as$J)$I[$J['NAME']]=array("db"=>$J['DEST_DB'],"table"=>$J['DEST_TABLE'],"source"=>array($J['SRC_COLUMN']),"target"=>array($J['DEST_COLUMN']),"on_delete"=>$J['ON_DELETE'],"on_update"=>null,);return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($Yi){return
apply_queries("DROP VIEW",$Yi);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
last_id(){return
0;}function
schemas(){$I=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($I?$I:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){global$g;return$g->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($ah,$h=null){global$g;if(!$h)$h=$g;return$h->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($ah));}function
show_variables(){return
get_key_vals('SELECT name, display_value FROM v$parameter');}function
process_list(){return
get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
show_status(){$K=get_rows('SELECT * FROM v$instance');return
reset($K);}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Tc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$Tc);}function
driver_config(){$U=array();$Gh=array();foreach(array('Numbers'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'Date and time'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'Strings'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'Binary'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),)as$z=>$X){$U+=$X;$Gh[$z]=array_keys($X);}return
array('possible_drivers'=>array("OCI8","PDO_OCI"),'jush'=>"oracle",'types'=>$U,'structured_types'=>$Gh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL"),'functions'=>array("length","lower","round","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",)),);}}$ic["mssql"]="MS SQL (beta)";if(isset($_GET["mssql"])){define("DRIVER","mssql");if(extension_loaded("sqlsrv")){class
Min_DB{var$extension="sqlsrv",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_get_error(){$this->error="";foreach(sqlsrv_errors()as$n){$this->errno=$n["code"];$this->error.="$n[message]\n";}$this->error=rtrim($this->error);}function
connect($M,$V,$F){global$b;$l=$b->database();$yb=array("UID"=>$V,"PWD"=>$F,"CharacterSet"=>"UTF-8");if($l!="")$yb["Database"]=$l;$this->_link=@sqlsrv_connect(preg_replace('~:~',',',$M),$yb);if($this->_link){$Rd=sqlsrv_server_info($this->_link);$this->server_info=$Rd['SQLServerVersion'];}else$this->_get_error();return(bool)$this->_link;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($G,$Bi=false){$H=sqlsrv_query($this->_link,$G);$this->error="";if(!$H){$this->_get_error();return
false;}return$this->store_result($H);}function
multi_query($G){$this->_result=sqlsrv_query($this->_link,$G);$this->error="";if(!$this->_result){$this->_get_error();return
false;}return
true;}function
store_result($H=null){if(!$H)$H=$this->_result;if(!$H)return
false;if(sqlsrv_field_metadata($H))return
new
Min_Result($H);$this->affected_rows=sqlsrv_rows_affected($H);return
true;}function
next_result(){return$this->_result?sqlsrv_next_result($this->_result):null;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->fetch_row();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$z=>$X){if(is_a($X,'DateTime'))$J[$z]=$X->format("Y-m-d H:i:s");}return$J;}function
fetch_assoc(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->_fields)$this->_fields=sqlsrv_field_metadata($this->_result);$o=$this->_fields[$this->_offset++];$I=new
stdClass;$I->name=$o["Name"];$I->orgname=$o["Name"];$I->type=($o["Type"]==1?254:0);return$I;}function
seek($hf){for($t=0;$t<$hf;$t++)sqlsrv_fetch($this->_result);}function
__destruct(){sqlsrv_free_stmt($this->_result);}}}elseif(extension_loaded("mssql")){class
Min_DB{var$extension="MSSQL",$_link,$_result,$server_info,$affected_rows,$error;function
connect($M,$V,$F){$this->_link=@mssql_connect($M,$V,$F);if($this->_link){$H=$this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");if($H){$J=$H->fetch_row();$this->server_info=$this->result("sp_server_info 2",2)." [$J[0]] $J[1]";}}else$this->error=mssql_get_last_message();return(bool)$this->_link;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return
mssql_select_db($j);}function
query($G,$Bi=false){$H=@mssql_query($G,$this->_link);$this->error="";if(!$H){$this->error=mssql_get_last_message();return
false;}if($H===true){$this->affected_rows=mssql_rows_affected($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
mssql_next_result($this->_result->_result);}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;return
mssql_result($H->_result,0,$o);}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=mssql_num_rows($H);}function
fetch_assoc(){return
mssql_fetch_assoc($this->_result);}function
fetch_row(){return
mssql_fetch_row($this->_result);}function
num_rows(){return
mssql_num_rows($this->_result);}function
fetch_field(){$I=mssql_fetch_field($this->_result);$I->orgtable=$I->table;$I->orgname=$I->name;return$I;}function
seek($hf){mssql_data_seek($this->_result,$hf);}function
__destruct(){mssql_free_result($this->_result);}}}elseif(extension_loaded("pdo_dblib")){class
Min_DB
extends
Min_PDO{var$extension="PDO_DBLIB";function
connect($M,$V,$F){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$F);return
true;}function
select_db($j){return$this->query("USE ".idf_escape($j));}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$K,$kg){foreach($K
as$N){$Ii=array();$Z=array();foreach($N
as$z=>$X){$Ii[]="$z = $X";if(isset($kg[idf_unescape($z)]))$Z[]="$z = $X";}if(!queries("MERGE ".table($Q)." USING (VALUES(".implode(", ",$N).")) AS source (c".implode(", c",range(1,count($N))).") ON ".implode(" AND ",$Z)." WHEN MATCHED THEN UPDATE SET ".implode(", ",$Ii)." WHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).");"))return
false;}return
true;}function
begin(){return
queries("BEGIN TRANSACTION");}}function
idf_escape($v){return"[".str_replace("]","]]",$v)."]";}function
table($v){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($v);}function
connect(){global$b;$g=new
Min_DB;$Kb=$b->credentials();if($g->connect($Kb[0],$Kb[1],$Kb[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($G,$Z,$_,$hf=0,$hh=" "){return($_!==null?" TOP (".($_+$hf).")":"")." $G$Z";}function
limit1($Q,$G,$Z,$hh="\n"){return
limit($G,$Z,1,0,$hh);}function
db_collation($l,$lb){global$g;return$g->result("SELECT collation_name FROM sys.databases WHERE name = ".q($l));}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($k){global$g;$I=array();foreach($k
as$l){$g->select_db($l);$I[$l]=$g->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$I;}function
table_status($D=""){$I=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment FROM sys.all_objects AS ao WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($D!=""?"AND name = ".q($D):"ORDER BY name"))as$J){if($D!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="VIEW";}function
fk_support($R){return
true;}function
fields($Q){$tb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($Q).", 'column', NULL)");$I=array();foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(".q(get_schema()).") AND o.type IN ('S', 'U', 'V') AND o.name = ".q($Q))as$J){$T=$J["type"];$te=(preg_match("~char|binary~",$T)?$J["max_length"]:($T=="decimal"?"$J[precision],$J[scale]":""));$I[$J["name"]]=array("field"=>$J["name"],"full_type"=>$T.($te?"($te)":""),"type"=>$T,"length"=>$te,"default"=>$J["default"],"null"=>$J["is_nullable"],"auto_increment"=>$J["is_identity"],"collation"=>$J["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"primary"=>$J["is_identity"],"comment"=>$tb[$J["name"]],);}return$I;}function
indexes($Q,$h=null){$I=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($Q),$h)as$J){$D=$J["name"];$I[$D]["type"]=($J["is_primary_key"]?"PRIMARY":($J["is_unique"]?"UNIQUE":"INDEX"));$I[$D]["lengths"]=array();$I[$D]["columns"][$J["key_ordinal"]]=$J["column_name"];$I[$D]["descs"][$J["key_ordinal"]]=($J["is_descending_key"]?'1':null);}return$I;}function
view($D){global$g;return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',$g->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($D))));}function
collations(){$I=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$d)$I[preg_replace('~_.*~','',$d)][]=$d;return$I;}function
information_schema($l){return
false;}function
error(){global$g;return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',$g->error)));}function
create_database($l,$d){return
queries("CREATE DATABASE ".idf_escape($l).(preg_match('~^[a-z0-9_]+$~i',$d)?" COLLATE $d":""));}function
drop_databases($k){return
queries("DROP DATABASE ".implode(", ",array_map('idf_escape',$k)));}function
rename_database($D,$d){if(preg_match('~^[a-z0-9_]+$~i',$d))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $d");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($D));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($Q,$D,$p,$fd,$rb,$yc,$d,$Ka,$Tf){$c=array();$tb=array();foreach($p
as$o){$e=idf_escape($o[0]);$X=$o[1];if(!$X)$c["DROP"][]=" COLUMN $e";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$tb[$o[0]]=$X[5];unset($X[5]);if($o[0]=="")$c["ADD"][]="\n  ".implode("",$X).($Q==""?substr($fd[$X[0]],16+strlen($X[0])):"");else{unset($X[6]);if($e!=$X[0])queries("EXEC sp_rename ".q(table($Q).".$e").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";}}}if($Q=="")return
queries("CREATE TABLE ".table($D)." (".implode(",",(array)$c["ADD"])."\n)");if($Q!=$D)queries("EXEC sp_rename ".q(table($Q)).", ".q($D));if($fd)$c[""]=$fd;foreach($c
as$z=>$X){if(!queries("ALTER TABLE ".idf_escape($D)." $z".implode(",",$X)))return
false;}foreach($tb
as$z=>$X){$rb=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($D).", @level2type = N'Column', @level2name = ".q($z));queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = ".$rb.", @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($D).", @level2type = N'Column', @level2name = ".q($z));}return
true;}function
alter_indexes($Q,$c){$w=array();$jc=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$jc[]=idf_escape($X[1]);else$w[]=idf_escape($X[1])." ON ".table($Q);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q):"ALTER TABLE ".table($Q)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$w||queries("DROP INDEX ".implode(", ",$w)))&&(!$jc||queries("ALTER TABLE ".table($Q)." DROP ".implode(", ",$jc)));}function
last_id(){global$g;return$g->result("SELECT SCOPE_IDENTITY()");}function
explain($g,$G){$g->query("SET SHOWPLAN_ALL ON");$I=$g->query($G);$g->query("SET SHOWPLAN_ALL OFF");return$I;}function
found_rows($R,$Z){}function
foreign_keys($Q){$I=array();foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($Q))as$J){$r=&$I[$J["FK_NAME"]];$r["db"]=$J["PKTABLE_QUALIFIER"];$r["table"]=$J["PKTABLE_NAME"];$r["source"][]=$J["FKCOLUMN_NAME"];$r["target"][]=$J["PKCOLUMN_NAME"];}return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($Yi){return
queries("DROP VIEW ".implode(", ",array_map('table',$Yi)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('table',$S)));}function
move_tables($S,$Yi,$Wh){return
apply_queries("ALTER SCHEMA ".idf_escape($Wh)." TRANSFER",array_merge($S,$Yi));}function
trigger($D){if($D=="")return
array();$K=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($D));$I=reset($K);if($I)$I["Statement"]=preg_replace('~^.+\s+AS\s+~isU','',$I["text"]);return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($Q))as$J)$I[$J["name"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){global$g;if($_GET["ns"]!="")return$_GET["ns"];return$g->result("SELECT SCHEMA_NAME()");}function
set_schema($Zg){return
true;}function
use_sql($j){return"USE ".idf_escape($j);}function
show_variables(){return
array();}function
show_status(){return
array();}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Tc){return
preg_match('~^(comment|columns|database|drop_col|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$Tc);}function
driver_config(){$U=array();$Gh=array();foreach(array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'Date and time'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'Strings'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'Binary'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),)as$z=>$X){$U+=$X;$Gh[$z]=array_keys($X);}return
array('possible_drivers'=>array("SQLSRV","MSSQL","PDO_DBLIB"),'jush'=>"mssql",'types'=>$U,'structured_types'=>$Gh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL"),'functions'=>array("len","lower","round","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",)),);}}$ic["mongo"]="MongoDB (alpha)";if(isset($_GET["mongo"])){define("DRIVER","mongo");if(class_exists('MongoDB')){class
Min_DB{var$extension="Mongo",$server_info=MongoClient::VERSION,$error,$last_id,$_link,$_db;function
connect($Ji,$xf){try{$this->_link=new
MongoClient($Ji,$xf);if($xf["password"]!=""){$xf["password"]="";try{new
MongoClient($Ji,$xf);$this->error='Database does not support password.';}catch(Exception$pc){}}}catch(Exception$pc){$this->error=$pc->getMessage();}}function
query($G){return
false;}function
select_db($j){try{$this->_db=$this->_link->selectDB($j);return
true;}catch(Exception$Fc){$this->error=$Fc->getMessage();return
false;}}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$de){$J=array();foreach($de
as$z=>$X){if(is_a($X,'MongoBinData'))$this->_charset[$z]=63;$J[$z]=(is_a($X,'MongoId')?"ObjectId(\"$X\")":(is_a($X,'MongoDate')?gmdate("Y-m-d H:i:s",$X->sec)." GMT":(is_a($X,'MongoBinData')?$X->bin:(is_a($X,'MongoRegex')?"$X":(is_object($X)?get_class($X):$X)))));}$this->_rows[]=$J;foreach($J
as$z=>$X){if(!isset($this->_rows[0][$z]))$this->_rows[0][$z]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$z=>$X)$I[$z]=$J[$z];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$he=array_keys($this->_rows[0]);$D=$he[$this->_offset++];return(object)array('name'=>$D,'charsetnr'=>$this->_charset[$D],);}}class
Min_Driver
extends
Min_SQL{public$kg="_id";function
select($Q,$L,$Z,$qd,$zf=array(),$_=1,$E=0,$mg=false){$L=($L==array("*")?array():array_fill_keys($L,true));$uh=array();foreach($zf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Gb);$uh[$X]=($Gb?-1:1);}return
new
Min_Result($this->_conn->_db->selectCollection($Q)->find(array(),$L)->sort($uh)->limit($_!=""?+$_:0)->skip($E*$_));}function
insert($Q,$N){try{$I=$this->_conn->_db->selectCollection($Q)->insert($N);$this->_conn->errno=$I['code'];$this->_conn->error=$I['err'];$this->_conn->last_id=$N['_id'];return!$I['err'];}catch(Exception$Fc){$this->_conn->error=$Fc->getMessage();return
false;}}}function
get_databases($dd){global$g;$I=array();$Ub=$g->_link->listDBs();foreach($Ub['databases']as$l)$I[]=$l['name'];return$I;}function
count_tables($k){global$g;$I=array();foreach($k
as$l)$I[$l]=count($g->_link->selectDB($l)->getCollectionNames(true));return$I;}function
tables_list(){global$g;return
array_fill_keys($g->_db->getCollectionNames(true),'table');}function
drop_databases($k){global$g;foreach($k
as$l){$Lg=$g->_link->selectDB($l)->drop();if(!$Lg['ok'])return
false;}return
true;}function
indexes($Q,$h=null){global$g;$I=array();foreach($g->_db->selectCollection($Q)->getIndexInfo()as$w){$cc=array();foreach($w["key"]as$e=>$T)$cc[]=($T==-1?'1':null);$I[$w["name"]]=array("type"=>($w["name"]=="_id_"?"PRIMARY":($w["unique"]?"UNIQUE":"INDEX")),"columns"=>array_keys($w["key"]),"lengths"=>array(),"descs"=>$cc,);}return$I;}function
fields($Q){return
fields_from_edit();}function
found_rows($R,$Z){global$g;return$g->_db->selectCollection($_GET["select"])->count($Z);}$uf=array("=");}elseif(class_exists('MongoDB\Driver\Manager')){class
Min_DB{var$extension="MongoDB",$server_info=MONGODB_VERSION,$affected_rows,$error,$last_id;var$_link;var$_db,$_db_name;function
connect($Ji,$xf){$gb='MongoDB\Driver\Manager';$this->_link=new$gb($Ji,$xf);$this->executeCommand('admin',array('ping'=>1));}function
executeCommand($l,$pb){$gb='MongoDB\Driver\Command';try{return$this->_link->executeCommand($l,new$gb($pb));}catch(Exception$pc){$this->error=$pc->getMessage();return
array();}}function
executeBulkWrite($We,$Wa,$Hb){try{$Og=$this->_link->executeBulkWrite($We,$Wa);$this->affected_rows=$Og->$Hb();return
true;}catch(Exception$pc){$this->error=$pc->getMessage();return
false;}}function
query($G){return
false;}function
select_db($j){$this->_db_name=$j;return
true;}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$de){$J=array();foreach($de
as$z=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->_charset[$z]=63;$J[$z]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'."$X\")":(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->getData():(is_a($X,'MongoDB\BSON\Regex')?"$X":(is_object($X)||is_array($X)?json_encode($X,256):$X)))));}$this->_rows[]=$J;foreach($J
as$z=>$X){if(!isset($this->_rows[0][$z]))$this->_rows[0][$z]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$z=>$X)$I[$z]=$J[$z];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$he=array_keys($this->_rows[0]);$D=$he[$this->_offset++];return(object)array('name'=>$D,'charsetnr'=>$this->_charset[$D],);}}class
Min_Driver
extends
Min_SQL{public$kg="_id";function
select($Q,$L,$Z,$qd,$zf=array(),$_=1,$E=0,$mg=false){global$g;$L=($L==array("*")?array():array_fill_keys($L,1));if(count($L)&&!isset($L['_id']))$L['_id']=0;$Z=where_to_query($Z);$uh=array();foreach($zf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Gb);$uh[$X]=($Gb?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$_=$_GET['limit'];$_=min(200,max(1,(int)$_));$rh=$E*$_;$gb='MongoDB\Driver\Query';try{return
new
Min_Result($g->_link->executeQuery("$g->_db_name.$Q",new$gb($Z,array('projection'=>$L,'limit'=>$_,'skip'=>$rh,'sort'=>$uh))));}catch(Exception$pc){$g->error=$pc->getMessage();return
false;}}function
update($Q,$N,$wg,$_=0,$hh="\n"){global$g;$l=$g->_db_name;$Z=sql_query_where_parser($wg);$gb='MongoDB\Driver\BulkWrite';$Wa=new$gb(array());if(isset($N['_id']))unset($N['_id']);$Ig=array();foreach($N
as$z=>$Y){if($Y=='NULL'){$Ig[$z]=1;unset($N[$z]);}}$Ii=array('$set'=>$N);if(count($Ig))$Ii['$unset']=$Ig;$Wa->update($Z,$Ii,array('upsert'=>false));return$g->executeBulkWrite("$l.$Q",$Wa,'getModifiedCount');}function
delete($Q,$wg,$_=0){global$g;$l=$g->_db_name;$Z=sql_query_where_parser($wg);$gb='MongoDB\Driver\BulkWrite';$Wa=new$gb(array());$Wa->delete($Z,array('limit'=>$_));return$g->executeBulkWrite("$l.$Q",$Wa,'getDeletedCount');}function
insert($Q,$N){global$g;$l=$g->_db_name;$gb='MongoDB\Driver\BulkWrite';$Wa=new$gb(array());if($N['_id']=='')unset($N['_id']);$Wa->insert($N);return$g->executeBulkWrite("$l.$Q",$Wa,'getInsertedCount');}}function
get_databases($dd){global$g;$I=array();foreach($g->executeCommand('admin',array('listDatabases'=>1))as$Ub){foreach($Ub->databases
as$l)$I[]=$l->name;}return$I;}function
count_tables($k){$I=array();return$I;}function
tables_list(){global$g;$mb=array();foreach($g->executeCommand($g->_db_name,array('listCollections'=>1))as$H)$mb[$H->name]='table';return$mb;}function
drop_databases($k){return
false;}function
indexes($Q,$h=null){global$g;$I=array();foreach($g->executeCommand($g->_db_name,array('listIndexes'=>$Q))as$w){$cc=array();$f=array();foreach(get_object_vars($w->key)as$e=>$T){$cc[]=($T==-1?'1':null);$f[]=$e;}$I[$w->name]=array("type"=>($w->name=="_id_"?"PRIMARY":(isset($w->unique)?"UNIQUE":"INDEX")),"columns"=>$f,"lengths"=>array(),"descs"=>$cc,);}return$I;}function
fields($Q){global$m;$p=fields_from_edit();if(!$p){$H=$m->select($Q,array("*"),null,null,array(),10);if($H){while($J=$H->fetch_assoc()){foreach($J
as$z=>$X){$J[$z]=null;$p[$z]=array("field"=>$z,"type"=>"string","null"=>($z!=$m->primary),"auto_increment"=>($z==$m->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,),);}}}}return$p;}function
found_rows($R,$Z){global$g;$Z=where_to_query($Z);$mi=$g->executeCommand($g->_db_name,array('count'=>$R['Name'],'query'=>$Z))->toArray();return$mi[0]->n;}function
sql_query_where_parser($wg){$wg=preg_replace('~^\sWHERE \(?\(?(.+?)\)?\)?$~','\1',$wg);$ij=explode(' AND ',$wg);$jj=explode(') OR (',$wg);$Z=array();foreach($ij
as$gj)$Z[]=trim($gj);if(count($jj)==1)$jj=array();elseif(count($jj)>1)$Z=array();return
where_to_query($Z,$jj);}function
where_to_query($ej=array(),$fj=array()){global$b;$Pb=array();foreach(array('and'=>$ej,'or'=>$fj)as$T=>$Z){if(is_array($Z)){foreach($Z
as$Lc){list($jb,$sf,$X)=explode(" ",$Lc,3);if($jb=="_id"&&preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~',$X,$C)){list(,$gb,$X)=$C;$X=new$gb($X);}if(!in_array($sf,$b->operators))continue;if(preg_match('~^\(f\)(.+)~',$sf,$C)){$X=(float)$X;$sf=$C[1];}elseif(preg_match('~^\(date\)(.+)~',$sf,$C)){$Rb=new
DateTime($X);$gb='MongoDB\BSON\UTCDatetime';$X=new$gb($Rb->getTimestamp()*1000);$sf=$C[1];}switch($sf){case'=':$sf='$eq';break;case'!=':$sf='$ne';break;case'>':$sf='$gt';break;case'<':$sf='$lt';break;case'>=':$sf='$gte';break;case'<=':$sf='$lte';break;case'regex':$sf='$regex';break;default:continue
2;}if($T=='and')$Pb['$and'][]=array($jb=>array($sf=>$X));elseif($T=='or')$Pb['$or'][]=array($jb=>array($sf=>$X));}}}return$Pb;}$uf=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);}function
table($v){return$v;}function
idf_escape($v){return$v;}function
table_status($D="",$Sc=false){$I=array();foreach(tables_list()as$Q=>$T){$I[$Q]=array("Name"=>$Q);if($D==$Q)return$I[$Q];}return$I;}function
create_database($l,$d){return
true;}function
last_id(){global$g;return$g->last_id;}function
error(){global$g;return
h($g->error);}function
collations(){return
array();}function
logged_user(){global$b;$Kb=$b->credentials();return$Kb[1];}function
connect(){global$b;$g=new
Min_DB;list($M,$V,$F)=$b->credentials();$xf=array();if($V.$F!=""){$xf["username"]=$V;$xf["password"]=$F;}$l=$b->database();if($l!="")$xf["db"]=$l;if(($Ja=getenv("MONGO_AUTH_SOURCE")))$xf["authSource"]=$Ja;$g->connect("mongodb://$M",$xf);if($g->error)return$g->error;return$g;}function
alter_indexes($Q,$c){global$g;foreach($c
as$X){list($T,$D,$N)=$X;if($N=="DROP")$I=$g->_db->command(array("deleteIndexes"=>$Q,"index"=>$D));else{$f=array();foreach($N
as$e){$e=preg_replace('~ DESC$~','',$e,1,$Gb);$f[$e]=($Gb?-1:1);}$I=$g->_db->selectCollection($Q)->ensureIndex($f,array("unique"=>($T=="UNIQUE"),"name"=>$D,));}if($I['errmsg']){$g->error=$I['errmsg'];return
false;}}return
true;}function
support($Tc){return
preg_match("~database|indexes|descidx~",$Tc);}function
db_collation($l,$lb){}function
information_schema(){}function
is_view($R){}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
foreign_keys($Q){return
array();}function
fk_support($R){}function
engines(){return
array();}function
alter_table($Q,$D,$p,$fd,$rb,$yc,$d,$Ka,$Tf){global$g;if($Q==""){$g->_db->createCollection($D);return
true;}}function
drop_tables($S){global$g;foreach($S
as$Q){$Lg=$g->_db->selectCollection($Q)->drop();if(!$Lg['ok'])return
false;}return
true;}function
truncate_tables($S){global$g;foreach($S
as$Q){$Lg=$g->_db->selectCollection($Q)->remove();if(!$Lg['ok'])return
false;}return
true;}function
driver_config(){global$uf;return
array('possible_drivers'=>array("mongo","mongodb"),'jush'=>"mongo",'operators'=>$uf,'functions'=>array(),'grouping'=>array(),'edit_functions'=>array(array("json")),);}}$ic["elastic"]="Elasticsearch (beta)";if(isset($_GET["elastic"])){define("DRIVER","elastic");if(function_exists('json_decode')&&ini_bool('allow_url_fopen')){class
Min_DB{var$extension="JSON",$server_info,$errno,$error,$_url,$_db;function
rootQuery($Xf,$Bb=array(),$Pe='GET'){@ini_set('track_errors',1);$Xc=@file_get_contents("$this->_url/".ltrim($Xf,'/'),false,stream_context_create(array('http'=>array('method'=>$Pe,'content'=>$Bb===null?$Bb:json_encode($Bb),'header'=>'Content-Type: application/json','ignore_errors'=>1,))));if(!$Xc){$this->error=$php_errormsg;return$Xc;}if(!preg_match('~^HTTP/[0-9.]+ 2~i',$http_response_header[0])){$this->error='Invalid credentials.'." $http_response_header[0]";return
false;}$I=json_decode($Xc,true);if($I===null){$this->errno=json_last_error();if(function_exists('json_last_error_msg'))$this->error=json_last_error_msg();else{$_b=get_defined_constants(true);foreach($_b['json']as$D=>$Y){if($Y==$this->errno&&preg_match('~^JSON_ERROR_~',$D)){$this->error=$D;break;}}}}return$I;}function
query($Xf,$Bb=array(),$Pe='GET'){return$this->rootQuery(($this->_db!=""?"$this->_db/":"/").ltrim($Xf,'/'),$Bb,$Pe);}function
connect($M,$V,$F){preg_match('~^(https?://)?(.*)~',$M,$C);$this->_url=($C[1]?$C[1]:"http://")."$V:$F@$C[2]";$I=$this->query('');if($I)$this->server_info=$I['version']['number'];return(bool)$I;}function
select_db($j){$this->_db=$j;return
true;}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows;function
__construct($K){$this->num_rows=count($K);$this->_rows=$K;reset($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);next($this->_rows);return$I;}function
fetch_row(){return
array_values($this->fetch_assoc());}}}class
Min_Driver
extends
Min_SQL{function
select($Q,$L,$Z,$qd,$zf=array(),$_=1,$E=0,$mg=false){global$b;$Pb=array();$G="$Q/_search";if($L!=array("*"))$Pb["fields"]=$L;if($zf){$uh=array();foreach($zf
as$jb){$jb=preg_replace('~ DESC$~','',$jb,1,$Gb);$uh[]=($Gb?array($jb=>"desc"):$jb);}$Pb["sort"]=$uh;}if($_){$Pb["size"]=+$_;if($E)$Pb["from"]=($E*$_);}foreach($Z
as$X){list($jb,$sf,$X)=explode(" ",$X,3);if($jb=="_id")$Pb["query"]["ids"]["values"][]=$X;elseif($jb.$X!=""){$Zh=array("term"=>array(($jb!=""?$jb:"_all")=>$X));if($sf=="=")$Pb["query"]["filtered"]["filter"]["and"][]=$Zh;else$Pb["query"]["filtered"]["query"]["bool"]["must"][]=$Zh;}}if($Pb["query"]&&!$Pb["query"]["filtered"]["query"]&&!$Pb["query"]["ids"])$Pb["query"]["filtered"]["query"]=array("match_all"=>array());$Ch=microtime(true);$bh=$this->_conn->query($G,$Pb);if($mg)echo$b->selectQuery("$G: ".json_encode($Pb),$Ch,!$bh);if(!$bh)return
false;$I=array();foreach($bh['hits']['hits']as$Cd){$J=array();if($L==array("*"))$J["_id"]=$Cd["_id"];$p=$Cd['_source'];if($L!=array("*")){$p=array();foreach($L
as$z)$p[$z]=$Cd['fields'][$z];}foreach($p
as$z=>$X){if($Pb["fields"])$X=$X[0];$J[$z]=(is_array($X)?json_encode($X):$X);}$I[]=$J;}return
new
Min_Result($I);}function
update($T,$_g,$wg,$_=0,$hh="\n"){$Vf=preg_split('~ *= *~',$wg);if(count($Vf)==2){$u=trim($Vf[1]);$G="$T/$u";return$this->_conn->query($G,$_g,'POST');}return
false;}function
insert($T,$_g){$u="";$G="$T/$u";$Lg=$this->_conn->query($G,$_g,'POST');$this->_conn->last_id=$Lg['_id'];return$Lg['created'];}function
delete($T,$wg,$_=0){$Gd=array();if(is_array($_GET["where"])&&$_GET["where"]["_id"])$Gd[]=$_GET["where"]["_id"];if(is_array($_POST['check'])){foreach($_POST['check']as$ab){$Vf=preg_split('~ *= *~',$ab);if(count($Vf)==2)$Gd[]=trim($Vf[1]);}}$this->_conn->affected_rows=0;foreach($Gd
as$u){$G="{$T}/{$u}";$Lg=$this->_conn->query($G,'{}','DELETE');if(is_array($Lg)&&$Lg['found']==true)$this->_conn->affected_rows++;}return$this->_conn->affected_rows;}}function
connect(){global$b;$g=new
Min_DB;list($M,$V,$F)=$b->credentials();if($F!=""&&$g->connect($M,$V,""))return'Database does not support password.';if($g->connect($M,$V,$F))return$g;return$g->error;}function
support($Tc){return
preg_match("~database|table|columns~",$Tc);}function
logged_user(){global$b;$Kb=$b->credentials();return$Kb[1];}function
get_databases(){global$g;$I=$g->rootQuery('_aliases');if($I){$I=array_keys($I);sort($I,SORT_STRING);}return$I;}function
collations(){return
array();}function
db_collation($l,$lb){}function
engines(){return
array();}function
count_tables($k){global$g;$I=array();$H=$g->query('_stats');if($H&&$H['indices']){$Od=$H['indices'];foreach($Od
as$Nd=>$Dh){$Md=$Dh['total']['indexing'];$I[$Nd]=$Md['index_total'];}}return$I;}function
tables_list(){global$g;if(min_version(6))return
array('_doc'=>'table');$I=$g->query('_mapping');if($I)$I=array_fill_keys(array_keys($I[$g->_db]["mappings"]),'table');return$I;}function
table_status($D="",$Sc=false){global$g;$bh=$g->query("_search",array("size"=>0,"aggregations"=>array("count_by_type"=>array("terms"=>array("field"=>"_type")))),"POST");$I=array();if($bh){$S=$bh["aggregations"]["count_by_type"]["buckets"];foreach($S
as$Q){$I[$Q["key"]]=array("Name"=>$Q["key"],"Engine"=>"table","Rows"=>$Q["doc_count"],);if($D!=""&&$D==$Q["key"])return$I[$D];}}return$I;}function
error(){global$g;return
h($g->error);}function
information_schema(){}function
is_view($R){}function
indexes($Q,$h=null){return
array(array("type"=>"PRIMARY","columns"=>array("_id")),);}function
fields($Q){global$g;$ze=array();if(min_version(6)){$H=$g->query("_mapping");if($H)$ze=$H[$g->_db]['mappings']['properties'];}else{$H=$g->query("$Q/_mapping");if($H){$ze=$H[$Q]['properties'];if(!$ze)$ze=$H[$g->_db]['mappings'][$Q]['properties'];}}$I=array();if($ze){foreach($ze
as$D=>$o){$I[$D]=array("field"=>$D,"full_type"=>$o["type"],"type"=>$o["type"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);if($o["properties"]){unset($I[$D]["privileges"]["insert"]);unset($I[$D]["privileges"]["update"]);}}}return$I;}function
foreign_keys($Q){return
array();}function
table($v){return$v;}function
idf_escape($v){return$v;}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
fk_support($R){}function
found_rows($R,$Z){return
null;}function
create_database($l){global$g;return$g->rootQuery(urlencode($l),null,'PUT');}function
drop_databases($k){global$g;return$g->rootQuery(urlencode(implode(',',$k)),array(),'DELETE');}function
alter_table($Q,$D,$p,$fd,$rb,$yc,$d,$Ka,$Tf){global$g;$sg=array();foreach($p
as$Qc){$Vc=trim($Qc[1][0]);$Wc=trim($Qc[1][1]?$Qc[1][1]:"text");$sg[$Vc]=array('type'=>$Wc);}if(!empty($sg))$sg=array('properties'=>$sg);return$g->query("_mapping/{$D}",$sg,'PUT');}function
drop_tables($S){global$g;$I=true;foreach($S
as$Q)$I=$I&&$g->query(urlencode($Q),array(),'DELETE');return$I;}function
last_id(){global$g;return$g->last_id;}function
driver_config(){$U=array();$Gh=array();foreach(array('Numbers'=>array("long"=>3,"integer"=>5,"short"=>8,"byte"=>10,"double"=>20,"float"=>66,"half_float"=>12,"scaled_float"=>21),'Date and time'=>array("date"=>10),'Strings'=>array("string"=>65535,"text"=>65535),'Binary'=>array("binary"=>255),)as$z=>$X){$U+=$X;$Gh[$z]=array_keys($X);}return
array('possible_drivers'=>array("json + allow_url_fopen"),'jush'=>"elastic",'operators'=>array("=","query"),'functions'=>array(),'grouping'=>array(),'edit_functions'=>array(array("json")),'types'=>$U,'structured_types'=>$Gh,);}}class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($i=false){return
password_file($i);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($M){return
h($M);}function
database(){return
DB;}function
databases($dd=true){return
get_databases($dd);}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$I=array();$q="adminer.css";if(file_exists($q))$I[]="$q?v=".crc32(file_get_contents($q));return$I;}function
loginForm(){global$ic;echo"<table cellspacing='0' class='layout'>\n",$this->loginFormField('driver','<tr><th>'.'System'.'<td>',html_select("auth[driver]",$ic,DRIVER,"loginDriver(this);")."\n"),$this->loginFormField('server','<tr><th>'.'Server'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'."\n"),$this->loginFormField('username','<tr><th>'.'Username'.'<td>','<input name="auth[username]" id="username" value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.'Password'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'."\n"),$this->loginFormField('db','<tr><th>'.'Database'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'."\n"),"</table>\n","<p><input type='submit' value='".'Login'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'Permanent login')."\n";}function
loginFormField($D,$_d,$Y){return$_d.$Y;}function
login($xe,$F){if($F=="")return
sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.',target_blank());return
true;}function
tableName($Nh){return
h($Nh["Name"]);}function
fieldName($o,$zf=0){return'<span title="'.h($o["full_type"]).'">'.h($o["field"]).'</span>';}function
selectLinks($Nh,$N=""){global$y,$m;echo'<p class="links">';$we=array("select"=>'Select data');if(support("table")||support("indexes"))$we["table"]='Show structure';if(support("table")){if(is_view($Nh))$we["view"]='Alter view';else$we["create"]='Alter table';}if($N!==null)$we["edit"]='New item';$D=$Nh["Name"];foreach($we
as$z=>$X)echo" <a href='".h(ME)."$z=".urlencode($D).($z=="edit"?$N:"")."'".bold(isset($_GET[$z])).">$X</a>";echo
doc_link(array($y=>$m->tableHelp($D)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$Mh){return
array();}function
backwardKeysPrint($Na,$J){}function
selectQuery($G,$Ch,$Rc=false){global$y,$m;$I="</p>\n";if(!$Rc&&($bj=$m->warnings())){$u="warnings";$I=", <a href='#$u'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$I<div id='$u' class='hidden'>\n$bj</div>\n";}return"<p><code class='jush-$y'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($Ch).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".'Edit'."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($K,$gd){return$K;}function
selectLink($X,$o){}function
selectVal($X,$A,$o,$Gf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$o["type"])&&!preg_match("~var~",$o["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$o["type"])&&!is_utf8($X))$I="<i>".lang(array('%d byte','%d bytes'),strlen($Gf))."</i>";if(preg_match('~json~',$o["type"]))$I="<code class='jush-js'>$I</code>";return($A?"<a href='".h($A)."'".(is_url($A)?target_blank():"").">$I</a>":$I);}function
editVal($X,$o){return$X;}function
tableStructurePrint($p){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>".'Column'."<td>".'Type'.(support("comment")?"<td>".'Comment':"")."</thead>\n";foreach($p
as$o){echo"<tr".odd()."><th>".h($o["field"]),"<td><span title='".h($o["collation"])."'>".h($o["full_type"])."</span>",($o["null"]?" <i>NULL</i>":""),($o["auto_increment"]?" <i>".'Auto Increment'."</i>":""),(isset($o["default"])?" <span title='".'Default value'."'>[<b>".h($o["default"])."</b>]</span>":""),(support("comment")?"<td>".h($o["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($x){echo"<table cellspacing='0'>\n";foreach($x
as$D=>$w){ksort($w["columns"]);$mg=array();foreach($w["columns"]as$z=>$X)$mg[]="<i>".h($X)."</i>".($w["lengths"][$z]?"(".$w["lengths"][$z].")":"").($w["descs"][$z]?" DESC":"");echo"<tr title='".h($D)."'><th>$w[type]<td>".implode(", ",$mg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$f){global$nd,$td;print_fieldset("select",'Select',$L);$t=0;$L[""]=array();foreach($L
as$z=>$X){$X=$_GET["columns"][$z];$e=select_input(" name='columns[$t][col]'",$f,$X["col"],($z!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($nd||$td?"<select name='columns[$t][fun]'>".optionlist(array(-1=>"")+array_filter(array('Functions'=>$nd,'Aggregation'=>$td)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($z!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($e)":$e)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$f,$x){print_fieldset("search",'Search',$Z);foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('h',$w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}}$Ya="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$t][col]'",$f,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'anywhere'.")"),html_select("where[$t][op]",$this->operators,$X["op"],$Ya),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $Ya }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($zf,$f,$x){print_fieldset("sort",'Sort',$zf);$t=0;foreach((array)$_GET["order"]as$z=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$f,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$z]),'descending')."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$f,"","selectAddRow"),checkbox("desc[$t]",1,false,'descending')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($_){echo"<fieldset><legend>".'Limit'."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($_)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($ci){if($ci!==null){echo"<fieldset><legend>".'Text length'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($ci)."'>","</div></fieldset>\n";}}function
selectActionPrint($x){echo"<fieldset><legend>".'Action'."</legend><div>","<input type='submit' value='".'Select'."'>"," <span id='noindex' title='".'Full table scan'."'></span>","<script".nonce().">\n","var indexColumns = ";$f=array();foreach($x
as$w){$Ob=reset($w["columns"]);if($w["type"]!="FULLTEXT"&&$Ob)$f[$Ob]=1;}$f[""]=1;foreach($f
as$z=>$X)json_row($z);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($vc,$f){}function
selectColumnsProcess($f,$x){global$nd,$td;$L=array();$qd=array();foreach((array)$_GET["columns"]as$z=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$nd)||in_array($X["fun"],$td)))){$L[$z]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$td))$qd[]=$L[$z];}}return
array($L,$qd);}function
selectSearchProcess($p,$x){global$g,$m;$I=array();foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="")$I[]="MATCH (".implode(", ",array_map('idf_escape',$w["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$z=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$ig="";$ub=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Jd=process_length($X["val"]);$ub.=" ".($Jd!=""?$Jd:"(NULL)");}elseif($X["op"]=="SQL")$ub=" $X[val]";elseif($X["op"]=="LIKE %%")$ub=" LIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$ub=" ILIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$ig="$X[op](".q($X["val"]).", ";$ub=")";}elseif(!preg_match('~NULL$~',$X["op"]))$ub.=" ".$this->processInput($p[$X["col"]],$X["val"]);if($X["col"]!="")$I[]=$ig.$m->convertSearch(idf_escape($X["col"]),$X,$p[$X["col"]]).$ub;else{$nb=array();foreach($p
as$D=>$o){if((preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$o["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$o["type"]))&&(!preg_match('~date|timestamp~',$o["type"])||preg_match('~^\d+-\d+-\d+~',$X["val"])))$nb[]=$ig.$m->convertSearch(idf_escape($D),$X,$o).$ub;}$I[]=($nb?"(".implode(" OR ",$nb).")":"1 = 0");}}}return$I;}function
selectOrderProcess($p,$x){$I=array();foreach((array)$_GET["order"]as$z=>$X){if($X!="")$I[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$z])?" DESC":"");}return$I;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$gd){return
false;}function
selectQueryBuild($L,$Z,$qd,$zf,$_,$E){return"";}function
messageQuery($G,$di,$Rc=false){global$y,$m;restart_session();$Ad=&get_session("queries");if(!$Ad[$_GET["db"]])$Ad[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\n??;$Ad[$_GET["db"]][]=array($G,time(),$di);$_h="sql-".count($Ad[$_GET["db"]]);$I="<a href='#$_h' class='toggle'>".'SQL command'."</a>\n";if(!$Rc&&($bj=$m->warnings())){$u="warnings-".count($Ad[$_GET["db"]]);$I="<a href='#$u' class='toggle'>".'Warnings'."</a>, $I<div id='$u' class='hidden'>\n$bj</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$_h' class='hidden'><pre><code class='jush-$y'>".shorten_utf8($G,1000)."</code></pre>".($di?" <span class='time'>($di)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($Ad[$_GET["db"]])-1)).'">'.'Edit'.'</a>':'').'</div>';}function
editRowPrint($Q,$p,$J,$Ii){}function
editFunctions($o){global$qc;$I=($o["null"]?"NULL/":"");$Ii=isset($_GET["select"])||where($_GET);foreach($qc
as$z=>$nd){if(!$z||(!isset($_GET["call"])&&$Ii)){foreach($nd
as$Zf=>$X){if(!$Zf||preg_match("~$Zf~",$o["type"]))$I.="/$X";}}if($z&&!preg_match('~set|blob|bytea|raw|file|bool~',$o["type"]))$I.="/SQL";}if($o["auto_increment"]&&!$Ii)$I='Auto Increment';return
explode("/",$I);}function
editInput($Q,$o,$Ha,$Y){if($o["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Ha value='-1' checked><i>".'original'."</i></label> ":"").($o["null"]?"<label><input type='radio'$Ha value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Ha,$o,$Y,0);return"";}function
editHint($Q,$o,$Y){return"";}function
processInput($o,$Y,$s=""){if($s=="SQL")return$Y;$D=$o["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$s))$I="$s()";elseif(preg_match('~^current_(date|timestamp)$~',$s))$I=$s;elseif(preg_match('~^([+-]|\|\|)$~',$s))$I=idf_escape($D)." $s $I";elseif(preg_match('~^[+-] interval$~',$s))$I=idf_escape($D)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$s))$I="$s(".idf_escape($D).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$s))$I="$s($I)";return
unconvert_field($o,$I);}function
dumpOutput(){$I=array('text'=>'open','file'=>'save');if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
dumpFormat(){return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($l){}function
dumpTable($Q,$Hh,$ce=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($Hh)dump_csv(array_keys(fields($Q)));}else{if($ce==2){$p=array();foreach(fields($Q)as$D=>$o)$p[]=idf_escape($D)." $o[full_type]";$i="CREATE TABLE ".table($Q)." (".implode(", ",$p).")";}else$i=create_sql($Q,$_POST["auto_increment"],$Hh);set_utf8mb4($i);if($Hh&&$i){if($Hh=="DROP+CREATE"||$ce==1)echo"DROP ".($ce==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";if($ce==1)$i=remove_definer($i);echo"$i;\n\n";}}}function
dumpData($Q,$Hh,$G){global$g,$y;$Ee=($y=="sqlite"?0:1048576);if($Hh){if($_POST["format"]=="sql"){if($Hh=="TRUNCATE+INSERT")echo
truncate_sql($Q).";\n";$p=fields($Q);}$H=$g->query($G,1);if($H){$Vd="";$Va="";$he=array();$Jh="";$Uc=($Q!=''?'fetch_assoc':'fetch_row');while($J=$H->$Uc()){if(!$he){$Ti=array();foreach($J
as$X){$o=$H->fetch_field();$he[]=$o->name;$z=idf_escape($o->name);$Ti[]="$z = VALUES($z)";}$Jh=($Hh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Ti):"").";\n";}if($_POST["format"]!="sql"){if($Hh=="table"){dump_csv($he);$Hh="INSERT";}dump_csv($J);}else{if(!$Vd)$Vd="INSERT INTO ".table($Q)." (".implode(", ",array_map('idf_escape',$he)).") VALUES";foreach($J
as$z=>$X){$o=$p[$z];$J[$z]=($X!==null?unconvert_field($o,preg_match(number_type(),$o["type"])&&!preg_match('~\[~',$o["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$Xg=($Ee?"\n":" ")."(".implode(",\t",$J).")";if(!$Va)$Va=$Vd.$Xg;elseif(strlen($Va)+4+strlen($Xg)+strlen($Jh)<$Ee)$Va.=",$Xg";else{echo$Va.$Jh;$Va=$Vd.$Xg;}}}if($Va)echo$Va.$Jh;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$g->error)."\n";}}function
dumpFilename($Fd){return
friendly_url($Fd!=""?$Fd:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Fd,$Se=false){$Jf=$_POST["output"];$Mc=(preg_match('~sql~',$_POST["format"])?"sql":($Se?"tar":"csv"));header("Content-Type: ".($Jf=="gz"?"application/x-gzip":($Mc=="tar"?"application/x-tar":($Mc=="sql"||$Jf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Jf=="gz")ob_start('ob_gzencode',1e6);return$Mc;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'Alter database'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'Alter schema':'Create schema')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'Database schema'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'Privileges'."</a>\n":"");return
true;}function
navigation($Re){global$ia,$y,$ic,$g;echo'<h1>
',$this->name(),' <span class="version">',$ia,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</h1>
';if($Re=="auth"){$Jf="";foreach((array)$_SESSION["pwds"]as$Vi=>$lh){foreach($lh
as$M=>$Qi){foreach($Qi
as$V=>$F){if($F!==null){$Ub=$_SESSION["db"][$Vi][$M][$V];foreach(($Ub?array_keys($Ub):array(""))as$l)$Jf.="<li><a href='".h(auth_url($Vi,$M,$V,$l))."'>($ic[$Vi]) ".h($V.($M!=""?"@".$this->serverName($M):"").($l!=""?" - $l":""))."</a>\n";}}}}if($Jf)echo"<ul id='logins'>\n$Jf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$S=array();if($_GET["ns"]!==""&&!$Re&&DB!=""){$g->select_db(DB);$S=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=4.8.1");if(support("sql")){echo'<script',nonce(),'>
';if($S){$we=array();foreach($S
as$Q=>$T)$we[]=preg_quote($Q,'/');echo"var jushLinks = { $y: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$we).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.$y;\n";}$kh=$g->server_info;echo'bodyLoad(\'',(is_object($g)?preg_replace('~^(\d\.?\d).*~s','\1',$kh):""),'\'',(preg_match('~MariaDB~',$kh)?", true":""),');
</script>
';}$this->databasesPrint($Re);if(DB==""||!$Re){echo"<p class='links'>".(support("sql")?"<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL command'."</a>\n<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'Import'."</a>\n":"")."";if(support("dump"))echo"<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'Export'."</a>\n";}if($_GET["ns"]!==""&&!$Re&&DB!=""){echo'<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'Create table'."</a>\n";if(!$S)echo"<p class='message'>".'No tables.'."\n";else$this->tablesPrint($S);}}}function
databasesPrint($Re){global$b,$g;$k=$this->databases();if(DB&&$k&&!in_array(DB,$k))array_unshift($k,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Sb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'database'."'>".'DB'."</span>: ".($k?"<select name='db'>".optionlist(array(""=>"")+$k,DB)."</select>$Sb":"<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".'Use'."'".($k?" class='hidden'":"").">\n";if(support("scheme")){if($Re!="db"&&DB!=""&&$g->select_db(DB)){echo"<br>".'Schema'.": <select name='ns'>".optionlist(array(""=>"")+$b->schemas(),$_GET["ns"])."</select>$Sb";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$O){$D=$this->tableName($O);if($D!=""){echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select")." title='".'Select data'."'>".'select'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($O)?"view":"structure"))." title='".'Show structure'."'>$D</a>":"<span>$D</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);$ic=array("server"=>"MySQL")+$ic;if(!defined("DRIVER")){define("DRIVER","server");if(extension_loaded("mysqli")){class
Min_DB
extends
MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($M="",$V="",$F="",$j=null,$dg=null,$th=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Dd,$dg)=explode(":",$M,2);$Bh=$b->connectSsl();if($Bh)$this->ssl_set($Bh['key'],$Bh['cert'],$Bh['ca'],'','');$I=@$this->real_connect(($M!=""?$Dd:ini_get("mysqli.default_host")),($M.$V!=""?$V:ini_get("mysqli.default_user")),($M.$V.$F!=""?$F:ini_get("mysqli.default_pw")),$j,(is_numeric($dg)?$dg:ini_get("mysqli.default_port")),(!is_numeric($dg)?$dg:$th),($Bh?64:0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$I;}function
set_charset($Za){if(parent::set_charset($Za))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $Za");}function
result($G,$o=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch_array();return$J[$o];}function
quote($P){return"'".$this->escape_string($P)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Min_DB{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($M,$V,$F){if(ini_bool("mysql.allow_local_infile")){$this->error=sprintf('Disable %s or enable %s or %s extensions.',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->_link=@mysql_connect(($M!=""?$M:ini_get("mysql.default_host")),("$M$V"!=""?$V:ini_get("mysql.default_user")),("$M$V$F"!=""?$F:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($Za){if(function_exists('mysql_set_charset')){if(mysql_set_charset($Za,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $Za");}function
quote($P){return"'".mysql_real_escape_string($P,$this->_link)."'";}function
select_db($j){return
mysql_select_db($j,$this->_link);}function
query($G,$Bi=false){$H=@($Bi?mysql_unbuffered_query($G,$this->_link):mysql_query($G,$this->_link));$this->error="";if(!$H){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($H===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
mysql_result($H->_result,0,$o);}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($H){$this->_result=$H;$this->num_rows=mysql_num_rows($H);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$I=mysql_fetch_field($this->_result,$this->_offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=($I->blob?63:0);return$I;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_MySQL";function
connect($M,$V,$F){global$b;$xf=array(PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$Bh=$b->connectSsl();if($Bh){if(!empty($Bh['key']))$xf[PDO::MYSQL_ATTR_SSL_KEY]=$Bh['key'];if(!empty($Bh['cert']))$xf[PDO::MYSQL_ATTR_SSL_CERT]=$Bh['cert'];if(!empty($Bh['ca']))$xf[PDO::MYSQL_ATTR_SSL_CA]=$Bh['ca'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$F,$xf);return
true;}function
set_charset($Za){$this->query("SET NAMES $Za");}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($G,$Bi=false){$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$Bi);return
parent::query($G,$Bi);}}}class
Min_Driver
extends
Min_SQL{function
insert($Q,$N){return($N?parent::insert($Q,$N):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));}function
insertUpdate($Q,$K,$kg){$f=array_keys(reset($K));$ig="INSERT INTO ".table($Q)." (".implode(", ",$f).") VALUES\n";$Ti=array();foreach($f
as$z)$Ti[$z]="$z = VALUES($z)";$Jh="\nON DUPLICATE KEY UPDATE ".implode(", ",$Ti);$Ti=array();$te=0;foreach($K
as$N){$Y="(".implode(", ",$N).")";if($Ti&&(strlen($ig)+$te+strlen($Y)+strlen($Jh)>1e6)){if(!queries($ig.implode(",\n",$Ti).$Jh))return
false;$Ti=array();$te=0;}$Ti[]=$Y;$te+=strlen($Y)+2;}return
queries($ig.implode(",\n",$Ti).$Jh);}function
slowQuery($G,$ei){if(min_version('5.7.8','10.1.2')){if(preg_match('~MariaDB~',$this->_conn->server_info))return"SET STATEMENT max_statement_time=$ei FOR $G";elseif(preg_match('~^(SELECT\b)(.+)~is',$G,$C))return"$C[1] /*+ MAX_EXECUTION_TIME(".($ei*1000).") */ $C[2]";}}function
convertSearch($v,$X,$o){return(preg_match('~char|text|enum|set~',$o["type"])&&!preg_match("~^utf8~",$o["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($v USING ".charset($this->_conn).")":$v);}function
warnings(){$H=$this->_conn->query("SHOW WARNINGS");if($H&&$H->num_rows){ob_start();select($H);return
ob_get_clean();}}function
tableHelp($D){$_e=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower(($_e?"information-schema-$D-table/":str_replace("_","-",$D)."-table.html"));if(DB=="mysql")return($_e?"mysql$D-table/":"system-database.html");}}function
idf_escape($v){return"`".str_replace("`","``",$v)."`";}function
table($v){return
idf_escape($v);}function
connect(){global$b,$U,$Gh;$g=new
Min_DB;$Kb=$b->credentials();if($g->connect($Kb[0],$Kb[1],$Kb[2])){$g->set_charset(charset($g));$g->query("SET sql_quote_show_create = 1, autocommit = 1");if(min_version('5.7.8',10.2,$g)){$Gh['Strings'][]="json";$U["json"]=4294967295;}return$g;}$I=$g->error;if(function_exists('iconv')&&!is_utf8($I)&&strlen($Xg=iconv("windows-1250","utf-8",$I))>strlen($I))$I=$Xg;return$I;}function
get_databases($dd){$I=get_session("dbs");if($I===null){$G=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME":"SHOW DATABASES");$I=($dd?slow_query($G):get_vals($G));restart_session();set_session("dbs",$I);stop_session();}return$I;}function
limit($G,$Z,$_,$hf=0,$hh=" "){return" $G$Z".($_!==null?$hh."LIMIT $_".($hf?" OFFSET $hf":""):"");}function
limit1($Q,$G,$Z,$hh="\n"){return
limit($G,$Z,1,0,$hh);}function
db_collation($l,$lb){global$g;$I=null;$i=$g->result("SHOW CREATE DATABASE ".idf_escape($l),1);if(preg_match('~ COLLATE ([^ ]+)~',$i,$C))$I=$C[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$i,$C))$I=$lb[$C[1]][-1];return$I;}function
engines(){$I=array();foreach(get_rows("SHOW ENGINES")as$J){if(preg_match("~YES|DEFAULT~",$J["Support"]))$I[]=$J["Engine"];}return$I;}function
logged_user(){global$g;return$g->result("SELECT USER()");}function
tables_list(){return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");}function
count_tables($k){$I=array();foreach($k
as$l)$I[$l]=count(get_vals("SHOW TABLES IN ".idf_escape($l)));return$I;}function
table_status($D="",$Sc=false){$I=array();foreach(get_rows($Sc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($D!=""?"AND TABLE_NAME = ".q($D):"ORDER BY Name"):"SHOW TABLE STATUS".($D!=""?" LIKE ".q(addcslashes($D,"%_\\")):""))as$J){if($J["Engine"]=="InnoDB")$J["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$J["Comment"]);if(!isset($J["Engine"]))$J["Comment"]="";if($D!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]===null;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"])||(preg_match('~NDB~i',$R["Engine"])&&min_version(5.6));}function
fields($Q){$I=array();foreach(get_rows("SHOW FULL COLUMNS FROM ".table($Q))as$J){preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$J["Type"],$C);$I[$J["Field"]]=array("field"=>$J["Field"],"full_type"=>$J["Type"],"type"=>$C[1],"length"=>$C[2],"unsigned"=>ltrim($C[3].$C[4]),"default"=>($J["Default"]!=""||preg_match("~char|set~",$C[1])?(preg_match('~text~',$C[1])?stripslashes(preg_replace("~^'(.*)'\$~",'\1',$J["Default"])):$J["Default"]):null),"null"=>($J["Null"]=="YES"),"auto_increment"=>($J["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i',$J["Extra"],$C)?$C[1]:""),"collation"=>$J["Collation"],"privileges"=>array_flip(preg_split('~, *~',$J["Privileges"])),"comment"=>$J["Comment"],"primary"=>($J["Key"]=="PRI"),"generated"=>preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$J["Extra"]),);}return$I;}function
indexes($Q,$h=null){$I=array();foreach(get_rows("SHOW INDEX FROM ".table($Q),$h)as$J){$D=$J["Key_name"];$I[$D]["type"]=($D=="PRIMARY"?"PRIMARY":($J["Index_type"]=="FULLTEXT"?"FULLTEXT":($J["Non_unique"]?($J["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$I[$D]["columns"][]=$J["Column_name"];$I[$D]["lengths"][]=($J["Index_type"]=="SPATIAL"?null:$J["Sub_part"]);$I[$D]["descs"][]=null;}return$I;}function
foreign_keys($Q){global$g,$pf;static$Zf='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$I=array();$Ib=$g->result("SHOW CREATE TABLE ".table($Q),1);if($Ib){preg_match_all("~CONSTRAINT ($Zf) FOREIGN KEY ?\\(((?:$Zf,? ?)+)\\) REFERENCES ($Zf)(?:\\.($Zf))? \\(((?:$Zf,? ?)+)\\)(?: ON DELETE ($pf))?(?: ON UPDATE ($pf))?~",$Ib,$Ce,PREG_SET_ORDER);foreach($Ce
as$C){preg_match_all("~$Zf~",$C[2],$vh);preg_match_all("~$Zf~",$C[5],$Wh);$I[idf_unescape($C[1])]=array("db"=>idf_unescape($C[4]!=""?$C[3]:$C[4]),"table"=>idf_unescape($C[4]!=""?$C[4]:$C[3]),"source"=>array_map('idf_unescape',$vh[0]),"target"=>array_map('idf_unescape',$Wh[0]),"on_delete"=>($C[6]?$C[6]:"RESTRICT"),"on_update"=>($C[7]?$C[7]:"RESTRICT"),);}}return$I;}function
view($D){global$g;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',$g->result("SHOW CREATE VIEW ".table($D),1)));}function
collations(){$I=array();foreach(get_rows("SHOW COLLATION")as$J){if($J["Default"])$I[$J["Charset"]][-1]=$J["Collation"];else$I[$J["Charset"]][]=$J["Collation"];}ksort($I);foreach($I
as$z=>$X)asort($I[$z]);return$I;}function
information_schema($l){return(min_version(5)&&$l=="information_schema")||(min_version(5.5)&&$l=="performance_schema");}function
error(){global$g;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$g->error));}function
create_database($l,$d){return
queries("CREATE DATABASE ".idf_escape($l).($d?" COLLATE ".q($d):""));}function
drop_databases($k){$I=apply_queries("DROP DATABASE",$k,'idf_escape');restart_session();set_session("dbs",null);return$I;}function
rename_database($D,$d){$I=false;if(create_database($D,$d)){$S=array();$Yi=array();foreach(tables_list()as$Q=>$T){if($T=='VIEW')$Yi[]=$Q;else$S[]=$Q;}$I=(!$S&&!$Yi)||move_tables($S,$Yi,$D);drop_databases($I?array(DB):array());}return$I;}function
auto_increment(){$La=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$w){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$w["columns"],true)){$La="";break;}if($w["type"]=="PRIMARY")$La=" UNIQUE";}}return" AUTO_INCREMENT$La";}function
alter_table($Q,$D,$p,$fd,$rb,$yc,$d,$Ka,$Tf){$c=array();foreach($p
as$o)$c[]=($o[1]?($Q!=""?($o[0]!=""?"CHANGE ".idf_escape($o[0]):"ADD"):" ")." ".implode($o[1]).($Q!=""?$o[2]:""):"DROP ".idf_escape($o[0]));$c=array_merge($c,$fd);$O=($rb!==null?" COMMENT=".q($rb):"").($yc?" ENGINE=".q($yc):"").($d?" COLLATE ".q($d):"").($Ka!=""?" AUTO_INCREMENT=$Ka":"");if($Q=="")return
queries("CREATE TABLE ".table($D)." (\n".implode(",\n",$c)."\n)$O$Tf");if($Q!=$D)$c[]="RENAME TO ".table($D);if($O)$c[]=ltrim($O);return($c||$Tf?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$c).$Tf):true);}function
alter_indexes($Q,$c){foreach($c
as$z=>$X)$c[$z]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($Q).implode(",",$c));}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($Yi){return
queries("DROP VIEW ".implode(", ",array_map('table',$Yi)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('table',$S)));}function
move_tables($S,$Yi,$Wh){global$g;$Jg=array();foreach($S
as$Q)$Jg[]=table($Q)." TO ".idf_escape($Wh).".".table($Q);if(!$Jg||queries("RENAME TABLE ".implode(", ",$Jg))){$Zb=array();foreach($Yi
as$Q)$Zb[table($Q)]=view($Q);$g->select_db($Wh);$l=idf_escape(DB);foreach($Zb
as$D=>$Xi){if(!queries("CREATE VIEW $D AS ".str_replace(" $l."," ",$Xi["select"]))||!queries("DROP VIEW $l.$D"))return
false;}return
true;}return
false;}function
copy_tables($S,$Yi,$Wh){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($S
as$Q){$D=($Wh==DB?table("copy_$Q"):idf_escape($Wh).".".table($Q));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $D"))||!queries("CREATE TABLE $D LIKE ".table($Q))||!queries("INSERT INTO $D SELECT * FROM ".table($Q)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J){$wi=$J["Trigger"];if(!queries("CREATE TRIGGER ".($Wh==DB?idf_escape("copy_$wi"):idf_escape($Wh).".".idf_escape($wi))." $J[Timing] $J[Event] ON $D FOR EACH ROW\n$J[Statement];"))return
false;}}foreach($Yi
as$Q){$D=($Wh==DB?table("copy_$Q"):idf_escape($Wh).".".table($Q));$Xi=view($Q);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $D"))||!queries("CREATE VIEW $D AS $Xi[select]"))return
false;}return
true;}function
trigger($D){if($D=="")return
array();$K=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($D));return
reset($K);}function
triggers($Q){$I=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J)$I[$J["Trigger"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($D,$T){global$g,$_c,$Td,$U;$Ba=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$wh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Ai="((".implode("|",array_merge(array_keys($U),$Ba)).")\\b(?:\\s*\\(((?:[^'\")]|$_c)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$Zf="$wh*(".($T=="FUNCTION"?"":$Td).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Ai";$i=$g->result("SHOW CREATE $T ".idf_escape($D),2);preg_match("~\\(((?:$Zf\\s*,?)*)\\)\\s*".($T=="FUNCTION"?"RETURNS\\s+$Ai\\s+":"")."(.*)~is",$i,$C);$p=array();preg_match_all("~$Zf\\s*,?~is",$C[1],$Ce,PREG_SET_ORDER);foreach($Ce
as$Nf)$p[]=array("field"=>str_replace("``","`",$Nf[2]).$Nf[3],"type"=>strtolower($Nf[5]),"length"=>preg_replace_callback("~$_c~s",'normalize_enum',$Nf[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Nf[8] $Nf[7]"))),"null"=>1,"full_type"=>$Nf[4],"inout"=>strtoupper($Nf[1]),"collation"=>strtolower($Nf[9]),);if($T!="FUNCTION")return
array("fields"=>$p,"definition"=>$C[11]);return
array("fields"=>$p,"returns"=>array("type"=>$C[12],"length"=>$C[13],"unsigned"=>$C[15],"collation"=>$C[16]),"definition"=>$C[17],"language"=>"SQL",);}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));}function
routine_languages(){return
array();}function
routine_id($D,$J){return
idf_escape($D);}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ID()");}function
explain($g,$G){return$g->query("EXPLAIN ".(min_version(5.1)&&!min_version(5.7)?"PARTITIONS ":"").$G);}function
found_rows($R,$Z){return($Z||$R["Engine"]!="InnoDB"?null:$R["Rows"]);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Zg,$h=null){return
true;}function
create_sql($Q,$Ka,$Hh){global$g;$I=$g->result("SHOW CREATE TABLE ".table($Q),1);if(!$Ka)$I=preg_replace('~ AUTO_INCREMENT=\d+~','',$I);return$I;}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
use_sql($j){return"USE ".idf_escape($j);}function
trigger_sql($Q){$I="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")),null,"-- ")as$J)$I.="\nCREATE TRIGGER ".idf_escape($J["Trigger"])." $J[Timing] $J[Event] ON ".table($J["Table"])." FOR EACH ROW\n$J[Statement];;\n";return$I;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($o){if(preg_match("~binary~",$o["type"]))return"HEX(".idf_escape($o["field"]).")";if($o["type"]=="bit")return"BIN(".idf_escape($o["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($o["field"]).")";}function
unconvert_field($o,$I){if(preg_match("~binary~",$o["type"]))$I="UNHEX($I)";if($o["type"]=="bit")$I="CONV($I, 2, 10) + 0";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))$I=(min_version(8)?"ST_":"")."GeomFromText($I, SRID($o[field]))";return$I;}function
support($Tc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view")))."~",$Tc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$g;return$g->result("SELECT @@max_connections");}function
driver_config(){$U=array();$Gh=array();foreach(array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'Date and time'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'Strings'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'Lists'=>array("enum"=>65535,"set"=>64),'Binary'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'Geometry'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$z=>$X){$U+=$X;$Gh[$z]=array_keys($X);}return
array('possible_drivers'=>array("MySQLi","MySQL","PDO_MySQL"),'jush'=>"sql",'types'=>$U,'structured_types'=>$Gh,'unsigned'=>array("unsigned","zerofill","unsigned zerofill"),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL"),'functions'=>array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper"),'grouping'=>array("avg","count","count distinct","group_concat","max","min","sum"),'edit_functions'=>array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",)),);}}$vb=driver_config();$hg=$vb['possible_drivers'];$y=$vb['jush'];$U=$vb['types'];$Gh=$vb['structured_types'];$Hi=$vb['unsigned'];$uf=$vb['operators'];$nd=$vb['functions'];$td=$vb['grouping'];$qc=$vb['edit_functions'];if($b->operators===null)$b->operators=$uf;define("SERVER",$_GET[DRIVER]);define("DB",$_GET["db"]);define("ME",preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));$ia="4.8.1";function
page_header($gi,$n="",$Ua=array(),$hi=""){global$ca,$ia,$b,$ic,$y;page_headers();if(is_ajax()&&$n){page_messages($n);exit;}$ii=$gi.($hi!=""?": $hi":"");$ji=strip_tags($ii.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$ji,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=4.8.1"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=4.8.1");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.8.1"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.8.1"),'">
';foreach($b->css()as$Mb){echo'<link rel="stylesheet" type="text/css" href="',h($Mb),'">
';}}echo'
<body class="ltr nojs">
';$q=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($q)&&filemtime($q)+86400>time()){$Wi=unserialize(file_get_contents($q));$tg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($Wi["version"],base64_decode($Wi["signature"]),$tg)==1)$_COOKIE["adminer_version"]=$Wi["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape('You are offline.'),'\';
var thousandsSeparator = \'',js_escape(','),'\';
</script>

<div id="help" class="jush-',$y,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Ua!==null){$A=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($A?$A:".").'">'.$ic[DRIVER].'</a> &raquo; ';$A=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=$b->serverName(SERVER);$M=($M!=""?$M:'Server');if($Ua===false)echo"$M\n";else{echo"<a href='".h($A)."' accesskey='1' title='Alt+Shift+1'>$M</a> &raquo; ";if($_GET["ns"]!=""||(DB!=""&&is_array($Ua)))echo'<a href="'.h($A."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> &raquo; ';if(is_array($Ua)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> &raquo; ';foreach($Ua
as$z=>$X){$bc=(is_array($X)?$X[1]:h($X));if($bc!="")echo"<a href='".h(ME."$z=").urlencode(is_array($X)?$X[0]:$X)."'>$bc</a> &raquo; ";}}echo"$gi\n";}}echo"<h2>$ii</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($n);$k=&get_session("dbs");if(DB!=""&&$k&&!in_array(DB,$k,true))$k=null;stop_session();define("PAGE_HEADER",1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Lb){$zd=array();foreach($Lb
as$z=>$X)$zd[]="$z $X";header("Content-Security-Policy: ".implode("; ",$zd));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$bf;if(!$bf)$bf=base64_encode(rand_string());return$bf;}function
page_messages($n){$Ji=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Oe=$_SESSION["messages"][$Ji];if($Oe){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Oe)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Ji]);}if($n)echo"<div class='error'>$n</div>\n";}function
page_footer($Re=""){global$b,$ni;echo'</div>

';if($Re!="auth"){echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="',$ni,'">
</p>
</form>
';}echo'<div id="menu">
';$b->navigation($Re);echo'</div>
',script("setupSubmitHighlight(document);");}function
int32($Ue){while($Ue>=2147483648)$Ue-=4294967296;while($Ue<=-2147483649)$Ue+=4294967296;return(int)$Ue;}function
long2str($W,$aj){$Xg='';foreach($W
as$X)$Xg.=pack('V',$X);if($aj)return
substr($Xg,0,end($W));return$Xg;}function
str2long($Xg,$aj){$W=array_values(unpack('V*',str_pad($Xg,4*ceil(strlen($Xg)/4),"\0")));if($aj)$W[]=strlen($Xg);return$W;}function
xxtea_mx($mj,$lj,$Kh,$fe){return
int32((($mj>>5&0x7FFFFFF)^$lj<<2)+(($lj>>3&0x1FFFFFFF)^$mj<<4))^int32(($Kh^$lj)+($fe^$mj));}function
encrypt_string($Fh,$z){if($Fh=="")return"";$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($Fh,true);$Ue=count($W)-1;$mj=$W[$Ue];$lj=$W[0];$ug=floor(6+52/($Ue+1));$Kh=0;while($ug-->0){$Kh=int32($Kh+0x9E3779B9);$pc=$Kh>>2&3;for($Lf=0;$Lf<$Ue;$Lf++){$lj=$W[$Lf+1];$Te=xxtea_mx($mj,$lj,$Kh,$z[$Lf&3^$pc]);$mj=int32($W[$Lf]+$Te);$W[$Lf]=$mj;}$lj=$W[0];$Te=xxtea_mx($mj,$lj,$Kh,$z[$Lf&3^$pc]);$mj=int32($W[$Ue]+$Te);$W[$Ue]=$mj;}return
long2str($W,false);}function
decrypt_string($Fh,$z){if($Fh=="")return"";if(!$z)return
false;$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($Fh,false);$Ue=count($W)-1;$mj=$W[$Ue];$lj=$W[0];$ug=floor(6+52/($Ue+1));$Kh=int32($ug*0x9E3779B9);while($Kh){$pc=$Kh>>2&3;for($Lf=$Ue;$Lf>0;$Lf--){$mj=$W[$Lf-1];$Te=xxtea_mx($mj,$lj,$Kh,$z[$Lf&3^$pc]);$lj=int32($W[$Lf]-$Te);$W[$Lf]=$lj;}$mj=$W[$Ue];$Te=xxtea_mx($mj,$lj,$Kh,$z[$Lf&3^$pc]);$lj=int32($W[0]-$Te);$W[0]=$lj;$Kh=int32($Kh-0x9E3779B9);}return
long2str($W,true);}$g='';$yd=$_SESSION["token"];if(!$yd)$_SESSION["token"]=rand(1,1e6);$ni=get_token();$bg=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($z)=explode(":",$X);$bg[$z]=$X;}}function
add_invalid_login(){global$b;$ld=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$ld)return;$Yd=unserialize(stream_get_contents($ld));$di=time();if($Yd){foreach($Yd
as$Zd=>$X){if($X[0]<$di)unset($Yd[$Zd]);}}$Xd=&$Yd[$b->bruteForceKey()];if(!$Xd)$Xd=array($di+30*60,0);$Xd[1]++;file_write_unlock($ld,serialize($Yd));}function
check_invalid_login(){global$b;$Yd=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$Xd=($Yd?$Yd[$b->bruteForceKey()]:array());$af=($Xd[1]>29?$Xd[0]-time():0);if($af>0)auth_error(lang(array('Too many unsuccessful logins, try again in %d minute.','Too many unsuccessful logins, try again in %d minutes.'),ceil($af/60)));}$Ia=$_POST["auth"];if($Ia){session_regenerate_id();$Vi=$Ia["driver"];$M=$Ia["server"];$V=$Ia["username"];$F=(string)$Ia["password"];$l=$Ia["db"];set_password($Vi,$M,$V,$F);$_SESSION["db"][$Vi][$M][$V][$l]=true;if($Ia["permanent"]){$z=base64_encode($Vi)."-".base64_encode($M)."-".base64_encode($V)."-".base64_encode($l);$ng=$b->permanentLogin(true);$bg[$z]="$z:".base64_encode($ng?encrypt_string($F,$ng):"");cookie("adminer_permanent",implode(" ",$bg));}if(count($_POST)==1||DRIVER!=$Vi||SERVER!=$M||$_GET["username"]!==$V||DB!=$l)redirect(auth_url($Vi,$M,$V,$l));}elseif($_POST["logout"]&&(!$yd||verify_token())){foreach(array("pwds","db","dbs","queries")as$z)set_session($z,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'Logout successful.'.' '.'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');}elseif($bg&&!$_SESSION["pwds"]){session_regenerate_id();$ng=$b->permanentLogin();foreach($bg
as$z=>$X){list(,$fb)=explode(":",$X);list($Vi,$M,$V,$l)=array_map('base64_decode',explode("-",$z));set_password($Vi,$M,$V,decrypt_string(base64_decode($fb),$ng));$_SESSION["db"][$Vi][$M][$V][$l]=true;}}function
unset_permanent(){global$bg;foreach($bg
as$z=>$X){list($Vi,$M,$V,$l)=array_map('base64_decode',explode("-",$z));if($Vi==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$l==DB)unset($bg[$z]);}cookie("adminer_permanent",implode(" ",$bg));}function
auth_error($n){global$b,$yd;$mh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$mh]||$_GET[$mh])&&!$yd)$n='Session expired, please login again.';else{restart_session();add_invalid_login();$F=get_password();if($F!==null){if($F===false)$n.=($n?'<br>':'').sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$mh]&&$_GET[$mh]&&ini_bool("session.use_only_cookies"))$n='Session support must be enabled.';$Of=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()),$Of["lifetime"]);page_header('Login',$n,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'The action will be performed after successful login with the same credentials.'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists("Min_DB")){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('No extension',sprintf('None of the supported PHP extensions (%s) are available.',implode(", ",$hg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Dd,$dg)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$dg,$C)&&($C[1]<1024||$C[1]>65535))auth_error('Connecting to privileged ports is not allowed.');check_invalid_login();$g=connect();$m=new
Min_Driver($g);}$xe=null;if(!is_object($g)||($xe=$b->login($_GET["username"],get_password()))!==true){$n=(is_string($g)?h($g):(is_string($xe)?$xe:'Invalid credentials.'));auth_error($n.(preg_match('~^ | $~',get_password())?'<br>'.'There is a space in the input password which might be the cause.':''));}if($_POST["logout"]&&$yd&&!verify_token()){page_header('Logout','Invalid CSRF token. Send the form again.');page_footer("db");exit;}if($Ia&&$_POST["token"])$_POST["token"]=$ni;$n='';if($_POST){if(!verify_token()){$Sd="max_input_vars";$Ie=ini_get($Sd);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$z){$X=ini_get($z);if($X&&(!$Ie||$X<$Ie)){$Sd=$z;$Ie=$X;}}}$n=(!$_POST["token"]&&$Ie?sprintf('Maximum number of allowed fields exceeded. Please increase %s.',"'$Sd'"):'Invalid CSRF token. Send the form again.'.' '.'If you did not send this request from Adminer then close this page.');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$n=sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.',"'post_max_size'");if(isset($_GET["sql"]))$n.=' '.'You can upload a big SQL file via FTP and import it from server.';}function
select($H,$h=null,$Bf=array(),$_=0){global$y;$we=array();$x=array();$f=array();$Sa=array();$U=array();$I=array();odd('');for($t=0;(!$_||$t<$_)&&($J=$H->fetch_row());$t++){if(!$t){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr>";for($ee=0;$ee<count($J);$ee++){$o=$H->fetch_field();$D=$o->name;$Af=$o->orgtable;$_f=$o->orgname;$I[$o->table]=$Af;if($Bf&&$y=="sql")$we[$ee]=($D=="table"?"table=":($D=="possible_keys"?"indexes=":null));elseif($Af!=""){if(!isset($x[$Af])){$x[$Af]=array();foreach(indexes($Af,$h)as$w){if($w["type"]=="PRIMARY"){$x[$Af]=array_flip($w["columns"]);break;}}$f[$Af]=$x[$Af];}if(isset($f[$Af][$_f])){unset($f[$Af][$_f]);$x[$Af][$_f]=$ee;$we[$ee]=$Af;}}if($o->charsetnr==63)$Sa[$ee]=true;$U[$ee]=$o->type;echo"<th".($Af!=""||$o->name!=$_f?" title='".h(($Af!=""?"$Af.":"").$_f)."'":"").">".h($D).($Bf?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($D),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr".odd().">";foreach($J
as$z=>$X){$A="";if(isset($we[$z])&&!$f[$we[$z]]){if($Bf&&$y=="sql"){$Q=$J[array_search("table=",$we)];$A=ME.$we[$z].urlencode($Bf[$Q]!=""?$Bf[$Q]:$Q);}else{$A=ME."edit=".urlencode($we[$z]);foreach($x[$we[$z]]as$jb=>$ee)$A.="&where".urlencode("[".bracket_escape($jb)."]")."=".urlencode($J[$ee]);}}elseif(is_url($X))$A=$X;if($X===null)$X="<i>NULL</i>";elseif($Sa[$z]&&!is_utf8($X))$X="<i>".lang(array('%d byte','%d bytes'),strlen($X))."</i>";else{$X=h($X);if($U[$z]==254)$X="<code>$X</code>";}if($A)$X="<a href='".h($A)."'".(is_url($A)?target_blank():'').">$X</a>";echo"<td>$X";}}echo($t?"</table>\n</div>":"<p class='message'>".'No rows.')."\n";return$I;}function
referencable_primary($fh){$I=array();foreach(table_status('',true)as$Oh=>$Q){if($Oh!=$fh&&fk_support($Q)){foreach(fields($Oh)as$o){if($o["primary"]){if($I[$Oh]){unset($I[$Oh]);break;}$I[$Oh]=$o;}}}}return$I;}function
adminer_settings(){parse_str($_COOKIE["adminer_settings"],$oh);return$oh;}function
adminer_setting($z){$oh=adminer_settings();return$oh[$z];}function
set_adminer_settings($oh){return
cookie("adminer_settings",http_build_query($oh+adminer_settings()));}function
textarea($D,$Y,$K=10,$nb=80){global$y;echo"<textarea name='$D' rows='$K' cols='$nb' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
edit_type($z,$o,$lb,$hd=array(),$Pc=array()){global$Gh,$U,$Hi,$pf;$T=$o["type"];echo'<td><select name="',h($z),'[type]" class="type" aria-labelledby="label-type">';if($T&&!isset($U[$T])&&!isset($hd[$T])&&!in_array($T,$Pc))$Pc[]=$T;if($hd)$Gh['Foreign keys']=$hd;echo
optionlist(array_merge($Pc,$Gh),$T),'</select><td><input name="',h($z),'[length]" value="',h($o["length"]),'" size="3"',(!$o["length"]&&preg_match('~var(char|binary)$~',$T)?" class='required'":"");echo' aria-labelledby="label-length"><td class="options">',"<select name='".h($z)."[collation]'".(preg_match('~(char|text|enum|set)$~',$T)?"":" class='hidden'").'><option value="">('.'collation'.')'.optionlist($lb,$o["collation"]).'</select>',($Hi?"<select name='".h($z)."[unsigned]'".(!$T||preg_match(number_type(),$T)?"":" class='hidden'").'><option>'.optionlist($Hi,$o["unsigned"]).'</select>':''),(isset($o['on_update'])?"<select name='".h($z)."[on_update]'".(preg_match('~timestamp|datetime~',$T)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?"CURRENT_TIMESTAMP":$o["on_update"])).'</select>':''),($hd?"<select name='".h($z)."[on_delete]'".(preg_match("~`~",$T)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$pf),$o["on_delete"])."</select> ":" ");}function
process_length($te){global$_c;return(preg_match("~^\\s*\\(?\\s*$_c(?:\\s*,\\s*$_c)*+\\s*\\)?\\s*\$~",$te)&&preg_match_all("~$_c~",$te,$Ce)?"(".implode(",",$Ce[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$te)));}function
process_type($o,$kb="COLLATE"){global$Hi;return" $o[type]".process_length($o["length"]).(preg_match(number_type(),$o["type"])&&in_array($o["unsigned"],$Hi)?" $o[unsigned]":"").(preg_match('~char|text|enum|set~',$o["type"])&&$o["collation"]?" $kb ".q($o["collation"]):"");}function
process_field($o,$_i){return
array(idf_escape(trim($o["field"])),process_type($_i),($o["null"]?" NULL":" NOT NULL"),default_value($o),(preg_match('~timestamp|datetime~',$o["type"])&&$o["on_update"]?" ON UPDATE $o[on_update]":""),(support("comment")&&$o["comment"]!=""?" COMMENT ".q($o["comment"]):""),($o["auto_increment"]?auto_increment():null),);}function
default_value($o){$Wb=$o["default"];return($Wb===null?"":" DEFAULT ".(preg_match('~char|binary|text|enum|set~',$o["type"])||preg_match('~^(?![a-z])~i',$Wb)?q($Wb):$Wb));}function
type_class($T){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$z=>$X){if(preg_match("~$z|$X~",$T))return" class='$z'";}}function
edit_fields($p,$lb,$T="TABLE",$hd=array()){global$Td;$p=array_values($p);$Xb=(($_POST?$_POST["defaults"]:adminer_setting("defaults"))?"":" class='hidden'");$sb=(($_POST?$_POST["comments"]:adminer_setting("comments"))?"":" class='hidden'");echo'<thead><tr>
';if($T=="PROCEDURE"){echo'<td>';}echo'<th id="label-name">',($T=="TABLE"?'Column name':'Parameter name'),'<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">Length
<td>','Options';if($T=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="Auto Increment">AI</acronym>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype.html#DATATYPE-SERIAL",'mssql'=>"ms186775.aspx",)),'<td id="label-default"',$Xb,'>Default value
',(support("comment")?"<td id='label-comment'$sb>".'Comment':"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($p))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".'Add next'."'>".script("row_count = ".count($p).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($p
as$t=>$o){$t++;$Cf=$o[($_POST?"orig":"field")];$fc=(isset($_POST["add"][$t-1])||(isset($o["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$Cf=="");echo'<tr',($fc?"":" style='display: none;'"),'>
',($T=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$Td),$o["inout"]):""),'<th>';if($fc){echo'<input name="fields[',$t,'][field]" value="',h($o["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';}echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($Cf),'">';edit_type("fields[$t]",$o,$lb,$hd);if($T=="TABLE"){echo'<td>',checkbox("fields[$t][null]",1,$o["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"';if($o["auto_increment"]){echo' checked';}echo' aria-labelledby="label-ai"></label><td',$Xb,'>',checkbox("fields[$t][has_default]",1,$o["has_default"],"","","","label-default"),'<input name="fields[',$t,'][default]" value="',h($o["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td$sb><input name='fields[$t][comment]' value='".h($o["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".'Add next'."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=4.8.1")."' alt='?? title='".'Move up'."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=4.8.1")."' alt='?? title='".'Move down'."'> ":""),($Cf==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.8.1")."' alt='x' title='".'Remove'."'>":"");}}function
process_fields(&$p){$hf=0;if($_POST["up"]){$ne=0;foreach($p
as$z=>$o){if(key($_POST["up"])==$z){unset($p[$z]);array_splice($p,$ne,0,array($o));break;}if(isset($o["field"]))$ne=$hf;$hf++;}}elseif($_POST["down"]){$jd=false;foreach($p
as$z=>$o){if(isset($o["field"])&&$jd){unset($p[key($_POST["down"])]);array_splice($p,$hf,0,array($jd));break;}if(key($_POST["down"])==$z)$jd=$o;$hf++;}}elseif($_POST["add"]){$p=array_values($p);array_splice($p,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($C){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($C[0][0].$C[0][0],$C[0][0],substr($C[0],1,-1))),'\\'))."'";}function
grant($od,$pg,$f,$of){if(!$pg)return
true;if($pg==array("ALL PRIVILEGES","GRANT OPTION"))return($od=="GRANT"?queries("$od ALL PRIVILEGES$of WITH GRANT OPTION"):queries("$od ALL PRIVILEGES$of")&&queries("$od GRANT OPTION$of"));return
queries("$od ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$f, ",$pg).$f).$of);}function
drop_create($jc,$i,$kc,$ai,$mc,$B,$Ne,$Le,$Me,$lf,$Ye){if($_POST["drop"])query_redirect($jc,$B,$Ne);elseif($lf=="")query_redirect($i,$B,$Me);elseif($lf!=$Ye){$Jb=queries($i);queries_redirect($B,$Le,$Jb&&queries($jc));if($Jb)queries($kc);}else
queries_redirect($B,$Le,queries($ai)&&queries($mc)&&queries($jc)&&queries($i));}function
create_trigger($of,$J){global$y;$fi=" $J[Timing] $J[Event]".(preg_match('~ OF~',$J["Event"])?" $J[Of]":"");return"CREATE TRIGGER ".idf_escape($J["Trigger"]).($y=="mssql"?$of.$fi:$fi.$of).rtrim(" $J[Type]\n$J[Statement]",";").";";}function
create_routine($Tg,$J){global$Td,$y;$N=array();$p=(array)$J["fields"];ksort($p);foreach($p
as$o){if($o["field"]!="")$N[]=(preg_match("~^($Td)\$~",$o["inout"])?"$o[inout] ":"").idf_escape($o["field"]).process_type($o,"CHARACTER SET");}$Yb=rtrim("\n$J[definition]",";");return"CREATE $Tg ".idf_escape(trim($J["name"]))." (".implode(", ",$N).")".(isset($_GET["function"])?" RETURNS".process_type($J["returns"],"CHARACTER SET"):"").($J["language"]?" LANGUAGE $J[language]":"").($y=="pgsql"?" AS ".q($Yb):"$Yb;");}function
remove_definer($G){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$G);}function
format_foreign_key($r){global$pf;$l=$r["db"];$cf=$r["ns"];return" FOREIGN KEY (".implode(", ",array_map('idf_escape',$r["source"])).") REFERENCES ".($l!=""&&$l!=$_GET["db"]?idf_escape($l).".":"").($cf!=""&&$cf!=$_GET["ns"]?idf_escape($cf).".":"").table($r["table"])." (".implode(", ",array_map('idf_escape',$r["target"])).")".(preg_match("~^($pf)\$~",$r["on_delete"])?" ON DELETE $r[on_delete]":"").(preg_match("~^($pf)\$~",$r["on_update"])?" ON UPDATE $r[on_update]":"");}function
tar_file($q,$ki){$I=pack("a100a8a8a8a12a12",$q,644,0,0,decoct($ki->size),decoct(time()));$eb=8*32;for($t=0;$t<strlen($I);$t++)$eb+=ord($I[$t]);$I.=sprintf("%06o",$eb)."\0 ";echo$I,str_repeat("\0",512-strlen($I));$ki->send();echo
str_repeat("\0",511-($ki->size+511)%512);}function
ini_bytes($Sd){$X=ini_get($Sd);switch(strtolower(substr($X,-1))){case'g':$X*=1024;case'm':$X*=1024;case'k':$X*=1024;}return$X;}function
doc_link($Yf,$bi="<sup>?</sup>"){global$y,$g;$kh=$g->server_info;$Wi=preg_replace('~^(\d\.?\d).*~s','\1',$kh);$Li=array('sql'=>"https://dev.mysql.com/doc/refman/$Wi/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$Wi/",'mssql'=>"https://msdn.microsoft.com/library/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$kh)."&id=",);if(preg_match('~MariaDB~',$kh)){$Li['sql']="https://mariadb.com/kb/en/library/";$Yf['sql']=(isset($Yf['mariadb'])?$Yf['mariadb']:str_replace(".html","/",$Yf['sql']));}return($Yf[$y]?"<a href='".h($Li[$y].$Yf[$y])."'".target_blank().">$bi</a>":"");}function
ob_gzencode($P){return
gzencode($P);}function
db_size($l){global$g;if(!$g->select_db($l))return"?";$I=0;foreach(table_status()as$R)$I+=$R["Data_length"]+$R["Index_length"];return
format_number($I);}function
set_utf8mb4($i){global$g;static$N=false;if(!$N&&preg_match('~\butf8mb4~i',$i)){$N=true;echo"SET NAMES ".charset($g).";\n\n";}}function
connect_error(){global$b,$g,$ni,$n,$ic;if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('Database'.": ".h(DB),'Invalid database.',true);}else{if($_POST["db"]&&!$n)queries_redirect(substr(ME,0,-1),'Databases have been dropped.',drop_databases($_POST["db"]));page_header('Select database',$n,false);echo"<p class='links'>\n";foreach(array('database'=>'Create database','privileges'=>'Privileges','processlist'=>'Process list','variables'=>'Variables','status'=>'Status',)as$z=>$X){if(support($z))echo"<a href='".h(ME)."$z='>$X</a>\n";}echo"<p>".sprintf('%s version: %s through PHP extension %s',$ic[DRIVER],"<b>".h($g->server_info)."</b>","<b>$g->extension</b>")."\n","<p>".sprintf('Logged as: %s',"<b>".h(logged_user())."</b>")."\n";$k=$b->databases();if($k){$ah=support("scheme");$lb=collations();echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'Database'." - <a href='".h(ME)."refresh=1'>".'Refresh'."</a>"."<td>".'Collation'."<td>".'Tables'."<td>".'Size'." - <a href='".h(ME)."dbsize=1'>".'Compute'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$k=($_GET["dbsize"]?count_tables($k):array_flip($k));foreach($k
as$l=>$S){$Sg=h(ME)."db=".urlencode($l);$u=h("Db-".$l);echo"<tr".odd().">".(support("database")?"<td>".checkbox("db[]",$l,in_array($l,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$Sg' id='$u'>".h($l)."</a>";$d=h(db_collation($l,$lb));echo"<td>".(support("database")?"<a href='$Sg".($ah?"&amp;ns=":"")."&amp;database=' title='".'Alter database'."'>$d</a>":$d),"<td align='right'><a href='$Sg&amp;schema=' id='tables-".h($l)."' title='".'Database schema'."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($l)."'>".($_GET["dbsize"]?db_size($l):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'Drop'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$ni'>\n","</form>\n",script("tableCheck();");}}page_footer("db");}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$g->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}connect_error();exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('Schema'.": ".h($_GET["ns"]),'Invalid schema.',true);page_footer("ns");exit;}}}$pf="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($Cb){$this->size+=strlen($Cb);fwrite($this->handler,$Cb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}$_c="'(?:''|[^'\\\\]|\\\\.)*'";$Td="IN|OUT|INOUT";if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$p=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$m->select($a,$L,array(where($_GET,$p)),$L);$J=($H?$H->fetch_row():array());echo$m->value($J[0],$p[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$p=fields($a);if(!$p)$n=error();$R=table_status1($a,true);$D=$b->tableName($R);page_header(($p&&is_view($R)?$R['Engine']=='materialized view'?'Materialized view':'View':'Table').": ".($D!=""?$D:h($a)),$n);$b->selectLinks($R);$rb=$R["Comment"];if($rb!="")echo"<p class='nowrap'>".'Comment'.": ".h($rb)."\n";if($p)$b->tableStructurePrint($p);if(!is_view($R)){if(support("indexes")){echo"<h3 id='indexes'>".'Indexes'."</h3>\n";$x=indexes($a);if($x)$b->tableIndexesPrint($x);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'Alter indexes'."</a>\n";}if(fk_support($R)){echo"<h3 id='foreign-keys'>".'Foreign keys'."</h3>\n";$hd=foreign_keys($a);if($hd){echo"<table cellspacing='0'>\n","<thead><tr><th>".'Source'."<td>".'Target'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($hd
as$D=>$r){echo"<tr title='".h($D)."'>","<th><i>".implode("</i>, <i>",array_map('h',$r["source"]))."</i>","<td><a href='".h($r["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($r["db"]),ME):($r["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($r["ns"]),ME):ME))."table=".urlencode($r["table"])."'>".($r["db"]!=""?"<b>".h($r["db"])."</b>.":"").($r["ns"]!=""?"<b>".h($r["ns"])."</b>.":"").h($r["table"])."</a>","(<i>".implode("</i>, <i>",array_map('h',$r["target"]))."</i>)","<td>".h($r["on_delete"])."\n","<td>".h($r["on_update"])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($D)).'">'.'Alter'.'</a>';}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'Add foreign key'."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'Triggers'."</h3>\n";$zi=triggers($a);if($zi){echo"<table cellspacing='0'>\n";foreach($zi
as$z=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($z)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($z))."'>".'Alter'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'Add trigger'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('Database schema',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Qh=array();$Rh=array();$ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Ce,PREG_SET_ORDER);foreach($Ce
as$t=>$C){$Qh[$C[1]]=array($C[2],$C[3]);$Rh[]="\n\t'".js_escape($C[1])."': [ $C[2], $C[3] ]";}$oi=0;$Pa=-1;$Zg=array();$Eg=array();$re=array();foreach(table_status('',true)as$Q=>$R){if(is_view($R))continue;$eg=0;$Zg[$Q]["fields"]=array();foreach(fields($Q)as$D=>$o){$eg+=1.25;$o["pos"]=$eg;$Zg[$Q]["fields"][$D]=$o;}$Zg[$Q]["pos"]=($Qh[$Q]?$Qh[$Q]:array($oi,0));foreach($b->foreignKeys($Q)as$X){if(!$X["db"]){$pe=$Pa;if($Qh[$Q][1]||$Qh[$X["table"]][1])$pe=min(floatval($Qh[$Q][1]),floatval($Qh[$X["table"]][1]))-1;else$Pa-=.1;while($re[(string)$pe])$pe-=.0001;$Zg[$Q]["references"][$X["table"]][(string)$pe]=array($X["source"],$X["target"]);$Eg[$X["table"]][$Q][(string)$pe]=$X["target"];$re[(string)$pe]=true;}}$oi=max($oi,$Zg[$Q]["pos"][0]+2.5+$eg);}echo'<div id="schema" style="height: ',$oi,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Rh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$oi,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($Zg
as$D=>$Q){echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($D).'"><b>'.h($D)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($Q["fields"]as$o){$X='<span'.type_class($o["type"]).' title="'.h($o["full_type"].($o["null"]?" NULL":'')).'">'.h($o["field"]).'</span>';echo"<br>".($o["primary"]?"<i>$X</i>":$X);}foreach((array)$Q["references"]as$Xh=>$Fg){foreach($Fg
as$pe=>$Bg){$qe=$pe-$Qh[$D][1];$t=0;foreach($Bg[0]as$vh)echo"\n<div class='references' title='".h($Xh)."' id='refs$pe-".($t++)."' style='left: $qe"."em; top: ".$Q["fields"][$vh]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$qe)."em;'></div></div>";}}foreach((array)$Eg[$D]as$Xh=>$Fg){foreach($Fg
as$pe=>$f){$qe=$pe-$Qh[$D][1];$t=0;foreach($f
as$Wh)echo"\n<div class='references' title='".h($Xh)."' id='refd$pe-".($t++)."' style='left: $qe"."em; top: ".$Q["fields"][$Wh]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=4.8.1")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$qe)."em;'></div></div>";}}echo"\n</div>\n";}foreach($Zg
as$D=>$Q){foreach((array)$Q["references"]as$Xh=>$Fg){foreach($Fg
as$pe=>$Bg){$Qe=$oi;$Ge=-10;foreach($Bg[0]as$z=>$vh){$fg=$Q["pos"][0]+$Q["fields"][$vh]["pos"];$gg=$Zg[$Xh]["pos"][0]+$Zg[$Xh]["fields"][$Bg[1][$z]]["pos"];$Qe=min($Qe,$fg,$gg);$Ge=max($Ge,$fg,$gg);}echo"<div class='references' id='refl$pe' style='left: $pe"."em; top: $Qe"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Ge-$Qe)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">Permanent link</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$n){$Fb="";foreach(array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$z)$Fb.="&$z=".urlencode($_POST[$z]);cookie("adminer_export",substr($Fb,1));$S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Mc=dump_headers((count($S)==1?key($S):DB),(DB==""||count($S)>1));$be=preg_match('~sql~',$_POST["format"]);if($be){echo"-- Adminer $ia ".$ic[DRIVER]." ".str_replace("\n"," ",$g->server_info)." dump\n\n";if($y=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$g->query("SET time_zone = '+00:00'");$g->query("SET sql_mode = ''");}}$Hh=$_POST["db_style"];$k=array(DB);if(DB==""){$k=$_POST["databases"];if(is_string($k))$k=explode("\n",rtrim(str_replace("\r","",$k),"\n"));}foreach((array)$k
as$l){$b->dumpDatabase($l);if($g->select_db($l)){if($be&&preg_match('~CREATE~',$Hh)&&($i=$g->result("SHOW CREATE DATABASE ".idf_escape($l),1))){set_utf8mb4($i);if($Hh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($l).";\n";echo"$i;\n";}if($be){if($Hh)echo
use_sql($l).";\n\n";$If="";if($_POST["routines"]){foreach(array("FUNCTION","PROCEDURE")as$Tg){foreach(get_rows("SHOW $Tg STATUS WHERE Db = ".q($l),null,"-- ")as$J){$i=remove_definer($g->result("SHOW CREATE $Tg ".idf_escape($J["Name"]),2));set_utf8mb4($i);$If.=($Hh!='DROP+CREATE'?"DROP $Tg IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$i;;\n\n";}}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$J){$i=remove_definer($g->result("SHOW CREATE EVENT ".idf_escape($J["Name"]),3));set_utf8mb4($i);$If.=($Hh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$i;;\n\n";}}if($If)echo"DELIMITER ;;\n\n$If"."DELIMITER ;\n\n";}if($_POST["table_style"]||$_POST["data_style"]){$Yi=array();foreach(table_status('',true)as$D=>$R){$Q=(DB==""||in_array($D,(array)$_POST["tables"]));$Pb=(DB==""||in_array($D,(array)$_POST["data"]));if($Q||$Pb){if($Mc=="tar"){$ki=new
TmpFile;ob_start(array($ki,'write'),1e5);}$b->dumpTable($D,($Q?$_POST["table_style"]:""),(is_view($R)?2:0));if(is_view($R))$Yi[]=$D;elseif($Pb){$p=fields($D);$b->dumpData($D,$_POST["data_style"],"SELECT *".convert_fields($p,$p)." FROM ".table($D));}if($be&&$_POST["triggers"]&&$Q&&($zi=trigger_sql($D)))echo"\nDELIMITER ;;\n$zi\nDELIMITER ;\n";if($Mc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$l/")."$D.csv",$ki);}elseif($be)echo"\n";}}if(function_exists('foreign_keys_sql')){foreach(table_status('',true)as$D=>$R){$Q=(DB==""||in_array($D,(array)$_POST["tables"]));if($Q&&!is_view($R))echo
foreign_keys_sql($D);}}foreach($Yi
as$Xi)$b->dumpTable($Xi,$_POST["table_style"],1);if($Mc=="tar")echo
pack("x512");}}}if($be)echo"-- ".$g->result("SELECT NOW()")."\n";exit;}page_header('Export',$n,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
';$Tb=array('','USE','DROP+CREATE','CREATE');$Sh=array('','DROP+CREATE','CREATE');$Qb=array('','TRUNCATE+INSERT','INSERT');if($y=="sql")$Qb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$J);if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".'Output'."<td>".html_select("output",$b->dumpOutput(),$J["output"],0)."\n";echo"<tr><th>".'Format'."<td>".html_select("format",$b->dumpFormat(),$J["format"],0)."\n";echo($y=="sqlite"?"":"<tr><th>".'Database'."<td>".html_select('db_style',$Tb,$J["db_style"]).(support("routine")?checkbox("routines",1,$J["routines"],'Routines'):"").(support("event")?checkbox("events",1,$J["events"],'Events'):"")),"<tr><th>".'Tables'."<td>".html_select('table_style',$Sh,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],'Auto Increment').(support("trigger")?checkbox("triggers",1,$J["triggers"],'Triggers'):""),"<tr><th>".'Data'."<td>".html_select('data_style',$Qb,$J["data_style"]),'</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="',$ni,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");$jg=array();if(DB!=""){$cb=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$cb>".'Tables'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'Data'."<input type='checkbox' id='check-data'$cb></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$Yi="";$Th=tables_list();foreach($Th
as$D=>$T){$ig=preg_replace('~_.*~','',$D);$cb=($a==""||$a==(substr($a,-1)=="%"?"$ig%":$D));$mg="<tr><td>".checkbox("tables[]",$D,$cb,$D,"","block");if($T!==null&&!preg_match('~table~i',$T))$Yi.="$mg\n";else
echo"$mg<td align='right'><label class='block'><span id='Rows-".h($D)."'></span>".checkbox("data[]",$D,$cb)."</label>\n";$jg[$ig]++;}echo$Yi;if($Th)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'Database'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$k=$b->databases();if($k){foreach($k
as$l){if(!information_schema($l)){$ig=preg_replace('~_.*~','',$l);echo"<tr><td>".checkbox("databases[]",$l,$a==""||$a=="$ig%",$l,"","block")."\n";$jg[$ig]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$Zc=true;foreach($jg
as$z=>$X){if($z!=""&&$X>1){echo($Zc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$z%")."'>".h($z)."</a>";$Zc=false;}}}elseif(isset($_GET["privileges"])){page_header('Privileges');echo'<p class="links"><a href="'.h(ME).'user=">'.'Create user'."</a>";$H=$g->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$od=$H;if(!$H)$H=$g->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($od?"":"<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>".'Username'."<th>".'Server'."<th></thead>\n";while($J=$H->fetch_assoc())echo'<tr'.odd().'><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.'Edit'."</a>\n";if(!$od||DB!="")echo"<tr".odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'Edit'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$n&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$Bd=&get_session("queries");$Ad=&$Bd[DB];if(!$n&&$_POST["clear"]){$Ad=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'Import':'SQL command'),$n);if(!$n&&$_POST){$ld=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$zh=$b->importServerPath();$ld=@fopen((file_exists($zh)?$zh:"compress.zlib://$zh.gz"),"rb");$G=($ld?fread($ld,1e6):false);}else$G=get_file("sql_file",true);if(is_string($G)){if(function_exists('memory_get_usage'))@ini_set("memory_limit",max(ini_bytes("memory_limit"),2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$ug=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$Ad||reset(end($Ad))!=$ug){restart_session();$Ad[]=array($ug,time());set_session("queries",$Bd);stop_session();}}$wh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$ac=";";$hf=0;$xc=true;$h=connect();if(is_object($h)&&DB!=""){$h->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$h);}$qb=0;$Bc=array();$Pf='[\'"'.($y=="sql"?'`#':($y=="sqlite"?'`[':($y=="mssql"?'[':''))).']|/\*|-- |$'.($y=="pgsql"?'|\$[^$]*\$':'');$pi=microtime(true);parse_str($_COOKIE["adminer_export"],$xa);$oc=$b->dumpFormat();unset($oc["sql"]);while($G!=""){if(!$hf&&preg_match("~^$wh*+DELIMITER\\s+(\\S+)~i",$G,$C)){$ac=$C[1];$G=substr($G,strlen($C[0]));}else{preg_match('('.preg_quote($ac)."\\s*|$Pf)",$G,$C,PREG_OFFSET_CAPTURE,$hf);list($jd,$eg)=$C[0];if(!$jd&&$ld&&!feof($ld))$G.=fread($ld,1e5);else{if(!$jd&&rtrim($G)=="")break;$hf=$eg+strlen($jd);if($jd&&rtrim($jd)!=$ac){while(preg_match('('.($jd=='/*'?'\*/':($jd=='['?']':(preg_match('~^-- |^#~',$jd)?"\n":preg_quote($jd)."|\\\\."))).'|$)s',$G,$C,PREG_OFFSET_CAPTURE,$hf)){$Xg=$C[0][0];if(!$Xg&&$ld&&!feof($ld))$G.=fread($ld,1e5);else{$hf=$C[0][1]+strlen($Xg);if($Xg[0]!="\\")break;}}}else{$xc=false;$ug=substr($G,0,$eg);$qb++;$mg="<pre id='sql-$qb'><code class='jush-$y'>".$b->sqlCommandQuery($ug)."</code></pre>\n";if($y=="sqlite"&&preg_match("~^$wh*+ATTACH\\b~i",$ug,$C)){echo$mg,"<p class='error'>".'ATTACH queries are not supported.'."\n";$Bc[]=" <a href='#sql-$qb'>$qb</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$mg;ob_flush();flush();}$Ch=microtime(true);if($g->multi_query($ug)&&is_object($h)&&preg_match("~^$wh*+USE\\b~i",$ug))$h->query($ug);do{$H=$g->store_result();if($g->error){echo($_POST["only_errors"]?$mg:""),"<p class='error'>".'Error in query'.($g->errno?" ($g->errno)":"").": ".error()."\n";$Bc[]=" <a href='#sql-$qb'>$qb</a>";if($_POST["error_stops"])break
2;}else{$di=" <span class='time'>(".format_time($Ch).")</span>".(strlen($ug)<1000?" <a href='".h(ME)."sql=".urlencode(trim($ug))."'>".'Edit'."</a>":"");$za=$g->affected_rows;$bj=($_POST["only_errors"]?"":$m->warnings());$cj="warnings-$qb";if($bj)$di.=", <a href='#$cj'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$cj');","");$Jc=null;$Kc="explain-$qb";if(is_object($H)){$_=$_POST["limit"];$Bf=select($H,$h,array(),$_);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$df=$H->num_rows;echo"<p>".($df?($_&&$df>$_?sprintf('%d / ',$_):"").lang(array('%d row','%d rows'),$df):""),$di;if($h&&preg_match("~^($wh|\\()*+SELECT\\b~i",$ug)&&($Jc=explain($h,$ug)))echo", <a href='#$Kc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Kc');","");$u="export-$qb";echo", <a href='#$u'>".'Export'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$xa["output"])." ".html_select("format",$oc,$xa["format"])."<input type='hidden' name='query' value='".h($ug)."'>"." <input type='submit' name='export' value='".'Export'."'><input type='hidden' name='token' value='$ni'></span>\n"."</form>\n";}}else{if(preg_match("~^$wh*+(CREATE|DROP|ALTER)$wh++(DATABASE|SCHEMA)\\b~i",$ug)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($g->info)."'>".lang(array('Query executed OK, %d row affected.','Query executed OK, %d rows affected.'),$za)."$di\n";}echo($bj?"<div id='$cj' class='hidden'>\n$bj</div>\n":"");if($Jc){echo"<div id='$Kc' class='hidden'>\n";select($Jc,$h,$Bf);echo"</div>\n";}}$Ch=microtime(true);}while($g->next_result());}$G=substr($G,$hf);$hf=0;}}}}if($xc)echo"<p class='message'>".'No commands to execute.'."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".lang(array('%d query executed OK.','%d queries executed OK.'),$qb-count($Bc))," <span class='time'>(".format_time($pi).")</span>\n";}elseif($Bc&&$qb>1)echo"<p class='error'>".'Error in query'.": ".implode("",$Bc)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Hc="<input type='submit' value='".'Execute'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$ug=$_GET["sql"];if($_POST)$ug=$_POST["query"];elseif($_GET["history"]=="all")$ug=$Ad;elseif($_GET["history"]!="")$ug=$Ad[$_GET["history"]][0];echo"<p>";textarea("query",$ug,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>$Hc\n",'Limit rows'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'File upload'."</legend><div>";$ud=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$ud (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Hc":'File uploads are disabled.'),"</div></fieldset>\n";$Id=$b->importServerPath();if($Id){echo"<fieldset><legend>".'From server'."</legend><div>",sprintf('Webserver file %s',"<code>".h($Id)."$ud</code>"),' <input type="submit" name="webfile" value="'.'Run file'.'">',"</div></fieldset>\n";}echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),'Stop on error')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),'Show only errors')."\n","<input type='hidden' name='token' value='$ni'>\n";if(!isset($_GET["import"])&&$Ad){print_fieldset("history",'History',$_GET["history"]!="");for($X=end($Ad);$X;$X=prev($Ad)){$z=key($Ad);list($ug,$di,$sc)=$X;echo'<a href="'.h(ME."sql=&history=$z").'">'.'Edit'."</a>"." <span class='time' title='".@date('Y-m-d',$di)."'>".@date("H:i:s",$di)."</span>"." <code class='jush-$y'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$ug)))),80,"</code>").($sc?" <span class='time'>($sc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'Clear'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'Edit all'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$p=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$p):""):where($_GET,$p));$Ii=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($p
as$D=>$o){if(!isset($o["privileges"][$Ii?"update":"insert"])||$b->fieldName($o)==""||$o["generated"])unset($p[$D]);}if($_POST&&!$n&&!isset($_GET["select"])){$B=$_POST["referer"];if($_POST["insert"])$B=($Ii?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$B))$B=ME."select=".urlencode($a);$x=indexes($a);$Di=unique_array($_GET["where"],$x);$xg="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($B,'Item has been deleted.',$m->delete($a,$xg,!$Di));else{$N=array();foreach($p
as$D=>$o){$X=process_input($o);if($X!==false&&$X!==null)$N[idf_escape($D)]=$X;}if($Ii){if(!$N)redirect($B);queries_redirect($B,'Item has been updated.',$m->update($a,$N,$xg,!$Di));if(is_ajax()){page_headers();page_messages($n);exit;}}else{$H=$m->insert($a,$N);$oe=($H?last_id():0);queries_redirect($B,sprintf('Item%s has been inserted.',($oe?" $oe":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($p
as$D=>$o){if(isset($o["privileges"]["select"])){$Fa=convert_field($o);if($_POST["clone"]&&$o["auto_increment"])$Fa="''";if($y=="sql"&&preg_match("~enum|set~",$o["type"]))$Fa="1*".idf_escape($D);$L[]=($Fa?"$Fa AS ":"").idf_escape($D);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$m->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$n=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$p){if(!$Z){$H=$m->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($m->primary=>"");}if($J){foreach($J
as$z=>$X){if(!$Z)$J[$z]=null;$p[$z]=array("field"=>$z,"null"=>($z!=$m->primary),"auto_increment"=>($z==$m->primary));}}}edit_form($a,$p,$J,$Ii);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Rf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$z)$Rf[$z]=$z;$Dg=referencable_primary($a);$hd=array();foreach($Dg
as$Oh=>$o)$hd[str_replace("`","``",$Oh)."`".str_replace("`","``",$o["field"])]=$Oh;$Ef=array();$R=array();if($a!=""){$Ef=fields($a);$R=table_status($a);if(!$R)$n='No tables.';}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST)set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($J["fields"])&&!$n){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'Table has been dropped.',drop_tables(array($a)));else{$p=array();$Ca=array();$Mi=false;$fd=array();$Df=reset($Ef);$Aa=" FIRST";foreach($J["fields"]as$z=>$o){$r=$hd[$o["type"]];$_i=($r!==null?$Dg[$r]:$o);if($o["field"]!=""){if(!$o["has_default"])$o["default"]=null;if($z==$J["auto_increment_col"])$o["auto_increment"]=true;$rg=process_field($o,$_i);$Ca[]=array($o["orig"],$rg,$Aa);if(!$Df||$rg!=process_field($Df,$Df)){$p[]=array($o["orig"],$rg,$Aa);if($o["orig"]!=""||$Aa)$Mi=true;}if($r!==null)$fd[idf_escape($o["field"])]=($a!=""&&$y!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$hd[$o["type"]],'source'=>array($o["field"]),'target'=>array($_i["field"]),'on_delete'=>$o["on_delete"],));$Aa=" AFTER ".idf_escape($o["field"]);}elseif($o["orig"]!=""){$Mi=true;$p[]=array($o["orig"]);}if($o["orig"]!=""){$Df=next($Ef);if(!$Df)$Aa="";}}$Tf="";if($Rf[$J["partition_by"]]){$Uf=array();if($J["partition_by"]=='RANGE'||$J["partition_by"]=='LIST'){foreach(array_filter($J["partition_names"])as$z=>$X){$Y=$J["partition_values"][$z];$Uf[]="\n  PARTITION ".idf_escape($X)." VALUES ".($J["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Tf.="\nPARTITION BY $J[partition_by]($J[partition])".($Uf?" (".implode(",",$Uf)."\n)":($J["partitions"]?" PARTITIONS ".(+$J["partitions"]):""));}elseif(support("partitioning")&&preg_match("~partitioned~",$R["Create_options"]))$Tf.="\nREMOVE PARTITIONING";$Ke='Table has been altered.';if($a==""){cookie("adminer_engine",$J["Engine"]);$Ke='Table has been created.';}$D=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($D),$Ke,alter_table($a,$D,($y=="sqlite"&&($Mi||$fd)?$Ca:$p),$fd,($J["Comment"]!=$R["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$R["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$R["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$Tf));}}page_header(($a!=""?'Alter table':'Create table'),$n,array("table"=>$a),h($a));if(!$_POST){$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($U["int"])?"int":(isset($U["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$R;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($Ef
as$o){$o["has_default"]=isset($o["default"]);$J["fields"][]=$o;}if(support("partitioning")){$md="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($a);$H=$g->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $md ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");list($J["partition_by"],$J["partitions"],$J["partition"])=$H->fetch_row();$Uf=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $md AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$Uf[""]="";$J["partition_names"]=array_keys($Uf);$J["partition_values"]=array_values($Uf);}}}$lb=collations();$zc=engines();foreach($zc
as$yc){if(!strcasecmp($yc,$J["Engine"])){$J["Engine"]=$yc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'Table name: <input name="name" data-maxlength="64" value="',h($J["name"]),'" autocapitalize="off">
';if($a==""&&!$_POST)echo
script("focus(qs('#form')['name']);");echo($zc?"<select name='Engine'>".optionlist(array(""=>"(".'engine'.")")+$zc,$J["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($lb&&!preg_match("~sqlite|mssql~",$y)?html_select("Collation",array(""=>"(".'collation'.")")+$lb,$J["Collation"]):""),' <input type="submit" value="Save">
';}echo'
';if(support("columns")){echo'<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';edit_fields($J["fields"],$lb,"TABLE",$hd);echo'</table>
',script("editFields();"),'</div>
<p>
Auto Increment: <input type="number" name="Auto_increment" size="6" value="',h($J["Auto_increment"]),'">
',checkbox("defaults",1,($_POST?$_POST["defaults"]:adminer_setting("defaults")),'Default values',"columnShow(this.checked, 5)","jsonly"),(support("comment")?checkbox("comments",1,($_POST?$_POST["comments"]:adminer_setting("comments")),'Comment',"editingCommentsClick(this, true);","jsonly").' <input name="Comment" value="'.h($J["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'">':''),'<p>
<input type="submit" value="Save">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));}if(support("partitioning")){$Sf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",'Partition by',$J["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Rf,$J["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($J["partition"]),'">)
Partitions: <input type="number" name="partitions" class="size',($Sf||!$J["partition_by"]?" hidden":""),'" value="',h($J["partitions"]),'">
<table cellspacing="0" id="partition-table"',($Sf?"":" class='hidden'"),'>
<thead><tr><th>Partition name<th>Values</thead>
';foreach($J["partition_names"]as$z=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($z==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$z]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Ld=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Ld[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Ld[]="SPATIAL";$x=indexes($a);$kg=array();if($y=="mongo"){$kg=$x["_id_"];unset($Ld[0]);unset($x["_id_"]);}$J=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$w){$D=$w["name"];if(in_array($w["type"],$Ld)){$f=array();$ue=array();$cc=array();$N=array();ksort($w["columns"]);foreach($w["columns"]as$z=>$e){if($e!=""){$te=$w["lengths"][$z];$bc=$w["descs"][$z];$N[]=idf_escape($e).($te?"(".(+$te).")":"").($bc?" DESC":"");$f[]=$e;$ue[]=($te?$te:null);$cc[]=$bc;}}if($f){$Ic=$x[$D];if($Ic){ksort($Ic["columns"]);ksort($Ic["lengths"]);ksort($Ic["descs"]);if($w["type"]==$Ic["type"]&&array_values($Ic["columns"])===$f&&(!$Ic["lengths"]||array_values($Ic["lengths"])===$ue)&&array_values($Ic["descs"])===$cc){unset($x[$D]);continue;}}$c[]=array($w["type"],$D,$N);}}}foreach($x
as$D=>$Ic)$c[]=array($Ic["type"],$D,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'Indexes have been altered.',alter_indexes($a,$c));}page_header('Indexes',$n,array("table"=>$a),h($a));$p=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$z=>$w){if($w["columns"][count($w["columns"])]!="")$J["indexes"][$z]["columns"][]="";}$w=end($J["indexes"]);if($w["type"]||array_filter($w["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($x
as$z=>$w){$x[$z]["name"]=$z;$x[$z]["columns"][]="";}$x[]=array("columns"=>array(1=>""));$J["indexes"]=$x;}echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">Column (length)
<th id="label-name">Name
<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".'Add next'."'>",'</noscript>
</thead>
';if($kg){echo"<tr><td>PRIMARY<td>";foreach($kg["columns"]as$z=>$e){echo
select_input(" disabled",$p,$e),"<label><input disabled type='checkbox'>".'descending'."</label> ";}echo"<td><td>\n";}$ee=1;foreach($J["indexes"]as$w){if(!$_POST["drop_col"]||$ee!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ee][type]",array(-1=>"")+$Ld,$w["type"],($ee==count($J["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($w["columns"]);$t=1;foreach($w["columns"]as$z=>$e){echo"<span>".select_input(" name='indexes[$ee][columns][$t]' title='".'Column'."'",($p?array_combine($p,$p):$p),$e,"partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($y=="sql"?"":$_GET["indexes"]."_")."')"),($y=="sql"||$y=="mssql"?"<input type='number' name='indexes[$ee][lengths][$t]' class='size' value='".h($w["lengths"][$z])."' title='".'Length'."'>":""),(support("descidx")?checkbox("indexes[$ee][descs][$t]",1,$w["descs"][$z],'descending'):"")," </span>";$t++;}echo"<td><input name='indexes[$ee][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$ee]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.8.1")."' alt='x' title='".'Remove'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ee++;}echo'</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$n&&!isset($_POST["add_x"])){$D=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'Database has been dropped.',drop_databases(array(DB)));}elseif(DB!==$D){if(DB!=""){$_GET["db"]=$D;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($D),'Database has been renamed.',rename_database($D,$J["collation"]));}else{$k=explode("\n",str_replace("\r","",$D));$Ih=true;$ne="";foreach($k
as$l){if(count($k)==1||$l!=""){if(!create_database($l,$J["collation"]))$Ih=false;$ne=$l;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($ne),'Database has been created.',$Ih);}}else{if(!$J["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($D).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),'Database has been altered.');}}page_header(DB!=""?'Alter database':'Create database',$n,array(),h(DB));$lb=collations();$D=DB;if($_POST)$D=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$lb);elseif($y=="sql"){foreach(get_vals("SHOW GRANTS")as$od){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$od,$C)&&$C[1]){$D=stripcslashes(idf_unescape("`$C[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($D,"\n")?'<textarea id="name" name="name" rows="10" cols="40">'.h($D).'</textarea><br>':'<input name="name" id="name" value="'.h($D).'" data-maxlength="64" autocapitalize="off">')."\n".($lb?html_select("collation",array(""=>"(".'collation'.")")+$lb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"ms187963.aspx",)):""),script("focus(qs('#name'));"),'<input type="submit" value="Save">
';if(DB!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".'Add next'."'>\n";echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$n){$A=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$A,'Schema has been dropped.');else{$D=trim($J["name"]);$A.=urlencode($D);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($D),$A,'Schema has been created.');elseif($_GET["ns"]!=$D)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($D),$A,'Schema has been altered.');else
redirect($A);}}page_header($_GET["ns"]!=""?'Alter schema':'Create schema',$n);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" id="name" value="',h($J["name"]),'" autocapitalize="off">
',script("focus(qs('#name'));"),'<input type="submit" value="Save">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?$_GET["name"]:$_GET["call"]);page_header('Call'.": ".h($da),$n);$Tg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Jd=array();$If=array();foreach($Tg["fields"]as$t=>$o){if(substr($o["inout"],-3)=="OUT")$If[$t]="@".idf_escape($o["field"])." AS ".idf_escape($o["field"]);if(!$o["inout"]||substr($o["inout"],0,2)=="IN")$Jd[]=$t;}if(!$n&&$_POST){$Xa=array();foreach($Tg["fields"]as$z=>$o){if(in_array($z,$Jd)){$X=process_input($o);if($X===false)$X="''";if(isset($If[$z]))$g->query("SET @".idf_escape($o["field"])." = $X");}$Xa[]=(isset($If[$z])?"@".idf_escape($o["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Xa).")";$Ch=microtime(true);$H=$g->multi_query($G);$za=$g->affected_rows;echo$b->selectQuery($G,$Ch,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$h=connect();if(is_object($h))$h->select_db(DB);do{$H=$g->store_result();if(is_object($H))select($H,$h);else
echo"<p class='message'>".lang(array('Routine has been called, %d row affected.','Routine has been called, %d rows affected.'),$za)." <span class='time'>".@date("H:i:s")."</span>\n";}while($g->next_result());if($If)select($g->query("SELECT ".implode(", ",$If)));}}echo'
<form action="" method="post">
';if($Jd){echo"<table cellspacing='0' class='layout'>\n";foreach($Jd
as$z){$o=$Tg["fields"][$z];$D=$o["field"];echo"<tr><th>".$b->fieldName($o);$Y=$_POST["fields"][$D];if($Y!=""){if($o["type"]=="enum")$Y=+$Y;if($o["type"]=="set")$Y=array_sum($Y);}input($o,$Y,(string)$_POST["function"][$D]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$D=$_GET["name"];$J=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){$Ke=($_POST["drop"]?'Foreign key has been dropped.':($D!=""?'Foreign key has been altered.':'Foreign key has been created.'));$B=ME."table=".urlencode($a);if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$Wh=array();foreach($J["source"]as$z=>$X)$Wh[$z]=$J["target"][$z];$J["target"]=$Wh;}if($y=="sqlite")queries_redirect($B,$Ke,recreate_table($a,$a,array(),array(),array(" $D"=>($_POST["drop"]?"":" ".format_foreign_key($J)))));else{$c="ALTER TABLE ".table($a);$jc="\nDROP ".($y=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($D);if($_POST["drop"])query_redirect($c.$jc,$B,$Ke);else{query_redirect($c.($D!=""?"$jc,":"")."\nADD".format_foreign_key($J),$B,$Ke);$n='Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.'."<br>$n";}}}page_header('Foreign key',$n,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($D!=""){$hd=foreign_keys($a);$J=$hd[$D];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}echo'
<form action="" method="post">
';$vh=array_keys(fields($a));if($J["db"]!="")$g->select_db($J["db"]);if($J["ns"]!="")set_schema($J["ns"]);$Cg=array_keys(array_filter(table_status('',true),'fk_support'));$Wh=array_keys(fields(in_array($J["table"],$Cg)?$J["table"]:reset($Cg)));$qf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".'Target table'.": ".html_select("table",$Cg,$J["table"],$qf)."\n";if($y=="pgsql")echo'Schema'.": ".html_select("ns",$b->schemas(),$J["ns"]!=""?$J["ns"]:$_GET["ns"],$qf);elseif($y!="sqlite"){$Ub=array();foreach($b->databases()as$l){if(!information_schema($l))$Ub[]=$l;}echo'DB'.": ".html_select("db",$Ub,$J["db"]!=""?$J["db"]:$_GET["db"],$qf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';$ee=0;foreach($J["source"]as$z=>$X){echo"<tr>","<td>".html_select("source[".(+$z)."]",array(-1=>"")+$vh,$X,($ee==count($J["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$z)."]",$Wh,$J["target"][$z],1,"label-target");$ee++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$pf),$J["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$pf),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"ms174979.aspx",'oracle'=>"https://docs.oracle.com/cd/B19306_01/server.102/b14200/clauses002.htm#sthref2903",)),'<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';if($D!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$D));}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$Ff="VIEW";if($y=="pgsql"&&$a!=""){$O=table_status($a);$Ff=strtoupper($O["Engine"]);}if($_POST&&!$n){$D=trim($J["name"]);$Fa=" AS\n$J[select]";$B=ME."table=".urlencode($D);$Ke='View has been altered.';$T=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$D&&$y!="sqlite"&&$T=="VIEW"&&$Ff=="VIEW")query_redirect(($y=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($D).$Fa,$B,$Ke);else{$Yh=$D."_adminer_".uniqid();drop_create("DROP $Ff ".table($a),"CREATE $T ".table($D).$Fa,"DROP $T ".table($D),"CREATE $T ".table($Yh).$Fa,"DROP $T ".table($Yh),($_POST["drop"]?substr(ME,0,-1):$B),'View has been dropped.',$Ke,'View has been created.',$a,$D);}}if(!$_POST&&$a!=""){$J=view($a);$J["name"]=$a;$J["materialized"]=($Ff!="VIEW");if(!$n)$n=error();}page_header(($a!=""?'Alter view':'Create view'),$n,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>Name: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],'Materialized view'):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="Save">
';if($a!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Wd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Eh=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$n){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'Event has been dropped.');elseif(in_array($J["INTERVAL_FIELD"],$Wd)&&isset($Eh[$J["STATUS"]])){$Yg="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'Event has been altered.':'Event has been created.'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Yg.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$Yg)."\n".$Eh[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'Alter event'.": ".h($aa):'Create event'),$n);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">End<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Wd,$J["INTERVAL_FIELD"]),'<tr><th>Status<td>',html_select("STATUS",$Eh,$J["STATUS"]),'<tr><th>Comment<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",'On completion preserve'),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="Save">
';if($aa!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$aa));}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);$Tg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$n){$Cf=routine($_GET["procedure"],$Tg);$Yh="$J[name]_adminer_".uniqid();drop_create("DROP $Tg ".routine_id($da,$Cf),create_routine($Tg,$J),"DROP $Tg ".routine_id($J["name"],$J),create_routine($Tg,array("name"=>$Yh)+$J),"DROP $Tg ".routine_id($Yh,$J),substr(ME,0,-1),'Routine has been dropped.','Routine has been altered.','Routine has been created.',$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?'Alter function':'Alter procedure').": ".h($da):(isset($_GET["function"])?'Create function':'Create procedure')),$n);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Tg);$J["name"]=$da;}$lb=get_vals("SHOW CHARACTER SET");sort($lb);$Ug=routine_languages();echo'
<form action="" method="post" id="form">
<p>Name: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',($Ug?'Language'.": ".html_select("language",$Ug,$J["language"])."\n":""),'<input type="submit" value="Save">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';edit_fields($J["fields"],$lb,$Tg);if(isset($_GET["function"])){echo"<tr><td>".'Return type';edit_type("returns",$J["returns"],$lb,array(),($y=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="Save">
';if($da!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$da));}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$J=$_POST;if($_POST&&!$n){$A=substr(ME,0,-1);$D=trim($J["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$A,'Sequence has been dropped.');elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($D),$A,'Sequence has been created.');elseif($fa!=$D)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($D),$A,'Sequence has been altered.');else
redirect($A);}page_header($fa!=""?'Alter sequence'.": ".h($fa):'Create sequence',$n);if(!$J)$J["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="Save">
';if($fa!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$fa))."\n";echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$J=$_POST;if($_POST&&!$n){$A=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$A,'Type has been dropped.');else
query_redirect("CREATE TYPE ".idf_escape(trim($J["name"]))." $J[as]",$A,'Type has been created.');}page_header($ga!=""?'Alter type'.": ".h($ga):'Create type',$n);if(!$J)$J["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$ga))."\n";else{echo"<input name='name' value='".h($J['name'])."' autocapitalize='off'>\n";textarea("as",$J["as"]);echo"<p><input type='submit' value='".'Save'."'>\n";}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$D=$_GET["name"];$yi=trigger_options();$J=(array)trigger($D,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$n&&in_array($_POST["Timing"],$yi["Timing"])&&in_array($_POST["Event"],$yi["Event"])&&in_array($_POST["Type"],$yi["Type"])){$of=" ON ".table($a);$jc="DROP TRIGGER ".idf_escape($D).($y=="pgsql"?$of:"");$B=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($jc,$B,'Trigger has been dropped.');else{if($D!="")queries($jc);queries_redirect($B,($D!=""?'Trigger has been altered.':'Trigger has been created.'),queries(create_trigger($of,$_POST)));if($D!="")queries(create_trigger($of,$J+array("Type"=>reset($yi["Type"]))));}}$J=$_POST;}page_header(($D!=""?'Alter trigger'.": ".h($D):'Create trigger'),$n,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>Time<td>',html_select("Timing",$yi["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>Event<td>',html_select("Event",$yi["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$yi["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>Type<td>',html_select("Type",$yi["Type"],$J["Type"]),'</table>
<p>Name: <input name="Trigger" value="',h($J["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="Save">
';if($D!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$D));}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$pg=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$Db)$pg[$Db][$J["Privilege"]]=$J["Comment"];}$pg["Server Admin"]+=$pg["File access on server"];$pg["Databases"]["Create routine"]=$pg["Procedures"]["Create routine"];unset($pg["Procedures"]["Create routine"]);$pg["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$pg["Columns"][$X]=$pg["Tables"][$X];unset($pg["Server Admin"]["Usage"]);foreach($pg["Tables"]as$z=>$X)unset($pg["Databases"][$z]);$Xe=array();if($_POST){foreach($_POST["objects"]as$z=>$X)$Xe[$X]=(array)$Xe[$X]+(array)$_POST["grants"][$z];}$pd=array();$mf="";if(isset($_GET["host"])&&($H=$g->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$C)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$C[1],$Ce,PREG_SET_ORDER)){foreach($Ce
as$X){if($X[1]!="USAGE")$pd["$C[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$pd["$C[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$C))$mf=$C[1];}}if($_POST&&!$n){$nf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $nf",ME."privileges=",'User has been dropped.');else{$Ze=q($_POST["user"])."@".q($_POST["host"]);$Wf=$_POST["pass"];if($Wf!=''&&!$_POST["hashed"]&&!min_version(8)){$Wf=$g->result("SELECT PASSWORD(".q($Wf).")");$n=!$Wf;}$Jb=false;if(!$n){if($nf!=$Ze){$Jb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $Ze IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Wf));$n=!$Jb;}elseif($Wf!=$mf)queries("SET PASSWORD FOR $Ze = ".q($Wf));}if(!$n){$Qg=array();foreach($Xe
as$ff=>$od){if(isset($_GET["grant"]))$od=array_filter($od);$od=array_keys($od);if(isset($_GET["grant"]))$Qg=array_diff(array_keys(array_filter($Xe[$ff],'strlen')),$od);elseif($nf==$Ze){$kf=array_keys((array)$pd[$ff]);$Qg=array_diff($kf,$od);$od=array_diff($od,$kf);unset($pd[$ff]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$ff,$C)&&(!grant("REVOKE",$Qg,$C[2]," ON $C[1] FROM $Ze")||!grant("GRANT",$od,$C[2]," ON $C[1] TO $Ze"))){$n=true;break;}}}if(!$n&&isset($_GET["host"])){if($nf!=$Ze)queries("DROP USER $nf");elseif(!isset($_GET["grant"])){foreach($pd
as$ff=>$Qg){if(preg_match('~^(.+)(\(.*\))?$~U',$ff,$C))grant("REVOKE",array_keys($Qg),$C[2]," ON $C[1] FROM $Ze");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'User has been altered.':'User has been created.'),!$n);if($Jb)$g->query("DROP USER $Ze");}}page_header((isset($_GET["host"])?'Username'.": ".h("$ha@$_GET[host]"):'Create user'),$n,array("privileges"=>array('','Privileges')));if($_POST){$J=$_POST;$pd=$Xe;}else{$J=$_GET+array("host"=>$g->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$mf;if($mf!="")$J["hashed"]=true;$pd[(DB==""||$pd?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
';if(!$J["hashed"])echo
script("typePassword(qs('#pass'));");echo(min_version(8)?"":checkbox("hashed",1,$J["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

';echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".'Privileges'.doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($pd
as$ff=>$od){echo'<th>'.($ff!="*.*"?"<input name='objects[$t]' value='".h($ff)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'Server',"Databases"=>'Database',"Tables"=>'Table',"Columns"=>'Column',"Procedures"=>'Routine',)as$Db=>$bc){foreach((array)$pg[$Db]as$og=>$rb){echo"<tr".odd()."><td".($bc?">$bc<td":" colspan='2'").' lang="en" title="'.h($rb).'">'.h($og);$t=0;foreach($pd
as$ff=>$od){$D="'grants[$t][".h(strtoupper($og))."]'";$Y=$od[strtoupper($og)];if($Db=="Server Admin"&&$ff!=(isset($pd["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$D><option><option value='1'".($Y?" selected":"").">".'Grant'."<option value='0'".($Y=="0"?" selected":"").">".'Revoke'."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$D value='1'".($Y?" checked":"").($og=="All privileges"?" id='grants-$t-all'>":">".($og=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";}$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="Save">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$n){$je=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$je++;}queries_redirect(ME."processlist=",lang(array('%d process has been killed.','%d processes have been killed.'),$je),$je||!$_POST["kill"]);}}page_header('Process list',$n);echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$J){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($J
as$z=>$X)echo"<th>$z".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($z),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr".odd().">".(support("kill")?"<td>".checkbox("kill[]",$J[$y=="sql"?"Id":"pid"],0):"");foreach($J
as$z=>$X)echo"<td>".(($y=="sql"&&$z=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||($y=="pgsql"&&$z=="current_query"&&$X!="<IDLE>")||($y=="oracle"&&$z=="sql_text"&&$X!="")?"<code class='jush-$y'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.'Clone'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill")){echo($t+1)."/".sprintf('%d in total',max_connections()),"<p><input type='submit' value='".'Kill'."'>\n";}echo'<input type="hidden" name="token" value="',$ni,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$x=indexes($a);$p=fields($a);$hd=column_foreign_keys($a);$if=$R["Oid"];parse_str($_COOKIE["adminer_import"],$ya);$Rg=array();$f=array();$ci=null;foreach($p
as$z=>$o){$D=$b->fieldName($o);if(isset($o["privileges"]["select"])&&$D!=""){$f[$z]=html_entity_decode(strip_tags($D),ENT_QUOTES);if(is_shortable($o))$ci=$b->selectLengthProcess();}$Rg+=$o["privileges"];}list($L,$qd)=$b->selectColumnsProcess($f,$x);$ae=count($qd)<count($L);$Z=$b->selectSearchProcess($p,$x);$zf=$b->selectOrderProcess($p,$x);$_=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Ei=>$J){$Fa=convert_field($p[key($J)]);$L=array($Fa?$Fa:idf_escape(key($J)));$Z[]=where_check($Ei,$p);$I=$m->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$kg=$Gi=null;foreach($x
as$w){if($w["type"]=="PRIMARY"){$kg=array_flip($w["columns"]);$Gi=($L?$kg:array());foreach($Gi
as$z=>$X){if(in_array(idf_escape($z),$L))unset($Gi[$z]);}break;}}if($if&&!$kg){$kg=$Gi=array($if=>0);$x[]=array("type"=>"PRIMARY","columns"=>array($if));}if($_POST&&!$n){$hj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$db=array();foreach($_POST["check"]as$ab)$db[]=where_check($ab,$p);$hj[]="((".implode(") OR (",$db)."))";}$hj=($hj?"\nWHERE ".implode(" AND ",$hj):"");if($_POST["export"]){cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$md=($L?implode(", ",$L):"*").convert_fields($f,$p,$L)."\nFROM ".table($a);$sd=($qd&&$ae?"\nGROUP BY ".implode(", ",$qd):"").($zf?"\nORDER BY ".implode(", ",$zf):"");if(!is_array($_POST["check"])||$kg)$G="SELECT $md$hj$sd";else{$Ci=array();foreach($_POST["check"]as$X)$Ci[]="(SELECT".limit($md,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p).$sd,1).")";$G=implode(" UNION ALL ",$Ci);}$b->dumpData($a,"table",$G);exit;}if(!$b->selectEmailProcess($Z,$hd)){if($_POST["save"]||$_POST["delete"]){$H=true;$za=0;$N=array();if(!$_POST["delete"]){foreach($f
as$D=>$X){$X=process_input($p[$D]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($D)]=($X!==false?$X:idf_escape($D));}}if($_POST["delete"]||$N){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a);if($_POST["all"]||($kg&&is_array($_POST["check"]))||$ae){$H=($_POST["delete"]?$m->delete($a,$hj):($_POST["clone"]?queries("INSERT $G$hj"):$m->update($a,$N,$hj)));$za=$g->affected_rows;}else{foreach((array)$_POST["check"]as$X){$dj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p);$H=($_POST["delete"]?$m->delete($a,$dj,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$dj)):$m->update($a,$N,$dj,1)));if(!$H)break;$za+=$g->affected_rows;}}}$Ke=lang(array('%d item has been affected.','%d items have been affected.'),$za);if($_POST["clone"]&&$H&&$za==1){$oe=last_id();if($oe)$Ke=sprintf('Item%s has been inserted.'," $oe");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Ke,$H);if(!$_POST["delete"]){edit_form($a,$p,(array)$_POST["fields"],!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$n='Ctrl+click on a value to modify it.';else{$H=true;$za=0;foreach($_POST["val"]as$Ei=>$J){$N=array();foreach($J
as$z=>$X){$z=bracket_escape($z,1);$N[idf_escape($z)]=(preg_match('~char|text~',$p[$z]["type"])||$X!=""?$b->processInput($p[$z],$X):"NULL");}$H=$m->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Ei,$p),!$ae&&!$kg," ");if(!$H)break;$za+=$g->affected_rows;}queries_redirect(remove_from_uri(),lang(array('%d item has been affected.','%d items have been affected.'),$za),$H);}}elseif(!is_string($Xc=get_file("csv_file",true)))$n=upload_error($Xc);elseif(!preg_match('~~u',$Xc))$n='File must be in UTF-8 encoding.';else{cookie("adminer_import","output=".urlencode($ya["output"])."&format=".urlencode($_POST["separator"]));$H=true;$nb=array_keys($p);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$Xc,$Ce);$za=count($Ce[0]);$m->begin();$hh=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($Ce[0]as$z=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$hh]*)$hh~",$X.$hh,$De);if(!$z&&!array_diff($De[1],$nb)){$nb=$De[1];$za--;}else{$N=array();foreach($De[1]as$t=>$jb)$N[idf_escape($nb[$t])]=($jb==""&&$p[$nb[$t]]["null"]?"NULL":q(str_replace('""','"',preg_replace('~^"|"$~','',$jb))));$K[]=$N;}}$H=(!$K||$m->insertUpdate($a,$K,$kg));if($H)$H=$m->commit();queries_redirect(remove_from_uri("page"),lang(array('%d row has been imported.','%d rows have been imported.'),$za),$H);$m->rollback();}}}$Oh=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header('Select'.": $Oh",$n);$N=null;if(isset($Rg["insert"])||!support("table")){$N="";foreach((array)$_GET["where"]as$X){if($hd[$X["col"]]&&count($hd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&!preg_match('~[_%]~',$X["val"]))))$N.="&set".urlencode("[".bracket_escape($X["col"])."]")."=".urlencode($X["val"]);}}$b->selectLinks($R,$N);if(!$f&&support("table"))echo"<p class='error'>".'Unable to select the table'.($p?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$f);$b->selectSearchPrint($Z,$f,$x);$b->selectOrderPrint($zf,$f,$x);$b->selectLimitPrint($_);$b->selectLengthPrint($ci);$b->selectActionPrint($x);echo"</form>\n";$E=$_GET["page"];if($E=="last"){$kd=$g->result(count_rows($a,$Z,$ae,$qd));$E=floor(max(0,$kd-1)/$_);}$ch=$L;$rd=$qd;if(!$ch){$ch[]="*";$Eb=convert_fields($f,$p,$L);if($Eb)$ch[]=substr($Eb,2);}foreach($L
as$z=>$X){$o=$p[idf_unescape($X)];if($o&&($Fa=convert_field($o)))$ch[$z]="$Fa AS $X";}if(!$ae&&$Gi){foreach($Gi
as$z=>$X){$ch[]=idf_escape($z);if($rd)$rd[]=idf_escape($z);}}$H=$m->select($a,$ch,$Z,$rd,$zf,$_,$E,true);if(!$H)echo"<p class='error'>".error()."\n";else{if($y=="mssql"&&$E)$H->seek($_*$E);$wc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($E&&$y=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$_!=""&&$qd&&$ae&&$y=="sql")$kd=$g->result(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".'No rows.'."\n";else{$Oa=$b->backwardKeys($a,$Oh);echo"<div class='scrollable'>","<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$qd&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'Modify'."</a>");$Ve=array();$nd=array();reset($L);$zg=1;foreach($K[0]as$z=>$X){if(!isset($Gi[$z])){$X=$_GET["columns"][key($L)];$o=$p[$L?($X?$X["col"]:current($L)):$z];$D=($o?$b->fieldName($o,$zg):($X["fun"]?"*":$z));if($D!=""){$zg++;$Ve[$z]=$D;$e=idf_escape($z);$Ed=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($z);$bc="&desc%5B0%5D=1";echo"<th id='th[".h(bracket_escape($z))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($Ed.($zf[0]==$e||$zf[0]==$z||(!$zf&&$ae&&$qd[0]==$e)?$bc:'')).'">';echo
apply_sql_function($X["fun"],$D)."</a>";echo"<span class='column hidden'>","<a href='".h($Ed.$bc)."' title='".'descending'."' class='text'> ??/a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.'Search'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($z)."');");}echo"</span>";}$nd[$z]=$X["fun"];next($L);}}$ue=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$z=>$X)$ue[$z]=max($ue[$z],min(40,strlen(utf8_decode($X))));}}echo($Oa?"<th>".'Relations':"")."</thead>\n";if(is_ajax()){if($_%2==1&&$E%2==1)odd();ob_end_clean();}foreach($b->rowDescriptions($K,$hd)as$Ue=>$J){$Di=unique_array($K[$Ue],$x);if(!$Di){$Di=array();foreach($K[$Ue]as$z=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$z))$Di[$z]=$X;}}$Ei="";foreach($Di
as$z=>$X){if(($y=="sql"||$y=="pgsql")&&preg_match('~char|text|enum|set~',$p[$z]["type"])&&strlen($X)>64){$z=(strpos($z,'(')?$z:idf_escape($z));$z="MD5(".($y!='sql'||preg_match("~^utf8~",$p[$z]["collation"])?$z:"CONVERT($z USING ".charset($g).")").")";$X=md5($X);}$Ei.="&".($X!==null?urlencode("where[".bracket_escape($z)."]")."=".urlencode($X):"null%5B%5D=".urlencode($z));}echo"<tr".odd().">".(!$qd&&$L?"":"<td>".checkbox("check[]",substr($Ei,1),in_array(substr($Ei,1),(array)$_POST["check"])).($ae||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Ei)."' class='edit'>".'edit'."</a>"));foreach($J
as$z=>$X){if(isset($Ve[$z])){$o=$p[$z];$X=$m->value($X,$o);if($X!=""&&(!isset($wc[$z])||$wc[$z]!=""))$wc[$z]=(is_mail($X)?$Ve[$z]:"");$A="";if(preg_match('~blob|bytea|raw|file~',$o["type"])&&$X!="")$A=ME.'download='.urlencode($a).'&field='.urlencode($z).$Ei;if(!$A&&$X!==null){foreach((array)$hd[$z]as$r){if(count($hd[$z])==1||end($r["source"])==$z){$A="";foreach($r["source"]as$t=>$vh)$A.=where_link($t,$r["target"][$t],$K[$Ue][$vh]);$A=($r["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($r["db"]),ME):ME).'select='.urlencode($r["table"]).$A;if($r["ns"])$A=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($r["ns"]),$A);if(count($r["source"])==1)break;}}}if($z=="COUNT(*)"){$A=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Di))$A.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($Di
as$fe=>$W)$A.=where_link($t++,$fe,$W);}$X=select_value($X,$A,$o,$ci);$u=h("val[$Ei][".bracket_escape($z)."]");$Y=$_POST["val"][$Ei][bracket_escape($z)];$rc=!is_array($J[$z])&&is_utf8($X)&&$K[$Ue][$z]==$J[$z]&&!$nd[$z];$bi=preg_match('~text|lob~',$o["type"]);echo"<td id='$u'";if(($_GET["modify"]&&$rc)||$Y!==null){$vd=h($Y!==null?$Y:$J[$z]);echo">".($bi?"<textarea name='$u' cols='30' rows='".(substr_count($J[$z],"\n")+1)."'>$vd</textarea>":"<input name='$u' value='$vd' size='$ue[$z]'>");}else{$ye=strpos($X,"<i>??/i>");echo" data-text='".($ye?2:($bi?1:0))."'".($rc?"":" data-warning='".h('Use edit link to modify this value.')."'").">$X</td>";}}}if($Oa)echo"<td>";$b->backwardKeysPrint($Oa,$K[$Ue]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($K||$E){$Gc=true;if($_GET["page"]!="last"){if($_==""||(count($K)<$_&&($K||!$E)))$kd=($E?$E*$_:0)+count($K);elseif($y!="sql"||!$ae){$kd=($ae?false:found_rows($R,$Z));if($kd<max(1e4,2*($E+1)*$_))$kd=reset(slow_query(count_rows($a,$Z,$ae,$qd)));else$Gc=false;}}$Mf=($_!=""&&($kd===false||$kd>$_||$E));if($Mf){echo(($kd===false?count($K)+1:$kd-$E*$_)>$_?'<p><a href="'.h(remove_from_uri("page")."&page=".($E+1)).'" class="loadmore">'.'Load more data'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$_).", '".'Loading'."??);",""):''),"\n";}}echo"<div class='footer'><div>\n";if($K||$E){if($Mf){$Fe=($kd===false?$E+(count($K)>=$_?2:1):floor(($kd-1)/$_));echo"<fieldset>";if($y!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'Page'."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'Page'."', '".($E+1)."')); return false; };"),pagination(0,$E).($E>5?" ??:"");for($t=max(1,$E-4);$t<min($Fe,$E+5);$t++)echo
pagination($t,$E);if($Fe>0){echo($E+5<$Fe?" ??:""),($Gc&&$kd!==false?pagination($Fe,$E):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Fe'>".'last'."</a>");}}else{echo"<legend>".'Page'."</legend>",pagination(0,$E).($E>1?" ??:""),($E?pagination($E,$E):""),($Fe>$E?pagination($E+1,$E).($Fe>$E+1?" ??:""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".'Whole result'."</legend>";$gc=($Gc?"":"~ ").$kd;echo
checkbox("all",1,0,($kd!==false?($Gc?"":"~ ").lang(array('%d row','%d rows'),$kd):""),"var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$gc' : checked); selectCount('selected2', this.checked || !checked ? '$gc' : checked);")."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>Modify</legend><div>
<input type="submit" value="Save"',($_GET["modify"]?'':' title="'.'Ctrl+click on a value to modify it.'.'"'),'>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">',confirm(),'</div></fieldset>
';}$id=$b->dumpFormat();foreach((array)$_GET["columns"]as$e){if($e["fun"]){unset($id['sql']);break;}}if($id){print_fieldset("export",'Export'." <span id='selected2'></span>");$Jf=$b->dumpOutput();echo($Jf?html_select("output",$Jf,$ya["output"])." ":""),html_select("format",$id,$ya["format"])," <input type='submit' name='export' value='".'Export'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($wc,'strlen'),$f);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".'Import'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$ya["format"],1);echo" <input type='submit' name='import' value='".'Import'."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$ni'>\n","</form>\n",(!$qd&&$L?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$O=isset($_GET["status"]);page_header($O?'Status':'Variables');$Ui=($O?show_status():show_variables());if(!$Ui)echo"<p class='message'>".'No rows.'."\n";else{echo"<table cellspacing='0'>\n";foreach($Ui
as$z=>$X){echo"<tr>","<th><code class='jush-".$y.($O?"status":"set")."'>".h($z)."</code>","<td>".h($X);}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Lh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$D=>$R){json_row("Comment-$D",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$z)json_row("$z-$D",h($R[$z]));foreach($Lh+array("Auto_increment"=>0,"Rows"=>0)as$z=>$X){if($R[$z]!=""){$X=format_number($R[$z]);json_row("$z-$D",($z=="Rows"&&$X&&$R["Engine"]==($yh=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Lh[$z]))$Lh[$z]+=($R["Engine"]!="InnoDB"||$z!="Data_free"?$R[$z]:0);}elseif(array_key_exists($z,$R))json_row("$z-$D");}}}foreach($Lh
as$z=>$X)json_row("sum-$z",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$g->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$l=>$X){json_row("tables-$l",$X);json_row("size-$l",db_size($l));}json_row("");}exit;}else{$Uh=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Uh&&!$n&&!$_POST["search"]){$H=true;$Ke="";if($y=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$Ke='Tables have been truncated.';}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Ke='Tables have been moved.';}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Ke='Tables have been copied.';}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$Ke='Tables have been dropped.';}elseif($y!="sql"){$H=($y=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Ke='Tables have been optimized.';}elseif(!$_POST["tables"])$Ke='No tables.';elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$Ke.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Ke,$H);}page_header(($_GET["ns"]==""?'Database'.": ".h(DB):'Schema'.": ".h($_GET["ns"])),$n,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'Tables and views'."</h3>\n";$Th=tables_list();if(!$Th)echo"<p class='message'>".'No tables.'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'Search data in tables'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'Search'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]="LIKE %%";search_tables();}}echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'Table','<td>'.'Engine'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'Collation'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'Data Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.'Index Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.'Data Free'.doc_link(array('sql'=>'show-table-status.html')),'<td>'.'Auto Increment'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'Rows'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.'Comment'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$S=0;foreach($Th
as$D=>$T){$Xi=($T!==null&&!preg_match('~table|sequence~i',$T));$u=h("Table-".$D);echo'<tr'.odd().'><td>'.checkbox(($Xi?"views[]":"tables[]"),$D,in_array($D,$Uh,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($D)."' title='".'Show structure'."' id='$u'>".h($D).'</a>':h($D));if($Xi){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($D).'" title="'.'Alter view'.'">'.(preg_match('~materialized~i',$T)?'Materialized view':'View').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($D).'" title="'.'Select data'.'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'Alter table'),"Index_length"=>array("indexes",'Alter indexes'),"Data_free"=>array("edit",'New item'),"Auto_increment"=>array("auto_increment=1&create",'Alter table'),"Rows"=>array("select",'Select data'),)as$z=>$A){$u=" id='$z-".h($D)."'";echo($A?"<td align='right'>".(support("table")||$z=="Rows"||(support("indexes")&&$z!="Data_length")?"<a href='".h(ME."$A[0]=").urlencode($D)."'$u title='$A[1]'>?</a>":"<span$u>?</span>"):"<td id='$z-".h($D)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($D)."'>":"");}echo"<tr><td><th>".sprintf('%d in total',count($Th)),"<td>".h($y=="sql"?$g->result("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$z)echo"<td align='right' id='sum-$z'>";echo"</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Ri="<input type='submit' value='".'Vacuum'."'> ".on_help("'VACUUM'");$vf="<input type='submit' name='optimize' value='".'Optimize'."'> ".on_help($y=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>".($y=="sqlite"?$Ri:($y=="pgsql"?$Ri.$vf:($y=="sql"?"<input type='submit' value='".'Analyze'."'> ".on_help("'ANALYZE TABLE'").$vf."<input type='submit' name='check' value='".'Check'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'Repair'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'Truncate'."'> ".on_help($y=="sqlite"?"'DELETE'":"'TRUNCATE".($y=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'Drop'."'>".on_help("'DROP TABLE'").confirm()."\n";$k=(support("scheme")?$b->schemas():$b->databases());if(count($k)!=1&&$y!="sqlite"){$l=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'Move to other database'.": ",($k?html_select("target",$k,$l):'<input name="target" value="'.h($l).'" autocapitalize="off">')," <input type='submit' name='move' value='".'Move'."'>",(support("copy")?" <input type='submit' name='copy' value='".'Copy'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'overwrite'):""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$ni'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'Create table'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'Create view'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'Routines'."</h3>\n";$Vg=routines();if($Vg){echo"<table cellspacing='0'>\n",'<thead><tr><th>'.'Name'.'<td>'.'Type'.'<td>'.'Return type'."<td></thead>\n";odd('');foreach($Vg
as$J){$D=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr'.odd().'>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$D).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$D).'">'.'Alter'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'Create procedure'.'</a>':'').'<a href="'.h(ME).'function=">'.'Create function'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'Sequences'."</h3>\n";$jh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($jh){echo"<table cellspacing='0'>\n","<thead><tr><th>".'Name'."</thead>\n";odd('');foreach($jh
as$X)echo"<tr".odd()."><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'Create sequence'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'User types'."</h3>\n";$Pi=types();if($Pi){echo"<table cellspacing='0'>\n","<thead><tr><th>".'Name'."</thead>\n";odd('');foreach($Pi
as$X)echo"<tr".odd()."><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'Create type'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'Events'."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table cellspacing='0'>\n","<thead><tr><th>".'Name'."<td>".'Schedule'."<td>".'Start'."<td>".'End'."<td></thead>\n";foreach($K
as$J){echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?'At given time'."<td>".$J["Execute at"]:'Every'." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.'Alter'.'</a>';}echo"</table>\n";$Ec=$g->result("SELECT @@event_scheduler");if($Ec&&$Ec!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($Ec)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'Create event'."</a>\n";}if($Th)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();
