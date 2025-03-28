(function($) {
    GO_BPT = {

        el_doc        : null,
        el_model      : null,
        selected_model: null,
        currect_step  : 1,

        _init: function() {
            GO_BPT._elements(
                GO_BPT._actions
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

        _next_step: function() {
            GO_BPT._focus();
            GO_BPT._tabs();
            GO_BPT._steps();
            GO_BPT._request();
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
            GO_BPT.currect_step   = 2;
            GO_BPT._next_step();
        },

        _actions: function() {
            GO_BPT.el_doc.on(
                'click',
                'a.build-price',
                GO_BPT._set_model
            );
        },

        _elements: function(_callback) {
            GO_BPT.el_doc = $(document);
            _callback();
        }
    }
    GO_BPT._init();
})(jQuery);