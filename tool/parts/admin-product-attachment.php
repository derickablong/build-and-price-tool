<?php 
$categories = $this->model_categories($model['id']); 

$terms = array_merge(
    $categories['front_attachment'],
    $categories['rear_attachment'],
    $categories['upgrade']
);

$tax_query = [    
    [
        'taxonomy' => 'product_cat',
        'field'    => 'term_id',
        'terms'    => $terms
    ]
];

$meta_query = [    
    [
        'key'     => $this->meta_box_key,
        'value'   => $model['title'],
        'compare' => 'LIKE'
    ]
];

$products_one = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => $meta_query
];

$products_two = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'tax_query'      => $tax_query    
];

$attachments     = [];
$loaded_products = [];
?>

<div class="wrap">
    <h1>Product Attachment for model <?php echo $model['title'] ?></h1>    
    <div class="attachment-setup">
        <?php
        $result_one = new WP_Query($products_one);
        if ($result_one->have_posts()): 
            while ($result_one->have_posts()):
                $result_one->the_post();                
                global $post;
                $product = new \WC_Product( $post->ID ); 
                if ($product->get_price() <= 0) continue;
                $attachments[$post->ID] = $post->post_title;
                $loaded_products[] = $post->ID;
            endwhile;
            wp_reset_query();
        endif;

        $products_two['post__not_in'] = $loaded_products;
        $result_two = new WP_Query($products_two);
        if ($result_two->have_posts()): 
            while ($result_two->have_posts()):
                $result_two->the_post();                
                global $post;
                $product = new \WC_Product( $post->ID ); 
                if ($product->get_price() <= 0) continue;
                $attachments[$post->ID] = $post->post_title;                
            endwhile;
            wp_reset_query();
        endif;
        ?>
        

        <div class="row-attachment">
            <div class="col">
                <div class="title">Product</div>
                <select name="attachment-item[]" class="attachment-item">
                    <option value="">--- Select Product ---</option>
                    <?php foreach ($attachments as $product_id => $product): ?>
                        <option value="<?php echo $product_id ?>"><?php echo $product ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <div class="title">Required Attachment</div>
                <select name="attachment-require[]" class="attachment-require">
                    <option value="">--- Select Product ---</option>
                    <?php foreach ($attachments as $product_id => $product): ?>
                        <option value="<?php echo $product_id ?>"><?php echo $product ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

    </div>
</div>