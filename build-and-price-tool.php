<?php
/**
 * Plugin Name:     Growth Optimizer - Build and Price Tool
 * Plugin URI:      https://growthoptimizer.com
 * Description:     Custom model build and price tool
 * Author:          Growth Optimizer
 * Author URI:      https://growthoptimizer.com/
 * Text Domain:     go-kit
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         growthoptimizer-bpt
 */
namespace GO_BPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define('GROWTH_OPTIMIZER_BPT_DIR', plugin_dir_path( __FILE__ ));
define('GROWTH_OPTIMIZER_BPT_URL', plugin_dir_url( __FILE__ ));

# Includes
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/library.php');
# Template parts
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/parts.php');
# Shortcode
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/shortcode.php');
# Build and price tool
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/tool.php');

# Starter the CPT filter widget
new GO_Build_And_Price_Tool(
    GROWTH_OPTIMIZER_BPT_DIR,
    GROWTH_OPTIMIZER_BPT_URL
);