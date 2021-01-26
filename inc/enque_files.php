<?php
function wpccbks_enqueue() {
    $wp_scripts = wp_scripts();
    $wpccbks_settings = get_option('wpccbks_options');
    $activeCurrencies = (isset($wpccbks_settings["currencies"]) ? $wpccbks_settings["currencies"] : array());

    wp_enqueue_script( 'jquery-ui-selectmenu' );
    wp_enqueue_script( 'wpccbks-script', WPCCBKS_PLUGIN_DIR_URL . 'assets/js/main.js', array('jquery'), WPCCBKS_PLUGIN_VERSION );
    wp_enqueue_style( 'wpccbks-jqueryui', WPCCBKS_PLUGIN_DIR_URL . 'assets/css/jquery-ui.min.css', null, WPCCBKS_PLUGIN_VERSION );
    wp_enqueue_style( 'wpccbks-flags', WPCCBKS_PLUGIN_DIR_URL . 'assets/css/flag-icon.min.css', null, WPCCBKS_PLUGIN_VERSION );
    wp_enqueue_style( 'wpccbks-style', WPCCBKS_PLUGIN_DIR_URL . 'assets/css/wpccbks-style.css', null, WPCCBKS_PLUGIN_VERSION );
    wp_localize_script( 'wpccbks-script', 'wpccbks_script_obj', array(
        'ajax_url' => admin_url( 'admin-ajax.php'),
        'currencyConverter' => $activeCurrencies
    ) );

    add_action( 'admin_print_scripts-' . $menu, 'admin_custom_js' );
}
add_action( 'wp_enqueue_scripts', 'wpccbks_enqueue' );
