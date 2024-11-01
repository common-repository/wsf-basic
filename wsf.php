<?php
/*
Plugin Name: WSF Basic
Version: 1.0.0
Plugin URI: https://www.halilbeycan.com/wordpress-eklentilerim/wordpress-social-flow
Description: Independent post creation commenting and voting plugin for Wordpress registered users and unregistered users. Free version. With the [wsf-load] shortcode, you can also use any page you want..
Author: Halil BEYCAN
Author URI: https://www.halilbeycan.com
Text Domain: wsf
*/

// plugin url and path directory
define( 'WSF_URL', trailingslashit(	plugin_dir_url( __FILE__ ) ) );
define( 'WSF_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

// start
require_once WSF_PATH . 'inc/wsf-start.php';