<?php


class restquery_Service_Activation implements restquery_Service_ActivationInterface {

	/**
	 * Whether the REST API is integrated in the WordPress CORE installation or not.
	 *
	 * @return bool
	 */
	public static function restApiIsIntegrated() {
		return false;
	}

	/**
	 * Handles the plugin activation.
	 */
	public static function activate() {
		if ( ! is_plugin_active( 'rest-api/plugin.php' ) || self::restApiIsIntegrated() ) {
			deactivate_plugins( 'rest-query/rest-query.php' );
			wp_die( 'REST Query requires either a version of WordPress integrating the REST API or the WP REST API plugin installed and activated.' );
		}
	}
}