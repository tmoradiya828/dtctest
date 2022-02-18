<?php

/**
 * Plugin Name: WordPress Simple Plugin
 * Plugin URI: http://www.codetab.org/tutorial/wordpress/
 * Description: Plugin to explain WordPress Plugin Basics
 * Version: 1.0.0
 * Author: maithilish
 * Author URI: http://www.codetab.org/about/
 * License: GPLv2
 */

defined( 'ABSPATH' ) or die( "Access denied !" );

define('WPSP_NAME','wp-simple-plugin');

define( "WPSP_URL", trailingslashit( plugin_dir_url( __FILE__ ) ) );