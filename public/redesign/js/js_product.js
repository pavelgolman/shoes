/* ---- 
	Define equals prototype
	---- */

if(Array.prototype.equals)
    console.warn("Overriding existing Array.prototype.equals. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");

Array.prototype.equals = function (array) {
    // if the other array is a falsy value, return
    if (!array)
        return false;

    // compare lengths - can save a lot of time 
    if (this.length != array.length)
        return false;

    for (var i = 0, l=this.length; i < l; i++) {
        // Check if we have nested arrays
        if (this[i] instanceof Array && array[i] instanceof Array) {
            // recurse into the nested arrays
            if (!this[i].equals(array[i]))
                return false;       
        }           
        else if (this[i] != array[i]) { 
            // Warning - two different object instances will never be equal: {x:20} != {x:20}
            return false;   
        }           
    }       
    return true;
}
// Hide method from for-in loops
Object.defineProperty(Array.prototype, "equals", {enumerable: false});

/* ---- 
	GET query
	---- */

function getParameterByName(name, url) {
  if (!url) {
    url = window.location.href;
  }
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

/* ---- 
	Money currency format
	---- */

window.theme = window.theme || {};
theme.Currency = (function() {
  var moneyFormat = '${{amount}}'; // eslint-disable-line camelcase

  function formatMoney(cents, format) {
    if (typeof cents === 'string') {
      cents = cents.replace('.', '');
    }
    var value = '';
    var placeholderRegex = /\{\{\s*(\w+)\s*\}\}/;
    var formatString = (format || moneyFormat);

    function formatWithDelimiters(number, precision, thousands, decimal) {
      precision = precision || 2;
      thousands = thousands || ',';
      decimal = decimal || '.';

      if (isNaN(number) || number == null) {
        return 0;
      }

      number = (number / 100.0).toFixed(precision);

      var parts = number.split('.');
      var dollarsAmount = parts[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1' + thousands);
      var centsAmount = parts[1] ? (decimal + parts[1]) : '';

      return dollarsAmount + centsAmount;
    }

    switch (formatString.match(placeholderRegex)[1]) {
      case 'amount':
        value = formatWithDelimiters(cents, 2);
        break;
      case 'amount_no_decimals':
        value = formatWithDelimiters(cents, 0);
        break;
      case 'amount_with_comma_separator':
        value = formatWithDelimiters(cents, 2, '.', ',');
        break;
      case 'amount_no_decimals_with_comma_separator':
        value = formatWithDelimiters(cents, 0, '.', ',');
        break;
      case 'amount_no_decimals_with_space_separator':
        value = formatWithDelimiters(cents, 0, ' ');
        break;
    }

    return formatString.replace(placeholderRegex, value);
  }

  return {
    formatMoney: formatMoney
  }
})();

window.oldSelectFunctions = function() {

	/* ---- 
		Get current variant
		---- */

	function getVariant() {

		var optionArray = [];

		$('form select.product-variants').each(function(){
			optionArray.push($(this).find(':selected').val())
		});

		return optionArray;

	}

	/* ---- 
		Init form fields
		---- */

	var productSingleObject = JSON.parse(document.getElementById('ProductJson').innerHTML);

	$('form select.product-variants').on('change', function(e){
		initVariantChange();
	});

	initVariantChange();

	/* ---- 
		Variant change
		---- */

	function initVariantChange() {	

		var variant = null,
			options = getVariant();

		productSingleObject.variants.forEach(function(el){

			if ( $(el)[0].options.equals(options) ) {
				variant = $(el)[0];
			}

		});

		selectCallback(variant);
		updateVariantState(variant);

	}

	function updateVariantState(variant) {

    if (!history.pushState || !variant) {
      return;
    }

    var newurl = window.location.protocol + '//' + window.location.host + window.location.pathname + '?variant=' + variant.id;
    window.history.replaceState({path: newurl}, '', newurl);

  }

	/* ---- 
		Actual select callback
		---- */

	function selectCallback(variant) {

	  var $addToCart = $('#addToCart'),
	        $productPrice = $('#productPrice'),
	        $comparePrice = $('#comparePrice'),
	        $quantityElements = $('.quantity-selector, label + .js-qty'),
	        $addToCartText = $('#addToCartText'),
	        $featuredImage = $('#productPhotoImg');

		if (variant) {

			// Set cart value id

			$('#productSelect').find('option[value="' + variant.id + '"]').prop('selected', true);

			// Swipe to variant slide

			var $swiperBullets = $('.swiper-pagination').children('span');

			if ( variant.featured_image ) {

				var newImg = $('.swiper-wrapper').find('.swiper-slide[data-variant-img="' + variant.featured_image.id + '"]');

				if ( newImg.length > 0 ) {
					if ( $.swiper != undefined ) {
						$.swiper.slideTo(newImg.data('index')-window.posFix);
					} else {
						$.swiperVariantAlready = newImg.data('index')-window.posFix;
					}
				}

			}

			// Edit cart buttons based on stock 
				
			var $variantQuantity = $('#variantQuantity');

			if ( variant.inventory_management == 'shopify' || variant.inventory_management == 'amazon_marketplace_web' || variant.inventory_management == null ) {

				if (variant.available) {

					if ( variant.inventory_quantity == 1 ) {
						$variantQuantity.text(window.product_words_one_product);
					} else if ( variant.inventory_quantity <= 5 ) {
						$variantQuantity.text(window.product_words_few_products.replace( '{{ count }}', variant.inventory_quantity));
					} else {
						$variantQuantity.text('');
					}
					$quantityElements.prop('max', variant.inventory_quantity);

					if ( variant.inventory_management == null ) {
						$variantQuantity.text('');
						$quantityElements.prop('max', 999);
          }

					$addToCart.removeClass('disabled').prop('disabled', false);
					$addToCartText.text(window.product_words_add_to_cart_button);
					$quantityElements.show();

				} else {
					
					$variantQuantity.text(window.product_words_no_products);
					$addToCart.addClass('disabled').prop('disabled', true);
					$addToCartText.text(window.product_words_sold_out_variant);
					$quantityElements.hide();

				}

				$quantityElements.on('keyup', function(){
					if ( $quantityElements.prop('max') != undefined && parseInt($quantityElements.val()) > parseInt($quantityElements.prop('max')) ) {
						$quantityElements.val($quantityElements.prop('max'));
					}
				});
			}

			// Update price

			$productPrice.html( theme.Currency.formatMoney(variant.price, window.shop_money_format) );
			if ( variant.compare_at_price > variant.price ) {
				$comparePrice.html(theme.Currency.formatMoney(variant.compare_at_price, window.shop_money_format)).show();
			} else {
				$comparePrice.hide();
			}

		} else {

			// Disable variant completely 

			$addToCart.addClass('disabled').prop('disabled', true);
			$addToCartText.text(window.product_words_unavailable_variant);
			$quantityElements.hide();

		}

	};

	/* ---- 
		Final adjustments
		---- */

	$('select.product-variants:not(.styled)').each(function(){
		
		$(this).styledSelect({
		    coverClass: 'regular-select-cover',
		    innerClass: 'regular-select-inner'
		}).addClass('styled');

	 	 $(this).parent().append($.themeAssets.arrowDown);

	});
	  	
	var selectLabels = '',
		i = 0;

	$('.product-variant').each(function(){
		$(this).attr('id', 'selector-' + i++);
		selectLabels += '#' + $(this).attr('id') + ' .regular-select-inner:before{content:"' + $(this).find('label').text() + ': ";}';
		$(this).find('label').hide();
	});	

	if ( selectLabels != '' ) {
		$('head').append('<style type="text/css">' + selectLabels + '</style>');
	}

	if ( productSingleObject.variants.length == 1 && productSingleObject.variants[0].title.indexOf('Default') >= 0 ) {
		$('.product-variant').hide();
	}

}

$(document).on('ready', function(){
	window.oldSelectFunctions();
});