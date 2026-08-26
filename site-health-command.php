<?php

namespace WP_CLI\SiteHealth;

use WP_CLI;

if ( ! class_exists( '\WP_CLI' ) ) {
	return;
}

$wpcli_site_health_autoloader = __DIR__ . '/vendor/autoload.php';

if ( file_exists( $wpcli_site_health_autoloader ) ) {
	require_once $wpcli_site_health_autoloader;
}

$wpcli_site_health_before_invoke = static function () {
	// Site Health, and the WP_Site_Health and WP_Debug_Data classes this command is
	// built on, were introduced in WordPress 5.2.
	if ( \WP_CLI\Utils\wp_version_compare( '5.2', '<' ) ) {
		WP_CLI::error( 'Requires WordPress 5.2 or greater.' );
	}
};

WP_CLI::add_command( 'site-health', SiteHealthCommand::class, [ 'before_invoke' => $wpcli_site_health_before_invoke ] );
