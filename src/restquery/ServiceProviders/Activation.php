<?php


class restquery_ServiceProviders_Activation extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container['mainPluginFile'] = dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/rest-query.php';
		$this->container['mainPluginPath'] = plugin_dir_path( $this->container['mainPluginFile'] );

		register_activation_hook( $this->container['mainPluginFile'], array( 'restquery_Service_Activation', 'activate' ) );
		register_deactivation_hook( $this->container['mainPluginFile'], array( 'restquery_Service_Deactivation', 'deactivate' ) );
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
		// TODO: Implement boot() method.
	}
}