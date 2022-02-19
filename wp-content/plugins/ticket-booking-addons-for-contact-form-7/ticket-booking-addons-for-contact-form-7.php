<?php
/**
 * Plugin Name: Ticket Booking Addons For Contact Form 7
 * Plugin URI: https://github.com/tmoradiya828/dtctest.git
 * Description: The only Contact form 7 addons plugin you should install to meet all your basic needs. Ticket booking for contact form 7. 
 * Version: 1.0.0
 * Author: Tushar Moradiya
 * Author URI: https://github.com/tmoradiya828/dtctest.git
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: ticket-booking-addons-cf7
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Class Ticket_Booking_Addon_CF7
*/
class Ticket_Booking_Addon_CF7 {
    
    /*
    * Construct function
    */
    public function __construct() {
        define( 'TBACF7_URL', plugin_dir_url( __FILE__ ) );
        define( 'TBACF7_ADDONS', TBACF7_URL.'addons' );
        define( 'TBACF7_PATH', plugin_dir_path( __FILE__ ) );
        
       
        
        //Plugin loaded
        add_action( 'plugins_loaded', array( $this, 'tbacf7_plugin_loaded' ) );
    }
	
    /*
    * Ticket booking addons loaded
    */
    public function tbacf7_plugin_loaded() {
        //Register text domain
        load_plugin_textdomain( 'ticket-booking-addons-cf7', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
        
        if(class_exists('WPCF7')){
            //Init ultimate addons
            $this->tbacf7_init();
        
        }else{
            //Admin notice
            add_action( 'admin_notices', array( $this, 'tbacf7_admin_notice' ) );
        }
    }

    
    
    /*
    * Admin notice- To check the Contact form 7 plugin is installed
    */
     public function tbacf7_admin_notice(){
        ?>
        <div class="notice notice-error is-dismissible">
            <p>
               <?php printf(
                __('Ticket Booking Addons for Contact Form 7 requires Contact form 7 to be installed and active. You can install and activate it from %s', 'ticket-booking-addons-cf7'),
                '<a href="'.admin_url('plugin-install.php?tab=search&s=contact+form+7').'">here</a>.'
            ); ?></p>
        </div>
        <?php
    }
    
    /*
    * Init ticket booking addons
    */
    public function tbacf7_init() {
        
        //Require ticket booking functions
        require_once( 'inc/functions.php' );
        
        //Enqueue admin scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        
        //Require admin menu
       require_once( 'admin/admin-menu.php' );
        
        //Require ticket booking addons
        require_once( 'addons/ticket-book.php' );
    }
    
    //Enquene admin scripts
    public function enqueue_admin_scripts(){
        
        wp_enqueue_style( 'tbacf7-admin-style', TBACF7_URL . 'assets/css/admin-style.css', 'sadf' );
        
        wp_enqueue_script( 'tbacf7-admin-script', TBACF7_URL . 'assets/js/admin-script.js', array('jquery'), null, true );
    }
    
}

/*
* Object - Ticket_Booking_Addon_CF7
*/
$ticket_booking_addon_cf7 = new Ticket_Booking_Addon_CF7();

register_activation_hook( __FILE__, 'create_table_install' );
register_activation_hook( __FILE__, 'add_booking_install_data' );

function create_table_install() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ticket_booking_dates';
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            fields text NOT NULL,
            value INT NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
}


function add_booking_install_data() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ticket_booking_dates';

        for ($i=1; $i <101 ; $i++) { 
           $wpdb->insert( 
            $table_name, 
            array( 
                'fields' => 'booking date'.$i, 
                'value' => 0, 
            ) 
        );
        }
}