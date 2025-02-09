<?
 
//if (isset($_POST["regId"]) && isset($_POST["message"])) {
    $regId = $_POST["regId"];
    $plataforma= "Android";
    $message = $_POST["message"];
    $title= $_POST["title"];
 
#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AAAANVpj1nQ:APA91bEG2gOZqu-NQSzkY5ajwHSCnKw30B_jjC3UimQhNwEWvcxtTtctEkRl6pMyZwPTSzLgFooqN5gAMjNWUjt5PvwGhGWgHVPvQHBnNDY-1qf0c2_fZsNMKlJHuBZYAZzaNzkUAHyX' );
    $registrationIds = $_GET['id'];
#prep the bundle
     $msg = array
          (
		'body' 	=> 'Body  Of Notification',
		'title'	=> 'Title Of Notification',
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
          );
	$fields = array
			(
				'to'		=> $registrationIds,
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
#Echo Result Of FireBase Server
echo $result;
//}

?> 