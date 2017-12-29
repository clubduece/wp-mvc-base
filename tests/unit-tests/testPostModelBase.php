<?php
namespace WPMVCB\Tests\Unit;

use WPMVCB\Post_Model_Base;
use WPMVCB\Tests\testCase;

/**
 * Class testPostModelBase
 * @package WPMVCB\Tests\Unit
 *
 * @coversDefaultClass \WPMVCB\Post_Model_Base
 */
class testPostModelBase extends testCase  {

	/**
	 * @var Post_Model_Base
	 */
	protected $_model;

	/**
	 * @var \WP_Post
	 */
	protected $_post;

	/**
	 *
	 */
	public function setUp() {
		$this->_post  = $this->factory()->post->create_and_get();

		update_post_meta($this->_post->ID, 'bar', 'baz');

		$this->_model = new Post_Model_Base($this->_post, array('foo' => 'bar'));

		parent::setUp();
	}

	/**
	 * @covers ::__construct
	 * @covers ::__call
	 */
	public function testCallNoPostIsNull() {
		$model = new Post_Model_Base(null);
		$this->assertNull($model->ID());
	}

	/**
	 * @covers ::__call
	 * @covers ::_is_post_property
	 * @covers \WPMVCB\Model_Base::__call
	 */
	public function testCallForPostModelBaseProperty() {
		$this->assertEquals('bar', $this->_model->foo());
	}

	/**
	 * @covers ::__call
	 * @covers ::_is_post_property
	 * @covers \WPMVCB\Model_Base::__call
	 */
	public function testCallForPostProperties() {
		$post  = $this->_post;
		$model = $this->_model;

		$this->assertEquals($post->ID,                    $model->ID(), 'The post ID does not match');
		$this->assertEquals($post->ancestors,             $model->ancestors(), 'The post ancestors does not match');
		$this->assertEquals($post->post_author,           $model->post_author(), 'The post author does not match');
		$this->assertEquals($post->post_category,         $model->post_category(), 'The post category does not match');
		$this->assertEquals($post->post_content_filtered, $model->post_content_filtered(), 'The content filtered does not match');
		$this->assertEquals($post->post_content,          $model->post_content(), 'The post content does not match');
		$this->assertEquals($post->post_date,             $model->post_date(), 'The post date does not match');
		$this->assertEquals($post->post_date_gmt,         $model->post_date_gmt(), 'The post date gmt does not match');
		$this->assertEquals($post->post_name,             $model->post_name(), 'The post name does not match');
	}

	/**
	 * @covers ::__call
	 * @covers ::_is_post_property
	 */
	public function testCallForPostMeta() {
		$this->assertEquals('baz', $this->_model->bar());
	}

	/**
	 * @covers ::__construct
	 * @covers ::has_post
	 */
	public function testHasPostFalse() {
		$model = new Post_Model_Base(null);
		$this->assertFalse($model->has_post());
	}

	/**
	 * @covers ::__construct
	 * @covers ::has_post
	 */
	public function testHasPost() {
		$this->assertTrue($this->_model->has_post());
	}

	/**
	 * @covers ::__call
	 * @covers \WPMVCB\Base::__construct
	 * @covers \WPMVCB\Base::__call
	 */
	public function testPost() {
		$this->assertEquals($this->_post, $this->_model->post());
	}

	/**
	 * @covers ::get_post
	 * @covers \WPMVCB\Base::deprecated
	 *
	 * @expectedException \PHPUnit_Framework_Error_Warning
	 */
	public function testGetPost() {
		$this->assertEquals($this->_post, $this->_model->get_post());
	}

	/**
	 * @covers ::has_image
	 */
	public function testHasImageFalse() {
		$this->assertFalse($this->_model->has_image());
	}

	/**
	 * @covers ::get_permalink
	 */
	public function testGetPermalink() {
		$this->assertEquals(get_the_permalink($this->_post->ID), $this->_model->get_permalink());
	}

	/**
	 * @covers ::get_image_id
	 */
	public function testGetImageId() {
		update_post_meta($this->_post->ID, '_thumbnail_id', 22);
		$this->assertEquals(22, $this->_model->get_image_id());
	}
}
