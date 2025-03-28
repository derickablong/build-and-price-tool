<?php

namespace GO_BPT;

trait GO_BPT_Parts
{

    /**
     * Register template parts
     * @return void
     */
    public function register_template_parts()
    {
        add_action(
            'bpt-step-nav',
            [$this, 'step_nav']
        );
        add_action(
            'bpt-step-1',
            [$this, 'step_1']
        );
        add_action(
            'bpt-step-build',
            [$this, 'step_build']
        );        
        add_action(
            'bpt-product-item',
            [$this, 'product'],
            10, 1
        );
        add_action(
            'bpt-cart',
            [$this, 'cart']            
        );
    }


    /**
     * Load step
     * @param mixed $file_name
     * @return void
     */
    public function step( $file_name )
    {
        include(GROWTH_OPTIMIZER_BPT_DIR.'tool/steps/'.$file_name.'.php');
    }
    

    /**
     * Load part
     * @param mixed $file_name
     * @return void
     */
    public function parts( $file_name )
    {
        include(GROWTH_OPTIMIZER_BPT_DIR.'tool/parts/'.$file_name.'.php');
    }


    /**
     * Step navigation
     * @return void
     */
    public function step_nav()
    {
        $this->parts('nav');
    }


    /**
     * Step 1
     * @return void
     */
    public function step_1()
    {
        $this->step('step-1');
    }

    /**
     * Step 2 to last step
     * @return void
     */
    public function step_build()
    {
        $this->step('step-build');
    }

    /**
     * Product item     
     * @return void
     */
    public function product()
    {
        $this->parts('product');
    }

    /**
     * Cart     
     * @return void
     */
    public function cart()
    {
        $this->parts('cart');
    }
}