(function($) {
    GO_BPT = {

        el_doc        : null,
        el_model      : null,
        el_back       : null,
        el_next       : null,
        el_start_over : null,
        el_title      : null,
        selected_model: null,
        currect_step  : 1,

        _init: function() {
            GO_BPT._elements(
                GO_BPT._actions
            );
        },

        _title: function() {            
            GO_BPT.el_title.text(
                $('.tab-'+GO_BPT.currect_step+' .step-title').text()
            );
        },

        _focus: function() {
            $('html, body').animate({
                scrollTop: $('body').offset().top
            }, 500);
        },

        _tabs: function() {
            $('.tab-item').removeClass('active');
            for (let step = 1; step <= GO_BPT.currect_step; step++) {
                $('.tab-'+step).addClass('active');
            }
        },

        _steps: function() {
            $('.step').fadeOut('fast');
            $('.step-'+GO_BPT.currect_step).fadeIn('fast');            
        },

        _navigate: function() {
            GO_BPT._title();
            GO_BPT._focus();
            GO_BPT._tabs();
            GO_BPT._steps();
            GO_BPT._request();
        },

        _prev_step: function() {
            GO_BPT.currect_step -= 1;
            GO_BPT._navigate();
        },

        _next_step: function() {
            GO_BPT.currect_step += 1;
            GO_BPT._navigate();
        },

        _request: function() {
            $.ajax({
                url     : go_bpt.ajaxurl,
                type    : 'POST',
                dataType: 'json',
                data    : {
                    action: 'bpt_model_products',
                    model : GO_BPT.selected_model,
                    step  : GO_BPT.currect_step
                }
            }).done(function(response) {
                $('.step-'+GO_BPT.currect_step+' .suggested-products').html(response.products);
            });
        },

        _set_model: function(e) {
            e.preventDefault();            
            GO_BPT.selected_model = $(this).data('model');            
            GO_BPT._next_step();
        },

        _actions: function() {
            GO_BPT.el_doc.on(
                'click',
                'a.build-price',
                GO_BPT._set_model
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_back,
                GO_BPT._prev_step
            );
            GO_BPT.el_doc.on(
                'click',
                GO_BPT.el_next,
                GO_BPT._next_step
            );
        },

        _elements: function(_callback) {
            GO_BPT.el_doc        = $(document);
            GO_BPT.el_title      = $('.step-current-title .heading');
            GO_BPT.el_back       = '.step-nav .prev';
            GO_BPT.el_next       = '.step-nav .next';
            GO_BPT.el_start_over = '.step-nav .start-over';
            _callback();
        }
    }
    GO_BPT._init();
})(jQuery);