<?php

function wpccbks_create_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Conversion Categories', 'taxonomy general name', 'wpccbks' ),
        'singular_name'     => _x( 'Conversion Category', 'taxonomy singular name', 'wpccbks' ),
        'search_items'      => __( 'Search Conversion Category', 'wpccbks' ),
        'all_items'         => __( 'Conversion Categories', 'wpccbks' ),
        'new_item_name'     => __( 'Add New Conversion Category', 'wpccbks' ),
        'menu_name'         => __( 'Currency Converter', 'wpccbks' ),
    );

    register_post_type('conversion_category', array(
        'supports'          => array('title'),
        'labels'            => $labels,
        'menu_icon'           => 'dashicons-money-alt',
        'show_admin_column' => true,
        'query_var'         => true,
        'public'      => true,
        'has_archive' => false,
        'rewrite'           => array( 'slug' => 'conversion-category' ),
    ));
}
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'wpccbks_create_taxonomies');