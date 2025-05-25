<?php

namespace GO_BPT;

trait GO_BPT_Ajax
{
    /**
     * Register AJAX
     * @return void
     */
    public function register_ajax()
    {
        add_action(
            'wp_ajax_bpt_model_products',
            [$this, 'products']
        );
        add_action(
            'wp_ajax_nopriv_bpt_model_products',
            [$this, 'products']
        );
        add_action(
            'wp_ajax_bpt_submit_quote',
            [$this, 'submit_quote']
        );
        add_action(
            'wp_ajax_nopriv_bpt_submit_quote',
            [$this, 'submit_quote']
        );
    }


    /**
     * Get products
     * @return void
     */
    public function products()
    {
        ob_start();

        $tax_query  = [];
        $meta_query = [];
        $model      = $_POST['model'];
        $step       = (int)$_POST['step'];
        $terms      = $this->models[$model]['step-'.$step];       
        

        if ($step == 2) {
            $meta_query = [[
                'key'     => $this->meta_box_key,
                'value'   => $model,
                'compare' => 'LIKE'
            ]];
            $tax_query = [];
        } else {
            $tax_query = [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $terms
                ]
            ];
        }


        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => $tax_query,
            'meta_query'     => $meta_query
        ];
        
        $results = new \WP_Query($args);

        if ($results->have_posts()): 
            while ($results->have_posts()):
                $results->the_post();                
                do_action('bpt-product-item');
            endwhile;
        endif;


        wp_send_json([
            'products' => ob_get_clean()
        ]);
        wp_die();
    }

    /**
     * Submit quote
     * @return void
     */
    public function submit_quote()
    {
        $model    = $_POST['model'];
        $products = $_POST['products'];
        $shipping = $_POST['shipping'];
        $token    = $_POST['token'];
        $response = $this->record($token, $model, $products, $shipping);

        wp_send_json([
            'token'   => $response
        ]);
        wp_die();
    }
}