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


# Admin
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/admin.php');
# Meta
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/metabox.php');
# GHL
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/ghl.php');
# Rewrite Role
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/rewrite-role.php');
# Database
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/database.php');
# Includes
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/library.php');
# Template parts
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/parts.php');
# Ajax
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/ajax.php');
# Shortcode
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/inc/shortcode.php');
# Build and price tool
require_once(GROWTH_OPTIMIZER_BPT_DIR.'tool/tool.php');

# Starter the CPT filter widget
new GO_Build_And_Price_Tool(
    GROWTH_OPTIMIZER_BPT_DIR,
    GROWTH_OPTIMIZER_BPT_URL,
    METABOX_FRONT_REAR_MOUNTING_OPTIONS_KEY
);