<?php
 
   $new_image_name = str_replace("/","-",$_POST['filename']).".jpg";
   print_r($_POST);
   move_uploaded_file($_FILES["file"]["tmp_name"], "img/wounds/".$new_image_name);
?>