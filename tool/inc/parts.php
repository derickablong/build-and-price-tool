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
            'bpt-step-1',
            [$this, 'step_1']
        );
        add_action(
            'bpt-step-2',
            [$this, 'step_2']
        );
        add_action(
            'bpt-product-item',
            [$this, 'product'],
            10, 1
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
     * Product item
     * @param object $post
     * @return void
     */
    public function product($post)
    {
        $this->parts('product');
    }
}