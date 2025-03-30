<div class="step step-build">

    <?php do_action('bpt-step-nav'); ?>

    <div class="step-products">
        
        <div class="suggested-products"></div>

        <?php         
        do_action('bpt-shipping'); 
        do_action('bpt-shipping-info'); 
        do_action('bpt-discount');
        do_action('bpt-confirmation');
        do_action('bpt-cart'); 
        ?>
        
    </div>
</div>