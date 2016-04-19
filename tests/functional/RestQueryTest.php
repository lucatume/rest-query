<?php


class RestQueryTest extends \Codeception\TestCase\WPTestCase {

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
	 * it should return an array of REST API data when querying for posts
	 */
	public function it_should_return_an_array_of_rest_api_data_when_querying_for_posts() {
		$this->factory()->post->create_many( 5, [ 'post_type' => 'post' ] );

		$restQueryResults = new restquery_Query( [ 'post_type' => 'post', 'posts_per_page' => 5 ] );

		$this->assertCount( 5, $restQueryResults->posts );
		foreach ( $restQueryResults->posts as $postData ) {
			$this->assertInternalType( 'array', $postData );
			$standardQueryResults = new WP_Query( [ 'p' => $postData['id'], 'restify' => true ] );
			$this->assertEquals( $standardQueryResults->post->data, $postData );
		}
	}

	/**
	 * @test
	 * it should allow iterating over the query as the standard query would allow
	 */
	public function it_should_allow_iterating_over_the_query_as_the_standard_query_would_allow() {
		$this->factory()->post->create_many( 5, [ 'post_type' => 'post' ] );

		$restQueryResults = new restquery_Query( [ 'post_type' => 'post', 'posts_per_page' => 5 ] );

		$this->assertCount( 5, $restQueryResults->posts );

		$titles = [ ];

		if ( $restQueryResults->have_posts() ) {
			while ( $restQueryResults->have_posts() ) {
				$restQueryResults->the_post();
				global $post;
				$titles[] = $post['title']['rendered'];
			}
		}

		$this->assertEquals( array_map( function ( $post ) {
			return $post->post_title;
		}, get_posts( [ 'post_type' => 'post', 'posts_per_page' => 5 ] ) ), $titles );
	}
}
