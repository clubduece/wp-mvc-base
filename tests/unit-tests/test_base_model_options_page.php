<?php
namespace WPMVCB\Testing
{
	require( WPMVCB_SRC_DIR . '/models/base_model_menu_page.php' );
	
	/**
	 * Base Model Options Page tests.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class TestBaseModelOptionsPage extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
			
			//set up the test class
			$this->_options_page = new \Base_Model_Menu_Page();
		}
		
		public function testPropertyParentSlugExists()
		{
			$this->assertClassHasAttribute( '_parent_slug', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyPageTitleExists()
		{
			$this->assertClassHasAttribute( '_page_title', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyMenuTitleExists()
		{
			$this->assertClassHasAttribute( '_menu_title', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyCapabilityExists()
		{
			$this->assertClassHasAttribute( '_capability', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyMenuSlugExists()
		{
			$this->assertClassHasAttribute( '_menu_slug', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyCallbackExists()
		{
			$this->assertClassHasAttribute( '_callback', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyIconUrlExists()
		{
			$this->assertClassHasAttribute( '_icon_url', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyPositionExists()
		{
			$this->assertClassHasAttribute( '_position', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyAdminScriptsExists()
		{
			$this->assertClassHasAttribute( '_admin_scripts', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyAdminCssExists()
		{
			$this->assertClassHasAttribute( '_admin_css', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyHelpTabsExists()
		{
			$this->assertClassHasAttribute( '_help_tabs', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyViewExists()
		{
			$this->assertClassHasAttribute( '_view', '\Base_Model_Menu_Page' );
		}
		
		public function testPropertyHookSuffixExists()
		{
			$this->assertClassHasAttribute( '_hook_suffix', '\Base_Model_Menu_Page' );
		}
		
		public function testMethodSetParentSlugExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_parent_slug' ) );
		}
		
		/**
		 * @depends testMethodSetParentSlugExists
		 */
		public function testMethodSetParentSlug()
		{
			$this->_options_page->set_parent_slug( 'settings' );
			
			$this->assertEquals( 'settings', $this->getReflectionPropertyValue( $this->_options_page, '_parent_slug' ) );
		}
		
		public function testMethodGetParentSlugExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Menu_Page', 'get_parent_slug' ) );
		}
		
		/**
		 * @depends testMethodSetParentSlugExists
		 * @depends testMethodGetParentSlugExists
		 * @depends testMethodSetParentSlug
		 */
		public function testMethodGetParentSlug()
		{
			$this->assertNull( $this->_options_page->get_parent_slug() );
			
			$this->_options_page->set_parent_slug( 'settings' );
			$this->assertEquals( 'settings', $this->_options_page->get_parent_slug() );
		}
		
		public function testMethodSetPageTitleExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_page_title' ) );
		}
		
		/**
		 * @depends testMethodSetPageTitleExists
		 */
		public function testMethodSetPageTitle()
		{
			$this->_options_page->set_page_title( 'My Page Title' );
			
			$this->assertEquals( 'My Page Title', $this->getReflectionPropertyValue( $this->_options_page, '_page_title' ) );
		}
		
		public function testMethodGetPageTitleExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Menu_Page', 'get_page_title' ) );
		}
		
		/**
		 * @depends testMethodSetPageTitleExists
		 * @depends testMethodGetPageTitleExists
		 * @depends testMethodSetPageTitle
		 */
		public function testMethodGetPageTitle()
		{
			$this->assertNull( $this->_options_page->get_page_title() );
			
			$this->_options_page->set_page_title( 'My Page Title' );
			$this->assertEquals( 'My Page Title', $this->_options_page->get_page_title() );
		}
		
		public function testMethodSetMenuTitleExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_menu_title' ) );
		}
		
		/**
		 * @depends testMethodSetMenuTitleExists
		 */
		public function testMethodSetMenuTitle()
		{
			$this->_options_page->set_menu_title( 'My Menu Page' );
			$this->assertEquals( 'My Menu Page', $this->getReflectionPropertyValue( $this->_options_page, '_menu_title' ) );
		}
		
		public function testMethodGetMenuTitleExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_menu_title' ) );
		}
		
		/**
		 * @depends testMethodSetMenuTitleExists
		 * @depends testMethodGetMenuTitleExists
		 * @depends testMethodSetMenuTitle
		 */
		public function testMethodGetMenuTitle()
		{
			$this->assertNull( $this->_options_page->get_menu_title() );
			
			$this->_options_page->set_menu_title( 'My Menu Page' );
			$this->assertEquals( 'My Menu Page', $this->_options_page->get_menu_title() );
		}
		
		public function testMethodSetCapabilityExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_capability' ) );
		}
		
		/**
		 * @depends testMethodSetCapabilityExists
		 */
		public function testMethodSetCapability()
		{
			$this->_options_page->set_capability( 'manage_posts' );
			$this->assertEquals( 'manage_posts', $this->getReflectionPropertyValue( $this->_options_page, '_capability' ) );
		}
		
		public function testMethodGetCapabilityExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_capability' ) );
		}
		
		/**
		 * @depends testMethodSetCapabilityExists
		 * @depends testMethodGetCapabilityExists
		 * @depends testMethodSetCapability
		 */
		public function testMethodGetCapability()
		{
			$this->assertNull( $this->_options_page->get_capability() );
			
			$this->_options_page->set_capability( 'manage_posts' );
			$this->assertEquals( 'manage_posts', $this->_options_page->get_capability() );
		}
		
		public function testMethodSetMenuSlugExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_menu_slug' ) );
		}
		
		/**
		 * @depends testMethodSetMenuSlugExists
		 */
		public function testMethodSetMenuSlug()
		{
			$this->_options_page->set_menu_slug( 'my_menu_slug' );
			$this->assertEquals( 'my_menu_slug', $this->getReflectionPropertyValue( $this->_options_page, '_menu_slug' ) );
		}
		
		public function testMethodGetMenuSlugExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_menu_slug' ) );
		}
		
		/**
		 * @depends testMethodSetMenuSlugExists
		 * @depends testMethodGetMenuSlugExists
		 * @depends testMethodSetMenuSlug
		 */
		public function testMethodGetMenuSlug()
		{
			$this->assertNull( $this->_options_page->get_menu_slug() );
			
			$this->_options_page->set_menu_slug( 'my_menu_slug' );
			$this->assertEquals( 'my_menu_slug', $this->_options_page->get_menu_slug() );
		}
		
		public function testMethodSetCallbackExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_callback' ) );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 */
		public function testMethodSetCallback()
		{
			$this->_options_page->set_callback( 'my_callback' );
			$this->assertEquals( 'my_callback', $this->getReflectionPropertyValue( $this->_options_page, '_callback' ) );
		}
		
		public function testMethodGetCallbackExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_callback' ) );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 * @depends testMethodGetCallbackExists
		 * @depends testMethodSetCallback
		 */
		public function testMethodGetCallback()
		{
			$this->assertNull( $this->_options_page->get_callback() );
			
			$this->_options_page->set_callback( 'my_callback' );
			$this->assertEquals( 'my_callback', $this->_options_page->get_callback() );
		}
		
		public function testMethodSetIconUrlExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_icon_url' ) );
		}
		
		/**
		 * @depends testMethodSetIconUrlExists
		 */
		public function testMethodSetIconUrl()
		{
			$this->_options_page->set_icon_url( 'my_icon_url' );
			$this->assertEquals( 'my_icon_url', $this->getReflectionPropertyValue( $this->_options_page, '_icon_url' ) );
		}
		
		public function testMethodGetIconUrlExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_icon_url' ) );
		}
		
		/**
		 * @depends testMethodSetIconUrlExists
		 * @depends testMethodGetIconUrlExists
		 * @depends testMethodSetIconUrl
		 */
		public function testMethodGetIconUrl()
		{
			$this->assertNull( $this->_options_page->get_icon_url() );
			
			$this->_options_page->set_icon_url( 'my_icon_url' );
			$this->assertEquals( 'my_icon_url', $this->_options_page->get_icon_url() );
		}
		
		public function testMethodSetPositionExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_position' ) );
		}
		
		/**
		 * @depends testMethodSetPositionExists
		 */
		public function testMethodSetPosition()
		{
			$this->_options_page->set_position( 'my_position' );
			$this->assertEquals( 'my_position', $this->getReflectionPropertyValue( $this->_options_page, '_position' ) );
		}
		
		public function testMethodGetPositionExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_position' ) );
		}
		
		/**
		 * @depends testMethodSetPositionExists
		 * @depends testMethodGetPositionExists
		 * @depends testMethodSetPosition
		 */
		public function testMethodGetPosition()
		{
			$this->assertNull( $this->_options_page->get_position() );
			
			$this->_options_page->set_position( 'my_position' );
			$this->assertEquals( 'my_position', $this->_options_page->get_position() );
		}
		
		public function testMethodSetAdminScriptsExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_admin_scripts' ) );
		}
		
		/**
		 * @depends testMethodSetAdminScriptsExists
		 */
		public function testMethodSetAdminScripts()
		{
			$this->_options_page->set_admin_scripts( 'my_admin_scripts' );
			$this->assertEquals( 'my_admin_scripts', $this->getReflectionPropertyValue( $this->_options_page, '_admin_scripts' ) );
		}
		
		public function testMethodGetAdminScriptsExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_admin_scripts' ) );
		}
		
		/**
		 * @depends testMethodSetAdminScriptsExists
		 * @depends testMethodGetAdminScriptsExists
		 * @depends testMethodSetAdminScripts
		 */
		public function testMethodGetAdminScripts()
		{
			$this->assertNull( $this->_options_page->get_admin_scripts() );
			
			$this->_options_page->set_admin_scripts( 'my_admin_scripts' );
			$this->assertEquals( 'my_admin_scripts', $this->_options_page->get_admin_scripts() );
		}
		
		public function testMethodSetAdminCssExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_admin_css' ) );
		}
		
		/**
		 * @depends testMethodSetAdminCssExists
		 */
		public function testMethodSetAdminCss()
		{
			$this->_options_page->set_admin_css( 'my_admin_css' );
			$this->assertEquals( 'my_admin_css', $this->getReflectionPropertyValue( $this->_options_page, '_admin_css' ) );
		}
		
		public function testMethodGetAdminCssExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_admin_css' ) );
		}
		
		/**
		 * @depends testMethodSetAdminCssExists
		 * @depends testMethodGetAdminCssExists
		 * @depends testMethodSetAdminCss
		 */
		public function testMethodGetAdminCss()
		{
			$this->assertNull( $this->_options_page->get_admin_css() );
			
			$this->_options_page->set_admin_css( 'my_admin_css' );
			$this->assertEquals( 'my_admin_css', $this->_options_page->get_admin_css() );
		}
		
		public function testMethodSetHelpTabsExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_help_tabs' ) );
		}
		
		/**
		 * @depends testMethodSetHelpTabsExists
		 */
		public function testMethodSetHelpTabs()
		{
			$this->_options_page->set_help_tabs( 'my_help_tabs' );
			$this->assertEquals( 'my_help_tabs', $this->getReflectionPropertyValue( $this->_options_page, '_help_tabs' ) );
		}
		
		public function testMethodGetHelpTabsExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_help_tabs' ) );
		}
		
		/**
		 * @depends testMethodSetHelpTabsExists
		 * @depends testMethodGetHelpTabsExists
		 * @depends testMethodSetHelpTabs
		 */
		public function testMethodGetHelpTabs()
		{
			$this->assertNull( $this->_options_page->get_help_tabs() );
			
			$this->_options_page->set_help_tabs( 'my_help_tabs' );
			$this->assertEquals( 'my_help_tabs', $this->_options_page->get_help_tabs() );
		}
		
		public function testMethodSetViewExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'set_view' ) );
		}
		
		/**
		 * @depends testMethodSetViewExists
		 */
		public function testMethodSetView()
		{
			$this->_options_page->set_view( 'my_view' );
			$this->assertEquals( 'my_view', $this->getReflectionPropertyValue( $this->_options_page, '_view' ) );
		}
		
		public function testMethodGetViewExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_view' ) );
		}
		
		/**
		 * @depends testMethodSetViewExists
		 * @depends testMethodGetViewExists
		 * @depends testMethodSetView
		 */
		public function testMethodGetView()
		{
			$this->assertNull( $this->_options_page->get_view() );
			
			$this->_options_page->set_view( 'my_view' );
			$this->assertEquals( 'my_view', $this->_options_page->get_view() );
		}
		
		public function testMethodGetHookSuffixExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'get_hook_suffix' ) );
		}
		
		/**
		 * @depends testMethodGetHookSuffixExists
		 */
		public function testMethodGetHookSuffix()
		{
			$this->assertNull( $this->_options_page->get_hook_suffix() );
			
			$this->setReflectionPropertyValue( $this->_options_page, '_hook_suffix', 'my_hook_suffix' );
			$this->assertEquals( 'my_hook_suffix', $this->_options_page->get_hook_suffix() );
		}
		
		public function testMethodAddExists()
		{
			$this->assertTrue( method_exists( $this->_options_page, 'add' ) );
		}
		
		/**
		 * Test the addition of a top level menu page with a set position.
		 *
		 * @depends testMethodSetParentSlugExists
		 * @depends testMethodSetPageTitleExists
		 * @depends testMethodSetMenuTitleExists
		 * @depends testMethodSetCapabilityExists
		 * @depends testMethodSetMenuSlugExists
		 * @depends testMethodSetCallbackExists
		 * @depends testMethodSetIconUrlExists
		 * @depends testMethodSetPositionExists
		 * @depends testMethodAddExists
		 */
		public function testMethodAddTopLevelPage()
		{
			$page = new \Base_Model_Menu_Page;
			$page->set_page_title( 'My Page Title' );
			$page->set_menu_title( 'My Menu Title' );
			$page->set_capability( 'manage_options' );
			$page->set_menu_slug( 'my-menu-slug');
			$page->set_callback( 'my_callback' );
			$page->set_icon_url( 'http://foo.com/my_icon.jpg' );
			$page->set_position( '3.14159' );
			
			//verify we had a successful addition
			$this->assertFalse( false === $page->add() );
			
			//verify the position
			global $menu;
			
			if( isset( $menu ) ) {
				$this->assertArrayHasKey( '3.14159', $menu );
			} else {
				$this->markTestIncomplete( 'The global $menu is not set.' );
			}
		}
		
		/**
		 * Test the addition of a sub menu page with appropriate user capability.
		 *
		 * @depends testMethodSetParentSlugExists
		 * @depends testMethodSetPageTitleExists
		 * @depends testMethodSetMenuTitleExists
		 * @depends testMethodSetCapabilityExists
		 * @depends testMethodSetMenuSlugExists
		 * @depends testMethodSetCallbackExists
		 * @depends testMethodAddExists
		 */
		public function testMethodAddSubmenuPage()
		{
			//set the current user to admin
			set_current_user( 1 );
			
			$page = new \Base_Model_Menu_Page;
			$page->set_parent_slug( 'options-general.php' );
			$page->set_page_title( 'My Page Title' );
			$page->set_menu_title( 'My Menu Title' );
			$page->set_capability( 'manage_options' );
			$page->set_menu_slug( 'my-menu-slug');
			$page->set_callback( 'my_callback' );
			
			//verify we had a successful addition
			$this->assertFalse( false === $page->add() );
		}
		
		/**
		 * Test the addition of a sub menu page without appropriate user capability.
		 *
		 * @depends testMethodSetParentSlugExists
		 * @depends testMethodSetPageTitleExists
		 * @depends testMethodSetMenuTitleExists
		 * @depends testMethodSetCapabilityExists
		 * @depends testMethodSetMenuSlugExists
		 * @depends testMethodSetCallbackExists
		 * @depends testMethodAddExists
		 */
		public function testMethodAddSubmenuPageLackCapability()
		{	
			set_current_user( 0 );
			$page = new \Base_Model_Menu_Page;
			$page->set_parent_slug( 'options-general.php' );
			$page->set_page_title( 'My Page Title' );
			$page->set_menu_title( 'My Menu Title' );
			$page->set_capability( 'manage_options' );
			$page->set_menu_slug( 'my-menu-slug');
			$page->set_callback( 'my_callback' );
			
			//verify we had a successful addition
			$this->assertTrue( false === $page->add() );
		}
	}
}
?>
