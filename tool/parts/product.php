<?php 
global $post;
$product = new \WC_Product( $post->ID ); 
if ($product->get_price() <= 0) return;
$short_description = trim($product->get_description());
?>
<div class="product-item product-item-<?php echo $post->ID ?>" data-product="<?php echo $post->ID ?>" data-reg-price="<?php echo $product->get_regular_price() ?>" data-sale-price="<?php echo $product->get_sale_price() ? $product->get_sale_price() : '0' ?>">        
    <div class="product-item-img" style="<?php echo has_post_thumbnail() ? 'background-image:url('.get_the_post_thumbnail_url($post->ID).'); background-size:contain;' : '' ?>"></div>
    <div class="product-item-det">
        <div class="product-item-title"><?php echo $post->post_title ?></div>
        <?php if (!empty($short_description)): ?>
        <div class="product-item-description"><?php echo $short_description ?></div>
        <?php endif; ?>
        <div class="product-item-price num"><?php echo $product->get_price_html(); ?></div>
        <div class="add">
            <button class="add-product">                
                <span class="label"></span>
            </button>
        </div>
    </div>    
</div>