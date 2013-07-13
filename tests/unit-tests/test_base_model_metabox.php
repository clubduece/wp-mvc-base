<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/base_model_metabox.php' );
	
	/**
	 * The test controller for Base_Model_Metabox.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class TestBaseModelMetabox extends WPMVCB_Test_Case
	{
		public function SetUp()
		{
			parent::setUp();
			$this->_metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				'my_super_cool_posttype',
				'normal',
				'default',
				array( 'foo' => 'bar' )
			);
		}
		
		public function testMethodAdd()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'add' ), 'Method does not exist' );
        	$this->_metabox->add();
        	global $wp_meta_boxes;
            
            $this->assertArrayHasKey( 'my-super-cool-metabox', $wp_meta_boxes['my_super_cool_posttype']['normal']['default'] );
        }

		/**
		 * @depends testMethodAdd
		 */
        public function testMethodRemove()
        {
        	global $wp_meta_boxes;
        	
        	$this->assertTrue( method_exists( $this->_metabox, 'remove' ), 'Method does not exist' );
        	
			$this->_metabox->add();
			$this->_metabox->remove();
			
			$this->assertFalse( is_array(  $wp_meta_boxes['my_super_cool_posttype']['normal']['default']['my-super-cool-metabox'] ), 'Metabox not removed' );
		}

		
		public function testMethodGetId()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'get_id' ), 'Method does not exist' );
			$this->assertEquals( 'my-super-cool-metabox', $this->_metabox->get_id(), 'ID Incorrect' );
		}
		
		public function testMethodGetTitle()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'get_title' ), 'Method does not exist' );
			$this->assertEquals( 'My Super Cool Metabox', $this->_metabox->get_title(), 'Title Incorrect' );
		}
		
		public function testMethodGetCallback()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'get_callback' ), 'Method does not exist' );
			$this->assertEquals( 'my_super_cool_callback', $this->_metabox->get_callback() );
		}
		
		public function testMethodGetPostType()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'get_post_type' ), 'Method does not exist' );
			$this->assertEquals( 'my_super_cool_posttype', $this->_metabox->get_post_type() );
		}
		
		public function testMethodGetContext()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'get_context' ), 'Method does not exist' );
			$this->assertEquals( 'normal', $this->_metabox->get_context() );
		}
		
		public function testMethodGetPriority()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'get_priority' ), 'Method does not exist' );
			$this->assertEquals( 'default', $this->_metabox->get_priority() );
		}
		
		public function testMethodGetCallbackArgs()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'get_callback_args' ), 'Method does not exist' );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->_metabox->get_callback_args() );
		}
		
		/**
		 * @depends testMethodGetId
		 */
		public function testMethodSetId()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'set_id' ), 'Method does not exist' );
			$this->_metabox->set_id( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->_metabox->get_id() );
		}
		
		/**
		 * @depends testMethodGetTitle
		 */
		public function testMethodSetTitle()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'set_title' ), 'Method does not exist' );
			$this->_metabox->set_title( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->_metabox->get_title() );
		}
		
		/**
		 * @depends testMethodGetCallback
		 */
		public function testMethodSetCallback()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'set_callback' ), 'Method does not exist' );
			$this->_metabox->set_callback( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->_metabox->get_callback() );
		}
		
		/**
		 * @depends testMethodGetPostType
		 */
		public function testMethodSetPostType()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'set_post_type' ), 'Method does not exist' );
			$this->_metabox->set_post_type( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->_metabox->get_post_type() );
		}
		
		/**
		 * @depends testMethodGetContext
		 */
		public function testMethodSetContext()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'set_context' ), 'Method does not exist' );
			$this->_metabox->set_context( 'side' );
			$this->assertEquals( 'side', $this->_metabox->get_context() );
		}
		
		/**
		 * @depends testMethodGetPriority
		 */
		public function testMethodSetPriority()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'set_priority' ), 'Method does not exist' );
			$this->_metabox->set_priority( 'low' );
			$this->assertEquals( 'low', $this->_metabox->get_priority() );
		}
		
		/**
		 * @depends testMethodGetCallbackArgs
		 */
		public function testMethodSetCallbackArgs()
		{
			$this->assertTrue( method_exists( $this->_metabox, 'set_callback_args' ), 'Method does not exist' );
			$this->_metabox->set_callback_args( array( 'flibbertygibbet' => 'mtzlplck' ) );
			$this->assertEquals( array( 'flibbertygibbet' => 'mtzlplck' ), $this->_metabox->get_callback_args() );
		}
		
		/**
		 * Test faulty metabox context assignment.
		 *
		 * This function tests the metabox object's setting the context to 'normal' when
		 * passed a value other than 'normal', 'advanced', or 'side'.
		 *
		 * @depends testMethodGetContext
		 * @since 0.1
		 */
		public function testInvalidContext()
		{
			$metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				'my_super_cool_posttype',
				'flibbertygibbet',
				'default',
				array( 'foo' => 'bar' )
			);
			
			$this->assertEquals( 'normal', $metabox->get_context() );
		}
		
		/**
		 * Test faulty metabox priority assignment.
		 *
		 * This function tests the metabox object's setting the priority to 'default' when
		 * passed a value other than 'high', 'core', 'default', or 'low'.
		 *
		 * @depends testMethodGetPriority
		 * @since 0.1
		 */
		public function testInvalidPriority()
		{
			$metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				'my_super_cool_posttype',
				'normal',
				'flibbertygibbet',
				array( 'foo' => 'bar' )
			);
			
			$this->assertEquals( 'default', $metabox->get_priority() );
		}
	}
}
?>