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
            <input type="hidden" name="model-attachment" value="1">            
            <div class="row-attachment group">                
                <div class="col">       
                    <div class="title">Attachment Group</div>         
                    <select name="attachment-require[]" class="attachment-require" multiple="multiple">
                        <option value="">--- Select Product ---</option>
                        <?php foreach ($attachments as $product_id => $product): ?>
                            <option value="<?php echo $product_id ?>"><?php echo $product ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col buttons">
                    <div class="cta">
                        <a href="#" class="remove">
                            <svg height="30px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="30px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M256,32C132.3,32,32,132.3,32,256s100.3,224,224,224s224-100.3,224-224S379.7,32,256,32z M384,272H128v-32h256V272z"/></g></svg>
                        </a>
                        <a href="#" class="add">
                            <svg height="30px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="30px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M256,32C132.3,32,32,132.3,32,256s100.3,224,224,224s224-100.3,224-224S379.7,32,256,32z M384,272H272v112h-32V272H128v-32   h112V128h32v112h112V272z"/></g></svg>
                        </a>
                    </div>
                </div>
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
    $('.row-attachment select').select2();

    $(document).on('click', '.add', function(e) {
        e.preventDefault();

        const $item     = $(this).closest('.row-attachment');
        let   $new_item = $item.clone();

        $new_item.find('.select2-container').remove();
        $new_item.insertAfter($item);        
        $new_item.find('select').select2();
    });

    $(document.body).on("change", ".attachment-item",function(){
        console.log(this.value);
    });
});
</script>