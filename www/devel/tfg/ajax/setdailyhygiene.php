<?
session_start();
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['usrtoken']));
$patient=sanitize($_POST['patient']);
$checked=sanitize($_POST['checked']);
$wound=sanitize($_POST['wound']);
$type=sanitize($_POST['type']);
$cream=sanitize($_POST['cream']);
$photo=sanitize($_POST['photo']);

$sethygiene=set_patient_hygiene($patient,$user->id,$checked,$wound,$cream,$type,$photo);
echo "1-".$sethygiene;

desconectar();
?>