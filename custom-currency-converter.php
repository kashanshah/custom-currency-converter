<?php
/*
Plugin Name: Custom Currency Converter
Author: kashanshah
Author URI: http://www.kashanshah.com
Description: Custom Currency Converter for WordPress
Version: 1.0
Tags: currency converter, cryptocurrency, wordpress
Requires at least: 5.1
Tested up to: 5.7.1
Requires PHP: 7.0
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

DEFINE("WPCCBKS_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
DEFINE("WPCCBKS_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
DEFINE("WPCCBKS_PLUGIN_VERSION", '0.0.3');

include('inc/taxonomy.php');
include('inc/shortcode.php');
include('inc/enque_files.php');
include('inc/admin_view.php');
include('inc/adding_copy_shortcode_column.php');

