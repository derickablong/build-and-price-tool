<?php 
$total      = (float)str_replace(',', '', $model->price);
$total_sale = (float)str_replace(',' ,'', $model->sale_price);
?>
<div class="bpt-details" data-token="<?php echo $token ?>">
    <div class="col details">
        <div class="detail-title first">Personal Info</div>

        <div class="detail-item">
            <div class="label">Name:</div>
            <div class="value"><?php echo $details->fname . ' ' . $details->lname ?></div>
        </div>
        <div class="detail-item">
            <div class="label">Company:</div>
            <div class="value"><?php echo $details->company ?></div>
        </div>
        <div class="detail-item">
            <div class="label">Phone:</div>
            <div class="value"><?php echo $details->phone ?></div>
        </div>
        <div class="detail-item">
            <div class="label">Email:</div>
            <div class="value"><?php echo $details->email ?></div>
        </div>

        <div class="detail-title">Mailing Address</div>

        <div class="detail-item">
            <div class="label">Address:</div>
            <div class="value"><?php echo $details->address ?></div>
        </div>
        <div class="detail-item">
            <div class="label">City:</div>
            <div class="value"><?php echo $details->city ?></div>
        </div>
        <div class="detail-item">
            <div class="label">State:</div>
            <div class="value"><?php echo $details->state ?></div>
        </div>
        <div class="detail-item">
            <div class="label">Country:</div>
            <div class="value"><?php echo $details->country ?></div>
        </div>
        <div class="detail-item">
            <div class="label">Postal Code:</div>
            <div class="value"><?php echo $details->postal ?></div>
        </div>

        <div class="detail-title">Discount</div>

        <div class="detail-item full">            
            <div class="value p"><?php echo $details->discount ?></div>
        </div>

        <div class="detail-title">How did you hear us?</div>

        <div class="detail-item full">            
            <div class="value p"><?php echo $details->about_us ?></div>
        </div>

        <div class="detail-title">Other Interest</div>

        <div class="detail-item full">            
            <div class="value p"><?php echo $details->question ?></div>
        </div>
    </div>    

    <div class="step-mini-cart">
        <div class="min-cart-container">
            <div class="cart-header">
                <span>Item</span>
                <span>Price</span>
                <span>Sale Price</span>
            </div>
            <div class="cart-items">

                <?php
                $regular_price = (float)str_replace(',', '', $model->price);
                $sale_price  = (float)str_replace(',', '', $model->sale_price);
                ?>

                <div class="cart-item item-model">
                    <div class="cart-col name"><?php echo $model->name ?></div>
                    <div class="cart-col num reg-price <?php echo $sale_price > 0 ? 'strike' : 'normal'?>"><?php echo wc_price($regular_price) ?></div>
                    <div class="cart-col num sale-price"><?php echo wc_price($sale_price) ?></div>
                </div>

                
                <div class="selected-products">
                <?php 
                foreach($products as $product): 

                    $regular_price = (float)str_replace(',', '', $product->reg_price);
                    $sale_price    = (float)str_replace(',', '', $product->sale_price);

                    $total += $sale_price > 0 ? $sale_price : $regular_price;
                    $total_sale += $sale_price > 0 ? $regular_price - $sale_price : $sale_price;
                    ?>                

                    <div class="cart-item">
                        <div class="cart-col name"><?php echo stripslashes($product->title) ?></div>
                        <div class="cart-col num reg-price <?php echo $sale_price > 0 ? 'strike' : 'normal' ?>"><?php echo wc_price( $regular_price ) ?></div>
                        <div class="cart-col num sale-price"><?php echo wc_price( $sale_price ) ?></div>
                    </div>

                <?php endforeach; ?>
                </div>


            </div>
            <div class="cart-summary">             
                <div class="summary-item">
                    <span class="summary-label">Total Price:</span>
                    <span class="summary-total num cart-total"><?php echo wc_price( $total ) ?></span>                
                </div>                
                <div class="summary-item">
                    <span class="summary-label">Save:</span>
                    <span class="summary-total num save"><?php echo wc_price( $total_sale ) ?></span>                
                </div>
            </div>
            <div class="selected-shipping">
                <span class="icon">
                    <svg fill="none" height="24" stroke-width="1.5" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M8 19C9.10457 19 10 18.1046 10 17C10 15.8954 9.10457 15 8 15C6.89543 15 6 15.8954 6 17C6 18.1046 6.89543 19 8 19Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="1.5"/><path d="M18 19C19.1046 19 20 18.1046 20 17C20 15.8954 19.1046 15 18 15C16.8954 15 16 15.8954 16 17C16 18.1046 16.8954 19 18 19Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="1.5"/><path d="M10.05 17H15V6.6C15 6.26863 14.7314 6 14.4 6H1" stroke="currentColor" stroke-linecap="round"/><path d="M5.65 17H3.6C3.26863 17 3 16.7314 3 16.4V11.5" stroke="currentColor" stroke-linecap="round"/><path d="M2 9L6 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 9H20.6101C20.8472 9 21.0621 9.13964 21.1584 9.35632L22.9483 13.3836C22.9824 13.4604 23 13.5434 23 13.6273V16.4C23 16.7314 22.7314 17 22.4 17H20.5" stroke="currentColor" stroke-linecap="round"/><path d="M15 17H16" stroke="currentColor" stroke-linecap="round"/></svg>
                </span>
                <span>
                    <span class="label">Shipping</span>
                    <span class="selected"><?php echo $shipping ?></span>
                </span>
            </div>
        </div>
        <?php do_action('bpt-contact-number') ?>
    </div>
    
</div>
<?php do_action('bpt-footer') ?>