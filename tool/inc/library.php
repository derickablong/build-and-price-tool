<?php

namespace GO_BPT;

trait GO_BPT_Library
{

    /**
     * Action to register libraries
     *
     * @return void
     */
    public function register_library()
    {
        add_action(
            'wp_enqueue_scripts', 
            [$this, 'library']
        );
    }

    /**
     * Register libraries
     *
     * @return void
     */
    public function library()
    {
        wp_register_style( 
            'go-bpt-css', 
            $this->url . 'tool/css/style.css',
            array(), 
            uniqid(), 
            'all' 
        );
        wp_register_script(
            'go-bpt-script',
            $this->url . 'tool/js/script.js',
            array('jquery'),
            uniqid(),            
            true
        );
        wp_localize_script(
            'go-bpt-script',
            'go_bpt',
            [
                'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
            ]
        );
    }
}