<?php

namespace GO_BPT;

class GO_Build_And_Price_Tool
{
    use GO_BPT_Library, GO_BPT_Shortcode, GO_BPT_Parts;

    # Directory path holder
    public $dir;

    # Directory URL holder
    public $url;

    function __construct($dir, $url)
    {
        $this->dir = $dir;
        $this->url = $url;

        # Install libraries
        $this->register_library();

        # Template parts
        $this->register_template_parts();

        # Shortcode
        $this->register_shortcode();
    }

}