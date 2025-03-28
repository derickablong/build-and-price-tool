(function($) {
    GO_BPT = {

        el_doc               : null,
        el_model             : null,
        el_btn_back          : null,
        el_btn_next          : null,
        el_btn_start_over    : null,
        el_btn_add_product   : null,
        el_title             : null,
        el_cart_items        : null,
        el_cart_total        : null,
        el_cart_save         : null,
        selected_model       : null,
        model_price          : 0,
        model_sale_price     : 0,
        cart_total_price     : 0,
        cart_total_sale_price: 0,
        current_step         : 1,
        selected_products    : [],

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
            $('.suggested-products').addClass('loading');
        },

        _after: function() {
            $(GO_BPT.selected_products).each(function(index, item) {
                $('.product-item-'+item.ID).addClass('added');
            });
            $('.suggested-products').removeClass('loading');
        },

        _navigate: function() {
            GO_BPT._title();
            GO_BPT._focus();
            GO_BPT._tabs();
            GO_BPT._steps();
            GO_BPT._request();
        },

        _prev_step: function() {            
            if (GO_BPT.current_step === 2) {
                GO_BPT._start_over(null);
            } else if (GO_BPT.current_step === -1) {
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

        _request: function() {
            GO_BPT._before();
            $.ajax({
                url     : go_bpt.ajaxurl,
                type    : 'POST',
                dataType: 'json',
                data    : {
                    action: 'bpt_model_products',
                    model : GO_BPT.selected_model,
                    step  : GO_BPT.current_step
                }
            }).done(function(response) {
                $('.suggested-products').html(response.products);
                GO_BPT._after();
            });
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
                    reg_price : GO_BPT._format_price( product.data('reg-price') ),
                    sale_price: GO_BPT._format_price( product.data('sale-price') )
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

        _set_model: function(e) {
            e.preventDefault();          
            const model = $(this);  
            GO_BPT.selected_model = model.data('model');            
            GO_BPT.model_price = parseFloat(model.data('price'));
            GO_BPT.model_sale_price = parseFloat(model.data('sale-price'));
            GO_BPT._starting_cart_item();
            GO_BPT._cart_summary();
            GO_BPT._cart_model();
            GO_BPT._next_step();
        },

        _start_over: function(e) {
            if (e !== null) {
                e.preventDefault();
            }
            if (confirm('Are you sure to start over again?')) {
                GO_BPT.current_step          = -1;
                GO_BPT.selected_model        = null;
                GO_BPT.model_price           = 0;
                GO_BPT.model_sale_price      = 0;
                GO_BPT.cart_total_price      = 0;
                GO_BPT.cart_total_sale_price = 0;
                GO_BPT.selected_products     = [];
                GO_BPT.el_cart_items.html('');
                GO_BPT._prev_step();
            }
        },

        _actions: function() {
            GO_BPT.el_doc.on(
                'click',
                'a.build-price',
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
        },

        _elements: function(_callback) {
            GO_BPT.el_doc             = $(document);
            GO_BPT.el_title           = $('.step-current-title .heading');
            GO_BPT.el_btn_back        = '.step-nav .prev';
            GO_BPT.el_btn_next        = '.step-nav .next';
            GO_BPT.el_btn_start_over  = '.step-nav .start-over';
            GO_BPT.el_btn_add_product = '.add-product';
            GO_BPT.el_cart_items      = $('.selected-products');
            GO_BPT.el_cart_total      = $('.summary-item .cart-total');
            GO_BPT.el_cart_save       = $('.summary-item .save');
            _callback();
        }
    }
    GO_BPT._init();
})(jQuery);