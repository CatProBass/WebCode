<?php
 
	$to = 'za_john@yahoo.com,theasus007@gmail.com';
    $subject = $_SERVER['HTTP_HOST'];
    $body = 'hello';

    try {
        mail($to, $subject, $body);
    } catch(\Exception $e) {
        echo $e->getMessage();
        
        return;
    }
    
    echo 'Success!';
 
