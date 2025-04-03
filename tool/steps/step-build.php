<div class="step step-build">

    <?php do_action('bpt-step-nav'); ?>

    <div class="step-products">
        
        <div class="suggested-products"></div>

        <?php         
        do_action('bpt-shipping'); 
        do_action('bpt-shipping-info', $token);
        do_action('bpt-cart'); 
        ?>
        
    </div>
</div>