<?php


class restquery_Posts_Controller implements restquery_Posts_ControllerInterface {

	/**
	 * @var WP_REST_Request
	 */
	protected $request;

	/**
	 * @var WP_REST_Posts_Controller
	 */
	protected $controller;

	public function __construct( WP_REST_Request $request = null ) {
		$this->request = null !== $request ? $request : new WP_REST_Request();
	}

	/**
	 * @param WP_Query $query
	 *
	 * @return WP_REST_Request The prepared request; internally set.
	 */
	public function setUpRequest( WP_Query $query ) {
		$this->request['context'] = 'view';
		$postType                 = $query->get( 'post_type', 'post' );
		$postType                 = ! empty( $postType ) && $postType !== 'any' ? $postType : 'post';
		$this->controller         = new WP_REST_Posts_Controller( $postType );
	}

	/**
	 * @param WP_Post|WP_REST_Response $post
	 *
	 * @return WP_REST_Response
	 */
	public function prepareItemForResponse( $post ) {
		return $post instanceof WP_Post ? $this->controller->prepare_item_for_response( $post, $this->request ) : $post;
	}
}