<?php


class restquery_Query extends WP_Query {

	public function __construct( $query = '' ) {
		$restQuery = parent::__construct( $query );

		if ( null === $restQuery ) {
			return;
		}

		return $restQuery;
	}

	public function get_posts() {
		$this->query_vars['restify'] = true;

		$semiRestifiedPosts = parent::get_posts();

		$restifiedPosts = array_map( array( $this, 'extractRestData' ), $semiRestifiedPosts );

		$this->posts = $restifiedPosts;

		return $restifiedPosts;
	}

	protected function extractRestData( WP_Post $post ) {
		return isset( $post->data ) ? $post->data : array();
	}
}