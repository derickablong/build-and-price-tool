<?php

namespace GO_BPT;

class GO_Build_And_Price_Tool
{
    use GO_BPT_Database, GO_BPT_Library, GO_BPT_Shortcode, GO_BPT_Parts, GO_BPT_Ajax, GO_BPT_GHL, GO_BPT_Metabox, GO_BPT_Admin;

    # Directory path holder
    public $dir;

    # Directory URL holder
    public $url;

    # Models
    public $models;

    # Metabox key
    public $meta_box_key;

    # Table
    public $table_bpt;
    public $table_model;
    public $table_model_category;

    function __construct($dir, $url, $meta_box_key)
    {
        global $wpdb;

        $this->dir                  = $dir;
        $this->url                  = $url;
        $this->models               = $this->models_steps();
        $this->meta_box_key         = $meta_box_key;
        $this->table_bpt            = $wpdb->prefix . 'bpt';
        $this->table_model          = $wpdb->prefix . 'bpt_models';
        $this->table_model_category = $wpdb->prefix . 'bpt_model_categories';

        # Admin
        $this->create_admin();

        # Metabox
        $this->metabox();

        # GHL Capture
        $this->capture();

        # Create database table
        $this->create_table();

        # Install libraries
        $this->register_library();

        # Template parts
        $this->register_template_parts();

        # Register Ajax
        $this->register_ajax();

        # Shortcode
        $this->register_shortcode();        
    }    
}