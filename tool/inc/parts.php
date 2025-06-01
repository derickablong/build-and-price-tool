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
            [$this, 'step_build'],
            10, 1
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
            [$this, 'shipping_info'],
            10, 1
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
        add_action(
            'bpt-shipping-form',
            [$this, 'shipping_form'],
            10,
            1 
        );
        add_action(
            'bpt-footer',
            [$this, 'footer'],
            10,
            1 
        );
        add_action(
            'bpt-admin',
            [$this, 'admin_part'],
            10,
            4
        );
        add_action(
            'bpt-admin-model',
            [$this, 'admin_model'],
            10,
            1
        );
        add_action(
            'bpt-metabox',
            [$this, 'admin_metabox'],
            10,
            1
        );
        add_action(
            'bpt-attachment',
            [$this, 'admin_attachment'],
            10,
            2
        );
        add_action(
            'bpt-model-attachments',
            [$this, 'model_attachments'],
            10,
            1
        );
        add_action(
            'bpt-popup',
            [$this, 'popup'],
            10,
            1
        );
        add_action(
            'bpt-preview',
            [$this, 'do_preview'],
            10,
            5
        );
        add_action(
            'bpt-builder',
            [$this, 'builder'],
            10,
            1
        );
    }


    /**
     * Admin page
     * @param array|object $models
     * @param array|object $edit_model
     * @param array|object $manage_model
     * @param array|object $product_attachment
     * @return void
     */
    public function admin_part($models = [], $edit_model = [], $manage_model = [], $product_attachment = 0)
    {
        if ($manage_model['id'])
            $this->parts('admin-manage', ['model' => $manage_model, 'categories' => $this->model_categories($manage_model)]);
        else if ($product_attachment['id'])
            $this->parts('admin-product-attachment', ['model' => $product_attachment]);
        else
            $this->parts('admin', ['models' => $models, 'edit_model' => $edit_model]);
    }

    /**
     * Admin model
     * @param array|object $model     
     * @return void
     */
    public function admin_model($model)
    {
        $this->parts('admin-model', ['model' => $model]);
    }  

    /**
     * Get model attachments     
     * @param int $products
     * @param array|object $item
     * @return void
     */
    public function admin_attachment($item, $products)
    {
        $this->parts('admin-attachment', ['products' => $products, 'item' => $item]);
    }


    /**
     * Load step
     * @param mixed $file_name
     * @param array $variables
     * @return void
     */
    public function step( $file_name, $variables = [] )
    {
        if (!empty($variables))
            extract($variables);
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
     * @param string $token
     * @return void
     */
    public function step_build($token)
    {
        $this->step('step-build', ['token' => $token]);
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
     * @param string $token
     * @return void
     */
    public function shipping_info($token)
    {
        $this->parts('shipping-info', ['token' => $token]);
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
     * Metabox
     * @param string $selected
     * @return void
     */
    public function admin_metabox($selected)
    {
        $this->parts('admin_metabox', ['selected' => $selected]);
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

    /**
     * Shipping form
     * @param string $token
     * @return void
     */
    public function shipping_form($token)
    {
        $this->parts('form', ['token' => $token]);
    }

    /**
     * Footer
     * @return void
     */
    public function footer()
    {
        $this->parts('footer');
    }

    /**
     * Model attachments
     * @param object $model
     * @return void
     */
    public function model_attachments($model)
    {
        $this->parts('attachment', [
            'model' => $model, 
            'attachments' => $this->attachments($model->id)
        ]);
    }

    /**
     * Popup attachment
     * @param string $products
     * @return void
     */
    public function popup($products)
    {
        $this->parts('popup', ['products' => $products]);
    }

    /**
     * Quote Preview
     * @param objeckt $quote
     * @param array|object $model
     * @param array|object $products
     * @param array|object $shipping
     * @param array|object $details
     * @return void
     */
    public function do_preview($quote, $model, $products, $shipping, $details)
    {
        $this->parts('preview', [
            'quote'    => $quote,
            'model'    => $model,
            'products' => $products,
            'shipping' => $shipping,
            'details'  => $details
        ]);
    }

    /**
     * Builder
     * @param string $token
     * @return void
     */
    public function builder($token)
    {
        $this->parts('builder', ['token' => $token]);
    }
}