<?
$ch = curl_init();

     $argsPost=array_filter($argsPost, '_remove_empty_internal');

    curl_setopt($ch, CURLOPT_URL, 'https://gourmetv2.apptecnica.com/api/v0/getContents');

    curl_setopt($ch, CURLOPT_POST, 1);



    curl_setopt($ch, CURLOPT_HTTPHEADER,array('GourmetLavanguardia-API_KEY:}s_?!#zK`22`q-4&'));

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($argsPost));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);

    $server_output = curl_exec($ch) ;
	echo $server_output;
		 	echo curl_error ($ch);
	curl_close($ch);
?>