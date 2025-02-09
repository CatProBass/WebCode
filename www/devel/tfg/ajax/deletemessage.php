<?
session_start();
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_SESSION['usrtoken']));
$to=$user->id;
$id=sanitize($_POST['id']);

if(deletemessage($id,$to)){ echo 1;}else{echo 0;}


desconectar();
?>