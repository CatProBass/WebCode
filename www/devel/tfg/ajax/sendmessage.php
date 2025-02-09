<?
session_start();
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_SESSION['usrtoken']));
$from=$user->id;
$to=sanitize($_POST['to']);
$subject=sanitize($_POST['subject']);
$body=sanitize($_POST['body']);
if(sendmessage($from,$to,$subject,$body)){ echo 1;}else{echo 0;}


desconectar();
?>