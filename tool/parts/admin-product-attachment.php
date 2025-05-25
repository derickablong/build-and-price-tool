<?php 
$model_attachments = $this->attachments($model['id']);
$categories        = $this->model_categories($model['id']);

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
    <h1>Product attachment for model <?php echo $model['title'] ?></h1>    
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
        <form action="" method="post">
            <input type="hidden" name="model-attachment" value="<?php echo $model['id'] ?>">    
            
            <?php 
            $current_index = 0;
            foreach ($model_attachments as $index => $item) {
                $current_index = $index;
                do_action('bpt-attachment', $index, $attachments, $item);
            }
            ?>

            
            <?php do_action('bpt-attachment', $current_index, $attachments, []) ?>

            <div class="submit">
                <a href="<?php echo admin_url('/admin.php?page=bpt') ?>" class="button black">Back</a>
                <button class="button">Save Settings</button>
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {

    const group = ['A', 'B', 'C', 'D', 'E', 'E', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V'];

    const naming = function() {
        $('.row-attachment').each(function(index, _row) {
            const $row = $(this);
            const alpa = group[index];

            $row.attr('data-group', index);
            $row.find('.title').text('Attachment '+alpa);
            $row.find('select').attr('name', 'attachment-require['+ alpa.toLowerCase() +'][]');
            $row.find('.select2-container').remove();
            $row.find('select').select2();
            $row.removeClass('loading');
        });
    }

    $('.row-attachment select').select2();

    $(document).on('click', '.add', function(e) {
        e.preventDefault();

        const $item     = $(this).closest('.row-attachment');
        let   $new_item = $item.clone();
        
        $new_item.insertAfter($item);   
        naming();             
    });

    $(document).on('click', '.remove', function(e) {
        e.preventDefault();

        const $item = $(this).closest('.row-attachment');
        if ($('.row-attachment').length > 1) {
            $item.remove();        
        } else {
            $item.find('select').val(null).trigger('change');
        }

        naming();
    });

    setTimeout(naming, 2000);
});
</script>