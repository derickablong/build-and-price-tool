<?php

# Custom query vars
add_filter( 'query_vars', function($vars) {
    $vars[] = 'quote-id';    
    return $vars;
});

add_action('init', function() {
    add_rewrite_rule('^build-and-price-tool/preview/([^/]*)/?','index.php?page_id='.PREVIEW_PAGE.'&quote-id=$matches[1]','top');
});