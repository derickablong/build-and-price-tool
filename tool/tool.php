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

    function __construct($dir, $url, $meta_box_key)
    {
        $this->dir          = $dir;
        $this->url          = $url;
        $this->models       = $this->models_steps();
        $this->meta_box_key = $meta_box_key;

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