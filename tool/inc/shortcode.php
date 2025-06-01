<?php

namespace GO_BPT;

trait GO_BPT_Shortcode
{
    /**
     * Register shortcode
     * @return void
     */
    public function register_shortcode()
    {
        add_shortcode(
            'BPT',
            [$this, 'shortcode']
        );
        add_shortcode(
            'BPT-preview',
            [$this, 'preview']
        );
    }

    
    /**
     * Display shortcode content
     * @return string
     */
    public function shortcode()
    {
        
        $token = isset($_GET['id']) ? $_GET['id'] : bin2hex(random_bytes(15));
        ob_start();        
        do_action('bpt-builder', $token);
        return ob_get_clean();
    }

    /**
     * Display quote details
     * @param array $atts
     * @return bool|string
     */
    public function preview($atts = array())
    {
        ob_start();
        $token = get_query_var('quote-id');
        if (array_key_exists('token', $atts))
            $token = $atts['token'];

        $quote    = $this->get($token);
        $model    = [];
        $products = [];
        $shipping = 'None';
        $details  = [];

        if ($quote) {
            $model    = json_decode($quote->model);
            $products = json_decode($quote->products);
            $shipping = $quote->shipping;
            $details  = json_decode($quote->shipping_details);
        }
        
        do_action('bpt-preview', $quote, $model, $products, $shipping, $details);

        return ob_get_clean();
    }
}