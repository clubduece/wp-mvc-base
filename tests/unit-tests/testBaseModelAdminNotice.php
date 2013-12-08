<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/models/class-base-model-admin-notice.php';

	/**
	 * The tests for Base_Model_Admin_Notice
	 * @since WPMVCBase 0.1
	 * @internal
	 */

	class testBaseModelAdminNotice extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			$this->admin_notice = new \Base_Model_Admin_Notice( 'updated', 'foo message', array( 'post' ) );
		}
		
		public function tearDown()
		{
			unset( $this->admin_notice );
		}
		
		public function testPropertyExistsType()
		{
			$this->assertClassHasAttribute( 'type', 'Base_Model_Admin_Notice' );
		}
		
		public function testPropertyExistsMessage()
		{
			$this->assertClassHasAttribute( 'message', 'Base_Model_Admin_Notice' );
		}
		
		public function testPropertyExistsScreens()
		{
			$this->assertClassHasAttribute( 'screens', 'Base_Model_Admin_Notice' );
		}
		
		/**
		 * @covers Base_Model_Admin_Notice::get_type
		 */
		public function testMethodGetType()
		{
			$this->assertTrue( method_exists( 'Base_Model_Admin_Notice', 'get_type' ), 'Method get_type does not exist' );
			$this->assertEquals( 'updated', $this->admin_notice->get_type() );
		}
		
		/**
		 * @covers Base_Model_Admin_Notice::get_message
		 */
		public function testMethodGetMessage()
		{
			$this->assertTrue( method_exists( 'Base_Model_Admin_Notice', 'get_message' ), 'Method get_message does not exist' );
			$this->assertEquals( 'foo message', $this->admin_notice->get_message() );
		}
		
		/**
		 * @covers Base_Model_Admin_Notice::get_screens
		 */
		public function testMethodGetScreens()
		{
			$this->assertTrue( method_exists( 'Base_Model_Admin_Notice', 'get_screens' ), 'Method get_screens does not exist' );
			$this->assertEquals( array( 'post' ), $this->admin_notice->get_screens() );
		}
		
		/**
		 * @covers Base_Model_Admin_Notice::get_screens
		 */
		public function testMethodGetScreensEmptyScreens()
		{
			$this->assertTrue( method_exists( 'Base_Model_Admin_Notice', 'get_screens' ), 'Method get_screens does not exist' );
			
			$notice = new \Base_Model_Admin_Notice( 'error', 'Foo' );
			$this->assertEquals( 'all', $notice->get_screens() );
		}
	}
}