<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
include ("conn.php");
include( 'wp-load.php');  

global $current_user;
get_currentuserinfo();
//print_r($current_user);
 $userid=$current_user->data->ID;
 die($userid);
 $pdffolder="pdf/";
if(empty($userid)){header("location:/");}
conectar();
 
	global $db;

$query= "SELECT * FROM cpbass_licencias WHERE userid=? AND anyo=".date("Y");

$stmt = $db->prepare($query);
if($stmt === false) {  trigger_error('Wrong SQL: ' . $query. ' Error: ' . $db->errno . ' ' . $db->error, E_USER_ERROR);}
$stmt->bind_param('s',  $userid);
$stmt->execute();
 
  $stmt->bind_result($lid, $uid,$archivo,$anyo);
  while ($stmt->fetch()) {
       $respuesta=array("id"=>$lid,"userid"=> $uid,"archivo"=>$archivo,"anyo"=>$anyo);
	 
    }		
	  $stmt->free_result();
 header("Content-type:application/pdf");
//
 header("Content-Disposition:attachment;filename=licencia_federativa_".date("Y")."_".$current_user->data->user_nicename.".pdf");

readfile($pdffolder.$respuesta['archivo'].".pdf");
cerrar();
?>