<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.wplauncher.com
 * @since      1.0.0
 *
 * @package    Settings_Page
 * @subpackage Settings_Page/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Settings_Page
 * @subpackage Settings_Page/admin
 * @author     Ben Shadle <benshadle@gmail.com>
 */
class Settings_Page_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);   
		add_action('admin_init', array( $this, 'registerAndBuildFields' )); 

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Settings_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Settings_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/settings-page-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Settings_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Settings_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/settings-page-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function addPluginAdminMenu() {
	
		add_submenu_page( 'options-general.php', 'Alert Post Type', 'Alert Post Type', 'administrator', 'alert-post-type', array( $this, 'displayPluginAdminSettings' ));
	}



	public function displayPluginAdminSettings() {
		// set this var to be used in the settings-display view
		
		require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
	}

	public function registerAndBuildFields() {

		add_settings_section(  
        'my_settings_section', // Section ID 
        '', // Section Title
        array($this,'settings_page_display_general_account'), // Callback
        'settings_page_general_settings' // What Page?  This makes the section show up on the General Settings Page
	    );

	    add_settings_field( // Option 1
	        'alert_msg', // Option ID
	        'Alert message', // Label
	        array($this,'my_textbox_callback'), // !important - This is where the args go!
	        'settings_page_general_settings', // Page it will be displayed (General Settings)
	        'my_settings_section', // Name of our section
	        array( // The $args
	            'alert_msg' // Should match Option ID
	        )  
	    ); 

	    add_settings_field( // Option 2
	        'all_post_type', // Option ID
	        'All post type', // Label
	        array($this,'sandbox_checkbox_element_callback'), // !important - This is where the args go!
	        'settings_page_general_settings', // Page it will be displayed
	        'my_settings_section', // Name of our section (General Settings)
	        array( // The $args
	            'all_post_type' // Should match Option ID
	        )  
	    ); 

	    add_settings_field( // Option 2
	        'all_post_type_list', // Option ID
	        '', // Label
	        array($this,'all_post_type_list_callback'), // !important - This is where the args go!
	        'settings_page_general_settings', // Page it will be displayed
	        'my_settings_section', // Name of our section (General Settings)
	        array( // The $args
	            'all_post_type_list' // Should match Option ID
	        )  
	    ); 

	    register_setting('settings_page_general_settings','alert_msg');
	    register_setting('settings_page_general_settings','all_post_type');
	    register_setting('settings_page_general_settings','all_post_type_list');

	}


	public function my_textbox_callback($args) {  // Textbox Callback
	    $option = get_option($args[0]);
	    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
	}

	function sandbox_checkbox_element_callback($args) {
	    $options = get_option($args[0],[]);

	     $args = array(
		   'public'   => true,
		);
	  	$html ='';
		$post_types = get_post_types( $args, 'objects' );

	  	unset( $post_types['attachment'] );
		foreach ( $post_types  as $post_type ) {
		    $html .= '<input type="checkbox" id="'.$post_type->name.'" name="all_post_type['.$post_type->name.']" value="1"  ' . checked( 1, $options[$post_type->name], false ) . '/>';
		    $html .= '<label for="'.$post_type->name.'">'.$post_type->labels->singular_name.'</label>';
		}

	    echo $html;

	}


	function all_post_type_list_callback($args)
	{
		$options = get_option($args[0],[]);

		$html ='';
		 $args = array(
		   'public'   => true,
		);
		$post_types = get_post_types( $args, 'objects' );

	  	unset( $post_types['attachment'] );

	  	foreach ($post_types as $post_type) {
			$args = array( 
		  'numberposts'		=> -1, // -1 is for all
		  'post_type'		=> $post_type->name, // or 'post', 'page'
		  'orderby' 		=> 'title', // or 'date', 'rand'
		  'order' 		=> 'ASC', // or 'DESC'
		);

		// Get the posts
		$myposts = get_posts($args);

		if(!empty($myposts)){
			$html .= '<h3>'.$post_type->labels->singular_name.'</h3>';
			$html .= '<select name="all_post_type_list['.$post_type->name.'][]" multiple="multiple">';
			foreach ($myposts as $key => $value) {
					$sel = '';
				    if (in_array($value->ID, $options[$post_type->name])) {
				        $sel = ' selected="selected" ';
				    }
		    	$html .= '<option value="'.$value->ID.'" ' . $sel. '>'.$value->post_title.'</option>';
			}
			$html .= '</select>';
		}

		}
		echo $html;

	}

	public function settings_page_display_general_account() {
		echo '<p>Set custom post type for post alert meassage.</p>';
	} 


	
}
