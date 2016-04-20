<?php


class MultiplePostTypeQueryTest extends \Codeception\TestCase\WPTestCase {

	public function setUp() {
		// before
		parent::setUp();

		// your set up methods here
	}

	public function tearDown() {
		// your tear down methods here

		// then
		parent::tearDown();
	}

	/**
	 * @test
	 * it should return queries with multiple post types in same order as query
	 */
	public function it_should_return_queries_with_multiple_post_types_in_same_order_as_query() {
		$post_id = $this->factory()->post->create( [ 'post_type' => 'post', 'post_title' => 'A' ] );
		$page_id = $this->factory()->post->create( [ 'post_type' => 'page', 'post_title' => 'B' ] );

		$query = new WP_Query( [
			'restify'   => true,
			'post_type' => [ 'post', 'page' ],
			'orderby'   => 'title',
			'order'     => 'ASC'
		] );

		$partiallyRestifiedPosts = $query->posts;
		$this->assertCount( 2, $partiallyRestifiedPosts );
		$this->assertEquals( $post_id, $partiallyRestifiedPosts[0]->ID );
		$this->assertEquals( $page_id, $partiallyRestifiedPosts[1]->ID );
		$this->assertObjectHasAttribute( 'data', $partiallyRestifiedPosts[0] );
		$this->assertObjectHasAttribute( 'data', $partiallyRestifiedPosts[1] );
		$this->assertEquals( 'post', $partiallyRestifiedPosts[0]->data['type'] );
		$this->assertEquals( 'page', $partiallyRestifiedPosts[1]->data['type'] );
	}

	/**
	 * @test
	 * it should allow making restquery_Queries for multiple post types
	 */
	public function it_should_allow_making_restquery_queries_for_multiple_post_types() {
		$post_id = $this->factory()->post->create( [ 'post_type' => 'post', 'post_title' => 'A' ] );
		$page_id = $this->factory()->post->create( [ 'post_type' => 'page', 'post_title' => 'B' ] );

		$query = new restquery_Query( [
			'restify'   => true,
			'post_type' => [ 'post', 'page' ],
			'orderby'   => 'title',
			'order'     => 'ASC'
		] );

		$posts = $query->posts;
		$this->assertCount( 2, $posts );
		$this->assertEquals( $post_id, $posts[0]['id'] );
		$this->assertEquals( $page_id, $posts[1]['id'] );
		$this->assertEquals( 'post', $posts[0]['type'] );
		$this->assertEquals( 'page', $posts[1]['type'] );
	}

	/**
	 * @test
	 * it should allow calling the restquery_get_posts function on multiple post types
	 */
	public function it_should_allow_calling_the_restquery_get_posts_function_on_multiple_post_types() {
		$post_id = $this->factory()->post->create( [ 'post_type' => 'post', 'post_title' => 'A' ] );
		$page_id = $this->factory()->post->create( [ 'post_type' => 'page', 'post_title' => 'B' ] );

		$posts = restquery_get_posts( [
			'restify'   => true,
			'post_type' => [ 'post', 'page' ],
			'orderby'   => 'title',
			'order'     => 'ASC'
		] );

		$this->assertCount( 2, $posts );
		$this->assertEquals( $post_id, $posts[0]['id'] );
		$this->assertEquals( $page_id, $posts[1]['id'] );
		$this->assertEquals( 'post', $posts[0]['type'] );
		$this->assertEquals( 'page', $posts[1]['type'] );
	}
}
