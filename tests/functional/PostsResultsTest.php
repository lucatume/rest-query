<?php


class PostsResultsTest extends \Codeception\TestCase\WPTestCase {

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
	 * it should return an array of WP_Post when 'restify' query var is not set
	 */
	public function it_should_return_an_array_of_wp_post_when_restify_query_var_is_not_set() {
		$this->factory()->post->create_many( 5, [ 'post_type' => 'post' ] );
		$query = new WP_Query( [
			'post_type'      => 'post',
			'posts_per_page' => 5
		] );

		$this->assertCount( 5, $query->posts );
		$this->assertContainsOnlyInstancesOf( 'WP_Post', $query->posts );
	}

	/**
	 * @test
	 * it should return an array of WP_Post with appended REST API data when if 'restify' query var is set to 'true'
	 */
	public function it_should_return_an_array_of_wp_post_with_appended_rest_api_data_when_if_restify_query_var_is_set_to_true_() {
		$this->factory()->post->create_many( 5, [ 'post_type' => 'post' ] );
		$query = new WP_Query( [
			'post_type'      => 'post',
			'posts_per_page' => 5,
			'restify'        => true
		] );

		$this->assertCount( 5, $query->posts );
		$this->assertContainsOnlyInstancesOf( 'WP_Post', $query->posts );
		foreach ( $query->posts as $post ) {
			$this->assertObjectHasAttribute( 'data', $post );
			$this->assertInternalType( 'array', $post->data );
		}
	}
}
