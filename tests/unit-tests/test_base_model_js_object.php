<?php
namespace WPMVCB\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_js_object.php' );
	
	/**
	 * The test controller for Base_Model_JS_Object.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class TestBaseModelJsObject extends WPMVCB_Test_Case
	{
		private $_script;
		
		public function SetUp()
		{
			parent::setUp();
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
		
		public function testMethodRegister()
		{
			global $wp_scripts;
			
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'register' ), 'Method register does not exist' );
			$this->_script->register();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'registered' ) );
			$this->assertEquals(
				'my-super-cool-script',
				$wp_scripts->registered['my-super-cool-script']->handle,
				'Handle incorrectly registered'
			);
			$this->assertEquals( 
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				$wp_scripts->registered['my-super-cool-script']->src,
				'Source incorrectly registered'
			);
			$this->assertEquals( 
				array( 'jquery', 'my-super-cool-framework' ),
				$wp_scripts->registered['my-super-cool-script']->deps,
				'Dependencies incorrectly registered'
			);
			$this->assertEquals( 
				true,
				$wp_scripts->registered['my-super-cool-script']->ver,
				'Version incorrectly registered'
			);
		}
		
		public function testMethodEnqueue()
		{
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'enqueue' ) );
			$this->_script->enqueue();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'enqueued' ) );
		}
		
		public function testMethodLocalize()
		{
			global $wp_scripts;
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'localize' ) );
			$script = $wp_scripts->query( 'my-super-cool-script' );
			$this->assertEquals( 'var mySuperCoolL10n = {"foo":"bar"};', $script->extra['data'] );
		}
		
		/**
		 * @depends testMethodEnqueue
		 * @depends testMethodLocalize
		 */
		public function testLocalizeEmpty()
		{
			global $wp_scripts;
			$baz = new \Base_Model_JS_Object( 'baz', 'http://example.com/baz.js', null, false, false );
			$baz->enqueue();
			$this->assertFalse( $baz->localize() );
		}
		
		/**
		 * @depends testMethodEnqueue
		 */
		public function test_dequeue()
		{
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'dequeue' ), 'Method dequeue does not exist' );
			$this->_script->enqueue();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'enqueued' ), 'Script not enqueued' );
			$this->_script->dequeue();
			$this->assertFalse( wp_script_is( 'my-super-cool-script', 'enqueued', 'Script not dequeued' ) );
		}
		
		/**
		 * @depends testMethodRegister
		 */
		public function test_deregister()
		{
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'deregister' ), 'Method deregister does not exist' );
			$this->_script->register();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'registered' ), 'Script not registered' );
			$this->_script->deregister();
			$this->assertFalse( wp_script_is( 'my-super-cool-script', 'registered' ), 'Script not deregistered' );
		}
	}
}
?>