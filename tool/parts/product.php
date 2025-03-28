<?php 
global $post;
$product = new \WC_Product( $post->ID ); 
?>
<div class="product-item">        
    <div class="product-item-img" style="<?php echo has_post_thumbnail() ? 'background-image:url('.get_the_post_thumbnail_url($post->ID).'); background-size:contain;' : '' ?>"></div>
    <div class="product-item-det">
        <div class="product-item-title"><?php echo $post->post_title ?></div>
        <div class="product-item-price num"><?php echo $product->get_price_html(); ?></div>
        <div class="add">
            <button>
                <span class="icon">
                    <svg enable-background="new 0 0 32 32" height="32px" id="svg2" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="plus"><g><polygon points="30,12 20,12 20,2 12,2 12,12 2,12 2,20 12,20 12,30 20,30 20,20 30,20   "/></g></g></svg>
                </span>
                <span>Add</span>
            </button>
        </div>
    </div>    
</div>