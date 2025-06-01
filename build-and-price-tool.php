<?php
/**
 * Plugin Name:     Growth Optimizer - Build and Price Tool
 * Plugin URI:      https://growthoptimizer.com
 * Description:     Custom model build and price tool
 * Author:          Growth Optimizer
 * Author URI:      https://growthoptimizer.com/
 * Text Domain:     go-bpt
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         growthoptimizer-bpt
 */
namespace GO_BPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

# Build and Price Tool page
define('BPT_PAGE', 2457);
define('PREVIEW_PAGE', 13764);

# Metabox
define('METABOX_FRONT_REAR_MOUNTING_OPTIONS_KEY', '_front_rear_mounting_options');

# Absolute path
define('GROWTH_OPTIMIZER_BPT_DIR', plugin_dir_path( __FILE__ ));
define('GROWTH_OPTIMIZER_BPT_URL', plugin_dir_url( __FILE__ ));

# Builder
$builder = [
    'inc/admin', # Admin
    'inc/metabox', # Metabox
    'inc/ghl', # Go High Level
    'inc/rewrite-role', # Rewrite Role
    'inc/database', # Database tables
    'inc/library', # Library
    'inc/parts', # Template parts
    'inc/ajax', # Ajax request
    'inc/shortcode', # Shortcodes
    'tool' # Builder
];

# Let's load required files
foreach ($builder as $require) {
    require_once(GROWTH_OPTIMIZER_BPT_DIR."tool/{$require}.php");
}

# Starter the CPT filter widget
new GO_Build_And_Price_Tool(
    GROWTH_OPTIMIZER_BPT_DIR,
    GROWTH_OPTIMIZER_BPT_URL,
    METABOX_FRONT_REAR_MOUNTING_OPTIONS_KEY
);