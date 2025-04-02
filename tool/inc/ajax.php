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

        $tax_query = [];
        $model     = $_POST['model'];
        $step      = (int)$_POST['step'];

        $tax_query = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $this->models[$model]['step-'.$step]
            ]
        ];

        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => $tax_query
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
        $quote_details = $_POST['quote_details'];
        $respose       = $this->record($quote_details);

        wp_send_json([
            'token'   => $respose,
            'details' => $quote_details
        ]);
        wp_die();
    }
}