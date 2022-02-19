<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.wplauncher.com
 * @since      1.0.0
 *
 * @package    Settings_Page
 * @subpackage Settings_Page/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Settings_Page
 * @subpackage Settings_Page/public
 * @author     Ben Shadle <benshadle@gmail.com>
 */
class Settings_Page_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'wp_footer', array( $this, 'dtc_site_notice' ));

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/settings-page-public.css', array(), $this->version, 'all' );

	}

	

		function dtc_site_notice() {
			$text = get_option('alert_msg');
			$all_post_type_list = get_option('all_post_type_list');
			$all_post_type = get_option('all_post_type');
			$post_type = get_post_type(get_the_ID());

			if ( is_admin() || empty( $text ) || !in_array(get_the_ID(), $all_post_type_list[$post_type]) || empty($all_post_type[$post_type])) {
				return;
			}
			?>
			<div
				class="site-notice"
				data-id="<?php echo esc_attr( md5( $text ) ); ?>"
			>
				<p><?php echo esc_html( $text ); ?></p>
				<button
					aria-label="<?php esc_html_e( 'Dismiss site notice', 'mytheme' ); ?>"
					class="site-notice-dismiss"
				>
					×
				</button>
			</div>
			<?php
		}


	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/settings-page-public.js', array( 'jquery' ), $this->version, false );

	}

}
