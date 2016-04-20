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

	/**
	 * @var array
	 */
	protected $controllerCache = array();

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
	}

	/**
	 * @param WP_Post|WP_REST_Response $post
	 *
	 * @return WP_REST_Response
	 */
	public function prepareItemForResponse( $post ) {
		if ( $post instanceof WP_Post ) {
			$postType   = $post->post_type;
			$controller = $this->getPostTypeController( $postType );

			$response   = $controller->prepare_item_for_response( $post, $this->request );
			$post->data = $response->data;
		}

		return $post;
	}

	/**
	 * @param $postType
	 *
	 * @return WP_REST_Posts_Controller
	 */
	protected function getPostTypeController( $postType ) {
		if ( isset( $this->controllerCache[ $postType ] ) ) {
			return $this->controllerCache[ $postType ];
		}
		$controller                         = new WP_REST_Posts_Controller( $postType );
		$this->controllerCache[ $postType ] = $controller;

		return $controller;
	}
}
