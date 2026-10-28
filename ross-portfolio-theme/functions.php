<?php
/**
 * Ross Portfolio Theme functions and definitions
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define Theme Constants
 */
define( 'ROSS_PORTFOLIO_VERSION', '1.0.0' );
define( 'ROSS_PORTFOLIO_DIR', get_template_directory() );
define( 'ROSS_PORTFOLIO_URI', get_template_directory_uri() );

/**
 * Require Include Modules
 */
require_once ROSS_PORTFOLIO_DIR . '/inc/setup.php';
require_once ROSS_PORTFOLIO_DIR . '/inc/enqueue.php';
require_once ROSS_PORTFOLIO_DIR . '/inc/helpers.php';
require_once ROSS_PORTFOLIO_DIR . '/inc/customizer.php';
require_once ROSS_PORTFOLIO_DIR . '/inc/seeder.php';
