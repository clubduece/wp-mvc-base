<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/helpers/class-base-helpers.php';
	require_once WPMVCB_SRC_DIR . '/models/class-base-model.php';
		
	/**
	 * Base Model Test Class
	 *
	 * @internal
	 * @since 0.1
	 */
	class testBaseModel extends WPMVCB_Test_Case
	{
		public function SetUp()
		{
			parent::setUp();
			
			$args = array(
				'/home/foo/plugin.php',
				'/home/foo',
				'/home/foo/app',
				'/home/foo/base',
				'http://example.com/foo',
				'footextdomain'
			);
			
			//create the model
			$this->model = $this->getMockBuilder( '\Base_Model' )
			                     ->setConstructorArgs( $args )
			                     ->getMockForAbstractClass();
		}
		
		public function tearDown()
		{
			unset( $this->model );
		}
		
		/**
		 * @covers Base_Model::__construct
		 */
		public function testPropertyMainPluginFile()
		{
			$this->assertClassHasAttribute( 'main_plugin_file', '\Base_Model' );
			$this->assertEquals(
				'/home/foo/plugin.php',
				$this->getReflectionPropertyValue( $this->model, 'main_plugin_file' )
			);
		}
		
		/**
		 * @covers Base_Model::__construct
		 */
		public function testPropertyAppPath()
		{
			$this->assertClassHasAttribute( 'app_path', '\Base_Model' );
			$this->assertEquals(
				'/home/foo/app/',
				$this->getReflectionPropertyValue( $this->model, 'app_path' )
			);
		}
		
		/**
		 * @covers Base_Model::__construct
		 */
		public function testPropertyBasePath()
		{
			$this->assertClassHasAttribute( 'base_path', '\Base_Model' );
			$this->assertEquals(
				'/home/foo/base/',
				$this->getReflectionPropertyValue( $this->model, 'base_path' )
			);
		}
		
		/**
		 * @covers Base_Model::__construct
		 */
		public function testPropertyUri()
		{
			$this->assertClassHasAttribute( 'uri', '\Base_Model' );
			$this->assertEquals(
				'http://example.com/foo/',
				$this->getReflectionPropertyValue( $this->model, 'uri' )
			);
		}
		
		/**
		 * @covers Base_Model::__construct
		 */
		public function testPropertyTxtdomain()
		{
			$this->assertClassHasAttribute( 'txtdomain', '\Base_Model' );
			$this->assertEquals(
				'footextdomain',
				$this->getReflectionPropertyValue( $this->model, 'txtdomain' )
			);
		}
		
		/**
		 * expectedException PHPUnit_Framework_Error
		 * expectedExceptionMessage DEPRECATED: The function main_plugin_file is deprecated. Please use get_main_plugin_file instead.
		 * @covers Base_Model::main_plugin_file
		 */
		public function testMethodMainPluginFile()
		{
			$this->assertTrue( method_exists( $this->model, 'main_plugin_file' ) );
			$this->assertEquals( '/home/foo/plugin.php', $this->model->main_plugin_file() );
		}

		/**
		 * @covers Base_Model::get_main_plugin_file
		 */
		public function testMethodGetMainPluginFile()
		{
			$this->assertTrue( method_exists( $this->model, 'get_main_plugin_file' ) );
			$this->assertEquals( '/home/foo/plugin.php', $this->model->get_main_plugin_file() );
		}

		/**
		 * @covers Base_Model::get_path
		 */
		public function testMethodGetPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_path' ) );
			$this->assertEquals( '/home/foo/', $this->model->get_path() );
		}

		/**
		 * @covers Base_Model::get_app_path
		 */
		public function testMethodGetAppPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_app_path' ) );
			$this->assertEquals( '/home/foo/app/', $this->model->get_app_path() );
		}

		/**
		 * @covers Base_Model::get_app_controllers_path
		 */
		public function testMethodGetAppControllersPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_app_controllers_path' ) );
			$this->assertEquals( '/home/foo/app/controllers/', $this->model->get_app_controllers_path() );
		}

		/**
		 * @covers Base_Model::get_app_models_path
		 */
		public function testMethodGetAppModelsPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_app_models_path' ) );
			$this->assertEquals( '/home/foo/app/models/', $this->model->get_app_models_path() );
		}

		/**
		 * @covers Base_Model::get_app_views_path
		 */
		public function testMethodGetAppViewsPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_app_views_path' ) );
			$this->assertEquals( '/home/foo/app/views/', $this->model->get_app_views_path() );
		}

		/**
		 * @covers Base_Model::get_base_path
		 */
		public function testMethodGetBasePath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_base_path' ) );
			$this->assertEquals( '/home/foo/base/', $this->model->get_base_path() );
		}

		/**
		 * @covers Base_Model::get_base_controllers_path
		 */
		public function testMethodGetBaseControllersPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_base_controllers_path' ) );
			$this->assertEquals( '/home/foo/base/controllers/', $this->model->get_base_controllers_path() );
		}

		/**
		 * @covers Base_Model::get_base_models_path
		 */
		public function testMethodGetBaseModelsPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_base_models_path' ) );
			$this->assertEquals( '/home/foo/base/models/', $this->model->get_base_models_path() );
		}

		/**
		 * @covers Base_Model::get_base_views_path
		 */
		public function testMethodGetBaseViewsPath()
		{
			$this->assertTrue( method_exists( $this->model, 'get_base_views_path' ) );
			$this->assertEquals( '/home/foo/base/views/', $this->model->get_base_views_path() );
		}

		/**
		 * @covers Base_Model::get_uri
		 */
		public function testMethodGetUri()
		{
			$this->assertTrue( method_exists( $this->model, 'get_uri' ) );
			$this->assertEquals( 'http://example.com/foo/', $this->model->get_uri() );
		}

		/**
		 * @covers Base_Model::get_textdomain
		 */
		public function testMethodGetTextdomain()
		{
			$this->assertTrue( method_exists( $this->model, 'get_textdomain' ) );
			$this->assertEquals( 'footextdomain', $this->model->get_textdomain() );
		}
		
		/**
		 * @covers Base_Model::get_css
		 */
		public function testMethodGetCss()
		{
			$this->assertClassHasAttribute( 'css', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'get_css' ) );
			$this->setReflectionPropertyValue( $this->model, 'css', array( 'foo_css' => array( 'handle' => 'bar_css' ) ) );
			
			$this->assertEquals(
				array( 'foo_css' => array( 'handle' => 'bar_css' ) ),
				$this->model->get_css( 'http://my-super-cool-site' )
			);
		}
		
		/**
		 * @covers Base_Model::get_css
		 */
		public function testMethodGetCssEmpty()
		{
			$this->assertTrue( method_exists( $this->model, 'get_css' ) );
			$this->assertFalse( $this->model->get_css() );
		}
		
		/**
		 * @covers Base_Model::get_admin_css
		 */
		public function testMethodGetAdminCss()
		{
			$this->assertClassHasAttribute( 'admin_css', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'get_admin_css' ) );
			$this->setReflectionPropertyValue( $this->model, 'admin_css', array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ) );
			$this->assertEquals(
				array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ),
				$this->model->get_admin_css( 'http://my-super-cool-site' )
			);
		}
		
		/**
		 * @covers Base_Model::get_admin_css
		 */
		public function testMethodGetAdminCssEmpty()
		{
			$this->assertTrue( method_exists( $this->model, 'get_admin_css' ) );
			$this->assertFalse( $this->model->get_admin_css() );
		}
		
		/**
		 * @covers Base_Model::get_scripts
		 */
		public function testMethodGetScripts()
		{
			$this->assertClassHasAttribute( 'scripts', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'get_scripts' ) );
			//global $post;
			
			$this->setReflectionPropertyValue( $this->model, 'scripts', array ( 'foo_scripts' => 'bar_scripts' ) );
			$this->assertEquals(
				array ( 'foo_scripts' => 'bar_scripts' ),
				$this->model->get_scripts()
			);
		}
		
		/**
		 * @covers Base_Model::get_scripts
		 */
		public function testMethodGetScriptsEmpty()
		{
			$this->assertTrue( method_exists( $this->model, 'get_scripts' ) );
			$this->assertFalse( $this->model->get_scripts() );
		}
		
		/**
		 * @covers Base_Model::get_admin_scripts
		 */
		public function testMethodGetAdminScripts()
		{
			$this->assertClassHasAttribute( 'admin_scripts', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'get_admin_scripts' ) );
			
			//global $post;
			$this->setReflectionPropertyValue( $this->model, 'admin_scripts', array( 'foo_admin_scripts' => 'bar_admin_scripts' ) );
			$this->assertEquals(
				array( 'foo_admin_scripts' => 'bar_admin_scripts' ),
				$this->model->get_admin_scripts()
			);
		}
		
		/**
		 * @covers Base_Model::get_admin_scripts
		 */
		public function testMethodGetAdminScriptsEmpty()
		{
			$this->assertTrue( method_exists( $this->model, 'get_admin_scripts' ) );
			$this->assertFalse( $this->model->get_admin_scripts() );
		}
		
		/**
		 * @covers Base_Model::add_metabox
		 */
		public function testMethodAddMetabox()
		{
			$this->assertClassHasAttribute( 'metaboxes', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'add_metabox' ) );
			$stub = $this->getMockBuilder( 'Base_Model_Metabox' )
						 ->disableOriginalConstructor()
						 ->getMock();
						 
			$this->model->add_metabox( 'foo', $stub );
			$this->assertEquals(
				array( 'foo' => $stub ),
				$this->getReflectionPropertyValue( $this->model, 'metaboxes' )
			);
		}
		
		/**
		 * @covers Base_Model::add_metabox
		 */
		public function testMethodAddMetaboxFail()
		{
			$foo = new \StdClass;
			
			$this->assertTrue( method_exists( $this->model, 'add_metabox') );
			$this->assertEquals(
				new \WP_Error(
					'fail',
					'Base_Model::add_metabox expects a Base_Model_Metabox object as the second parameter',
					$foo
				),
				$this->model->add_metabox( 'foo', $foo )
			);
		}
		
		/**
		 * @covers Base_Model::get_metaboxes
		 */
		public function testMethodGetMetaboxes()
		{
			$this->assertClassHasAttribute( 'metaboxes', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'get_metaboxes' ) );
			
			$stub = $this->getMockBuilder( '\Base_Model_Metabox' )
						 ->disableOriginalConstructor()
						 ->getMock();
			$this->setReflectionPropertyValue( $this->model, 'metaboxes', array( 'foo' => $stub ) );
			
			$this->assertEquals( array( 'foo' => $stub ), $this->model->get_metaboxes( 'bar', 'baz') );
		}
		
		/**
		 * @covers Base_Model::get_metaboxes
		 */
		public function testMethodGetmetaboxesEmpty()
		{
			$this->assertTrue( method_exists( $this->model, 'get_metaboxes' ) );
			$this->assertFalse( $this->model->get_metaboxes() );
		}
		
		/**
		 * @covers Base_Model::add_help_tab
		 */
		public function testMethodAddHelpTab()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'add_help_tab' ) );
			//set up our mock help tab object
			$stub = $this->getMockBuilder( '\Base_Model_Help_Tab' )
						 ->disableOriginalConstructor()
						 ->getMock();
			
			$this->model->add_help_tab( 'foo', $stub );
			
			$this->assertEquals( 
				array( 'foo' => $stub ),
				$this->getReflectionPropertyValue( $this->model, 'help_tabs' )
			);
		}
		
		/**
		 * Pass an object not of type Base_Model_Help_Tab. Test should fail.
		 * @covers Base_Model::add_help_tab
		 */
		public function testMethodAddHelpTabFail()
		{
			$this->assertTrue( method_exists( $this->model, 'add_help_tab' ) );
			
			$tab = new \StdClass;
			
			$this->assertEquals(
				new \WP_Error(
					'invalid object type',
					'Base_Model::add_help_tab expects a Base_Model_Help_Tab object as the second parameter',
					$tab
				),
				$this->model->add_help_tab( 'foo', $tab )
			);
		}
		
		/**
		 * @covers Base_Model::get_help_screen
		 * @depends testMethodAddHelpTab
		 */
		public function testMethodGetHelpScreen()
		{
			$this->assertTrue( method_exists( $this->model, 'get_help_screen' ) );
			$stub = $this->getMockBuilder( 'Base_Model_Help_Tab' )
						 ->disableOriginalConstructor()
						 ->getMock();
			
			$this->model->add_help_tab( 'foo', $stub );
			
			$this->assertEquals(
				array( 'foo' => $stub ),
				$this->model->get_help_screen()
			);
		}
		
		/**
		 * @covers Base_Model::get_help_screen
		 * @depends testMethodGetHelpScreen
		 */
		public function testMethodGetHelpScreenError()
		{
			@$this->model->get_help_screen( __FILE__, 'my-super-cool-text-domain' );
			$error = error_get_last();
			$this->assertEquals(
				'DEPRECATED: The function get_help_screen is deprecated. Please use get_help_tabs instead.',
				$error['message']
			);
		}
		
		/**
		 * @covers Base_Model::get_help_tabs
		 */
		public function testMethodGetHelpTabs()
		{
			$this->assertTrue( method_exists( $this->model, 'get_help_tabs' ) );
			
			$this->setReflectionPropertyValue( $this->model, 'help_tabs', array( 'foo' => 1 , 'bar' => 2 ) );
			
			$this->assertEquals( 
				array( 'foo' => 1, 'bar' => 2 ),
				$this->model->get_help_tabs()
			);
		}
		
		/**
		 * @covers Base_Model::get_help_tabs
		 */
		public function testMethodGetHelpTabsEmpty()
		{
			$this->assertTrue( method_exists( $this->model, 'get_help_tabs' ) );
			$this->assertFalse( $this->model->get_help_tabs() );
		}
		
		/**
		 * @covers Base_Model::add_shortcode
		 */
		public function testMethodAddShortcode()
		{
			$this->assertClassHasAttribute( 'shortcodes', '\Base_Model' );
			$this->assertTrue( method_exists( $this->model, 'add_shortcode' ) );
			
			$this->assertTrue( $this->model->add_shortcode( 'foo', array( &$this, 'testMethodGetHelpTabs' ) ) );
		}
		
		/**
		 * @covers Base_Model::add_shortcode
		 */
		public function testMethodAddShortcodeFail()
		{
			$this->assertTrue( method_exists( $this->model, 'add_shortcode' ) );
			
			$this->assertEquals(
				new \WP_Error(
					'not callable',
					'Base_Model::add_shortcode expects a valid callback.',
					'foocallback'
				),
				$this->model->add_shortcode( 'fooshortcode', 'foocallback' )
			);	
		}
		
		/**
		 * @covers Base_Model::get_shortcodes
		 */
		public function testMethodGetShortcodes()
		{
			$this->assertTrue( method_exists( $this->model, 'get_shortcodes' ) );
			$this->setReflectionPropertyValue(
				$this->model,
				'shortcodes',
				array('fooshortcode' => array( &$this, 'testMethodAddShortcode' ) ) 
			);
			
			$this->assertEquals( array( 'fooshortcode' => array( &$this, 'testMethodAddShortcode' ) ), $this->model->get_shortcodes() );
		}
		
		/**
		 * @covers Base_Model::get_shortcodes
		 */
		public function testMethodGetShortcodesEmpty()
		{
			$this->assertTrue( method_exists( $this->model, 'get_shortcodes' ) );
			$this->assertFalse( $this->model->get_shortcodes() );
		}
		
		/**
		 * @covers Base_Model::authenticate_post
		 */
		public function testMethodAuthenticatePostForPost()
		{
			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'post',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 1 );

			$this->assertTrue(
				$this->model->authenticate_post(
					$post_id,
					'post',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Model::authenticate_post
		 */
		public function testMethodAuthenticatePostForPage()
		{
			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 1 );

			$this->assertTrue(
				$this->model->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Model::authenticate_post
		 */
		public function testMethodAuthenticatePostUserCannotEditPage()
		{
			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 0 );

			$this->assertEmpty(
				$this->model->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Model::authenticate_post
		 */
		public function testMethodAuthenticatePostUserCannotEditPost()
		{
			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'post',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 0 );

			$this->assertEmpty(
				$this->model->authenticate_post(
					$post_id,
					'post',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Model::authenticate_post
		 */
		public function testMethodAuthenticatePostNoNonce()
		{
			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 1 );

			$this->assertEmpty(
				$this->model->authenticate_post(
					$post_id,
					'page',
					array(),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Model::authenticate_post
		 */
		public function testMethodAuthenticatePostDoingAutosave()
		{
			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );

			define( 'DOING_AUTOSAVE', true );

			$this->assertEmpty(
				$this->model->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}
		
		/**
		 * @covers Base_Model::get_admin_notices
		 */
		public function testMethodGetAdminNotices()
		{
			$this->setReflectionPropertyValue( $this->model, 'admin_notices', array( 'foo', 'bar' ) );
			
			$this->assertTrue( method_exists( 'Base_Model', 'get_admin_notices' ) );
			$this->assertEquals( array( 'foo', 'bar' ), $this->model->get_admin_notices() );
		}
		
		/**
		 * @covers Base_Model::get_admin_notices
		 */
		public function testMethodGetAdminNoticesEmpty()
		{	
			$this->assertTrue( method_exists( 'Base_Model', 'get_admin_notices' ), 'Method get_admin_notices does not exist' );
			$this->assertFalse( $this->model->get_admin_notices() );
		}
	}
}
