<?php

/**
 * @package hotel-booking-progress-bar
 * @version 1.0.0
 */

/**
* Plugin Name: Hotel Bookings Progress Bar for MotoPress
* Plugin URI:  https://www.millswebdevelopment.com/progress-bar-plugin.html
* Text Domain: hotel-booking-progress-bar
* Description: This plugin Will allow the addition of a progress bar to the MotoPress hotel booking process. It requires MotoPress Hotel Bookings to be installed.
* Author:      Mills Web Development
* Version:     1.0.0
* Author URI:  https://www.millswebdevelopment.com
* License:     GPL v2 or later
*/


//Add plugin settings to WordPress 'Settings' menu
function mphbpb_menu_option() {
	add_submenu_page( 'options-general.php', 'Hotel Booking Progress Bar', 'Booking Progress Bar', 
		'manage_options', 'hotel_booking_progress_bar_menu', 'mphbpb_menu_page', '', 200 );
}

add_action('admin_menu', 'mphbpb_menu_option');


//Add color picker functionality
function mphbpb_enqueue_color_picker( $hook_suffix ) {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'add-color-picker', plugins_url('/assets/js/colorPickerScript.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

add_action( 'admin_enqueue_scripts' , 'mphbpb_enqueue_color_picker' );


//Retrieve values from database, escape and return array of values
function mphbpb_DB_query() {
	$dbValues = array(
		'step1' => wp_kses_post( stripslashes( get_option( 'mphbpb_step_1' , '<strong>Step 1:</strong><br />Search Results' ) ) ),
		'step2' => wp_kses_post( stripslashes( get_option( 'mphbpb_step_2' , '<strong>Step 2:</strong><br />Booking Details' ) ) ),
		'step3' => wp_kses_post( stripslashes( get_option( 'mphbpb_step_3' , '<strong>Step 3:</strong><br />Booking Confirmed' ) ) ),
		'greyedOut' => esc_attr( get_option( 'mphbpb_greyed_out' , '#CCC' ) ),
		'activeColor' =>  esc_attr( get_option( 'mphbpb_active' , '#555' ) ),
		'showSubmitted' => esc_attr( get_option( 'mphbpb_show_submitted' , 'on' ) )
	);
	return $dbValues;
}


//Layout and options for plugin admin page 
function mphbpb_menu_page() {

	//Check is settings were saved and check nonce
	if( array_key_exists( 'submit_mphbpb_changes' , $_POST ) ){

		$retrieved_nonce = $_REQUEST['_wpnonce'];

		if ( !wp_verify_nonce( $retrieved_nonce , 'update_mphbpb_settings' ) ){ 
			?>
			<div id="setting-error-settings_updated" class="notice notice-error is-dismissible">
				<p>
					<strong>There was an error and the data was not saved! Please try again.</strong>
				</p>
			</div>
			<?php
		} else {
			//Sanitize data and update database
			$greyedOut = sanitize_hex_color( $_POST['mphbpb_greyed_out'] );
			$activeColor = sanitize_hex_color( $_POST['mphbpb_active'] );
			$step1 = wp_kses_post( $_POST['mphbpb_step_1'] );
			$step2 = wp_kses_post( $_POST['mphbpb_step_2'] );
			$step3 = wp_kses_post( $_POST['mphbpb_step_3'] );
			$showSubmitted = sanitize_key( $_POST['mphbpb_show_submitted'] );

			update_option( 'mphbpb_greyed_out' , $greyedOut );
			update_option( 'mphbpb_active' , $activeColor );
			update_option( 'mphbpb_step_1' , $step1 );
			update_option( 'mphbpb_step_2' , $step2 );
			update_option( 'mphbpb_step_3' , $step3 );
			update_option( 'mphbpb_show_submitted' , $showSubmitted );

			?>

			<div id="setting-error-settings_updated" class="notice notice-success is-dismissible">
				<p>
					<strong>Settings have been saved</strong>
				</p>
			</div>

			<?php
		}
	}

	$dbValues =	mphbpb_DB_query();
	$wpEditorSettings = array( 'media_buttons' => false, 'textarea_rows'=> '3' , 'wpautop' => false );

	//Add plugin settings if MotoPress Hotel Booking plugin installed
	?>
		<div class="wrap">
			<h2 style="margin-top: 50px;">Hotel Booking Progress Bar Settings</h2>
			<?php if ( is_plugin_active( 'motopress-hotel-booking/motopress-hotel-booking.php' ) ) { ?>
				<br>
				<h3>Progress bar colors</h3>
				<br>
				<form action="" method="post">
					<?php wp_nonce_field( 'update_mphbpb_settings' ); ?>
					<p>Inactive/incomplete step color:</p>
					<input name="mphbpb_greyed_out" type="text" value="<?php echo $dbValues['greyedOut']; ?>" class="color-field"/>
					<br><br>
					<p>Active/completed step color:</p>
					<input name="mphbpb_active" type="text" value="<?php echo $dbValues['activeColor']; ?>" class="color-field"/>
					<br><br><br>
					<h3>Text for each step</h3>
					<span>Step 1 text:</span>
					<?php wp_editor( $dbValues['step1'], 'mphbpb_step_1', $wpEditorSettings ); ?>
					<br><br>
					<span>Step 2 text:</span>
					<?php wp_editor( $dbValues['step2'], 'mphbpb_step_2', $wpEditorSettings ); ?>
					<br><br>
					<span>Step 3 text:</span>
					<?php wp_editor( $dbValues['step3'], 'mphbpb_step_3', $wpEditorSettings ); ?>
					<br><br>
					<input id="mphbpb_show_submitted" name="mphbpb_show_submitted" type="checkbox" <?php 
						if( $dbValues['showSubmitted'] === 'on' ) {
							echo 'checked';
						}
					?> />
					<label for="mphbpb_show_submitted">Show step 3 as complete on the 'reservation submitted' page</label>
					<p>This option is especially for bookings that require admin or guest confirmation to complete, and therefore show a 'reservation submitted' page instead of the 'booking confirmed' page. If bookings are confirmed directly, this option will have no affect. 
					<br><br><br><br>
					<input type="submit" name="submit_mphbpb_changes" value="Save Settings" class="button button_primary primary">
				</form>
				
			<?php }else{ ?>
				<h3>Please note that the MotoPress Hotel Bookings plugin is required for this plugin</h3>
			<?php } ?>
		</div>

	<?php
}


//Add js to add progress bar to search results, checkout and booking confirmed pages
function mphbpb_add_scripts() {

	if( is_plugin_active( 'motopress-hotel-booking/motopress-hotel-booking.php' )){

		$searchResultsPage = get_option( 'mphb_search_results_page' , 'search-results' );
		$bookingDetailsPage = get_option( 'mphb_checkout_page' , 'booking-confirmation' );
		$bookingConfirmedPage = get_option( 'mphb_booking_confirmation_page' ,'booking-confirmed' );
		
		
		if( is_page( $searchResultsPage ) || is_page( $bookingDetailsPage ) || is_page( $bookingConfirmedPage ) ){
			
			$progressBarDetails =	mphbpb_DB_query();

			wp_enqueue_script( 'mphbpb_insert_progress_bar', plugins_url('/assets/js/addProgressBar.js', __FILE__ ), '', '', true );
			wp_localize_script( 'mphbpb_insert_progress_bar', 'progressBarDetails', $progressBarDetails );
			wp_enqueue_style( 'mphbpb_style' , plugins_url( '/assets/css/progressBar.css' , __FILE__ ), array(), false, false);
		}
	}
}

add_action( 'wp_enqueue_scripts', 'mphbpb_add_scripts' );


//Add settings link to plugin list
function mphbpb_add_settings_link( $links ) {

	$url = 'options-general.php?page=hotel_booking_progress_bar_menu';

	$settings_link = "<a href=$url>" . __( 'Settings' ) . "</a>";

	array_unshift( $links , $settings_link );
	return $links;
}

$pluginName = plugin_basename( __FILE__ );

add_filter( 'plugin_action_links_$pluginName' , 'mphbpb_add_settings_link' );

