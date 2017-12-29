<?php
namespace WPMVCB\Tests;
use WPMVCB\Post_Type_Base;

/**
 * Class testControllerBase
 * @package WPMVCB\Tests
 *
 * @coversDefaultClass \WPMVCB\Post_Type_Base
 */
class testPostTypeBase extends testCase {

	/**
	 * @covers ::get_instance
	 */
	public function testGetInstanceIsNull() {
		$post = $this->factory()->post->create_and_get();

		$this->assertNull(Post_Type_Base::get_instance($post->ID));
	}

}