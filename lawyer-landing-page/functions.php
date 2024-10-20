<?php
/**
 * Lawyer Landing Page functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Lawyer_Landing_Page
 */

$lawyer_landing_page_theme_data = wp_get_theme();
if( ! defined( 'LAWYER_LANDING_PAGE_THEME_VERSION' ) ) define ( 'LAWYER_LANDING_PAGE_THEME_VERSION', $lawyer_landing_page_theme_data->get( 'Version' ) );
if( ! defined( 'LAWYER_LANDING_PAGE_THEME_NAME' ) ) define( 'LAWYER_LANDING_PAGE_THEME_NAME', $lawyer_landing_page_theme_data->get( 'Name' ) );

/**
 * Implement Local Font Method functions.
 */
require get_template_directory() . '/inc/class-webfont-loader.php';

/**
 * Implement the Custom functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Custom template function for this theme.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Metabox for Sidebar Layout
*/
require get_template_directory() . '/inc/metabox.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Widgets.
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
* Recommended Plugins
*/
require_once get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Dashboard
*/
require get_template_directory() . '/inc/dashboard/dashboard.php';

/**
 * Add theme compatibility function for woocommerce if active
*/
if( lawyer_landing_page_is_woocommerce_activated() )
require get_template_directory() . '/inc/woocommerce-functions.php';