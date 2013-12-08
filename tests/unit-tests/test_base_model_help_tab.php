<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/class-base-model-help-tab.php' );
	
	class testBaseModelHelpTab extends WPMVCB_Test_Case
	{
		private $tab;
		
		public function setUp()
		{
			parent::setUp();
			$this->tab = new \Base_Model_Help_Tab(
				'test-tab',
				'My Test Tab',
				array( 'load-post-new.php' ),
				array( 'post' ),
				'Here is some test tab content'
			);
		}
		
		/**
		 * @expectedException        PHPUnit_Framework_Error
		 */
		public function testPagesNotArray()
		{
			$tab = new \Base_Model_Help_Tab( 'Empty Tab', 'empty-tab', 'foo.php' );
		}
				
		public function testAttributeIdExists()
		{
			$this->assertClassHasAttribute( 'id', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeTitleExists()
		{
			$this->assertClassHasAttribute( 'title', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeScreensExists()
		{
			$this->assertClassHasAttribute( 'screens', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributePostTypesExists()
		{
			$this->assertClassHasAttribute( 'post_types', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeContentExists()
		{
			$this->assertClassHasAttribute( 'content', 'Base_Model_Help_Tab' );
		}
		
		public function testMethodGetId()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_id' ) );
			$this->assertEquals( 'test-tab', $this->tab->get_id() );
		}
		
		public function testMethodGetTitle()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_title' ) );
			$this->assertEquals( 'My Test Tab', $this->tab->get_title() );
		}
		
		public function testMethodGetScreens()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_screens' ) );
			$this->assertEquals( array( 'load-post-new.php' ), $this->tab->get_screens() );
		}
		
		public function testMethodGetPostTypes()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_post_types' ) );
			$this->assertEquals( array( 'post' ), $this->tab->get_post_types() );
		}
		
		public function testMethodGetContent()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_content' ) );
			$this->assertEquals( 'Here is some test tab content', $this->tab->get_content() );
		}
	}
}