<?php
namespace WPMVCB\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_help_tab.php' );
	
	class testBaseModelHelpTab extends WPMVCB_Test_Case
	{
		private $_tab;
		
		public function setUp()
		{
			parent::setUp();
			$this->_tab = new \Base_Model_Help_Tab(
				'My Test Tab',
				'test-tab',
				'Here is some test tab content',
				array( &$this, 'help_tab_callback' )
			);
		}
		
		public function mock_callback()
		{
			//implemented, but does nothing
		}
		
		public function testMissingParamsError()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$tab = new \Base_Model_Help_Tab( 'Empty Tab', 'empty-tab' );
		}
		
		public function testMissingParamsMessage()
		{
			@$tab = new \Base_Model_Help_Tab( 'Empty Tab', 'empty-tab' );
			$error = error_get_last();
			
			$this->assertEquals(
				'You must specify either the help tab content, a callback function, or a view to use for the help tab', 
				$error['message']
			);
		}
		
		public function testAttributeIdExists()
		{
			$this->assertClassHasAttribute( '_id', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeTitleExists()
		{
			$this->assertClassHasAttribute( '_title', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeContentExists()
		{
			$this->assertClassHasAttribute( '_content', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeCallbackExists()
		{
			$this->assertClassHasAttribute( '_callback', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeViewExists()
		{
			$this->assertClassHasAttribute( '_view', 'Base_Model_Help_Tab' );
		}
		
		public function testMethodGetId()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_id' ) );
			$this->assertEquals( 'test-tab', $this->_tab->get_id() );
		}
		
		public function testMethodGetTitle()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_title' ) );
			$this->assertEquals( 'My Test Tab', $this->_tab->get_title() );
		}
		
		public function testMethodSetCallbackExists()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'set_callback' ) );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 */
		public function testMethodSetCallbackError()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_tab->set_callback( 'foo' );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 */
		public function testSetCallbackMessage()
		{
			@$this->_tab->set_callback( 'foo' );
			$error = error_get_last();
			$this->assertEquals( 'A valid callback function must be specified', $error['message'] );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 */
		public function testSetCallback()
		{
			$this->assertTrue( $this->_tab->set_callback( array( &$this, 'mock_callback' ) ) );
			$this->assertEquals( array( &$this, 'mock_callback' ), $this->getReflectionPropertyValue( $this->_tab, '_callback' ) );
		}
		
		public function testMethodSetContent()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'set_content' ) );
			
			$this->_tab->set_content( 'foo' );
			$this->assertEquals( 'foo', $this->getReflectionPropertyValue( $this->_tab, '_content' ) );
		}
		
		public function testAdd()
		{
			$this->markTestIncomplete( 'This test not yet implemented' );
		}
	}
}