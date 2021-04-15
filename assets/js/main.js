jQuery(document).ready(function (){
    const $ = jQuery;
    $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
        _renderItem: function( ul, item ) {
            var li = $( "<li>" ),
                wrapper = $( "<div>", { text: item.label } );

            if ( item.disabled ) {
                li.addClass( "ui-state-disabled" );
            }

            $( "<img>", {
                "class": "bks-currency-flag",
                "src": item.element.attr( "data-flag" )
            })
                .prependTo( wrapper );

            return li.append( wrapper ).appendTo( ul );
        },
        _renderButtonItem: function( item ) {
            var buttonItem = $( "<div>", {
                "class": "bks-selected-currency"
            });


            var flagIcon = $( "<img>", {
                "class": "bks-selected-currency-flag",
                "src": item.element.attr( "data-flag" )
            });

            var currencyName = $( "<span>", {
                "class": "bks-selected-currency-name"
            });
            this._setText(currencyName, item.label)

            var currencyValue = $( "<span>", {
                "class": "bks-selected-currency-value"
            });
            this._setText(currencyValue, item.value)

            flagIcon.prependTo(buttonItem);
            currencyValue.appendTo(buttonItem);
            currencyName.appendTo(buttonItem);

            return buttonItem;
        },
    });

    function updateConversion() {
        $(".converter-div").each(function (){
            var wrapper = $(this);
            var fromCurrency = wrapper.find(".bks-country-dropdown-from").val();
            var toCurrency = wrapper.find(".bks-country-dropdown-to").val();
            var currencyObj = wpccbks_script_obj.currencyConverter;
            var indexFrom = currencyObj.abbr.indexOf(fromCurrency);
            var indexTo = currencyObj.abbr.indexOf(toCurrency);
            var amount = wrapper.find(".currency-input").val();
            var type = wrapper.find(".conversion-type").val();
            var rateTo = wpccbks_script_obj.currencyConverter["rate_"+type][indexTo];
            var rateFrom = wpccbks_script_obj.currencyConverter["rate_"+type][indexFrom];
            var rateToSymbol = wpccbks_script_obj.currencyConverter["symbol"][indexTo];
            var rateToSymbolPosition = wpccbks_script_obj.currencyConverter["position"][indexFrom];
            wrapper.find(".currency-output").text((rateToSymbolPosition == 'before' ? rateToSymbol : '') +  ((amount * rateFrom) / rateTo).toFixed('6') + (rateToSymbolPosition == 'after' ? rateToSymbol : ''))
            wrapper.find(".rate-from").text((rateToSymbolPosition == 'before' ? rateToSymbol : '') + (rateFrom / rateTo).toFixed('6') + (rateToSymbolPosition == 'after' ? rateToSymbol : ''))
        });
    }

    $(window).on('load', function (){
        updateConversion();
    })

    $(document).ready(function (){
        updateConversion();
    })

    $(".currency-input").on('change, keyup', function (){
        updateConversion();
    })

	
    $( ".bks-currency-dropdown" ).each(function(index){
		$(this).closest(".wpcc-bks").addClass("wpcc-bks-"+index);
    	$(this)
	        .iconselectmenu({
    	        appendTo: ".wpcc-bks-"+index,
        	    change: function (event){
            	    updateConversion();
            	}

	        })
    	    .iconselectmenu( "menuWidget" )
        	.addClass( "ui-menu-icons customicons" );
	});
});