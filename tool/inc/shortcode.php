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
    }

    
    /**
     * Display shortcode content
     * @return string
     */
    public function shortcode()
    {
        ob_start();
        wp_enqueue_style('go-bpt-css');
        wp_enqueue_script('go-bpt-script');
        include(GROWTH_OPTIMIZER_BPT_DIR.'tool/parts/builder.php');
        return ob_get_clean();
    }
}