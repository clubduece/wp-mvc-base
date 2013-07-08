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
				true,
				'mySuperCoolL10n',
				array( 'foo' => 'bar' )
			);
			do_action( 'init' );
		}
		
		public function test_register()
		{
			global $wp_scripts;
			
			$this->_script->register();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'registered' ) );
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
		
		public function testEnqueue()
		{
			global $wp_scripts;
			$this->_script->enqueue();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'enqueued' ) );
		}
		
		public function testLocalize()
		{
			global $wp_scripts;
			$script = $wp_scripts->query( 'my-super-cool-script' );
			$this->assertEquals( 'var mySuperCoolL10n = {"foo":"bar"};', $script->extra['data'] );
		}
		
		public function testLocalizeEmpty()
		{
			global $wp_scripts;
			$baz = new \Base_Model_JS_Object( 'baz', 'http://example.com/baz.js', null, false, false );
			$baz->enqueue();
			$this->assertFalse( $baz->localize() );
		}
		
		public function test_dequeue()
		{
			$this->_script->enqueue();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'enqueued' ) );
			$this->_script->dequeue();
			$this->assertFalse( wp_script_is( 'my-super-cool-script', 'enqueued' ) );
		}
		
		public function test_deregister()
		{
			$this->_script->register();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'registered' ) );
			$this->_script->deregister();
			$this->assertFalse( wp_script_is( 'my-super-cool-script', 'registered' ) );
		}
	}
}
?>