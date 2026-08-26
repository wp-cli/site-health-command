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
	// SiteHealthCommand::__construct() calls WP_Site_Health::get_instance(),
	// which was only introduced in WordPress 5.4.
	if ( \WP_CLI\Utils\wp_version_compare( '5.4', '<' ) ) {
		WP_CLI::error( 'Requires WordPress 5.4 or greater.' );
	}
};

WP_CLI::add_command( 'site-health', SiteHealthCommand::class, [ 'before_invoke' => $wpcli_site_health_before_invoke ] );
