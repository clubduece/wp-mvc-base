<?php

namespace WPMVCB\Tests\Integration;

use WPMVCB\Post_Base;
use WPMVCB\Post_Model_Base;
use WPMVCB\Post_View_Base;
use WPMVCB\Tests\testCase;

/**
 * Class testPostBase
 * @package WPMVCB\Tests\Integration
 *
 * @coversDefaultClass \WPMVCB\Post_Base
 */
class testPostBase extends testCase {

	/**
	 * @var Post_Base
	 */
	protected $_item;

	/**
	 * @var \WP_Post
	 */
	protected $_post;

	/**
	 *
	 */
	public function setUp() {
		$this->_post = $this->factory()->post->create_and_get();
		$this->_item = new Post_Base( $this->_post );
	}

	/**
	 * @covers ::__construct
	 * @covers ::model
	 * @covers ::view
	 */
	public function testPostBaseConstructor() {
		$this->assertInstanceOf(Post_Model_Base::class, $this->_item->model());
		$this->assertInstanceOf(Post_View_Base::class, $this->_item->view());
	}

	/**
	 * @covers ::__construct
	 * @covers \WPMVCB\Post_Model_Base::__construct
	 */
	public function testConstructWithInt() {
		$post = new Post_Base($this->_post->ID);

		$this->assertEquals($this->_post, $post->model()->post());
	}

	/**
	 * @covers ::__call
	 */
	public function testPostProperties() {
		$post = $this->_post;
		$item = $this->_item;

		$this->assertEquals($post->ID,                    $item->ID());
		$this->assertEquals($post->post_title,            $item->post_title());
		$this->assertEquals($post->post_content,          $item->post_content());
		$this->assertEquals($post->post_content_filtered, $item->post_content_filtered());
		$this->assertEquals($post->post_category,         $item->post_category());
		$this->assertEquals($post->post_name,             $item->post_name());
	}

}