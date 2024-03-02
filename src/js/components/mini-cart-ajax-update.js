const miniCartAjaxUpdate = () => {
    // https://github.com/anisur2805/woocommerce-mini-cart-ajax-plus-minus
    const $ = jQuery

    // console.log($, my_ajax_object)


    $("body").on("click", ".ic-item-quantity-btn", function () {
        ic_quantity_update_buttons($(this))
    });

    $("body").on("blur", ".ic-cart-sidebar-wrapper_body input", function () {
        ic_quantity_update_input_blue($(this))
    })

    $('body').on('click', '.ic-cart-header-btn', function(e){
        e.preventDefault();
        $('body').addClass('active-mini-cart');
    });

    $('body').on('click', '.ic-cart-header-btn-close', function(e){
        $('body').removeClass('active-mini-cart');
    });

    var ic_quantity_update_send = true
    // Update cart on button click
    function ic_quantity_update_buttons(el) {
        if( ic_quantity_update_send ) {
            $(".widget_shopping_cart_content .woocommerce-mini-cart").addClass("loading")
            ic_quantity_update_send = false
            var wrap = $(el).closest(".woocommerce-mini-cart-item")
            var input = $(wrap).find(".qty")
            var key = $(wrap).data("key")
            var number = parseInt($(input).val())
            var type = $(el).data("type")

            console.log('wrap', wrap)

            if (type == "minus") {
                number--
            } else {
                number++
            }
            if (number <= 1) {
                number = 1
                wrap.addClass("min_value")
            } else {
                wrap.removeClass("min_value")
            }

            $(input).val(number)
            var data = {
                action: "ic_qty_update",
                key: key,
                number: number,
                security: my_ajax_object.nonce
            }

            $.post(my_ajax_object.ajax_url, data, function (res) {
                var cart_res = JSON.parse(res)
                $( ".ic-cart-sidebar-wrapper_body  p.woocommerce-mini-cart__total.total .amount" ).html(cart_res["total"]);
                $(wrap) .find(".ic-custom-render-total").html(cart_res["item_price"]);
                ic_quantity_update_send = true;
                $(".widget_shopping_cart_content .woocommerce-mini-cart").removeClass("loading")

                // IF YOU WANT TO GO WITH HEADER COUNT/PRICE UPDATE ENABLE BELOW LINE AND FIX YOUR SELECTOR
                // ЯКЩО ВИ ХОЧЕТЕ ПЕРЕХОДИТИ З ОНОВЛЕННЯМ ЗАГОЛОВКУ COUNTPRICE,
                // УВІМКНІТЬ ПІД РЯДКОМ ТА ВИПРАВІТЬ ВАШ СЕЛЕКТОР
                // $('.ic-mid-nav-right ul li a .ic-cart-qty span.ic-qty').html( cart_res['count'] );
                // $('.ic-cart-header-btn .ic-total-price').html( cart_res['total'] );
                $('.header__shop_link .header__shop_cart_contents_count').html( cart_res['count'] );
                $('.cart_bottom_basket__btn .cart_bottom_basket__items_count').html( cart_res['count'] );
                $('.woocommerce-mini-cart__total .amount').html( cart_res['total'] );
            })
        }
    }

    // Update cart on input blur
    function ic_quantity_update_input_blue( input ) {
        $(".ic-cart-sidebar-wrapper_body ul").addClass("loading")
        ic_quantity_update_send = false
        var wrap = $( input ).closest(".woocommerce-mini-cart-item")
        var key = $(wrap).data("key")
        var number = parseInt($(input).val());
        if( !number || number <1){
            number = 1;
        }

        $(input).val(number)
        var data = {
            action: "ic_qty_update",
            key: key,
            number: number,
            security: my_ajax_object.nonce
        }

        $.post(my_ajax_object.ajax_url, data, function (res) {
            var cart_res = JSON.parse(res)
            $( ".ic-cart-sidebar-wrapper_body  p.woocommerce-mini-cart__total.total .amount" ).html(cart_res["total"]);
            $( wrap ) .find( ".ic-custom-render-total" ) .html(cart_res["item_price"]);
            $( ".ic-cart-sidebar-wrapper_body ul" ).removeClass("loading")

            // IF YOU WANT TO GO WITH HEADER COUNT/PRICE UPDATE ENABLE BELOW LINE AND FIX YOUR SELECTOR
            // $('.ic-mid-nav-right ul li a .ic-cart-qty span.ic-qty').html( cart_res['count'] );
            // $('.ic-cart-header-btn .ic-total-price').html( cart_res['total'] );
        })
    }
}

export default miniCartAjaxUpdate