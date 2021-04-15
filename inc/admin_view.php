<?php

// Including Admin Panel Settings Page
add_action('admin_menu', 'wpccbks_admin_actions');
function wpccbks_admin_actions()
{
    add_submenu_page('edit.php?post_type=conversion_category', 'Conversion Rates', 'Conversion Rates', 'manage_options', 'wpccbks', 'wpccbks_admin');
    register_setting( 'wpccbks_options', 'wpccbks_options' );

    // admin scripts
    wp_enqueue_script( 'wpccbks_admin_script', WPCCBKS_PLUGIN_DIR_URL . 'assets/js/admin.js', array( 'jquery-ui-core', 'jquery-ui-tabs' ) );
}

function wpccbks_admin()
{
    ?>
    <?php settings_errors(); ?>
    <style>
        .bks-input-field[type="date"], .bks-input-field[type="datetime-local"], .bks-input-field[type="datetime"], .bks-input-field[type="email"], .bks-input-field[type="month"], .bks-input-field[type="number"], .bks-input-field[type="password"], .bks-input-field[type="search"], .bks-input-field[type="tel"], .bks-input-field[type="text"], .bks-input-field[type="time"], .bks-input-field[type="url"], .bks-input-field[type="week"], select.bks-input-field {
            width: 100%;
            padding: 5px;
            height: auto;
        }
        #wpccbks_options .form-table {
            margin-left: -10px;
            margin-right: -10px;
        }
        .form-table td{
            vertical-align: top;
            max-width: 150px;
        }
    </style>
    <?php echo "<h1>" . __('Currency Converter', 'wpccbks') . "</h1>"; ?>
    <h4><?php echo __('Add/remove or update currency exchange rates below', 'wpccbks'); ?></h4>
    <form method="post" action="options.php" id="wpccbks_options">
        <?php settings_fields('wpccbks_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <?php
        $wpccbks_settings = get_option('wpccbks_options');
        $activeCurrencies = (isset($wpccbks_settings["currencies"]) ? $wpccbks_settings["currencies"] : array());
        ?>
        <h2><?php echo __('Active Currencies', 'wpccbks'); ?></h2>
        <table id="currency-changer-table" class="form-table">
            <?php
            if (!empty($activeCurrencies)) {
                for ($i = 0; $i < sizeof($activeCurrencies["name"]); $i++) {
                    if($activeCurrencies["name"][$i] !== ""){
                    ?>
                    <tr valign="top">
                        <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][name][]" placeholder="Currency Name, e.g. US Dollar" value="<?php echo $activeCurrencies["name"][$i]; ?>" /></td>
                        <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][abbr][]" placeholder="Currency Acronym, e.g. USD" value="<?php echo $activeCurrencies["abbr"][$i]; ?>" /></td>
                        <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][symbol][]" placeholder="Currency Symbol, e.g. $" value="<?php echo $activeCurrencies["symbol"][$i]; ?>" /></td>
                        <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][flag][]" placeholder="Flag URL" value="<?php echo $activeCurrencies["flag"][$i]; ?>" /></td>
                        <td>
                            <select class="bks-input-field" name="wpccbks_options[currencies][category][]" >
                                <?php
                                $query = new WP_Query(
                                    array(
                                        'post_type'      => 'conversion_category',
                                        'posts_per_page' => -1,
                                        'post_status' => array('publish')
                                    )
                                );
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                $post = get_post(get_the_ID());
                                $slug = $post->post_name;
                                ?>
                                <option value="<?php echo $slug; ?>" <?php selected($slug, $activeCurrencies["category"][$i]); ?>><?php echo get_the_title(); ?></option>
                                <?php
                            } // endwhile
                            wp_reset_postdata(); // VERY VERY IMPORTANT
                        }
                        ?>
                            </select>
                        </td>
                        <td>
                            <select class="bks-input-field" name="wpccbks_options[currencies][position][]" >
                                <option value="before" <?php selected($activeCurrencies["position"], "before")[$i]; ?>>Before Symbol</option>
                                <option value="after" <?php selected($activeCurrencies["position"], "after")[$i]; ?>>After symbol</option>
                            </select>
                        </td>
                        <td>
                            <select class="bks-input-field" name="wpccbks_options[currencies][status][]" >
                                <option value="1" <?php selected($activeCurrencies["status"], "1")[$i]; ?>>Active</option>
                                <option value="0" <?php selected($activeCurrencies["status"], "0")[$i]; ?>>Inactive</option>
                            </select>
                        </td>
                        <td>
                            <input class="bks-input-field" type="text" name="wpccbks_options[currencies][rate_buy][]" placeholder="Buying Rate" value="<?php echo $activeCurrencies["rate_buy"][$i]; ?>" />
                            <label for="" class="help-text">Buying rate would be in USD, e.g. if 1 EUR=1.22USD, the rate for EUR would be 1.22</label>
                        </td>
                        <td>
                            <input class="bks-input-field" type="text" name="wpccbks_options[currencies][rate_sell][]" placeholder="Selling Rate" value="<?php echo $activeCurrencies["rate_sell"][$i]; ?>" />
                            <label for="" class="help-text">Selling rate would be in USD, e.g. if 1 EUR=1.22USD, the rate for EUR would be 1.22</label>
                        </td>
                        <td><a href="javascript:" class="wpccbks-remove-currency">remove</a></td>
                    </tr>
                    <?php
                    }
                }
                ?>
                <?php
            }
                ?>
                <tr id="markup-to-clone" valign="top">
                    <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][name][]" placeholder="Currency Name, e.g. US Dollar" value="" /></td>
                    <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][abbr][]" placeholder="Currency Acronym, e.g. USD" value="" /></td>
                    <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][symbol][]" placeholder="Currency Symbol, e.g. $" value="" /></td>
                    <td><input class="bks-input-field" type="text" name="wpccbks_options[currencies][flag][]" placeholder="Flag URL" value="" /></td>
                    <td>
                        <select class="bks-input-field" name="wpccbks_options[currencies][position][]" >
                            <option value="before">Before Symbol</option>
                            <option value="after">After symbol</option>
                        </select>
                    </td>
                    <td>
                        <select class="bks-input-field" name="wpccbks_options[currencies][category][]" >
                            <?php
                            $query = new WP_Query(
                                array(
                                    'post_type'      => 'conversion_category',
                                    'posts_per_page' => -1,
                                    'post_status' => array('publish')
                                )
                            );
                            if($query->have_posts()) {
                                while($query->have_posts()) {
                                    $query->the_post();
                                    $post = get_post(get_the_ID());
                                    $slug = $post->post_name;
                                    ?>
                                    <option value="<?php echo $slug; ?>"><?php echo get_the_title(); ?></option>
                                    <?php
                                } // endwhile
                                wp_reset_postdata(); // VERY VERY IMPORTANT
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="bks-input-field" name="wpccbks_options[currencies][status][]" >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </td>
                    <td>
                        <input class="bks-input-field" type="text" name="wpccbks_options[currencies][rate_buy][]" placeholder="Buying Rate" value="" />
                        <label for="" class="help-text">Buying rate would be in USD, e.g. if 1 EUR=1.22USD, the rate for EUR would be 1.22</label>
                    </td>
                    <td>
                        <input class="bks-input-field" type="text" name="wpccbks_options[currencies][rate_sell][]" placeholder="Selling Rate" value="" />
                        <label for="" class="help-text">Buying rate would be in USD, e.g. if 1 EUR=1.22USD, the rate for EUR would be 1.22</label>
                    </td>
                    <td><a href="javascript:" class="wpccbks-remove-currency">remove</a></td>
                </tr>
                <?php
            ?>
            <style>#markup-to-clone{display: none;}</style>
        </table>
        <a href="javascript:" class="btn btn-secondary" id="add-more-currency">Add More Currencies</a>

        <table class="form-table">
            <tr>
                <td><h4>Default From: </h4></td>
                <td>
                    <select class="bks-input-field" name="wpccbks_options[defaultFrom]" >
                        <?php
                        if (!empty($activeCurrencies)) {
                            for ($i = 0; $i < sizeof($activeCurrencies["name"]); $i++) {
                                if ($activeCurrencies["name"][$i] !== "") {
                                    ?>
                                    <option value="<?php echo $i; ?>" <?php selected($wpccbks_settings["defaultFrom"], $i); ?>><?php echo $activeCurrencies["name"][$i]; ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </td>
                <td><h4>Default To: </h4></td>
                <td>
                    <select class="bks-input-field" name="wpccbks_options[defaultTo]" >
                        <?php
                        if (!empty($activeCurrencies)) {
                            for ($i = 0; $i < sizeof($activeCurrencies["name"]); $i++) {
                                if ($activeCurrencies["name"][$i] !== "") {
                                    ?>
                                    <option value="<?php echo $i; ?>" <?php selected($wpccbks_settings["defaultTo"], $i); ?>><?php echo $activeCurrencies["name"][$i]; ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
    <?php
}




