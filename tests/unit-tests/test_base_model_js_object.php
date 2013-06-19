<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_js_object.php' );
	
	/**
	 * The test controller for Base_Model_JS_Object.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class TestBaseModelJsObject extends \WP_UnitTestCase
	{
		private $_script;
		
		public function SetUp()
		{
			$this->_script = new \Base_Model_JS_Object(
				'my-super-cool-script',
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				array( 'jquery', 'my-super-cool-framework' ),
				true,
				'mySuperCoolL10n',
				array( 'foo' => 'bar' )
			);
		}
		
		public function test_register()
		{
			$this->_script->register();
			$this->_script->enqueue();
			$this->_script->localize();
			$this->assertArrayHasKey( 'my-super-cool-script', $GLOBALS['wp_scripts']->registered );
		}
		
		public function testRegisterHandle()
		{
			$this->assertEquals( 'my-super-cool-script', $GLOBALS['wp_scripts']->registered['my-super-cool-script']->handle );
		}
		
		public function test_register_src()
		{
			$this->assertEquals( 
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				$GLOBALS['wp_scripts']->registered['my-super-cool-script']->src
			);
		}
		
		public function test_register_deps()
		{
			$this->assertEquals( 
				array( 'jquery', 'my-super-cool-framework' ),
				$GLOBALS['wp_scripts']->registered['my-super-cool-script']->deps
			);
		}
		
		public function test_register_ver()
		{
			$this->assertEquals( 
				true,
				$GLOBALS['wp_scripts']->registered['my-super-cool-script']->ver
			);
		}
		
		public function testLocalize()
		{
			/**
			 * @todo Determine how to test this
			 */
		}
		
		public function test_deregister()
		{
			$this->_script->deregister();
			$this->assertFalse( array_key_exists( 'my-super-cool-script', $GLOBALS['wp_scripts']->registered ) );
			
		}
	}
}
?>