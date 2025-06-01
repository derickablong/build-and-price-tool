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

$products        = [];
$loaded_products = [];
?>

<div class="wrap">
    <h1>Machine and Attachment for model <?php echo $model['title'] ?></h1>    
    <div class="attachment-setup">
        <?php
        $result_one = new WP_Query($products_one);
        if ($result_one->have_posts()): 
            while ($result_one->have_posts()):
                $result_one->the_post();                
                global $post;
                $product = new \WC_Product( $post->ID ); 
                if ($product->get_price() <= 0) continue;
                $products[$post->ID] = $post->post_title;
                $loaded_products[] = $post->ID;
            endwhile;            
        endif;
        wp_reset_query();

        $products_two['post__not_in'] = $loaded_products;
        $result_two = new WP_Query($products_two);
        if ($result_two->have_posts()): 
            while ($result_two->have_posts()):
                $result_two->the_post();                
                global $post;
                $product = new \WC_Product( $post->ID ); 
                if ($product->get_price() <= 0) continue;
                $products[$post->ID] = $post->post_title;                
            endwhile;            
        endif;
        wp_reset_query();
        ?>
        <form action="" method="post">
            <input type="hidden" name="model-attachment" value="<?php echo $model['id'] ?>">    
            <div class="row-attachment">
                <?php                 
                foreach ($model_attachments as $item) {                    
                    do_action('bpt-attachment', $item, $products);
                }
                ?>

                
                <?php do_action('bpt-attachment', [], $products) ?>
            </div>

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

    const _select2 = function($row) {
        $row.find('.select2-container').remove();

        const $select = $row.find('select');   
        $select.removeClass('select2-offscreen');     
        $select.select2();        
        
        $row.removeClass('loading');
    }

    const process = function() {
        $('.attachment-item').each(function(index, _row) {
            const $row = $(this);                        
            naming($row, _select2);            
        });
    }   

    const naming = function($row, _callback) {
        const $products    = $row.find('select.attachment-products');
        const $requirement = $row.find('select.attachment-requirement');
        
        const requirement_data = $requirement.select2('data');        
        const selected = requirement_data.id ? requirement_data.id : $requirement.val();                

        $products.attr('name', 'attachment-products['+ selected +'][]');
        $requirement.attr('name', 'attachment-requirement['+ selected +']');               

        _callback($row);
    }
    

    $(document).on('click', '.add', function(e) {
        e.preventDefault();

        const $item     = $(this).closest('.attachment-item');
        const $new_item = $item.clone();
        
        $new_item.insertAfter($item);
        $new_item.find('select.attachment-products').val(null);
        $new_item.find('select.attachment-requirement').val(0);

        process();             
    });

    $(document).on('click', '.remove', function(e) {
        e.preventDefault();

        const $item = $(this).closest('.attachment-item');
        if ($('.attachment-item').length > 1) {
            $item.remove();        
        } else {            
            $item.find('select.attachment-products').val(null).trigger('change');
            $item.find('select.attachment-requirement').val(0).trigger('change');
        }

        process();
    });

    $('select').on('change', function() {
        console.log('Processing...');
        const $row = $(this).closest('.attachment-item');        
        naming($row, function(_row) {
            console.log('Done.');
        });
    });

    setTimeout(process, 2000);
});
</script>