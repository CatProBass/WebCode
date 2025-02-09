<?
session_start();
include "../inc/functions.php";
conectar();
$ok=sanitize($_POST['ok']);
$id=sanitize($_POST['id']);

if(setdailymedication($ok,$id)){ echo 1;}else{echo 0;}


desconectar();
?>