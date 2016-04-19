<?php


class restqueryFunctionsTest extends \Codeception\TestCase\WPTestCase {

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
	 * restquery_get_posts will return restified version of posts
	 */
	public function test_restquery_get_posts_will_return_restified_version_of_posts() {
		$this->factory()->post->create_many( 5, [ 'post_type' => 'post' ] );

		$restifiedPosts = restquery_get_posts( [ 'post_type' => 'post', 'post_per_page' => 5 ] );

		$this->assertCount( 5, $restifiedPosts );

		foreach ( $restifiedPosts as $restifiedPost ) {
			$this->assertInternalType( 'array', $restifiedPost );
			$restquery_Query = new restquery_Query( [ 'p' => $restifiedPost['id'] ] );
			$this->assertEquals( $restquery_Query->post->data, $restifiedPost );
		}
	}
}