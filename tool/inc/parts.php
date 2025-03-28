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
            'bpt-step-2',
            [$this, 'step_2']
        );
        add_action(
            'bpt-step-3',
            [$this, 'step_3']
        );
        add_action(
            'bpt-step-4',
            [$this, 'step_4']
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
     * Step 2
     * @return void
     */
    public function step_2()
    {
        $this->step('step-2');
    }

    /**
     * Step 3
     * @return void
     */
    public function step_3()
    {
        $this->step('step-3');
    }

    /**
     * Step 4
     * @return void
     */
    public function step_4()
    {
        $this->step('step-4');
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