<?php


class restquery_Posts_Restifier implements restquery_Posts_RestifierInterface {

	/**
	 * @var restquery_Posts_ControllerInterface
	 */
	private $postsController;

	/**
	 * restquery_Posts_Restifier constructor.
	 *
	 * @param restquery_Posts_ControllerInterface $postsController
	 */
	public function __construct( restquery_Posts_ControllerInterface $postsController ) {
		$this->postsController = $postsController;
	}

	/**
	 * Processes an array of WP_Posts to convert them to the REST API output format.
	 *
	 * @param array    $posts
	 * @param WP_Query $query
	 *
	 * @return array An array of WP_REST_Response instances.
	 */
	public function restifyPostsResults( array $posts, WP_Query &$query ) {
		if ( false === $query->get( 'restify', false ) ) {
			return $posts;
		}

		$restified = array();

		try {
			$this->postsController->setUpRequest( $query );
			$restified = array_map( array( $this->postsController, 'prepareItemForResponse' ), $posts );
		} catch ( restquery_Exception $e ) {
			// noop
		}

		return $restified;
	}
}