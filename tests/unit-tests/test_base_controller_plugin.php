<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/controllers/class-base-controller-plugin.php';

	/**
	 * The test controller for Base_Controller_Plugin
	 *
	 * @since WPMVCBase 0.1
	 * @internal
	 */

	class BaseControllerPluginTest extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();

			//set up our virtual filesystem
			/*
\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();
*/

			//set up the plugin model
			$this->_model = $this
				->getMockBuilder( '\Base_Model_Plugin' )
				->disableOriginalConstructor()
				->getMock();

			//set up our controller
			$this->_controller = $this
				->getMockBuilder( '\Base_Controller_Plugin' )
				->setConstructorArgs( array( $this->_model ) )
				->getMockForAbstractClass();
		}

		public function tearDown()
		{
			wp_deregister_script( 'fooscript' );
			unset( $this->_controller );
			unset( $this->_mock_path );
			unset( $this->_filesystem );
		}

		/**
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedExceptionMessage __construct expects an instance of Base_Model_Plugin
		 * @covers Base_Controller_Plugin::__construct
		 */
		public function testMethodConstructorFail()
		{
			$model = new \stdClass;

			//set up our controller
			$controller = $this
				->getMockBuilder( '\Base_Controller_Plugin' )
				->setConstructorArgs( array( $model ) )
				->getMockForAbstractClass();

			unset( $controller );
		}

		public function testAttributePluginModelExists()
		{
			$this->assertClassHasAttribute( 'plugin_model', '\Base_Controller_Plugin' );
		}

		public function testActionAdminNoticesExists()
		{
			$this->assertFalse( false === has_action( 'admin_notices', array( $this->_controller, 'admin_notice' ) ) );
		}

		public function testActionPluginsLoadedExists()
		{
			$this->assertFalse( false === has_action( 'plugins_loaded', array( $this->_controller, 'load_text_domain' ) ) );
		}

		public function testActionAddMetaBoxesExists()
		{
			$this->assertFalse( false === has_action( 'add_meta_boxes', array( $this->_controller, 'add_meta_boxes' ) ) );
		}

		public function testActionAdminEnqueueScriptsExists()
		{
			$this->assertFalse( false === has_action( 'admin_enqueue_scripts', array( $this->_controller, 'admin_enqueue_scripts' ) ) );
		}

		public function testActionWpEnqueueScriptsExists()
		{
			$this->assertFalse( false === has_action( 'wp_enqueue_scripts', array( $this->_controller, 'wp_enqueue_scripts' ) ) );
		}
		
		/**
		 * covers Base_Controller_Plugin::wp_enqueue_scripts
		 */
		public function testMethodWpEnqueueScripts()
		{
			$this->assertTrue( method_exists( $this->_controller, 'wp_enqueue_scripts' ) );
			
			$script = $this->getMockBuilder( '\Base_Model_JS_Object' )
			               ->disableOriginalConstructor()
			               ->setMethods( array( 'get_handle', 'get_src', 'get_deps', 'get_ver', 'get_in_footer' ) )
			               ->getMock();
			
			$script->expects( $this->any() )
			       ->method( 'get_handle' )
			       ->will( $this->returnValue( 'fooscript' ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_src' )
			       ->will( $this->returnValue('http://example.com/foo.js' ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_deps' )
			       ->will( $this->returnValue( array( 'jquery' ) ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_ver' )
			       ->will( $this->returnValue( true ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_in_footer' )
			       ->will( $this->returnValue( true ) );
			
			$model = $this->getMockBuilder( '\Base_Model_Plugin' )
			              ->disableOriginalConstructor()
			              ->setMethods( array( 'get_scripts' ) )
			              ->getMock();
			              
			$model->expects( $this->any() )
			      ->method( 'get_scripts' )
			      ->will( $this->returnValue( array( $script ) ) );
			
			//add the model to the controller
			$this->setReflectionPropertyValue( $this->_controller, 'plugin_model', $model );
			
			//call the SUT
			$this->_controller->wp_enqueue_scripts();
			
			//make sure script is registered
			$this->assertScriptRegistered( 
				array(
					'fooscript',
					'http://example.com/foo.js',
					array( 'jquery' ),
					true,
					true
				)
			);
			
			//and enqueued
			$this->assertTrue( wp_script_is( 'fooscript', 'enqueued' ), 'script not enuqueued' );
		}
		
		/**
		 * covers Base_Controller_Plugin::admin_enqueue_scripts
		 */
		public function testMethodAdminEnqueueScripts()
		{
			$this->assertTrue( method_exists( $this->_controller, 'admin_enqueue_scripts' ) );
			
			$script = $this->getMockBuilder( '\Base_Model_JS_Object' )
			               ->disableOriginalConstructor()
			               ->setMethods( array( 'get_handle', 'get_src', 'get_deps', 'get_version', 'get_in_footer' ) )
			               ->getMock();
			
			$script->expects( $this->any() )
			       ->method( 'get_handle' )
			       ->will( $this->returnValue( 'fooadminscript' ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_src' )
			       ->will( $this->returnValue('http://example.com/fooadmin.js' ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_deps' )
			       ->will( $this->returnValue( array( 'jquery' ) ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_version' )
			       ->will( $this->returnValue( true ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_in_footer' )
			       ->will( $this->returnValue( true ) );
			
			$model = $this->getMockBuilder( '\Base_Model_Plugin' )
			              ->disableOriginalConstructor()
			              ->setMethods( array( 'get_admin_scripts', 'get_textdomain', 'get_uri' ) )
			              ->getMock();
			              
			$model->expects( $this->any() )
			      ->method( 'get_admin_scripts' )
			      ->will( $this->returnValue( array( $script ) ) );
			
			$model->expects( $this->any() )
			      ->method( 'get_textdomain' )
			      ->will( $this->returnValue( 'footxtdomain' ) );
			
			$this->setReflectionPropertyValue( $this->_controller, 'plugin_model', $model );
			
			$this->_controller->admin_enqueue_scripts( 'foohook' );
			
			$this->assertTrue( wp_script_is( 'fooadminscript', 'registered' ) );
			
			global $wp_scripts;
			
			$this->assertArrayHasKey( 'fooadminscript', $wp_scripts->registered );
			$this->assertEquals( $wp_scripts->registered['fooadminscript']->handle, 'fooadminscript' );
			$this->assertEquals( $wp_scripts->registered['fooadminscript']->src, 'http://example.com/fooadmin.js' );
			$this->assertEquals( $wp_scripts->registered['fooadminscript']->deps, array( 'jquery' ) );
			$this->assertEquals( $wp_scripts->registered['fooadminscript']->ver, true );
			$this->assertEquals( $wp_scripts->registered['fooadminscript']->extra, array( 'group' => 1 ) );
		}
	}
}
