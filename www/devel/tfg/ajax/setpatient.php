<?
session_start();
include "../inc/functions.php";
conectar();
if(empty($_POST['id']) || $_POST['id']=="undefined"){
$user=json_decode(getuser($_POST['usrtoken']));
 $gp=json_decode(getpatients($user->id));
$patient=$gp[0];	
 
	}else{
$patient=json_decode(getpatient($_POST['id']));}
$_SESSION['patient']=$patient;
echo "1-".$patient->name." ".$patient->surname ;
desconectar();

?>