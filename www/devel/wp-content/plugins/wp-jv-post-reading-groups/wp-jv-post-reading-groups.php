<?php
/**
 * Plugin Name: WP JV Post Reading Groups
 * Plugin URI: http://janosver.com/projects/wordpress/wp-jv-post-reading-groups
 * Description: Grant read-only permission for selected users (with no administrator role) on selected private posts
 * Version: 2.4
 * Author: Janos Ver
 * Author URI: http://janosver.com
 * License: GPLv2 or later
 */

//No direct access allowed to plugin php file
if(!defined('ABSPATH')) {
	die('You are not allowed to call this page directly.');
}


/************************************************************************************************************/
/* Adds a Reading Groups metabox to Edit Post and Edit Page screens */
/************************************************************************************************************/

//Support custom post types and allow others to hook into $post_types
function wp_jv_prg_get_post_types() {
	$args = array(
   'public'   => true,
   '_builtin' => false //Exclude things like attachments
	);

	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'

	$post_types = get_post_types( $args, $output, $operator ); 
	//Make sure that the default post and page types are there at all times
	$post_types = array_merge( $post_types, array( 'post' => 'post','page' => 'page' ) );
  	if ( has_filter( 'wp_jv_prg_post_types' ) ){
		  $post_types = apply_filters( 'wp_jv_prg_post_types', $post_types );
  	}
	return $post_types;
}

function wp_jv_prg_modify_post_types( $post_types ) {
  return $post_types;
}
add_filter( 'wp_jv_prg_post_types', 'wp_jv_prg_modify_post_types' );

//Add the box to the edit screens
function wp_jv_prg_add_rg_meta_box_head() {
	$post_types = wp_jv_prg_get_post_types();
	foreach( $post_types as $post_type ) {
	  add_meta_box('wp_jv_prg_sectionid','WP JV Reading Groups','wp_jv_prg_add_rg_meta_box', $post_type,'side','high');
  	}
}
add_action( 'add_meta_boxes', 'wp_jv_prg_add_rg_meta_box_head' );

//Prints the box content
function wp_jv_prg_add_rg_meta_box( $post ) {

	// Add an nonce field so we can check for it later
	wp_nonce_field( 'wp_jv_prg_meta_box', 'wp_jv_prg_meta_box_nonce' );

	//Get all available RGs from database
	$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');
	//Get current user's permissions
	$wp_jv_post_rg=get_post_meta($post->ID, 'wp_jv_post_rg',true);

	//Echo checkboxes and tick saved selections
	if (empty($wp_jv_prg_rg_settings)) {
		echo __('Create some groups first at','wp-jv-post-reading-groups');
		echo ' <a href="options-reading.php">';
		echo __('Settings -> Reading','wp-jv-post-reading-groups');
		echo '</a>';
	}
	else {
	     echo __( 'Select who can read this post', 'wp-jv-post-reading-groups');
		 echo '<br>';

		foreach ($wp_jv_prg_rg_settings as $key => $value) {
			echo '<input type="checkbox" name="wp-jv-reading-group-field-'. $key. '" value="'. $wp_jv_prg_rg_settings[$key]. '" ';
			if (!empty($wp_jv_post_rg) && in_array($key, $wp_jv_post_rg,true)) { echo 'checked="checked"';}
			echo '/>'. $wp_jv_prg_rg_settings[$key]. '<br>';
			}
		}
}

//When the post is saved, saves our custom data
function wp_jv_prg_save_rg_meta_box( $post_id ) {

	// Verify this came from our screen and with proper authorization

	// Check if our nonce is set.
	if ( ! isset( $_POST['wp_jv_prg_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['wp_jv_prg_meta_box_nonce'], 'wp_jv_prg_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	$NewRG=null;
	$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');
	if (!empty($wp_jv_prg_rg_settings)) {
		foreach ($wp_jv_prg_rg_settings as $key => $value) {
			if (isset($_POST['wp-jv-reading-group-field-'. $key])) {$NewRG[]=$key;}
			}
	}
	// Update reading groups custom field in the database.
	update_post_meta( $post_id, 'wp_jv_post_rg', $NewRG );
}
add_action( 'save_post', 'wp_jv_prg_save_rg_meta_box' );


/************************************************************************************************************/
/* Creating Reading Groups @ Settings-> Reading */
/************************************************************************************************************/

//Load WP_List_Table if not loaded
if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	require_once( ABSPATH . 'wp-admin/includes/class-wp-screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
}

/*Start class WP_JV_PRG_List_Table*/
class WP_JV_PRG_List_Table extends WP_List_Table {

	function __construct( $args = array() ){
		$args = wp_parse_args($args,  array(
			'singular'  => __( 'Reading Group','wp-jv-post-reading-groups'),     //singular name of the listed records
			'plural'    => __( 'Reading Groups','wp-jv-post-reading-groups' ),   //plural name of the listed records
			'ajax'      => false,
			'screen' => null
			));
	}

	function get_columns(){
		$columns = array('reading_group' => __('Reading Group','wp-jv-post-reading-groups'), 'count'=>"Count");
		return $columns;
	}

	function column_default( $item, $column_name ) {
		switch( $column_name ) {
		case 'reading_group':
		  return $item[ $column_name ];
		case 'count':
		  return $item[ $column_name ];
		}
	}

	function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$wp_jv_prg_reading_groups_stored=get_option('wp_jv_prg_rg_settings');

		if (!empty($wp_jv_prg_reading_groups_stored)) {
		foreach ($wp_jv_prg_reading_groups_stored as $key=>$value) {
			$wp_jv_prg_reading_groups_to_display[] = array(
					'reading_group'=> $wp_jv_prg_reading_groups_stored[$key], 
					"count" => wp_jv_prg_get_count_of_items_in_rg($wp_jv_prg_reading_groups_stored[$key])
			);
		}
		$this->items=$wp_jv_prg_reading_groups_to_display;
		}
	}

	function display_tablenav($which){
		//Leave it empty to remove tablenav
	}

	function bulk_actions($which = ''){
		//
	}

	//Refresh table with AJAX (no page refresh)
	function ajax_response() {
		$this->prepare_items();
		ob_start();
		if ( ! empty( $_REQUEST['no_placeholder'] ) ) {
			$rows = $this->display_rows();
		}
		else
			{$rows = $this->display_rows_or_placeholder();}
		$rows = ob_get_clean();
		$response = array( 'rows' => $rows );
		die(json_encode( $response ));
	}

	//Add row actions
	function column_reading_group( $item ) {
		$data=get_option('wp_jv_prg_rg_settings');
		$ItemKey=array_search($item['reading_group'],$data);
		$renamediv='<div class="RenameDiv-'. $ItemKey. '"></div>';
		$itemdiv='<div class="ItemDiv-'. $ItemKey. '">'. $item['reading_group']. '</div>';
		$actions = array(
			//Hidden input box
			//Edit link
			'edit'		=> sprintf('<a class="lnkEdit" data-RG="'.
			$ItemKey.
			'" href="'.
			wp_nonce_url( admin_url('options-reading.php?action=edit&rg='. $ItemKey),'edit'. $ItemKey,'jv_prg_nonce')
			. '">'.
			__('Rename','wp-jv-post-reading-groups').
			'</a>'),
			//Delete link
			'delete'		=> sprintf('<a class="lnkDelete" href="'.
			wp_nonce_url( admin_url('options-reading.php?action=delete&rg='. $ItemKey),'delete'. $ItemKey,'jv_prg_nonce').
			'">'.
			__('Delete','wp-jv-post-reading-groups').
			'</a>')
			);
		return sprintf('%1$s %2$s %3$s', $renamediv, $itemdiv, $this->row_actions( $actions ));
	}
}
/*End class WP_JV_PRG_List_Table*/


//Initialize js methods
function wp_jv_prg_load_js_methods() {
   wp_register_script( 'wp_jv_prg_script', plugin_dir_url(__FILE__).'wp-jv-post-reading-groups.min.js', array('jquery') );
   wp_register_style( 'wp_jv_rg_styles',plugin_dir_url(__FILE__).'wp-jv-post-reading-groups.css');

    //support languages
   load_plugin_textdomain('wp-jv-post-reading-groups', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

   //Load script
   wp_enqueue_script( 'wp_jv_prg_script' );
   //Load style
   wp_enqueue_style('wp_jv_rg_styles');
   //Improve security
   $nonce_array = array( 'wp_jv_rg_nonce' =>  wp_create_nonce ('wp_jv_rg_nonce') );
   wp_localize_script( 'wp_jv_prg_script', 'wp_jv_prg_obj', $nonce_array );
}
add_action( 'admin_enqueue_scripts', 'wp_jv_prg_load_js_methods' );


//Refresh WP-List-Table (AJAX call handler)
function wp_jv_prg_refresh_rg_list() {
	$wp_jv_prg_reading_groups_table = new WP_JV_PRG_List_Table();
	$wp_jv_prg_reading_groups_table->ajax_response();
}
add_action('wp_ajax_wp_jv_prg_refresh_rg_list', 'wp_jv_prg_refresh_rg_list');


//Add new Reading Group to database (AJAX call handler)
function wp_jv_prg_add_new_rg_to_db() {
   //Avoid being easily hacked
	if (!isset($_POST['wp_jv_rg_nonce']) || !wp_verify_nonce($_POST['wp_jv_rg_nonce'],'wp_jv_rg_nonce')) {
		$result=array('error'	   => true,
			 		   'error_msg'  => 'Something went wrong',
					   'error_code' => 'F-01');
		header('Content-Type: application/json');
		die(json_encode($result));
	}

	//No value OR empty -> no data saved
	if(isset($_POST['newrg'])) {
		$newRG = sanitize_text_field($_POST['newrg']);
		if (!empty($newRG)) {
			$data = get_option('wp_jv_prg_rg_settings');
			if (!array_search($newRG,$data) ) {
				$data[] =$newRG;
				update_option('wp_jv_prg_rg_settings',$data);
				$result=array('error'	   => false,
							  'error_msg'  => 'Reading Group: '. $newRG. ' added',
							  'error_code' => null);
				}
				else {
					  $result=array('error'	   => true,
									'error_msg'  => __('Reading Group name','wp-jv-post-reading-groups').' "'. $newRG. '" '.__('already exists.','wp-jv-post-reading-groups'),
									'error_code' => 'P-01');

					}
		} else {
				$result=array('error'	   => true,
					  'error_msg' => __('Please specify a valid Reading Group name.','wp-jv-post-reading-groups'),
					  'error_code' => 'P-02');
			}
	}
	else $result=array('error'	    => true,
			 		   'error_msg'  => 'Something went wrong',
					   'error_code' => 'F-02');
	//to debug uncomment the following 3 lines
	/*
	$result=array_merge($result,array('action'		=>	'add',
					'newRG'	=>	sanitize_text_field($_POST['newrg'])
					));
	*/
	header('Content-Type: application/json');
	die(json_encode($result));
}
add_action('wp_ajax_wp_jv_prg_add_new_rg_to_db','wp_jv_prg_add_new_rg_to_db');



//Rename existing Reading Group in database (AJAX call handler)
//SaveRenamedRGtoDB
function wp_jv_prg_save_renamed_rg_to_db() {
    //RGToRename = Existing RG ID
	//NewRGName = New RG name

	//No value OR empty -> no data saved
	$NewRGName = sanitize_text_field($_POST['NewRGName']);
	$RGToRename = $_POST['RGToRename'];
	if(isset($_POST['RGToRename']) && isset($_POST['NewRGName'])) {
		if (!empty($NewRGName)) {
			$data = get_option('wp_jv_prg_rg_settings');
			if (!empty($data[$RGToRename]) ) {
				if (!array_search($NewRGName,$data,true) && array_search($NewRGName,$data,true) !==0 ) {
					$data[$RGToRename] = $NewRGName;
					update_option('wp_jv_prg_rg_settings',$data);
					$result=array('error'	   => false,
								  'error_msg'  => 'Reading Group: '. $data[$RGToRename]. ' renamed to'. $NewRGName,
								  'error_code' => null);
					}
					else {
							$result=array('error'	   => true,
										'error_msg'  => __('Reading Group','wp-jv-post-reading-groups').' "'. $NewRGName. '" '.__('already exists.','wp-jv-post-reading-groups'),
										'error_code' => 'P-03');

						}
				}
				else {
						$result=array('error'	   => true,
									'error_msg'  => __('Reading Group','wp-jv-post-reading-groups').' "'. $data[$RGToRename]. '" '.__('does not  exists.','wp-jv-post-reading-groups'),
									'error_code' => 'P-04');
					}
		} else {
				$result=array('error'	   => true,
					  'error_msg'  => __('Please specify a valid Reading Group name.','wp-jv-post-reading-groups'),
					  'error_code' => 'P-05');
			}
	}
	else $result=array('error'	   => true,
			 		   'error_msg'  => 'Something went wrong',
					   'error_code' => 'F-03');

	//to debug uncomment the following 4 lines
	/*
	$result=array_merge($result,array('action'		=>	'rename',
					'RGToRename'	=>	$RGToRename,
					'NewRGName'		=>	$NewRGName
					));
	*/
	header('Content-Type: application/json');
	die(json_encode($result));
}
add_action('wp_ajax_wp_jv_prg_save_renamed_rg_to_db','wp_jv_prg_save_renamed_rg_to_db');


//Delete row (AJAX call handler)
function wp_jv_prg_delete_rg() {
    //Check if we are getting hacked
	$url=parse_url($_POST['delurl']);
	parse_str($url['query'],$params);
	if (empty($params['action']) || ( empty($params['rg']) && $params['rg'] !=0 ) || empty($params['jv_prg_nonce']) || !wp_verify_nonce($params['jv_prg_nonce'],'delete'. $params['rg'])) {
		$result=array('error'=> true,
					  'error_msg'  => 'Something went wrong.',
					  'error_code' => 'F-04'
					);
		//to debug uncomment the following line
		//$result=array_merge($result,$params);
		header('Content-Type: application/json');
		die(json_encode($result));
	}

	//Remove this RG from all Posts where it is being used

	//Get list of posts might affected
	global $wpdb;
	$posts_affected = $wpdb->get_results("
	select id, meta_value
	from 	$wpdb->posts p,
			$wpdb->postmeta pm
	where p.id=pm.post_id
		  and pm.meta_key='wp_jv_post_rg'
	");

	//Get all RGs
	$wp_jv_prg_rg_settings=get_option('wp_jv_prg_rg_settings');
	//Get the one we need to delete
	$RG_to_be_deleted=$params['rg']; //this is an RG ID actually


	//Go through list of posts might affected and remove this RG one by one if associated
	//$value->id == Post ID
	//unserialize($value->meta_value) == array(RG ID)
	foreach ($posts_affected as $value) {
		//We don't care about those posts which has got no RG associated at all
		$postRG=unserialize($value->meta_value);
		if (!empty($postRG)) {
			//Search for RG we want to delete
			if (in_array($RG_to_be_deleted, $postRG)) {
				update_post_meta($value->id, 'wp_jv_post_rg', array_diff($postRG,array($RG_to_be_deleted)));
			}
		}
	}

	//Get rid of that RG
	update_option('wp_jv_prg_rg_settings',array_diff($wp_jv_prg_rg_settings, array($wp_jv_prg_rg_settings[$RG_to_be_deleted])));

	$result=array('error'=> false);

	//to debug uncomment the following line
	//$result=array_merge($result,$params);

	header('Content-Type: application/json');
	die(json_encode($result));

}
add_action('wp_ajax_wp_jv_prg_delete_rg', 'wp_jv_prg_delete_rg');


//Adding settings to Settings->Reading
function wp_jv_prg_add_rg_to_settings_reading() {
	add_settings_section('wp_jv_prg_rg_settings','WP JV Post Reading Groups','wp_jv_prg_settings','reading');

	add_option('wp_jv_prg_rg_settings',array());
}
add_action( 'admin_init', 'wp_jv_prg_add_rg_to_settings_reading' );


//WP JV Post Reading Groups Settings section intro text
function wp_jv_prg_settings() {
	//Wrapper
	echo '<div class="jv-wrapper">';

	//Header
	echo '<div class="jv-header">';
	echo __('Create your Reading Groups and then assign these to','wp-jv-post-reading-groups').' <a href="users.php">'.__('users','wp-jv-post-reading-groups').'</a>.<br><br>';
	echo '</div>'; //jv-header end

	//Left side: Add new RG functionality
	echo '<div class="jv-left">';
	echo __('Reading Group Name','wp-jv-post-reading-groups');
	echo '<br>';
    echo '<input type="text" name="new_reading_group" class="jv-new-reading-group-text" id="jv-new-reading-group-text"/><br>';
	echo '<input type="button" id="btnAddNewRG" class="button-primary" value="'.__('Add New Reading Group','wp-jv-post-reading-groups').'" />';
	//Add loading image - hidden by default
	echo '<img id="spnAddRG" src="'. admin_url() . '/images/wpspin_light.gif" style="display: none;">';
	echo '</div>';//jv-left end

    //Right side: List of reading groups
	echo '<div class="jv-right">';
	$wp_jv_prg_reading_groups_table = new WP_JV_PRG_List_Table();
	$wp_jv_prg_reading_groups_table->screen=convert_to_screen( null );
	$wp_jv_prg_reading_groups_table->prepare_items();
	$wp_jv_prg_reading_groups_table->display();
	echo '</div>'; //jv-right end

	//no footer this time
	echo '<div class="jv-footer">';
	echo '</div>'; //jv-footer end

	echo '</div>'; //jv-wrapper end

}

/************************************************************************************************************/
//Add Reading Groups to User's Profile screen
/************************************************************************************************************/

function wp_jv_prg_user_profile($user) {

	//Only admins can see these options
	if ( !current_user_can( 'edit_users' ) ) { return; }

	//Wrapper
	echo '<div class="jv-wrapper">';

	//Header
	echo '<div class="jv-header">';
	echo '<h3>WP JV Reading Groups</h3>';
	echo '</div>'; //jv-header end

	echo '<div class="jv-content">';

	if (!empty($user->ID)) {
		if ( user_can($user->ID, 'edit_users' ) ) {
			echo __('Administrators access all posts.','wp-jv-post-reading-groups').'<br>';
		}
	}

	echo __('Grant permissions for the following Reading Group(s)','wp-jv-post-reading-groups').'<br>';

	//Get all available RGs from database
	$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');

	$wp_jv_user_rg=null;
	//Get current user's permissions
	if (!empty($user->ID)) {
		$wp_jv_user_rg=get_user_meta($user->ID, 'wp_jv_user_rg',true);
	}

	//Echo checkboxes and tick saved selections
	if (empty($wp_jv_prg_rg_settings)) {
		echo __('Create some groups first at','wp-jv-post-reading-groups');
		echo ' <a href="options-reading.php">';
		echo __('Settings -> Reading','wp-jv-post-reading-groups');
		echo '</a>';
	}
	else {
		foreach ($wp_jv_prg_rg_settings as $key => $value) {
			echo '<input type="checkbox" name="wp-jv-reading-group-field-'. $key. '" value="'. $wp_jv_prg_rg_settings[$key]. '"';
			if (!empty($wp_jv_user_rg) && in_array($key, $wp_jv_user_rg,true)) { echo 'checked="checked"';}
			echo '/>'. $wp_jv_prg_rg_settings[$key]. '<br>';
			}
		}

	echo '</div>'; //jv-content end

	//no footer this time
	echo '<div class="jv-footer">';
	echo '</div>'; //jv-footer end

	echo '</div>'; //jv-wrapper end

}
add_action( 'show_user_profile', 'wp_jv_prg_user_profile' );
add_action( 'edit_user_profile', 'wp_jv_prg_user_profile' );


//Save Profile settings
function wp_jv_prg_save_user_profile( $user_id ) {
	//Only admins can save
	if ( !current_user_can( 'edit_users', $user_id ) ) { return; }

	$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');

	if (empty($wp_jv_prg_rg_settings)) {
		return;
	}
	else {
		$newRG=null;
		foreach ($wp_jv_prg_rg_settings as $key => $value) {
			if (isset($_POST['wp-jv-reading-group-field-'. $key])) {
				$newRG[]=$key;
			}
		}
		update_user_meta( $user_id, 'wp_jv_user_rg', $newRG );
		//Check if new RG saved successfully
		if ( get_user_meta($user_id,  'wp_jv_user_rg', true ) != $newRG ) {	wp_die('Something went wrong.<br>[Error: F-05] ');}
	}
}
add_action( 'personal_options_update', 'wp_jv_prg_save_user_profile' );
add_action( 'edit_user_profile_update', 'wp_jv_prg_save_user_profile' );


/************************************************************************************************************/
/* Add Reading Groups to Add New User screen */
/************************************************************************************************************/
add_action('user_new_form','wp_jv_prg_user_profile');
add_action('user_register','wp_jv_prg_save_user_profile');

/************************************************************************************************************/
/* Add Reading Groups to All Users screen */
/************************************************************************************************************/

//Add column
function wp_jv_prg_all_users_column_register( $columns ) {
    $columns['wp_jv_prg'] = __('Reading Groups','wp-jv-post-reading-groups');
    return $columns;
}

//Add rows
function wp_jv_prg_all_users_column_rows( $empty, $column_name, $user_id ) {
    $rg=null;
	if ( 'wp_jv_prg' != $column_name ) {
        return $empty;
	}
	if (user_can($user_id,'edit_users')) {$rg=__('Access all RGs','wp-jv-post-reading-groups');}
	else {
		$wp_jv_user_rg=get_user_meta($user_id,'wp_jv_user_rg',true);
		if (empty($wp_jv_user_rg)) {$rg = null;} //Access only public posts
		else {
			$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');
			foreach ($wp_jv_user_rg as $key => $value) {
				$count_of_items = wp_jv_prg_get_count_of_items_in_rg($wp_jv_prg_rg_settings[$value]); 
				$rg=$rg. $wp_jv_prg_rg_settings[$value]. ' ('.$count_of_items.')<br>';
			}
		}
	}
    return $rg;
}
add_filter( 'manage_users_columns', 'wp_jv_prg_all_users_column_register' );
add_filter( 'manage_users_custom_column', 'wp_jv_prg_all_users_column_rows', 10, 3 );

/************************************************************************************************************/
//Add Reading Groups to All Posts screen
/************************************************************************************************************/

//Add column
function wp_jv_prg_all_posts_column_register( $columns ) {
    $columns['wp_jv_prg'] = __('Reading Groups','wp-jv-post-reading-groups');
    return $columns;
}

//Add rows
function wp_jv_prg_all_posts_column_rows($column_name, $post_id ) {
    if ( 'wp_jv_prg' != $column_name ) {
        return;
	}
	$wp_jv_post_rg=get_post_meta($post_id,'wp_jv_post_rg',true);
	$rg = null;
	if (empty($wp_jv_post_rg)) {$rg = null;} //Access only public posts
	else {
		$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');
		foreach ($wp_jv_post_rg as $key => $value) {
			$rg=$rg. $wp_jv_prg_rg_settings[$value]. '<br>';
		}
	}
    echo $rg;
}
add_filter( 'manage_posts_columns', 'wp_jv_prg_all_posts_column_register' );
add_filter( 'manage_posts_custom_column', 'wp_jv_prg_all_posts_column_rows', 10, 2 );


/************************************************************************************************************/
//Add Reading Groups to All Pages screen
/************************************************************************************************************/

//Add column
function wp_jv_prg_all_pages_column_register( $columns ) {
    $columns['wp_jv_prg'] = __('Reading Groups','wp-jv-post-reading-groups');
    return $columns;
}

//Add rows
function wp_jv_prg_all_pages_column_rows($column_name, $post_id ) {
    if ( 'wp_jv_prg' != $column_name ) {
        return;
	}
	$wp_jv_post_rg=get_post_meta($post_id,'wp_jv_post_rg',true);
	$rg = null;
	if (empty($wp_jv_post_rg)) {$rg = null;} //Access only public posts
	else {
		$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');
		foreach ($wp_jv_post_rg as $key => $value) {
			$rg=$rg. $wp_jv_prg_rg_settings[$value]. '<br>';
		}
	}
    echo $rg;
}

add_filter( 'manage_pages_columns', 'wp_jv_prg_all_pages_column_register' );
add_filter( 'manage_pages_custom_column', 'wp_jv_prg_all_pages_column_rows', 10, 2 );

/************************************************************************************************************/
//Influence display posts
/************************************************************************************************************/

// Amend status of privately published posts if user has permission to view it
/* This is a permanent fix for the issue when a subscriber was not able to comment on private posts to which he/she has read access
Original doc: https://codex.wordpress.org/Plugin_API/Filter_Reference/user_has_cap
*/
function wp_jv_prg_grant_read_post($allcaps, $cap, $args ) {
	if (($args[0]!='read_post') ) {
		return $allcaps;
	}
	//Exit if it is not post related
	if (empty($args[2])) {
		return $allcaps;
	}
	$post = get_post( $args[2] );
	$current_user = $args[1];
	$can_view_this_post = wp_jv_prg_user_can_see_a_post($current_user, $post->ID);
	if ($post->post_status == 'private' && $can_view_this_post) {
		$allcaps[$cap[0]] = true;
	}
    return $allcaps;
}
add_filter('user_has_cap','wp_jv_prg_grant_read_post',10,3);


//Display private posts as well (only those for which user has permissions)
function wp_jv_prg_posts_where_statement($where) {
	global $wpdb;

	if (is_page()) {return $where;}
	if (is_feed()) {return $where;}
	if (is_attachment()) {return $where;}
	if (is_preview()) {return $where;}
	
	if (is_admin()){
		return $where;
	}

	if(is_user_logged_in()) {
		$who_is_the_user=get_current_user_id();
		// Handle categories, tags
		if (is_archive()) {
			
			//Private posts in a category will be displayed if the user has permission to read it
			if (is_category()) {
				$category=single_cat_title(null,false);
				$query_args = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'name',
							'terms' => $category
						)
					),
					'post_status' =>array('private','publish'),
					'posts_per_page'=>-1
				);
				$all_posts_in_category = get_posts($query_args);
				$to_show=array();
				foreach ($all_posts_in_category as $key => $value) {
					if ((wp_jv_prg_user_can_see_a_post(get_current_user_id(), $value->ID))) {
						$to_show[]=$value->ID;
					}
				}
				if (!empty($to_show)) {
					$where =" AND $wpdb->posts.post_type = 'post' AND $wpdb->posts.ID IN (". implode(',',$to_show). ")";
				}
				return $where;
			}
			//When a specific tag has been clicked on and content with that tag is being displayed
			else if (is_tag()) {
				//Private posts with a given tag will be displayed if the user has permission to read it
				$tag=single_tag_title(null,false);
				$query_args = array(
					'tag_slug__in' => $tag,
					'post_status' =>array('private','publish'),
					'posts_per_page'=>-1
				);
				$all_posts_with_tag = get_posts($query_args);
				$to_show=array();
				foreach ($all_posts_with_tag as $key => $value) {
					if ((wp_jv_prg_user_can_see_a_post(get_current_user_id(), $value->ID))) {
						$to_show[]=$value->ID;
					}
				}
				if (!empty($to_show)) {
					$where =" AND $wpdb->posts.post_type = 'post' AND $wpdb->posts.ID IN (". implode(',',$to_show). ")";
				}

				return $where;
			}
			else {return $where;}
		}
		//Display all to admins
		if (user_can($who_is_the_user,'edit_users')) {
			if (is_single()) {
				$where .= " AND $wpdb->posts.post_status IN ('private','publish')";
			}
			else {
				$where = " AND $wpdb->posts.post_type = 'post'
						   AND $wpdb->posts.post_status IN ('private','publish') ";
			}
			return $where;
		}
		else {
		//sigle post
		if (is_single()) {
			$where .= " AND $wpdb->posts.post_status IN ('private','publish')";
		}
		//multiple posts
		else {
			$request = "
			SELECT ID,
				   meta_value as wp_jv_post_rg
			FROM $wpdb->posts,
				 $wpdb->postmeta
			WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
			AND post_status='private' AND meta_key='wp_jv_post_rg'";
			$all_posts = $wpdb->get_results($request);
			$to_show=array();
			foreach ($all_posts as $key => $value) {
				if ((wp_jv_prg_user_can_see_a_post(get_current_user_id(), $value->ID))) {
					$to_show[]=$value->ID;
				}
				//If user has access to at least one private post
				if (!empty($to_show)) {
					$where = " AND $wpdb->posts.post_type = 'post'
							   AND ( ($wpdb->posts.ID IN (".implode(',',$to_show).") AND $wpdb->posts.post_status ='private')
									 OR ($wpdb->posts.post_author=$who_is_the_user AND $wpdb->posts.post_status ='publish')
									 OR  $wpdb->posts.post_status ='publish') ";

				}
			}
		} //End multiple post
		} //End non-admins
	} //End change only for logged-in users
	return $where;
}
add_filter( 'posts_where' , 'wp_jv_prg_posts_where_statement' );


//Enable private post URLs to eligible users
function wp_jv_prg_posts_results($posts) {
	if (is_admin()){
		return $posts;
	}

	if (is_archive()) {
		//fixing categories
		if (is_category() && !empty($posts)) {
			$category=single_cat_title(null,false);
			foreach ($posts as $value) {
				if (in_category($category,$value->ID))	{
					$value->post_status = 'publish';
				}
			}
		}
	}
	else {
		//for posts only
		if(is_user_logged_in() && !empty($posts)) {
			foreach ($posts as $value) {
				if (wp_jv_prg_user_can_see_a_post(get_current_user_id(), $value->ID))	{
					$value->post_status = 'publish';
					}
			}
		}
	}
	return $posts;
}
add_filter('posts_results', 'wp_jv_prg_posts_results');

/************************************************************************************************************/
// Influence how comments are displayed
//
// Show comments for private posts/pages if the user is eligible
/************************************************************************************************************/

function wp_jv_prg_show_private_comments( $comment_args ) {
	global $wpdb;

	if (is_admin()){
		return $comment_args;
	}
	$comment_args['status'] = 'approve';
	if(is_user_logged_in()) {
		$who_is_the_user=get_current_user_id();
		//Find out which private posts the user can read
		$private_posts = "
		SELECT ID,
			   meta_value as wp_jv_post_rg
		FROM $wpdb->posts,
			 $wpdb->postmeta
		WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
		AND post_status='private' AND meta_key='wp_jv_post_rg'";
		$all_private_posts = $wpdb->get_results($private_posts);
		$private_to_show=array();
		foreach ($all_private_posts as $key => $value) {
			if ((wp_jv_prg_user_can_see_a_post($who_is_the_user, $value->ID))) {
				$private_to_show[]=$value->ID;
			}
		}

		if (!empty($private_to_show)) {
			//If user can access any private we need to find out which are the public ones
			$public_posts = "
			SELECT ID
			FROM $wpdb->posts
			WHERE post_status='publish'";
			$all_public_posts  = $wpdb->get_results($public_posts );
			$to_show=$private_to_show;
			foreach ($all_public_posts  as $key => $value) {
				if ((wp_jv_prg_user_can_see_a_post($who_is_the_user, $value->ID))) {
					$to_show[]=$value->ID;
				}
			}
			// we need to list all posts IDs even if those are public
			$comment_args['post__in'] = $to_show;
			$comment_args['post_status'] = array('publish','private');
		}
		else $comment_args['post_status'] = array('publish');
	}
	return $comment_args;
}
add_filter( 'widget_comments_args', 'wp_jv_prg_show_private_comments' );


/************************************************************************************************************/
//Influence default widgets
/************************************************************************************************************/

//Display private only categories if the user has permission
//#TODO: if 'Display as dropdown' is checked on Appearance->Widgest screen for the Categories widget, then private only categories are still missing and it hasn't been tested with the 'Show hierarchy' option enabled
function wp_jv_prg_add_private_to_category_widget($output,$args) {
	//First we need to make sure the user is logged in
	if(is_user_logged_in()) {
		$who_is_the_user=get_current_user_id();
		$all_posts = get_posts(array('post_status' =>array('private','publish'),'posts_per_page'=>-1));

		$to_show=array();
		foreach ($all_posts as $key => $value) {
			if ((wp_jv_prg_user_can_see_a_post($who_is_the_user, $value->ID))) {
				$to_show[]=$value->ID;
			}
		}
		//$to_show now contains all the posts the user have access to
		if (!empty($to_show)) {

			//$post_categories=wp_get_post_terms( $to_show[1], 'category');
			//echo $post_categories[0]->term_id;

			$list_of_all_categories = array();
			foreach ($to_show as $key => $value) {
				//Get all categories a single post belongs to
				$post_categories=wp_get_post_terms( $to_show[$key], 'category');
				foreach ($post_categories as $key => $value) {
					//Get a list of term ids (which we use to identify categories a single post belongs to)
					//So if post 1 belongs to category A,B and C and post 2 belongs to category A,B
					//then this array will contain the term id of A and B twice and C once
					$list_of_all_categories[]=$post_categories[$key]->term_id;
				}
			}
			//Creating and array of term_id->count
			$unique_categories_with_count=array_count_values($list_of_all_categories);

			//If there is any category to display
			if (!empty($unique_categories_with_count)) {
				//Handling "Show post counts" options
				//If it is enabled then we need to count it as private posts are not counted in (counts are stored in <wp_db_prefix>_term_taxonomy.count column)
				$need_to_show_counts=false;
				if (array_key_exists('show_count',$args)) {
					if ($args['show_count'] == 1) {
					$need_to_show_counts=true;
					}
				}
				$new_output='';
				foreach ($unique_categories_with_count as $key => $value) {
					//Don't display the default Uncategorized category which is always id=1
					if ($key<>1) {
						$cat_item=get_term( $key, 'category');
						//We need to put together the actual HTML code which will be displayed
						$new_output .='<li class="cat-item cat-item-'.$cat_item->term_id.'"><a href="'.get_category_link ($cat_item->term_id).'" >'.$cat_item->name.($need_to_show_counts ? ' ('.$value.')':'').'</a> </li>';
					}
				$output=$new_output;
				}
			}
		}
	}
	return $output;
}
add_filter('wp_list_categories','wp_jv_prg_add_private_to_category_widget',10,2);


#TODO: add tags with private posts only to tag cloud

/************************************************************************************************************/
// Permission management
/************************************************************************************************************/

//Check if a user can access a particular category (there is at least one post in that category the user can see)
function wp_jv_prg_user_can_see_a_category($user, $category_id) {
	$user_can_see_a_category=false;
	//Try to use user irrespectively of its type
	if (is_a($user, 'WP_User')) {
		$uid=$user->ID;
	} else {
		$uid=$user;
	}
	//Get all posts within the category
	$all_posts = get_posts(array('category'=>$category_id,'post_status' =>array('private','publish'),'posts_per_page'=>-1));
	foreach ($all_posts as $key=>$value) {
		//Check if the user can see a post
		if (wp_jv_prg_user_can_see_a_post($uid,$value->ID)) {
			//Stop processing if there is any post the user can see
			$user_can_see_a_category=true;
			break;
		}
	}
	return $user_can_see_a_category;
}

// Check if a user can see a particular post
// This supports WP JV Custom Email Settings Plugin as well
function wp_jv_prg_user_can_see_a_post($user, $post_id) {
	$user_can_see_a_post=false;

	//Try to use user irrespectively of its type
	if (is_a($user, 'WP_User')) {
		$uid=$user->ID;
	} else {
		$uid=$user;
	}

	//If a post is public then anybody can see it
	if (get_post($post_id)->post_status == 'publish') { $user_can_see_a_post=true; }

	else {
		//Display all to admins
		if (user_can($uid,'edit_users')) {$user_can_see_a_post=true; }
		else {
			//Get current user and his/her permissions
			$user_permissions = get_user_meta($uid,'wp_jv_user_rg',true);
			if (!is_array($user_permissions)) {
				$user_permissions=str_split($user_permissions);
			}

			//if current user has any kind of permission...
			if ($user_permissions) {
				$post_permitted=get_post($post_id)->wp_jv_post_rg;

				//Check if post has any Reading Group assigned to it or not (if not only admins can see it)
				if (!is_null($post_permitted)) {
					//Convert to array if necessary
					if (!is_array($post_permitted)) {
						$post_permitted=str_split($post_permitted);
					}

					//If post permissions set AND current user has appropriate permissions add this post to the list of posts to show
					$this_user_can_see_this_post=array_intersect($user_permissions, $post_permitted);

					if (!empty($user_permissions) && !empty($this_user_can_see_this_post)) {
						$user_can_see_a_post=true;
					}
				}
			}
		}
	}
	return $user_can_see_a_post;
}

//Count of pages, posts, custom post types by Reading Group
function wp_jv_prg_get_count_of_items_in_rg($rg_name){
	$count = 0;
	//get all posts
	$all_posts = get_posts(array('post_type'=>wp_jv_prg_get_post_types(), 'post_status' =>array('private','publish'),'posts_per_page'=>-1));
	//Get all available RGs from database
	$wp_jv_prg_rg_settings = get_option('wp_jv_prg_rg_settings');
	//loop through all posts
	foreach ($all_posts as $pkey=>$pvalue) {

		//get reading groups for that post
		$post_rgs = get_post_meta($pvalue->ID, 'wp_jv_post_rg',true);

		//If the post is part of a reading group
		if (!empty($post_rgs)) {
			//loop through all reading groups for a post
			foreach ($post_rgs as $rgkey=>$rgvalue){
				//Increment when the post belongs to the reading group we are looking for
				if ($rg_name == $wp_jv_prg_rg_settings[$rgvalue]) {
				 $count = $count +1;
				}
				
			}
		}
	}
	return $count;
} 

//Remove 'Private:' text from title
function wp_jv_prg_remove_private_from_title($title){
	return str_replace( sprintf( __('Private: %s'), '' ), '', $title );
}
add_filter('the_title', 'wp_jv_prg_remove_private_from_title');


/************************************************************************************************************/
/* Remove private pages and categories from menus if user is not eligible or not logged in */
/************************************************************************************************************/
function wp_jv_prg_remove_private_pages_from_menu_items( $items, $menu, $args ) {
	foreach ( $items as $key => $item ) {
		//Remove private pages
		if ($item->object=='page') {
			if (get_post_field( 'post_status', $item->object_id )=='private') {
				//check permissions and if not entitled remove it
				if(!is_user_logged_in() || !wp_jv_prg_user_can_see_a_post(get_current_user_id(), $item->object_id)) {
					unset( $items[$key] );
				}
			}
		}
		//Remove private categories
		if ($item->object=='category') {
			if(!wp_jv_prg_user_can_see_a_category(get_current_user_id(),$item->object_id)) {
					unset( $items[$key] );
				}
		}
		//Do not remove from the menu any custom links, even if they point to pages/categories or posts which are private regardless of the users' permissions
		//if ($item->object=='custom') { null;}
	}
    return $items;
}
add_filter( 'wp_get_nav_menu_items', 'wp_jv_prg_remove_private_pages_from_menu_items',null, 3 );


/************************************************************************************************************/
/* Debugging */
/************************************************************************************************************/
function debug_to_console( $data ) {
	$output = $data;
	if ( is_array( $output ) ) {
		if (empty($output)) {
			echo "<script>console.log('Empty array');</script>";	
		}
		else {
			$output = implode( ',', $output);
			echo "<script>console.log('Array converted to string:');</script>";	
			echo "<script>console.log('$output');</script>";
		}
	}
	else {
		if (is_bool($data)) {
			if ($data) {
				echo "<script>console.log('true');</script>";	
			}
			else {
				echo "<script>console.log('false');</script>";	
			}
		} 
		else {
			echo "<script>console.log('$output');</script>";
		}	
	}
}

?>
