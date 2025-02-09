<?

session_start();
include "../inc/functions.php";
conectar();
if(!empty($_POST['token'])){
	$trylogin=json_decode(getuser($_POST['token']));
	}else{
$trylogin=json_decode(trylogin($_POST['username'],$_POST['password']));
}
if($trylogin->error==""){
	$_SESSION['username']=$trylogin->username;
	$_SESSION['usrtoken']=$trylogin->token;
 echo ("1-".$trylogin->token."-".$trylogin->id);
 
	}else{
		echo ("0-".$trylogin->error);
		}

desconectar();
?>