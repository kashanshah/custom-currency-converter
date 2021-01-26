<?php
add_shortcode( 'wpccbks', 'wpccbks_func' );
function getCountryList($activeCurrencies, $defaultIndex) {
    $retData = '';
    if (!empty($activeCurrencies)) {
        for ($i = 0; $i < sizeof($activeCurrencies["name"]); $i++) {
            $retData .= '<option '.selected($defaultIndex, $i, false).' value="'.$activeCurrencies["abbr"][$i].'" data-flag="'.$activeCurrencies["flag"][$i].'">'.__($activeCurrencies["name"][$i], 'wpccbks').'</option>';
        }
    }
    return $retData;
}
// Reading Shortcode From Content
function wpccbks_func( $atts ) {
    $wpccbks_scAttr = shortcode_atts( array(
        'type' => 'buy',
        'heading' => 'Currency Converter',
        'class' => ''
    ), $atts );
    $i = -1;

    $wpccbks_settings = get_option('wpccbks_options');
    $activeCurrencies = (isset($wpccbks_settings["currencies"]) ? $wpccbks_settings["currencies"] : array());
    $wpccbks_postcontent = '
        	<div class="wpcc-bks '.$wpccbks_scAttr["class"].'">
		<div class="title-container no-gutters">
			<div class="title-div">
				<h1 class="title">'.__($wpccbks_scAttr["heading"], 'wpccbks').'</h1>
			</div>
		</div>
		
		<div class="converter-div">
			<input type="hidden" name="conversion_type" class="conversion-type" value="'.$wpccbks_scAttr['type'].'">
			<div class="converter-div-col">
				<div class="country-div">
                    <select class="select-country bks-currency-dropdown bks-country-dropdown-from">
                    '.getCountryList($activeCurrencies, $wpccbks_settings["defaultFrom"]).'
                    </select>
				</div>
                <p>'.__('Rate', 'wpccbks').': <span class="rate-from">-</span></p>
			</div>
			<!-- input field 2 -->
			<div class="converter-div-col">
				<div class="country-div">
                    <select class="select-country bks-currency-dropdown bks-country-dropdown-to">
                        '.getCountryList($activeCurrencies, $wpccbks_settings["defaultTo"]).'
                    </select>
                </div>
                <p>&nbsp;</p>
            </div>
            <div class="converter-div-col">
				<input class="currency-input" type="number" min="0" value="1">
            </div>
            <div class="converter-div-col">
                <div class="bks-d-flex">
                    <span class="currency-output">-</span>
                </div>
			</div>
		</div>
	</div>
	';

    return $wpccbks_postcontent;
}
