<?php


interface restquery_Posts_ControllerInterface {

	/**
	 * @param WP_Query $query
	 *
	 * @return WP_REST_Request The prepared request; internally set.
	 */
	public function setUpRequest( WP_Query $query );

	/**
	 * @param WP_Post|WP_REST_Response $post
	 *
	 * @return WP_REST_Response
	 */
	public function prepareItemForResponse( $post );
}