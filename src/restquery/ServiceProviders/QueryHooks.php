<?php


class restquery_ServiceProviders_QueryHooks extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 */
	public function register() {
		$this->container->singleton( 'restquery_Posts_RestifierInterface', 'restquery_Posts_Restifier' );
		$this->container->singleton( 'restquery_Posts_ControllerInterface', 'restquery_Posts_Controller' );


		add_filter( 'the_posts', array( $this->container->make( 'restquery_Posts_RestifierInterface' ), 'restifyPostsResults' ), 999, 2 );
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot() {
	}
}