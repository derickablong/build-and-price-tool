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
        add_action(
            'admin_enqueue_scripts',
            [$this, 'admin_library']
        );
        add_action('wp_head', function() {
            echo '<script>var BPT_ATTACHMENTS = [];</script>';
            echo '<script>var BPT_ALPHABET = '.json_encode($this->alphabets).';</script>';
        });
        add_action('admin_head', function() {
            echo '<script>var BPT_ALPHABET = '.json_encode($this->alphabets).';</script>';
        });
    }

    /**
     * Admin library
     * @return void
     */
    public function admin_library()
    {
        wp_register_style( 
            'go-bpt-admin-css', 
            $this->url . 'tool/css/admin.css',
            array(), 
            uniqid(), 
            'all' 
        );
        wp_register_script(
            'go-bpt-admin-script',
            $this->url . 'tool/js/admin.js',
            array('jquery'),
            uniqid(),            
            true
        );
    }

    /**
     * Register libraries
     *
     * @return void
     */
    public function library()
    {
        global $post;
        if ($post->ID == BPT_PAGE && !isset($_GET['id'])) {
            $token = bin2hex(random_bytes(15));            
            $params = $_SERVER['QUERY_STRING'];
            wp_redirect(
                home_url('/build-and-price-tool/?id='.$token.($params ? '&'.$params : ''))
            );
        }
        
        wp_register_style( 
            'go-bpt-css', 
            $this->url . 'tool/css/style.css',
            array(), 
            uniqid(), 
            'all' 
        );
        wp_register_style( 
            'go-bpt-preview-css', 
            $this->url . 'tool/css/preview.css',
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
                'ajaxurl'    => esc_url( admin_url( 'admin-ajax.php' ) ),
                'plugin_url' => $this->url
            ]
        );

        # Load library if Build and Price Tool page
        if ($post->ID == BPT_PAGE) {
            wp_enqueue_style('go-bpt-css');        
            wp_enqueue_script('go-bpt-script');
        }

        # If preview page
        if ($post->ID == PREVIEW_PAGE) {
            wp_enqueue_style('go-bpt-preview-css');
        }
    }
}