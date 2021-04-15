<?php
/*
Plugin Name: Custom Currency Converter
Plugin URI: http://www.kashanshah.com
Description: Custom Currency Converter for WordPress
Version: 0.0.3
Author: Kashan Shah
Author URI: http://www.kashanshah.com
License: A "wpccbks" license name e.g. GPL2
*/

DEFINE("WPCCBKS_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
DEFINE("WPCCBKS_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
DEFINE("WPCCBKS_PLUGIN_VERSION", '0.0.3');

include('inc/taxonomy.php');
include('inc/shortcode.php');
include('inc/enque_files.php');
include('inc/admin_view.php');
include('inc/adding_copy_shortcode_column.php');

