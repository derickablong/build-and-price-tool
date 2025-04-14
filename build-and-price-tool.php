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
define('PREVIEW_PAGE', 13501);

# Model Category ID
# MODEL8500
define('MODEL8500_FRONT_ATTACHMENT', 58);
define('MODEL8500_QUICK_HITCH_MOUNTING_SYSTEM', 56);
define('MODEL8500_REAR_ATTACHMENT', 72);
define('MODEL8500_SHOE_OPTION', 75);
define('MODEL8500_UPGRADES', 73);
# MODEL9500
define('MODEL9500_FRONT_ATTACHMENT', 58);
define('MODEL9500_QUICK_HITCH_MOUNTING_SYSTEM', 56);
define('MODEL9500_REAR_ATTACHMENT', 72);
define('MODEL9500_SHOE_OPTION', 75);
define('MODEL9500_UPGRADES', 73);

# Metabox
define('METABOX_FRONT_REAR_MOUNTING_OPTIONS_KEY', '_front_rear_mounting_options');

# Absolute path
define('GROWTH_OPTIMIZER_BPT_DIR', plugin_dir_path( __FILE__ ));
define('GROWTH_OPTIMIZER_BPT_URL', plugin_dir_url( __FILE__ ));


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
    [
        'MH8500' => [
            'step-2' => [
                MODEL8500_QUICK_HITCH_MOUNTING_SYSTEM
            ],
            'step-3' => [
                MODEL8500_FRONT_ATTACHMENT                
            ],
            'step-4' => [
                MODEL8500_REAR_ATTACHMENT
            ],
            'step-5' => [
                MODEL8500_SHOE_OPTION,
                MODEL8500_UPGRADES
            ]
        ],
        'MH4900' => [
            'step-2' => [              
                MODEL9500_QUICK_HITCH_MOUNTING_SYSTEM
            ],
            'step-3' => [
                MODEL9500_FRONT_ATTACHMENT                
            ],
            'step-4' => [
                MODEL9500_REAR_ATTACHMENT
            ],
            'step-5' => [
                MODEL9500_SHOE_OPTION,
                MODEL9500_UPGRADES
            ]
        ]
    ],
    METABOX_FRONT_REAR_MOUNTING_OPTIONS_KEY
);