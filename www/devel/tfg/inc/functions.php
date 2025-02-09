<?
define('DB_NAME', 'catalunydc907');
define('DB_USER', 'catalunydc907');
define('DB_PASSWORD', 'QmfyV7KHtNXk');
define('DB_HOST', 'mysql590.sql002:3306');
define('TABLE_PREF',"sgr_");
 header('Access-Control-Allow-Origin: *'); 
 
function siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName."/tfg/";
}
define( 'SITE_URL', siteURL() );
include "oldmysql.php";

/* error_reporting(E_ALL);
ini_set('display_errors', 1);
/**/
//<<VALORES ELIMINACIONES
//no cambiar el orden de los valores hardcodeados, como mucho añadir
$stoolconsistency=array("Dura","Normal","Líquida");
$stoolappearance=array("Homogénea","Sangre");
$urinecolor=array("Clara","Oscura");
$urineappearance=array("Turbia","Clara");
$hygienetype=array("Total","Parcial");
//VALORES ELIMINACIONES>>

function sanitize($string){
	$string=strip_tags($string);
	$string=str_replace(array("(",")",".","<script","script"),array("",""),strtolower($string));
		$string=str_replace(array("<object","object"),array("",""),strtolower($string));
	 $string=htmlspecialchars($string,ENT_QUOTES);
	return $string;
	}



function searchForIdHour($id,$hour, $array) {
   foreach ($array as $key => $val) {
	   
       if ($val->id_medication === $id && $val->hour===$hour) {
           return array($val->dose,$val->id,$val->did);
       }
   }
   return null;
}


function conectar(){
global $conect;
$conect=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Error de conexión");
mysql_select_db(DB_NAME,$conect) or die("Error de BBDD");
}
function desconectar(){
	global $conect;
	mysql_close($conect);
	}
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; 
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; 
    $bits = (int) $log + 1; 
    $filter = (int) (1 << $bits) - 1; 
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; 
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

function fechaCastellano ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
}



function trylogin($user,$password){
$q=mysql_query("SELECT * FROM ".TABLE_PREF."user WHERE email='".mysql_real_escape_string($user)."' AND password='".md5($password)."'") or die (mysql_error());
	if(mysql_num_rows($q)>0){
		$tkn=getToken(15);
		$r=mysql_fetch_array($q);
		mysql_query("INSERT INTO ".TABLE_PREF."token VALUES (null,'".$tkn."',".$r['id'].",NOW())") or die(mysql_error()); 
		return json_encode(array("error"=>"","username"=>$r['name']." ".$r['surname'],"id"=>$r['id'],"email"=>$r['email'],"token"=>$tkn));
		
		}	else{
			return json_encode(array("error"=>"Usuario o contraseña incorrectos"));
			}
		
		
	}
	
 
	
	

function getuser($token){
	 
		 
	$q=mysql_query("SELECT user.id, id_rol, name,surname,rol as rolname, CONCAT(name,' ',surname) as username, email,token FROM ".TABLE_PREF."user as user,".TABLE_PREF."token,".TABLE_PREF."roles as r  WHERE  id_rol=r.id AND token='".mysql_real_escape_string($token)."' AND id_user=user.id") or die (mysql_error());
	 $result=mysql_fetch_assoc($q);
	 if(mysql_num_rows($q)==0){
		  $result["error"]="Usuario incorrecto";
		 }else{
			 $result["error"]="";
			 }
 
	return json_encode($result);
	}


function getevents($idpatient){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."events WHERE id_patient=".mysql_real_escape_string($idpatient)) or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
		}

function getevent($id){
	$result=array();
$q=mysql_query("SELECT * FROM ".TABLE_PREF."events WHERE id=".mysql_real_escape_string($id)) or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
		return json_encode($result);
	}
	
	
 function getpatients($user){
	 $result=array();
$q=mysql_query("SELECT p.*,pa.name as pathologyname FROM ".TABLE_PREF."user_patient,".TABLE_PREF."patient as p , ".TABLE_PREF."pathologies as pa WHERE id_user=".mysql_real_escape_string($user)." AND pathology=pa.id AND id_patient=p.id GROUP BY p.id ORDER by surname") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
		return json_encode($result);
	}
 function getpatient($id)	{
	 $result=array();
$q=mysql_query("SELECT p.*,pa.name as pathologyname FROM ".TABLE_PREF."patient  as p , ".TABLE_PREF."pathologies as pa WHERE   pathology=pa.id  AND  p.id=".mysql_real_escape_string($id)) or die (mysql_error());
	 $result=mysql_fetch_assoc($q);
	 return json_encode($result);
	 }
	
	
	function getusersbypatient($idpatient){
		 $result=array();
$q=mysql_query("SELECT  u.* FROM ".TABLE_PREF."user as u, ".TABLE_PREF."user_patient as up WHERE id_patient=".mysql_real_escape_string($idpatient)." AND up.id_user=u.id ORDER by name,surname") or die (mysql_error());
 
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		} 
		 
		return  ($result);
 	}
	
	
	
	
function getpathologies(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."pathologies ORDER by name") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
		}	
	
	function getpathology($id){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."pathologies WHERE id=".mysql_real_escape_string($id)) or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	
	}	
	
	
	
 function getmessagesfrom($user){
	 $result=array();
$q=mysql_query("SELECT * FROM ".TABLE_PREF."msg   WHERE user_from=".mysql_real_escape_string($user)."  ORDER by date DESC") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
		return json_encode($result);
	}	
	
	 function getmessagesto($user,$limit){
		 if($limit!=""){$limitq=" LIMIT 0,".$limit;}
	 $result=array();
$q=mysql_query("SELECT m.*,CONCAT(u.name,'',u.surname) as name FROM ".TABLE_PREF."msg as m,".TABLE_PREF."user   as u WHERE user_to=".mysql_real_escape_string($user)."  AND user_from=u.id ORDER by date DESC ".$limitq) or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
		return json_encode($result);
	}	
	
	
	
	
	 function getunreadmessages($user){
	 $result=array();
$q=mysql_query("SELECT m.*,CONCAT(u.name,'',u.surname) as name FROM ".TABLE_PREF."msg as m,".TABLE_PREF."user   as u WHERE user_to=".mysql_real_escape_string($user)."  AND user_from=u.id AND _read=0 ORDER by date DESC") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
		return json_encode($result);
	}
	
	function sendmessage($from,$to,$subject,$body){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."msg  (user_from,user_to,date,subject,body) VALUES (".mysql_real_escape_string($from).",".mysql_real_escape_string($to).",NOW(),'".mysql_real_escape_string($subject)."','".mysql_real_escape_string($body)."')") or die(mysql_error());
		return true;
		
		}

function getmessage($id){
	 $result=array();
$q=mysql_query("SELECT * FROM ".TABLE_PREF."msg   WHERE id=".mysql_real_escape_string($id)) or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
		return json_encode($result);
	}
	
	function setmessageread($id){
	 $result=array();
$q=mysql_query("UPDATE ".TABLE_PREF."msg  SET _read=1 WHERE id=".mysql_real_escape_string($id)) or die (mysql_error());
	 
		return true;
	}
	
		function deletemessage($id,$iduser){
	 $result=array();
$q=mysql_query("DELETE FROm ".TABLE_PREF."msg  WHERE user_to=".mysql_real_escape_string($iduser)." AND id=".mysql_real_escape_string($id)) or die (mysql_error());
	 
		return true;
	}
	
	

	
 function getpatientmedications($idpatient){
	 $result=array();
	 		$q=mysql_query("SELECT m.*  FROM ".TABLE_PREF."medication m,".TABLE_PREF."patient_medication pm  WHERE id_medication=m.id AND id_patient=".mysql_real_escape_string($idpatient)."  ORDER by name ") or die (mysql_error());
		while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
		return json_encode($result);
 }
	
	function getdailymedication($idpatient){
				 $result=array();
		$exist=mysql_query("SELECT id FROM ".TABLE_PREF."patient_daily_medication WHERE day=CURDATE() AND id_patient=".mysql_real_escape_string($idpatient)) or die(mysql_error());
	 
		
		if(mysql_num_rows($exist)==0){
				$q=mysql_query("SELECT pm.*,m.name  FROM ".TABLE_PREF."medication m,".TABLE_PREF."patient_medication pm  WHERE id_medication=m.id AND id_patient=".mysql_real_escape_string($idpatient)."  ORDER by hour  DESC") or die (mysql_error());
				while($r=mysql_fetch_array($q)){
					
	$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_daily_medication (id_patient, id_medication,day) VALUES (".mysql_real_escape_string($idpatient).",".mysql_real_escape_string($r['id']).",CURDATE())") or die(mysql_error());
				
			 
					}
			
			}
	
		$q2=mysql_query("SELECT pm.*,dm.dose,m.name,dm.id as did  FROM ".TABLE_PREF."medication m,".TABLE_PREF."patient_medication pm,".TABLE_PREF."patient_daily_medication dm  WHERE pm.id_medication=m.id AND pm.id_patient=".mysql_real_escape_string($idpatient)."	AND day=CURDATE() AND	dm.id_medication=pm.id AND dm.id_patient=".mysql_real_escape_string($idpatient)."		  ORDER by hour  DESC") or die (mysql_error());
		
		
		
		
	while($r2=mysql_fetch_assoc($q2)){
		array_push($result,$r2);
		
		}
		return json_encode($result);
		}


	function setdailymedication($ok,$id){
		 $result=array();
	 
$q=mysql_query("UPDATE ".TABLE_PREF."patient_daily_medication  SET dose=".mysql_real_escape_string($ok)." WHERE id=".mysql_real_escape_string($id)) or die (mysql_error());
	 
		return true;
		
		
		}



function getmealtypes(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."meal ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}

function getmealintakes(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."meal_intake ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}
function getwaterintakes(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."water_intake ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}


function set_patient_meal_intake($patient,$meal,$intake){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_meal_intake  (id_patient,id_meal,id_intake,day) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($meal).",".mysql_real_escape_string($intake).", CURDATE())") or die(mysql_error());
		return true;
		
		}

function get_patient_meal_intake($patient,$meal){
	$result=array();
	$q=mysql_query("SELECT pmi.*,mi.name  FROM ".TABLE_PREF."patient_meal_intake as pmi, ".TABLE_PREF."meal_intake as mi WHERE  pmi.id_intake=mi.id AND id_patient=".mysql_real_escape_string($patient)." AND id_meal=".mysql_real_escape_string($meal)." AND day=CURDATE()") or die (mysql_error());
	
 
 $result=mysql_fetch_assoc($q) ;
	return json_encode($result);
	}



function get_patient_meal_intake_date($patient,$meal,$date1){
	$result=array();
	$q=mysql_query("SELECT pmi.*,mi.name  FROM ".TABLE_PREF."patient_meal_intake as pmi, ".TABLE_PREF."meal_intake as mi WHERE  pmi.id_intake=mi.id AND id_patient=".mysql_real_escape_string($patient)." AND id_meal=".mysql_real_escape_string($meal)."    AND day>='".$date1."'  AND day<='".$date1."'") or die (mysql_error());
  $result=mysql_fetch_assoc($q) ;
 
	return json_encode($result);
	}


function set_patient_water_intake($patient,$intake){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_water_intake(id_patient,id_intake,day) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($intake).", CURDATE())") or die(mysql_error());
		return true;
		
		}
		
		
function get_patient_water_intake($patient){
 
	$q=mysql_query("SELECT pwi.*,wi.name FROM ".TABLE_PREF."patient_water_intake as pwi, ".TABLE_PREF."water_intake as wi WHERE id_patient=".mysql_real_escape_string($patient)."  AND pwi.id_intake=wi.id  AND day=CURDATE()") or die (mysql_error());
 $r=mysql_fetch_assoc($q) ;
		
	 
	return json_encode($r);
	}		
		
	function get_patient_water_intake_date($patient,$meal,$date1){
	$result=array();
	$q=mysql_query("SELECT pwi.*,wi.name FROM ".TABLE_PREF."patient_water_intake as pwi, ".TABLE_PREF."water_intake as wi WHERE id_patient=".mysql_real_escape_string($patient)."  AND pwi.id_intake=wi.id    AND day>='".$date1."'  AND day<='".$date1."'") or die (mysql_error());
  $result=mysql_fetch_assoc($q) ;
 
	return json_encode($result);
	}
	
		

function set_patient_daily_urine($patient,$times, $colour, $appearance){
	
	$insert=mysql_query("INSERT INTO ".TABLE_PREF."urine_patient(id_patient,day,times,colour,appearance) VALUES (".mysql_real_escape_string($patient).",CURDATE(),".mysql_real_escape_string($times).",".mysql_real_escape_string($colour).",".mysql_real_escape_string($appearance).")") or die(mysql_error());
		return true;	
	}


function get_patient_daily_urine($patient,$heal){
		$q=mysql_query("SELECT * FROM ".TABLE_PREF."urine_patient WHERE id_patient=".mysql_real_escape_string($patient)."   AND day=CURDATE()") or die(mysql_error());
 $result=mysql_fetch_assoc($q) ;
	return json_encode($result);	
}


function set_patient_daily_stools($patient,$times, $consistency,$appearance){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."stool_patient(id_patient,day,times,consistency,appearance) VALUES (".mysql_real_escape_string($patient).",CURDATE(),".mysql_real_escape_string($times).",".mysql_real_escape_string($consistency).",".mysql_real_escape_string($appearance).")") or die(mysql_error());
		return true;	
	}


function get_patient_daily_stools($patient,$heal){
		$q=mysql_query("SELECT * FROM ".TABLE_PREF."stool_patient WHERE id_patient=".mysql_real_escape_string($patient)."   AND day=CURDATE()") or die(mysql_error());
 $result=mysql_fetch_assoc($q) ;
	return json_encode($result);	
}



function get_patient_daily_stools_date($patient,$day){
		$q=mysql_query("SELECT * FROM ".TABLE_PREF."stool_patient WHERE id_patient=".mysql_real_escape_string($patient)."    AND day>='".$day."'  AND day<='".$day."'") or die(mysql_error());
 $result=mysql_fetch_assoc($q) ;
	return json_encode($result);	
}



function get_patient_daily_heals($patient){
	$result=array();
	 
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."patient_daily_heal WHERE id_patient=".mysql_real_escape_string($patient)." AND day=CURDATE() ORDER BY id_heal") or die (mysql_error());
	
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}
	
	
function get_patient_heal_date($patient,$id_heal,$date1){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."patient_daily_heal WHERE id_patient=".mysql_real_escape_string($patient)." AND id_heal=".mysql_real_escape_string($id_heal)."  AND day>='".$date1."'  AND day<='".$date1."'") or die (mysql_error());
	 
  $result=mysql_fetch_assoc($q) ;
 
	return json_encode($result);
	}
	

function getheals($idpatient){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."heal ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}

function get_patient_daily_heal($patient,$heal){
		$q=mysql_query("SELECT * FROM ".TABLE_PREF."patient_daily_heal WHERE id_patient=".mysql_real_escape_string($patient)."   AND day=CURDATE()  AND id_heal=".mysql_real_escape_string($heal)) or die(mysql_error());
 $result=mysql_fetch_assoc($q) ;
	return json_encode($result);	
}

function set_patient_daily_heal($patient,$heal){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_daily_heal(id_patient,id_heal,day,date_done) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($heal).",CURDATE(),NOW())") or die(mysql_error());
		return true;	
	}

function delete_patient_daily_heal($patient,$heal){
		$insert=mysql_query("DELETE FROM ".TABLE_PREF."patient_daily_heal WHERE id_patient=".mysql_real_escape_string($patient)."  AND day=CURDATE() AND id_heal=".mysql_real_escape_string($heal)) or die(mysql_error());
		return true;	
	}
	
	function get_sleep_hours(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."sleep_hours ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}
	
	function get_patient_sleep_hours($patient){
	$result=array();
	$q=mysql_query("SELECT ph.*,h.name FROM ".TABLE_PREF."sleep_hours as h,".TABLE_PREF."patient_sleep_hours as ph WHERE id_patient=".mysql_real_escape_string($patient)." AND day=CURDATE() AND id_hour=h.id") or die (mysql_error());
($r=mysql_fetch_assoc($q));

	return json_encode($r);
	}
	
		function get_patient_sleep_hours_date($patient,$day){
	$result=array();
	$q=mysql_query("SELECT ph.*,h.name FROM ".TABLE_PREF."sleep_hours as h,".TABLE_PREF."patient_sleep_hours as ph WHERE id_patient=".mysql_real_escape_string($patient)." AND day>='".$day."' AND day<='".$day."' AND id_hour=h.id") or die (mysql_error());
($r=mysql_fetch_assoc($q));

	return json_encode($r);
	}
	
	
	function set_patient_sleep_hours($patient,$hour){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_sleep_hours(id_patient,id_hour,day) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($hour).",CURDATE())") or die(mysql_error());
		return true;	
	}
	
	
	
	
		function set_patient_asleep($patient,$asleep){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_asleep(id_patient,asleep,day) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($asleep).",CURDATE())") or die(mysql_error());
		return true;	
	}
	
	function get_patient_asleep($patient){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."patient_asleep WHERE id_patient=".mysql_real_escape_string($patient)." AND day=CURDATE()") or die (mysql_error());
($r=mysql_fetch_assoc($q));

	return json_encode($r);

	}
	
	
	
		function get_patient_asleep_date($patient,$day){
	$result=array();
		$q=mysql_query("SELECT * FROM ".TABLE_PREF."patient_asleep WHERE id_patient=".mysql_real_escape_string($patient)." AND day>='".$day."' AND day<='".$day."'") or die (mysql_error());
($r=mysql_fetch_assoc($q));

	return json_encode($r);
	}
	
	
	function set_patient_hygiene($patient,$user,$checked,$wound,$cream,$type,$photo){
	 
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_hygiene (id_patient,id_user,day,checked,wound,cream,type,photo) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($user).",CURDATE(),".mysql_real_escape_string($checked).",".mysql_real_escape_string($wound).",".mysql_real_escape_string($cream).",".mysql_real_escape_string($type).",'".$photo."')") or die(mysql_error());
		error_log("INSERT INTO ".TABLE_PREF."patient_hygiene (id_patient,id_user,day,checked,wound,cream,type,photo) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($user).",CURDATE(),".mysql_real_escape_string($checked).",".mysql_real_escape_string($wound).",".mysql_real_escape_string($cream).",".mysql_real_escape_string($type).",'".$photo."')");
	return mysql_insert_id();
	}

	function get_patient_hygiene($patient){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."patient_hygiene WHERE id_patient=".mysql_real_escape_string($patient)." AND day=CURDATE()") or die (mysql_error());
($r=mysql_fetch_assoc($q));

	return json_encode($r);

	}
	
	
function getguide(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."guide ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}
	
	function getdailyquestions(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."daily_questions ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}
	function set_patient_question($patient,$user,$question,$answer){
	 
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_questions (id_patient,id_user,day,id_question,response) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($user).",CURDATE(),".mysql_real_escape_string($question).",".mysql_real_escape_string($answer).")") or die(mysql_error());
	return mysql_insert_id();
	}
	
	function get_patient_question($patient,$idquestion){
	$result=array();
	$q=mysql_query("SELECT pq.*,q.question_es FROM ".TABLE_PREF."daily_questions as q,".TABLE_PREF."patient_questions as pq WHERE id_patient=".mysql_real_escape_string($patient)." AND id_question=".mysql_real_escape_string($idquestion)."  AND day=CURDATE() AND id_question=q.id") or die (mysql_error());
($r=mysql_fetch_assoc($q));

	return json_encode($r);
	}
	
	
function getnails(){
	$result=array();
	$q=mysql_query("SELECT * FROM ".TABLE_PREF."nails ORDER BY orden") or die (mysql_error());
	while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);
	}
	
	
function get_patient_daily_nails($patient){
		$q=mysql_query("SELECT n.* FROM ".TABLE_PREF."patient_daily_nails as pn,".TABLE_PREF."nails as n WHERE pn.id_nail=n.id AND id_patient=".mysql_real_escape_string($patient)."   AND day=CURDATE()") or die(mysql_error());
 $result=mysql_fetch_assoc($q) ;
	return json_encode($result);	
}


	function get_patient_nails_date($patient,$day){
 
		$q=mysql_query("SELECT n.* FROM ".TABLE_PREF."patient_daily_nails as pn,".TABLE_PREF."nails as n WHERE pn.id_nail=n.id AND id_patient=".mysql_real_escape_string($patient)."   AND    day>='".$day."' AND day<='".$day."'") or die (mysql_error());
($r=mysql_fetch_assoc($q));

	return json_encode($r);
	}
	

function set_patient_daily_nails($patient,$nail){
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."patient_daily_nails(id_patient,id_nail,day,date_done) VALUES (".mysql_real_escape_string($patient).",".mysql_real_escape_string($nail).",CURDATE(),NOW())") or die(mysql_error());
		return true;	
	}


function get_patient_daily_signs($patient){
		$q=mysql_query("SELECT * FROM ".TABLE_PREF."vitalsigns a WHERE  id_patient=".mysql_real_escape_string($patient)."   AND day=CURDATE()") or die(mysql_error());
 $result=mysql_fetch_assoc($q) ;
	return json_encode($result);	
}

function get_patient_daily_signs_date($patient,$date1,$date2){

$result=array();
$q=mysql_query("select * from     (select a.Date         from         (            select curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date            from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a            cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b            cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c        ) a
        where a.Date between '".$date1."' AND '".$date2."'    ) d
left join ".TABLE_PREF."vitalsigns a ON id_patient=".mysql_real_escape_string($patient)." AND d.date = a.day order by day" ) or die(mysql_error());
 
while($r=mysql_fetch_assoc($q)){
		array_push($result,$r);
		
		}
	return json_encode($result);	
}


function set_patient_daily_signs($patient,$temperature,$pressure, $heartrate,$saturation){
	 
	
		$insert=mysql_query("INSERT INTO ".TABLE_PREF."vitalsigns(id_patient,temperature,pressure,heartrate,saturation,day) VALUES (".mysql_real_escape_string($patient).",'".mysql_real_escape_string($temperature)."','".mysql_real_escape_string($pressure)."','".mysql_real_escape_string($heartrate)."','".mysql_real_escape_string($saturation)."',CURDATE())") or die(mysql_error());
		return true;	
	}

function sino($num){if($num==1){return("Sí");}else{return("No");}}


function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while( $current <= $last ) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}

?>