<?
session_start();
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['usrtoken']));
$patient=sanitize($_POST['patient']);
 
$question=sanitize($_POST['question']);
$answer=sanitize($_POST['answer']);
 

$setpq=set_patient_question($patient,$user->id,$question,$answer);
echo "1-".$setpq;

desconectar();
?>