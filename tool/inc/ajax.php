<?php

namespace GO_BPT;

trait GO_BPT_Ajax
{
    public function register_ajax()
    {
        add_action(
            'wp_ajax_bpt_model_products',
            [$this, 'products']
        );
    }


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
}