<?php
/************************************************************************************************************/
/*                                                                                            			    */
/* Plugin Name: Bamboo Social																				*/
/* Description: Add social media widget and shortcodes			                                		    */
/* Plugin URI:  https://www.bamboomanchester.uk/wordpress/bamboo-social                     		            */
/* Author:      Bamboo		                                                     		                    */
/* Author URI:  https://www.bamboosolutions.co.uk                                             		        */
/* Version:     1.1.3                                                  			                            */
/*                                                                                 			                */
/************************************************************************************************************/

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

/************************************************************************************************************/

	// SET THE PLUGIN PREFIX
	$plugin_prefix = 'bamboo_social_';

/************************************************************************************************************/

	// ENABLE SHORTCODES IN WIDGETS
	add_filter( 'widget_text', 'do_shortcode' );

/************************************************************************************************************/

	// INITIALISE THE PLUGIN OPTIONS
	add_action( 'init', 'bamboo_social_init' );
	function bamboo_social_init() {

		global $plugin_prefix;

		// CHECK THAT THE PLUGIN OPTIONS HAVE BEEN INITIALISED
		if( !get_option( $plugin_prefix.'initialised' ) ) {
			update_option( $plugin_prefix.'twitter_link',  	'' );
			update_option( $plugin_prefix.'facebook_link',	'' );
			update_option( $plugin_prefix.'google_link',	'' );
			update_option( $plugin_prefix.'linkedin_link',	'' );
			update_option( $plugin_prefix.'instagram_link',	'' );
			update_option( $plugin_prefix.'initialised',	'true' );
		}

	}

/************************************************************************************************************/

	// ADD THE PLUGIN OPTIONS PAGE
	add_action( 'admin_menu',  'bamboo_social_add_options_page' );
	function bamboo_social_add_options_page() {

		global $plugin_prefix;

		add_menu_page(
			'Bamboo Social',
			'Bamboo Social',
			'manage_options',
			$plugin_prefix,
			'bamboo_social_show_options_page',
			'dashicons-groups',
			20
		);

	}

/************************************************************************************************************/

	// REGISTER THE WIDGET
	add_action( 'widgets_init', 'bamboo_social_register_widget' );
	function bamboo_social_register_widget() {

		register_widget( 'Bamboo_Social' );

	}

/**************************************************************************************************/

	// ENQUEUE THE STYLESHEETS AND SCRIPTS
	add_action( 'wp_enqueue_scripts', 'bamboo_social_enqueue_styles' );
	function bamboo_social_enqueue_styles() {

		$path = plugins_url( '', __FILE__ );

		if( function_exists( 'bamboo_enqueue_style' ) ) {
			bamboo_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
			bamboo_enqueue_style( 'bamboo-social', $path.'/bamboo-social.css' );
		} else {
			wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), null );
			wp_enqueue_style( 'bamboo-social', $path.'/bamboo-social.css', array(), null );
		}

	}


/**************************************************************************************************/

	// REGISTER THE SHORTCODE
	add_shortcode( 'bamboo-social', 'bamboo_social_shortcode' );
	function bamboo_social_shortcode( $atts, $content = null ) {

		global $plugin_prefix;

		$html = '<div class="bamboo_social">';

		$addr =  get_option( $plugin_prefix.'twitter_link' );
		if( ''!=$addr ){
			if( ( 'http'!=substr( $addr, 0, 4 ) ) && ( 'https'!=substr( $addr, 0, 5 ) ) ) {
					$addr ='http://'.$addr;
			}
			$html .= '<a target="_blank" class="bamboo-social-link twitter" href="' . $addr . '"><i class="fa fa-twitter"></i></a>';
		}

		$addr = get_option( $plugin_prefix.'facebook_link' );
		if( ''!=$addr ){
			if( ( 'http'!=substr( $addr, 0, 4 ) ) && ( 'https'!=substr( $addr, 0, 5 ) ) ) {
					$addr ='http://'.$addr;
			}
			$html .= '<a target="_blank" class="bamboo-social-link facebook" href="' . $addr . '"><i class="fa fa-facebook"></i></a>';
		}

		$addr = get_option( $plugin_prefix.'instagram_link' );
		if( ''!=$addr ){
			if( ( 'http'!=substr( $addr, 0, 4 ) ) && ( 'https'!=substr( $addr, 0, 5 ) ) ) {
					$addr ='http://'.$addr;
			}
			$html .= '<a target="_blank" class="bamboo-social-link instagram" href="' . $addr . '"><i class="fa fa-instagram"></i></a>';
		}

		$addr = get_option( $plugin_prefix.'google_link' );
		if( ''!=$addr ){
			if( ( 'http'!=substr( $addr, 0, 4 ) ) && ( 'https'!=substr( $addr, 0, 5 ) ) ) {
					$addr ='http://'.$addr;
			}
			$html .= '<a target="_blank" class="bamboo-social-link google" href="' . $addr . '"><i class="fa fa-google"></i></a>';
		}

		$addr = get_option( $plugin_prefix.'linkedin_link' );
		if( ''!=$addr ){
			if( ( 'http'!=substr( $addr, 0, 4 ) ) && ( 'https'!=substr( $addr, 0, 5 ) ) ) {
					$addr ='http://'.$addr;
			}
			$html .= '<a target="_blank" class="bamboo-social-link linkedin" href="' . $addr . '"><i class="fa fa-linkedin"></i></a>';
		}

		$addr = get_option( $plugin_prefix.'pinterest_link' );
		if( ''!=$addr ){
			if( ( 'http'!=substr( $addr, 0, 4 ) ) && ( 'https'!=substr( $addr, 0, 5 ) ) ) {
					$addr ='http://'.$addr;
			}
			$html .= '<a target="_blank" class="bamboo-social-link pinterest" href="' . $addr . '"><i class="fa fa-pinterest"></i></a>';
		}

		$addr = get_option( $plugin_prefix.'tumblr_link' );
		if( ''!=$addr ){
			if( ( 'http'!=substr( $addr, 0, 4 ) ) && ( 'https'!=substr( $addr, 0, 5 ) ) ) {
					$addr ='http://'.$addr;
			}
			$html .= '<a target="_blank" class="bamboo-social-link tumblr" href="' . $addr . '"><i class="fa fa-tumblr"></i></a>';
		}

		$html .= "</div>";
		return $html;

	}

/**************************************************************************************************/

	// SHOW THE PLUGIN OPTIONS PAGE
	function bamboo_social_show_options_page() {

	// CHECK THE USER HAS PERMISSION TO VIEW THE OPTIONS PAGE
	if (!current_user_can('manage_options')) {
    	wp_die('You do not have sufficient permissions to access this page.');
	}

    // SET THE PLUGIN PREFIX
    $plugin_prefix = 'bamboo_social_';

    // If the form has been posted back update the options in the database
    if ( sizeof( $_POST )>0 ) {

		$nonce = $_POST['_wpnonce'];
		if( !wp_verify_nonce( $nonce ) ) {
	    	wp_die('You do not have sufficient permissions to access this page.');
		}

        // Remove magic quotes
        $_POST = array_map( 'stripslashes_deep', $_POST );

        foreach( $_POST as $key => $value ) {
            update_option( $plugin_prefix.$key, $value );
        }

        // If the import settings box has been filled in import the settings
        if( $_POST["import-settings"]!="" ) {
            $options = bamboo_social_decode_base64( $_POST["import-settings"] );
            $options = unserialize( $options );
            if( $options ) {
                foreach ( $options as $key => $value ) {
                    update_option( $key, $value );
                }
            }
        }
    }

    // Construct the Export Settings code string
    $all_options = wp_load_alloptions();
    $export_key = 'bamboo-social-export-settings';
    foreach ($all_options as $key => $value) {
        if(substr($key,0,strlen($plugin_prefix)) != $plugin_prefix) unset($all_options[$key]);
        if($key==$export_key) unset($all_options[$key]);
    }
    $export_settings_code = bamboo_social_encode_base64(serialize($all_options));


/**************************************************************************************************/
?>

    <div class="wrap">

        <header>
            <h2>Bamboo Social</h2>
        </header>

        <div class="clearfix"></div>

    <?php if (sizeof($_POST)>0) {  ?>
        <div class="updated settings-error" id="setting-error-settings_updated">
            <p><strong>Settings saved.</strong></p>
        </div>
    <?php } ?>

        <form method="POST" action="">
	        <?php wp_nonce_field(); ?>
            <p>Enter the links to each of your social media accounts below (leaving any you don't wish to use blank) :</p>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="twitter">Twitter</label></th>
                    <td><input type="text" class="regular-text" name="twitter_link" value="<?php echo get_option($plugin_prefix.'twitter_link');?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="facebook">Facebook</label></th>
                    <td><input type="text" class="regular-text" name="facebook_link" value="<?php echo get_option($plugin_prefix.'facebook_link');?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter">Instagram</label></th>
                    <td><input type="text" class="regular-text" name="instagram_link" value="<?php echo get_option($plugin_prefix.'instagram_link');?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter">Google</label></th>
                    <td><input type="text" class="regular-text" name="google_link" value="<?php echo get_option($plugin_prefix.'google_link');?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter">LinkedIn</label></th>
                    <td><input type="text" class="regular-text" name="linkedin_link" value="<?php echo get_option($plugin_prefix.'linkedin_link');?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter">Pinterest</label></th>
                    <td><input type="text" class="regular-text" name="pinterest_link" value="<?php echo get_option($plugin_prefix.'pinterest_link');?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter">Tumblr</label></th>
                    <td><input type="text" class="regular-text" name="tumblr_link" value="<?php echo get_option($plugin_prefix.'tumblr_link');?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter">Export Settings</label></th>
                    <td><textarea name="export-settings" cols="70" rows="7"><?php echo $export_settings_code; ?></textarea><p class="description">This is your Bamboo Social options in one code string. You can paste this directly into the "Import Settings" box to apply all of these settings.<br/><strong>Please make sure you have saved any changes before copying this code.</strong></p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter">Import Settings</label></th>
                    <td><textarea name="import-settings" cols="70" rows="7"></textarea><p class="description">Paste your options code string here to import all your Bamboo Social option settings in one go.<br/><strong>PLEASE NOTE: This will override all your current settings.</strong></p></td>
                </tr>
            </table>
            <p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
        </form>
    </div>

<?php
	}

/**************************************************************************************************/

	// ENCODE A STRING TO BASE64
	function bamboo_social_encode_base64( $string='' ){

		$binval = bamboo_social_convert_to_binary( $string );
	    $final = "";
	    $start = 0;
	    while( $start < strlen( $binval ) ) {
			if( strlen( substr( $binval,$start ) ) < 6 )
				$binval .= str_repeat( "0", 6-strlen( substr( $binval,$start ) ) );
	        $tmp = bindec( substr( $binval, $start, 6) );
	        if( $tmp < 26 )
	            $final .= chr( $tmp+65 );
	        elseif( $tmp > 25 && $tmp < 52 )
	            $final .= chr($tmp+71);
	        elseif( $tmp == 62 )
	            $final .= "+";
	        elseif( $tmp == 63 )
	            $final .= "/";
	        elseif( !$tmp )
	            $final .= "A";
	        else
	            $final .= chr( $tmp-4 );
	        $start += 6;
	    }
	    if( strlen( $final )%4>0 )
	        $final .= str_repeat( "=",4-strlen( $final )%4 );

	    return $final;

	}

/**************************************************************************************************/

	// DECODE A BASE64 STRING
	function bamboo_social_decode_base64($input) {

	    $keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	    $chr1 = $chr2 = $chr3 = "";
	    $enc1 = $enc2 = $enc3 = $enc4 = "";
	    $i = 0;
	    $output = "";

	     // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
	    $input = preg_replace( "[^A-Za-z0-9\+\/\=]", "", $input );

	    do {
	            $enc1 = strpos( $keyStr, substr( $input, $i++, 1 ) );
	            $enc2 = strpos( $keyStr, substr( $input, $i++, 1 ) );
	            $enc3 = strpos( $keyStr, substr( $input, $i++, 1 ) );
	            $enc4 = strpos( $keyStr, substr( $input, $i++, 1 ) );

	            $chr1 = ( $enc1 << 2 ) | ( $enc2 >> 4 );
	            $chr2 = ( ( $enc2 & 15 ) << 4 ) | ( $enc3 >> 2 );
	            $chr3 = ( ( $enc3 & 3 ) << 6 ) | $enc4;

	            $output = $output . chr( (int)$chr1 );

	            if( $enc3 != 64 ) {
	                    $output = $output . chr( (int)$chr2 );
	            }
	            if( $enc4 != 64 ) {
	                    $output = $output . chr( (int)$chr3 );
	            }

	            $chr1 = $chr2 = $chr3 = "";
	            $enc1 = $enc2 = $enc3 = $enc4 = "";

	    } while( $i < strlen( $input ) );

	    return urldecode( $output );

	}

/**************************************************************************************************/

	//CONVERT A STRING TO BINARY
	function bamboo_social_convert_to_binary($string) {

		$result = "";

	    if( strlen( $string )>0 ) {
	    	for( $i=0; $i<strlen( $string ); $i++ ) {
	    		$char = decbin( ord( $string[$i] ) );
	    		$char = str_repeat( "0", 8-strlen( $char ) ).$char;
	    		$result.= $char;
	    	}
	    }

	    return $result;

	}

/**************************************************************************************************/

	class Bamboo_Social extends WP_Widget {

/**************************************************************************************************/

		public function __construct() {

			parent::__construct(
		 		'bamboo_social', // Base ID
				'Bamboo Social', // Name
				array( 'description' => 'Links to all your social media accounts' )
			);

		}

/**************************************************************************************************/

	 	public function form( $instance ) {

			if ( isset( $instance['title'] ) ) {
				$title = $instance[ 'title' ];
			} else {
				$title = 'New title';
			}

?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bamboo' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
<?php
		}

/**************************************************************************************************/

		public function update( $new_instance, $old_instance ) {

			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;

		}

/**************************************************************************************************/

		public function widget( $args, $instance ) {

			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $before_widget;
			if ( ! empty( $title ) ) {
				echo $before_title . $title . $after_title;
			}
			$atts = array();
			echo bamboo_social_shortcode( $atts );
			echo $after_widget;

		}

/**************************************************************************************************/

	}

/**************************************************************************************************/

?>
