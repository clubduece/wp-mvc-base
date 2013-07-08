<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_help_tab.php' );
	
	class Test_Base_Model_Help_Tab extends \WP_UnitTestCase
	{
		private $_tab;
		
		public function setUp()
		{
			$this->_tab = new \Base_Model_Help_Tab(
				'My Test Tab',
				'test-tab',
				'Here is some test tab content',
				array( &$this, 'help_tab_callback' )
			);
			
			$this->_reflection = new \ReflectionClass( $this->_tab );
		}
		
		public function mock_callback()
		{
			//implemented, but does nothing
		}
		
		public function test_missing_params_error()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$tab = new \Base_Model_Help_Tab( 'Empty Tab', 'empty-tab' );
		}
		
		public function test_missing_params_message()
		{
			@$tab = new \Base_Model_Help_Tab( 'Empty Tab', 'empty-tab' );
			$error = error_get_last();
			
			$this->assertEquals(
				'You must specify either the help tab content, a callback function, or a view to use for the help tab', 
				$error['message']
			);
		}
		
		public function test_attribute_id()
		{
			$this->assertClassHasAttribute( '_id', 'Base_Model_Help_Tab' );
		}
		
		public function test_attribute_title()
		{
			$this->assertClassHasAttribute( '_title', 'Base_Model_Help_Tab' );
		}
		
		public function test_attribute_content()
		{
			$this->assertClassHasAttribute( '_content', 'Base_Model_Help_Tab' );
		}
		
		public function test_attribute_callback()
		{
			$this->assertClassHasAttribute( '_callback', 'Base_Model_Help_Tab' );
		}
		
		public function test_attribute_view()
		{
			$this->assertClassHasAttribute( '_view', 'Base_Model_Help_Tab' );
		}
		
		public function test_get_id()
		{
			$this->assertEquals( 'test-tab', $this->_tab->get_id() );
		}
		
		public function test_get_title()
		{
			$this->assertEquals( 'My Test Tab', $this->_tab->get_title() );
		}
		
		public function test_set_callback_error()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_tab->set_callback( 'foo' );
		}
		
		public function test_set_callback_message()
		{
			@$this->_tab->set_callback( 'foo' );
			$error = error_get_last();
			$this->assertEquals( 'A valid callback function must be specified', $error['message'] );
		}
		
		public function test_set_callback()
		{
			$this->assertTrue( $this->_tab->set_callback( array( &$this, 'mock_callback' ) ) );
			$callback = $this->_reflection->getProperty( '_callback' );
			$callback->setAccessible( true );
			$this->assertEquals( array( &$this, 'mock_callback' ), $callback->getValue( $this->_tab ) );
		}
		
		public function testSetContent()
		{
			$content = $this->_reflection->getProperty( '_content' );
			$content->setAccessible( true );
			
			$this->_tab->set_content( 'foo' );
			$this->assertEquals( 'foo', $content->getValue( $this->_tab ) );
		}
		
		public function testAdd()
		{
			$this->markTestIncomplete( 'This test not yet implemented' );
		}
	}
}