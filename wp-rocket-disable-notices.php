<?php
/**
 * Plugin Name: WP Rocket - Disable file permissions notices
 * Description: Prevent WP Rocket from displaying warning notices about files not being writeable.
 * Version: 0.0.1
 * Requires PHP: 7.0
 * Author: WP Media
 * Licence: GPLv2 or later
 *
 * Copyright 2021 WP Rocket
 * */

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

/**
 * Function to remove WP Rocket notices about .htaccess 
 * and advanced-cache.php files are not writable.
 */
function wp_rocket_remove_notices_helper() {
    // If WP Rocket is not installed finish the execution.
    if ( ! defined( 'WP_ROCKET_VERSION' ) ) {
        return;
    }

    // Remove .htaccess file is not writable notice.
    remove_action( 'admin_notices', 'rocket_warning_htaccess_permissions');

    // Get AdvancedCache instance.
    $container              = apply_filters( 'rocket_container', null );
    $admin_cache_subscriber = $container->get( 'admin_cache_subscriber' );

    // Remove advanced-cache.php file is not writable notice.
    remove_action( 'admin_notices', [ $admin_cache_subscriber, 'notice_advanced_cache_permissions' ] );
}

// Add action with a low priority value (higher priority) to remove notices.
add_action( 'admin_notices', 'wp_rocket_remove_notices_helper', 5 );
