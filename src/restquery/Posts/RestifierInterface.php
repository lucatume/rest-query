<?php


interface restquery_Posts_RestifierInterface {

	/**
	 * Processes an array of WP_Posts to convert them to the REST API output format.
	 *
	 * @param array    $posts
	 * @param WP_Query $query
	 *
	 * @return array An array of WP_REST_Response instances.
	 */
	public function restifyPostsResults( array $posts, WP_Query &$query );

}