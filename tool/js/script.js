(function($) {
    'use strict';
    const GO_BPT = {

        el_doc               : null,
        el_model             : null,
        el_btn_continue_build: null,
        el_btn_cancel_build  : null,
        el_btn_build         : null,
        el_btn_back          : null,
        el_btn_next          : null,
        el_btn_start_over    : null,
        el_btn_add_product   : null,
        el_input_token       : null,
        el_title             : null,
        el_cart_items        : null,
        el_cart_total        : null,
        el_cart_save         : null,
        el_products          : null,
        el_shipping          : null,
        el_shipping_info     : null,
        el_discount          : null,
        el_confirmation      : null,
        el_step_header       : null,
        el_checkbox_group    : null,
        el_selected_shipping : null,
        selected_model       : null,
        model_price          : 0,
        model_sale_price     : 0,
        cart_total_price     : 0,
        cart_total_sale_price: 0,
        current_step         : 1,
        selected_products    : [],
        selected_shipping    : null,

        _init: function() {
            GO_BPT._elements(
                GO_BPT._actions
            );
        },

        _title: function() {            
            GO_BPT.el_title.text(
                $('.tab-'+GO_BPT.current_step+' .step-title').text()
            );
        },

        _focus: function() {
            $('html, body').animate({
                scrollTop: $('body').offset().top - 40
            }, 500);
        },

        _tabs: function() {
            $('.tab-item').removeClass('active');
            for (let step = 1; step <= GO_BPT.current_step; step++) {
                $('.tab-'+step).addClass('active');
            }
        },

        _steps: function() {
            $('.step-1, .step-build').hide();            
            $(GO_BPT.current_step > 1 ? '.step-build' : '.step-1').show();            
        },
        
        _before: function() {
            GO_BPT.el_products.addClass('loading');
        },

        _after: function() {
            $(GO_BPT.selected_products).each(function(index, item) {
                $('.product-item-'+item.ID).addClass('added');
            });
            GO_BPT.el_products.removeClass('loading');
        },

        _navigate: function() {
            GO_BPT._title();
            GO_BPT._focus();
            GO_BPT._tabs();
            GO_BPT._steps();

            if (GO_BPT.current_step <= 5) {             
                GO_BPT.el_shipping.hide();
                GO_BPT.el_products.css('display', 'grid');
                GO_BPT._get_products();
            } else {
                GO_BPT._shipping_discount();
            }
        },

        _prev_step: function() {            
            if (GO_BPT.current_step === -1) {
                GO_BPT.current_step = 1;
                GO_BPT._navigate();
            } else {
                GO_BPT.current_step -= 1;
                GO_BPT._navigate();
            }            
        },

        _next_step: function() {
            GO_BPT.current_step += 1;
            GO_BPT._navigate();
        },

        _get_products: function() {
            GO_BPT._request(
                {
                    action: 'bpt_model_products',
                    model : GO_BPT.selected_model,
                    step  : GO_BPT.current_step
                }, function(response) {
                    GO_BPT.el_products.html(response.products);
                    GO_BPT._after();
                }
            );
        },

        _request: function(data, _callback) {
            GO_BPT._before();
            $.ajax({
                url     : go_bpt.ajaxurl,
                type    : 'POST',
                dataType: 'json',
                data    : data
            }).done(_callback);
        },

        _quote_details: function() {            
            return {
                action: 'bpt_submit_quote',
                token : GO_BPT.el_input_token.val(),
                model : {
                    name      : GO_BPT.selected_model,
                    price     : GO_BPT.model_price,
                    sale_price: GO_BPT.model_sale_price
                },
                products: GO_BPT.selected_products,
                shipping: GO_BPT.selected_shipping
            };            
        },

        _submit_quote: function() {            
            GO_BPT._request(GO_BPT._quote_details(), function(response) {
                console.log(response);
            });
        },

        _val: function(element) {
            return $(element).val();
        },

        _cart_model: function() {
            $('.item-model .name').text(GO_BPT.selected_model );
            $('.item-model .reg-price').text('$' + GO_BPT._format_price(GO_BPT.model_price) );
            $('.item-model .reg-price').addClass(parseFloat(GO_BPT.model_sale_price) > 0 ? 'strike' : 'normal');
            $('.item-model .sale-price').text('$' + GO_BPT._format_price(GO_BPT.model_sale_price) );
        },

        _cart_item: function(product) {
            const item = `
            <div class="cart-item">
                <div class="cart-col name">`+product.title+`</div>
                <div class="cart-col num reg-price `+(parseFloat(product.sale_price) > 0 ? 'strike' : 'normal')+`">$`+product.reg_price+`</div>
                <div class="cart-col num sale-price">$`+product.sale_price+`</div>
            </div>
            `;
            GO_BPT.el_cart_items.append(item);
        },        

        _cart: function(_callback) {
            $(GO_BPT.selected_products).each(function(index, item) {
                GO_BPT._cart_item( item );
                GO_BPT._cart_total( item );
            });
            _callback();
        },

        _cart_total: function(item) {
            const regular_price = parseFloat(item.reg_price.replace(',',''));
            const sale_price = parseFloat(item.sale_price.replace(',',''));

            GO_BPT.cart_total_price += sale_price > 0 ? sale_price : regular_price;
            if (sale_price > 0) {                
                GO_BPT.cart_total_sale_price += (regular_price - sale_price);
            }
        },

        _remove_item: function(ID) {            
            const products = GO_BPT.selected_products.filter(function(item) {                
                return ID !== item.ID
            });
            GO_BPT.selected_products = products;
        },

        _starting_cart_item: function() {
            GO_BPT.cart_total_price = GO_BPT.model_price;
            GO_BPT.cart_total_sale_price = GO_BPT.model_sale_price;
        },

        _add_product: function(e) {
            e.preventDefault();

            GO_BPT._starting_cart_item();
            GO_BPT.el_cart_items.html('');

            const product = $(this).closest('.product-item');

            if (product.hasClass('added')) {                
                console.log(product.data('product'));
                GO_BPT._remove_item( product.data('product') );
                product.removeClass('added');
            } else {
                product.addClass('added');
                GO_BPT.selected_products.push({
                    ID        : product.data('product'),
                    title     : product.find('.product-item-title').text(),
                    reg_price : GO_BPT._format_price( parseFloat(product.data('reg-price')) ),
                    sale_price: GO_BPT._format_price( parseFloat(product.data('sale-price')) )
                });
            }            
            GO_BPT._cart(
                GO_BPT._cart_summary
            );
        },

        _cart_summary: function() {          
            GO_BPT.el_cart_total.text('$'+GO_BPT._format_price( GO_BPT.cart_total_price ));
            GO_BPT.el_cart_save.text('$'+GO_BPT._format_price( GO_BPT.cart_total_sale_price ));
        },

        _format_price: function(price) {        
            const options = {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2           
            };
            return price.toLocaleString("en-IN", options);
        },

        _clear_step: function() {
            GO_BPT.el_products.hide();         
            GO_BPT.el_shipping.hide();     
            GO_BPT.el_shipping_info.hide();            
            GO_BPT.el_step_header.removeClass('disabled');
        },        

        _shipping_discount: function() {
            GO_BPT._clear_step();
            if (GO_BPT.current_step === 6) {
                GO_BPT.el_shipping.show();
                GO_BPT._shipping_step();
            } else if (GO_BPT.current_step >= 7) {
                if (GO_BPT.selected_shipping === null) {
                    alert('Please select shipping.');
                    GO_BPT.current_step = 6;
                    GO_BPT._navigate();
                } else {
                    GO_BPT._submit_quote();
                    GO_BPT.current_step = 6;
                    GO_BPT.el_shipping_info.show();
                    GO_BPT._shipping_info_step();
                }
            } 
        },                

        _shipping_step: function() {
            GO_BPT.el_title.text('Shipping');
        },

        _shipping_info_step: function() {
            GO_BPT.el_title.text('Shipping Details');
        },        

        _checkbox_group: function(e) {
            e.preventDefault();            
            const input = $(this).find('input');
            input.prop('checked', true);
            GO_BPT.selected_shipping = input.val();
            GO_BPT.el_selected_shipping.find('.selected').text(input.val());
            GO_BPT.el_selected_shipping.addClass('applied');
        },

        _before_set_model: function() {
            $('.model-item').addClass('disabled');
            $('.model-item').removeClass('selected');
            GO_BPT.el_model.removeClass('disabled');
            GO_BPT.el_model.addClass('selected');
        },

        _clear_model: function() {            
            $('.model-item').removeClass('disabled selected');
        },

        _continue_build: function(e) {
            e.preventDefault();
            GO_BPT._next_step();
        },

        _set_model: function(e) {
            e.preventDefault();          
            const model = $(this);  

            GO_BPT.selected_model   = model.data('model');
            GO_BPT.model_price      = parseFloat(model.data('price'));
            GO_BPT.model_sale_price = parseFloat(model.data('sale-price'));

            GO_BPT.el_model = model.closest('.model-item');
            GO_BPT._before_set_model();
            GO_BPT._starting_cart_item();
            GO_BPT._cart_summary();
            GO_BPT._cart_model();
            GO_BPT._next_step();
        },        

        _reset_fields: function() {
            GO_BPT.el_selected_shipping.removeClass('applied');            
            $('.checkbox').find('input').prop('checked', false);            
            $('.checkbox-group input').prop('checked', false);
            $('.form-field input[type="checkbox"]').prop('checked', false);
            $('.form-field select').val('');
            $('#shipping-form input').val('');
            $('.form-field textarea').val('');
            $('div.error').remove();            
        },

        _start_over: function(e) {
            if (e !== null) {
                e.preventDefault();
            }
            if (confirm('Are you sure to start over again?')) {
                GO_BPT._clear_step();
                GO_BPT.current_step          = -1;
                GO_BPT.selected_model        = null;
                GO_BPT.model_price           = 0;
                GO_BPT.model_sale_price      = 0;
                GO_BPT.cart_total_price      = 0;
                GO_BPT.cart_total_sale_price = 0;
                GO_BPT.selected_products     = [];
                GO_BPT.el_cart_items.html('');
                GO_BPT._clear_model();
                GO_BPT._reset_fields();
                GO_BPT._prev_step();
            }
        },                

        _actions: function() {                        
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_build,
                GO_BPT._set_model
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_back,
                GO_BPT._prev_step
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_next,
                GO_BPT._next_step
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_add_product,
                GO_BPT._add_product
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_start_over,
                GO_BPT._start_over
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_checkbox_group,
                GO_BPT._checkbox_group
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_cancel_build,
                GO_BPT._start_over
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_continue_build,
                GO_BPT._continue_build
            );            
        },

        _elements: function(_callback) {
            GO_BPT.el_doc                     = $(document);
            GO_BPT.el_title                   = $('.step-current-title .heading');
            GO_BPT.el_btn_continue_build      = 'a.continue';
            GO_BPT.el_btn_build               = 'a.build-price';
            GO_BPT.el_btn_cancel_build        = 'a.cancel-model';
            GO_BPT.el_btn_back                = '.step-nav .prev';
            GO_BPT.el_btn_next                = '.step-nav .next';
            GO_BPT.el_btn_start_over          = '.start-over';
            GO_BPT.el_btn_add_product         = '.add-product';
            GO_BPT.el_input_token             = $('#quote-token');
            GO_BPT.el_checkbox_group          = '.checkbox-group';
            GO_BPT.el_cart_items              = $('.selected-products');
            GO_BPT.el_cart_total              = $('.summary-item .cart-total');
            GO_BPT.el_cart_save               = $('.summary-item .save');
            GO_BPT.el_products                = $('.suggested-products');            
            GO_BPT.el_shipping                = $('.form-shipping');
            GO_BPT.el_shipping_info           = $('.form-shipping-info');        
            GO_BPT.el_step_header             = $('.step-header');
            GO_BPT.el_selected_shipping       = $('.selected-shipping');            
            _callback();
        }
    }
    GO_BPT._init();

    window.recaptchaCallback = function() {
        const response = grecaptcha.getResponse();
        GO_BPT.el_hidden_grecaptcha.val(response);
    }
    window.recaptchaExpired = function() {
        GO_BPT.el_hidden_grecaptcha.val('');
    }
})(jQuery);