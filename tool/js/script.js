(function($) {
    GO_BPT = {

        el_doc                    : null,
        el_model                  : null,
        el_btn_continue_build     : null,
        el_btn_cancel_build       : null,
        el_btn_build              : null,
        el_btn_back               : null,
        el_btn_next               : null,
        el_btn_start_over         : null,
        el_btn_add_product        : null,
        el_btn_submit_quote       : null,
        el_select_mailing_country : null,
        el_select_mailing_state   : null,
        el_input_mailing_phone    : null,
        el_select_shipping_country: null,
        el_select_shipping_state  : null,
        el_input_shipping_phone   : null,
        el_shipping_address       : null,
        el_checkbox_show_shipping : null,
        el_hidden_grecaptcha      : null,
        el_title                  : null,
        el_cart_items             : null,
        el_cart_total             : null,
        el_cart_save              : null,
        el_products               : null,
        el_shipping               : null,
        el_shipping_info          : null,
        el_discount               : null,
        el_confirmation           : null,
        el_step_header            : null,
        el_checkbox_group         : null,
        el_selected_shipping      : null,
        selected_model            : null,
        model_price               : 0,
        model_sale_price          : 0,
        cart_total_price          : 0,
        cart_total_sale_price     : 0,
        current_step              : 1,
        selected_products         : [],
        selected_shipping         : null,

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
                scrollTop: $('body').offset().top
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

            if (GO_BPT.current_step <= 4) {
                GO_BPT.el_discount.hide();
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

        _submit_quote: function(e) {
            e.preventDefault();

            const discounts = [];
            $('.checkbox-discount:checked').each(function() {
                discounts.push( $(this).val() );
            });

            const shipping_address_different  = $('#show-shiipping-address').is(':checked');
            const quote_details = {
                model: {
                    name      : GO_BPT.selected_model,
                    price     : GO_BPT.model_price,
                    sale_price: GO_BPT.model_sale_price
                },
                selected_products   : GO_BPT.selected_products,
                shipping            : GO_BPT.selected_shipping,
                email_address       : $('#mailing_email_address').val(),
                subscribe_newsletter: $('#subscribe-newsletter').is(':checked'),
                mailing_address     : {
                    first_name    : $('#mailing_first_name').val(),
                    last_name     : $('#mailing_last_name').val(),
                    company       : $('#mailing_company').val(),
                    street_address: $('#mailing_street_address').val(),
                    city          : $('#mailing_city').val(),
                    country       : $('#mailing_country').val(),
                    state         : $('#mailing_state').val(),
                    zip_code      : $('#mailing_zip_code').val(),
                    phone_number  : $('#mailing_phone_number').val()
                },
                shipping_address_different: shipping_address_different,
                shipping_address          : {
                    first_name    : shipping_address_different ? $('#shipping_first_name').val() : '',
                    last_name     : shipping_address_different ? $('#shipping_last_name').val() : '',
                    company       : shipping_address_different ? $('#shipping_company').val() : '',
                    street_address: shipping_address_different ? $('#shipping_street_address').val() : '',
                    city          : shipping_address_different ? $('#shipping_city').val() : '',
                    country       : shipping_address_different ? $('#shipping_country').val() : '',
                    state         : shipping_address_different ? $('#shipping_state').val() : '',
                    zip_code      : shipping_address_different ? $('#shipping_zip_code').val() : '',
                    phone_number  : shipping_address_different ? $('#shipping_phone_number').val() : ''
                },
                hear_about_us   : $('#hear-about-us').val(),
                discounts       : discounts,
                other_interested: $('#other-interested').val()
            };
            console.log('QUOTE DETAILS', quote_details);
        },

        _cart_model: function() {
            $('.item-model .name').text(GO_BPT.selected_model );
            $('.item-model .reg-price').text('$' + GO_BPT._format_price(GO_BPT.model_price) );
            $('.item-model .sale-price').text('$' + GO_BPT._format_price(GO_BPT.model_sale_price) );
        },

        _cart_item: function(product) {
            const item = `
            <div class="cart-item">
                <div class="cart-col name">`+product.title+`</div>
                <div class="cart-col num reg-price">$`+product.reg_price+`</div>
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
            GO_BPT.cart_total_price += parseFloat(item.reg_price);
            if (parseFloat(item.sale_price) > 0) {
                GO_BPT.cart_total_sale_price += parseFloat(item.sale_price);
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
            const sale_price = GO_BPT.cart_total_sale_price > 0 ? GO_BPT.cart_total_price - GO_BPT.cart_total_sale_price : 0;
            GO_BPT.el_cart_total.text('$'+GO_BPT._format_price( GO_BPT.cart_total_price ));
            GO_BPT.el_cart_save.text('$'+GO_BPT._format_price( sale_price ));
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
            GO_BPT.el_discount.hide();
            GO_BPT.el_shipping.hide();     
            GO_BPT.el_shipping_info.hide();
            GO_BPT.el_confirmation.hide();
            GO_BPT.el_step_header.removeClass('disabled');
        },

        _shipping_discount: function() {
            GO_BPT._clear_step();
            if (GO_BPT.current_step === 5) {
                GO_BPT.el_shipping.show();
                GO_BPT._shipping_step();
            } else if (GO_BPT.current_step === 6) {
                GO_BPT.el_shipping_info.show();
                GO_BPT._shipping_info_step();
            } else if (GO_BPT.current_step === 7) {                
                GO_BPT.el_discount.show();
                GO_BPT._discount_step();
            } else if (GO_BPT.current_step === 8) {                
                GO_BPT.el_confirmation.show();
                GO_BPT._confirmation_step();
            }            
        },

        _discount_step: function() {
            GO_BPT.el_title.text('Discount');
        },

        _shipping_step: function() {
            GO_BPT.el_title.text('Shipping');
        },

        _shipping_info_step: function() {
            GO_BPT.el_title.text('Shipping Details');
        },

        _confirmation_step: function() {
            GO_BPT.el_step_header.addClass('disabled');
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
            GO_BPT.el_shipping_address.removeClass('open');
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

        _validate: function() {
            GO_BPT.el_shipping_info.find('form').validate({
                errorElement: 'div',
                rules: {
                    mailing_first_name    : "required",
                    mailing_last_name     : "required",
                    mailing_street_address: "required",
                    mailing_city          : "required",
                    mailing_state         : "required",
                    mailing_zip_code      : "required",
                    mailing_country       : "required",
                    mailing_phone_number  : "required",
                    mailing_email_address : {
                        required: true,
                        email: true
                    },
                    mailing_confirm_email_address: {
                        required: true,
                        email: true,
                        equalTo: "#mailing_email_address"
                    },
                    shipping_first_name: {
                        required: "#show-shiipping-address:checked",
                        required: true
                    },
                    shipping_last_name: {
                        required: "#show-shiipping-address:checked",
                        required: true
                    },
                    shipping_street_address: {
                        required: "#show-shiipping-address:checked",
                        required: true
                    },
                    shipping_street_address_2: {
                        required: "#show-shiipping-address:checked",
                        required: false
                    },
                    shipping_city: {
                        required: "#show-shiipping-address:checked",
                        required: true
                    },
                    shipping_state: {
                        required: "#show-shiipping-address:checked",
                        required: true
                    },
                    shipping_zip_code: {
                        required: "#show-shiipping-address:checked",
                        required: true
                    },
                    shipping_country: {
                        required: "#show-shiipping-address:checked",
                        required: true
                    },
                    hidden_grecaptcha: {
                        required: true,
                        minlength: "255"
                    },
    
                },
                messages: {
                    mailing_first_name           : "Please enter your firstname",
                    mailing_last_name            : "Please enter your lastname",
                    mailing_street_address       : "Please enter your street address",
                    mailing_street_address_2     : "Please enter your street address 2",
                    mailing_city                 : "Please enter your city",
                    mailing_state                : "Please enter your state/province",
                    mailing_zip_code             : "Please enter your zip code",
                    mailing_country              : "Please enter your country",
                    shipping_first_name          : "Please enter your firstname",
                    shipping_last_name           : "Please enter your lastname",
                    shipping_street_address      : "Please enter your street address",
                    shipping_street_address_2    : "Please enter your street address 2",
                    shipping_city                : "Please enter your city",
                    shipping_state               : "Please enter your state/province",
                    shipping_zip_code            : "Please enter your zip code",
                    shipping_country             : "Please enter your country",
                    phone_number                 : "Please enter your phone number",
                    mailing_email_address        : "Please enter a valid email address",
                    mailing_confirm_email_address: {
                        required: "Please provide a valid email address",
                        equalTo: "Please enter the same email as above"
                    },
                    hidden_grecaptcha: "Invalid reCAPTCHA"
                }, 
                onfocusout: function(element, event) {
                    this.element(element);
                }
            });
            
            GO_BPT.el_shipping_info.find('form').on('submit', function(e) {
                e.preventDefault();
            });            
        },

        _populate_mailing_country: function() {
            const country = $(this).val();
            if (country != '') {
                GO_BPT._load_json_data(GO_BPT.el_select_mailing_state, country);
            } else {
                $(GO_BPT.el_select_mailing_state).html('<option value="">State</option>');                
            }
        },

        _populate_shipping_country: function() {
            const country = $(this).val();
            if (country != '') {
                GO_BPT._load_json_data(GO_BPT.el_select_shipping_state, country);
            } else {
                $(GO_BPT.el_select_shipping_state).html('<option value="">State</option>');                
            }
        },

        _show_shipping_address: function() {
            if ($(this).is(':checked')) {
                GO_BPT.el_shipping_address.addClass('open');
            } else {
                GO_BPT.el_shipping_address.removeClass('open');
            }
        },

        _load_json_data: function(id, country) {
            let html_code = '';
            let jsonFile  = [];
            if (id == GO_BPT.el_select_mailing_country || id == GO_BPT.el_select_shipping_country) {
                html_code += '<option value="">Country</option>';
                jsonFile = go_bpt.plugin_url + '/tool/js/country.json';
            } else if (id == GO_BPT.el_select_mailing_state || id == GO_BPT.el_select_shipping_state) {
                html_code += '<option value="">State</option>';
                jsonFile = go_bpt.plugin_url + '/tool/js/state.json';
            }

            $.getJSON(jsonFile, function(data) {
                $.each(data, function(key, value) {
                    if (id == GO_BPT.el_select_mailing_country || id == GO_BPT.el_select_shipping_country) {
                        html_code += '<option value="' + value.name + '">' + value.name +'</option>';
                    } else if (id == GO_BPT.el_select_mailing_state || id == GO_BPT.el_select_shipping_state) {                        
                        if (value.country == country) {
                            html_code += '<option value="' + value.shortname + '">' + value.name +'</option>';
                        }
                    }
                });
                $(id).html(html_code);
            });
        },

        _actions: function() {            
            GO_BPT._validate();
            GO_BPT._load_json_data(
                GO_BPT.el_select_mailing_country,
                null
            );
            GO_BPT._load_json_data(
                GO_BPT.el_select_shipping_country,
                null
            );
            GO_BPT.el_input_mailing_phone.usPhoneFormat({
                format: '(xxx) xxx-xxxx',
            });
            GO_BPT.el_input_shipping_phone.usPhoneFormat({
                format: '(xxx) xxx-xxxx',
            });            
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
            GO_BPT.el_doc.on(
                'change',
                GO_BPT.el_select_mailing_country,
                GO_BPT._populate_mailing_country
            );
            GO_BPT.el_doc.on(
                'change',
                GO_BPT.el_select_shipping_country,
                GO_BPT._populate_shipping_country
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_checkbox_show_shipping,
                GO_BPT._show_shipping_address
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_btn_submit_quote,
                GO_BPT._submit_quote
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
            GO_BPT.el_checkbox_group          = '.checkbox-group';
            GO_BPT.el_cart_items              = $('.selected-products');
            GO_BPT.el_cart_total              = $('.summary-item .cart-total');
            GO_BPT.el_cart_save               = $('.summary-item .save');
            GO_BPT.el_products                = $('.suggested-products');
            GO_BPT.el_discount                = $('.form-discount');
            GO_BPT.el_shipping                = $('.form-shipping');
            GO_BPT.el_shipping_info           = $('.form-shipping-info');
            GO_BPT.el_confirmation            = $('.confirmation');
            GO_BPT.el_step_header             = $('.step-header');
            GO_BPT.el_selected_shipping       = $('.selected-shipping');
            GO_BPT.el_select_mailing_country  = 'select#mailing_country';
            GO_BPT.el_select_mailing_state    = 'select#mailing_state';
            GO_BPT.el_select_shipping_country = 'select#shipping_country';
            GO_BPT.el_select_shipping_state   = 'select#shipping_state';
            GO_BPT.el_input_mailing_phone     = $('input#mailing_phone_number');
            GO_BPT.el_input_shipping_phone    = $('input#shipping_phone_number');
            GO_BPT.el_shipping_address        = $('.shipping-address');
            GO_BPT.el_checkbox_show_shipping  = 'input#show-shiipping-address';
            GO_BPT.el_hidden_grecaptcha       = $('input#hidden_grecaptcha');
            GO_BPT.el_btn_submit_quote        = '.submit-quote';
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