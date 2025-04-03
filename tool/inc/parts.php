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
            'bpt-discount',
            [$this, 'discount']
        );   
        add_action(
            'bpt-shipping',
            [$this, 'shipping']
        );
        add_action(
            'bpt-shipping-info',
            [$this, 'shipping_info']
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
        add_action(
            'bpt-contact-number',
            [$this, 'contact_number']            
        );
        add_action(
            'bpt-model-cta',
            [$this, 'model_cta'],
            10,
            4 
        );
        add_action(
            'bpt-confirmation',
            [$this, 'confirmation'],
            10,
            4 
        );
        add_action(
            'bpt-quote-details',
            [$this, 'quote_details'],
            10,
            4 
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
     * Load template parts
     * @param string $file_name
     * @param array $variables
     * @return void
     */
    public function parts( $file_name, $variables = [] )
    {
        if (!empty($variables))
            extract($variables);
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

    /**
     * Discount     
     * @return void
     */
    public function discount()
    {
        $this->parts('discount');
    }

    /**
     * Shipping     
     * @return void
     */
    public function shipping()
    {
        $this->parts('shipping');
    }

    /**
     * Shipping info
     * @return void
     */
    public function shipping_info()
    {
        $this->parts('shipping-info');
    }

    /**
     * Contact number     
     * @return void
     */
    public function contact_number()
    {
        $this->parts('contact-number');
    }

    /**
     * Confirmation
     * @return void
     */
    public function confirmation()
    {
        $this->parts('confirmation');
    }

    /**
     * Model CTA
     * 
     * @param string $model
     * @param string $url
     * @param float $price
     * @param float $sale_price
     * @return void
     */
    public function model_cta($url, $model, $price = 0, $sale_price = 0)
    {
        $this->parts(
            'model-cta',
            [
                'url'        => $url,
                'model'      => $model,
                'price'      => $price,
                'sale_price' => $sale_price
            ]
        );
    }

    /**
     * Quote details
     * @param string $key
     * @return void
     */
    public function quote_details($key)
    {
        $this->parts('quote-details', ['key' => $key]);
    }
}