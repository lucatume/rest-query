<?php
if ( ! function_exists( 'restquery_get_posts' ) ) {
	function restquery_get_posts( $args = null ) {
		$args = array_merge( $args, array( 'suppress_filters' => false, 'restify' => true ) );

		$semiRestifiedPosts = get_posts( $args );

		$posts = array();

		foreach ( $semiRestifiedPosts as $semiRestifiedPost ) {
			$posts[] = isset( $semiRestifiedPost->data ) ? $semiRestifiedPost->data : array();
		}

		return $posts;
	}
}
