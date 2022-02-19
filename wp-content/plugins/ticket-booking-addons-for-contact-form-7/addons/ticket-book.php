<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TBACF7_TICKET_BOOKING {
    /*
    * Construct function
    */
    public function __construct() {
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_script' ) );
        add_action('wpcf7_init', array($this, 'add_shortcodes'));
        add_action( 'admin_init', array( $this, 'tag_generator' ) );
    }
	
    /*
	* Enqueue scripts
	*/
    public function enqueue_frontend_script() {        
        wp_enqueue_style( 'tbacf7-ticket-booking-style', TBACF7_ADDONS . '/star-rating/assets/css/star-rating.css' );
        wp_enqueue_style( 'tbacf7-fontawesome', TBACF7_ADDONS . '/star-rating/assets/css/all.css' );
    }
    
    /*
    * Create form tag: uacf7_star_rating
    */
    public function add_shortcodes() {
        
		wpcf7_add_form_tag( array('ticket_book_cf7','uacf7_ticket_booking'), array( $this, 'tbacf7_ticket_booking_cb' ), true );
  
    }
    
    /*
    * Field: Post title
    */
	public function tbacf7_ticket_booking_cb($tag){
        
        ob_start();

         global $wpdb;
        
        $table_name = $wpdb->prefix . 'ticket_booking_dates';

        $dates = $wpdb->get_results("SELECT * FROM $table_name");

        echo '<p>Select ticket booking dates<br><span class="wpcf7-form-control-wrap">
                <span class="wpcf7-form-control wpcf7-checkbox wpcf7-validates-as-required wpcf7-exclusive-checkbox">';
        foreach ($dates as $key => $date) {
            $dis = '';
            if($date->value != 0){
                $dis = 'disabled';
            }
            echo '<span class="wpcf7-list-item">
                <input type="checkbox" name="booking_dates['.$date->id.']" value="1" '.$dis.'>
                <span class="wpcf7-list-item-label">'.$date->fields.'</span>
                </span>
                ';
        }
        echo '</span></span></p>';

        
        return ob_get_clean();
    }

    /*
    * Generate tag
    */
    public function tag_generator() {
        if (! function_exists('wpcf7_add_tag_generator'))
            return;

        wpcf7_add_tag_generator('ticket_book_cf7',
            __('Ticket Booking', 'ticket-booking-addons-cf7'),
            'tbacf7-tg-pane-ticket-booking',
            array($this, 'tg_pane_ticket_booking')
        );
    }

    static function tg_pane_ticket_booking( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $tbacf7_field_type = 'ticket_book_cf7';
        ?>

        <div class="insert-box">
            <input type="text" name="<?php echo esc_attr($tbacf7_field_type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

            <div class="submitbox">
                <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'ticket-booking-addons-cf7' ) ); ?>" />
            </div>
        </div>
        <?php
    }
    
    
    
    
    
}

new TBACF7_TICKET_BOOKING();