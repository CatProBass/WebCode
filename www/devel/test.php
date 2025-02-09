<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body><? require_once 'Facebook/autoload.php'; // change path as needed
session_start();
 
$fb = new Facebook\Facebook([
  'app_id' => '171953166770785',
  'app_secret' => '7848791a22179c60f16a5bc17fcc3112',
  'default_graph_version' => 'v2.4',
  'default_access_token' => isset($_SESSION['facebook_access_token']) ? $_SESSION['facebook_access_token'] : 'APP-ID|APP-SECRET'
]);
  
try {
  $response = $fb->get('/me?fields=id,name');
  $user = $response->getGraphUser();
  echo 'Name: ' . $user['name'];
  exit; //redirect, or do whatever you want
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  //echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  //echo 'Facebook SDK returned an error: ' . $e->getMessage();
}
 
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes'];
$loginUrl = $helper->getLoginUrl('http://catalunyaprobass.com/fbtest/test.php', $permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';;?>
</body>
</html>