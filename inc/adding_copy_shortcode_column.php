<?php

// Adding shortcode column to the conversion_category post type:
add_filter( 'manage_conversion_category_posts_columns', 'conversion_category_set_custom_edit_conversion_category_columns' );
function conversion_category_set_custom_edit_conversion_category_columns($columns) {
    $columns['Shortcode'] = 'Shortcode';
    return $columns;
}

// Add the data to the shortcode column for the conversion_category post type:
add_action( 'manage_conversion_category_posts_custom_column' , 'conversion_category_custom_conversion_category_column', 10, 2 );
function conversion_category_custom_conversion_category_column( $column, $post_id ) {
    switch ( $column ) {
        case 'Shortcode' :
            echo '<span class="conversion_category_shortcode"><input style="background: inherit;color: inherit;font-size: 12px;width:100%;padding: 4px 8px;margin: 0;" type="text" value="'.htmlentities('[wpccbks type="buy" heading="'.get_the_title().' Buying Rates" category="'.get_post_field( 'post_name', $post_id ).'" class=""]').'" readonly onfocus="this.select();" /></span>
            <span class="conversion_category_shortcode"><input style="background: inherit;color: inherit;font-size: 12px;width:100%;padding: 4px 8px;margin: 0;" type="text" value="'.htmlentities('[wpccbks type="sell" heading="'.get_the_title().' Selling Rates" category="'.get_post_field( 'post_name', $post_id ).'" class=""]').'" readonly onfocus="this.select();" /></span>';
            break;
    }
}
