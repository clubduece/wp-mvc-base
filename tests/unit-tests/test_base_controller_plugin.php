<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_TEST_DIR . '/includes/test_stub_plugin_controller.php' );
	
	/**
	 * The test controller for Base_Controller_Plugin.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class Test_Base_Controller_Plugin extends \WP_UnitTestCase
	{
		private $_controller;
		private $_post;
		private $_page;
		private $_attachment;
		private $_cpt;
		
		public function setUp()
		{	
			//set up our virtual filesystem
			\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();
			
			//set up our post factory
			$this->factory = new \WP_UnitTest_Factory;
			
			//set up our controller
			$this->_controller = new Test_Controller(
				'my-super-cool-plugin',
				'1.0',
				$this->_mock_path,
				$this->_mock_path . 'my-super-cool-plugin.php',
				'http://my-super-cool-domain.com/wp-content/plugins/my-super-cool-plugin',
				'my-super-cool-text-domain'
			);
			
			$this->_post = $this->factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'post',
					'post_status' => 'publish'
				)
			);
			
			$this->_page = $this->factory->post->create_object(
				array(
					'post_title' => 'Test Page',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);
			
			$this->_attachment = $this->factory->attachment->create_object( 
				dirname( __FILE__ ) . '../README.md',
				$this->_post,
				array(
					'post_title' => 'Test Attachment',
					'post_content' => 'A super cool attachment',
					'post_status' => 'publish',
					'post_mime_type' => 'content/txt'
				)
			);
			
			$this->_cpt = $this->factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'tbc-cpt',
					'post_status' => 'publish'
				)
			);
			
			wp_set_current_user( 1 );
			//do_action( 'init' );
			do_action( 'plugins_loaded' );
		}
		
		public function testFilesystemExists()
		{
			$this->assertTrue( is_dir( $this->_mock_path ) );
		}
		
		public function testMethodGetVersionExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'get_version' ) );
		}
		
		/**
		 * @depends testMethodGetVersionExists
		 */
		public function testMethodGetVersion()
		{
			$this->assertEquals( '1.0', $this->_controller->get_version() );
		}
		
		public function testMethodGetSlugExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'get_slug' ) );
		}
		
		/**
		 * @depends testMethodGetSlugExists
		 */
		public function testMethodGetSlug()
		{
			$this->assertEquals( 'my-super-cool-plugin', $this->_controller->get_slug() );
		}
		
		public function testMethodGetTextdomainExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'get_textdomain' ) );
		}
		
		/**
		 * @depends testMethodGetTextdomainExists
		 */
		public function testMethodGetTextdomain()
		{
			$this->assertEquals( 'my-super-cool-text-domain', $this->_controller->get_textdomain() );
		}
		
		public function testMethodMainPluginFileExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'main_plugin_file' ) );
		}
		
		/**
		 * @depends testMethodMainPluginFileExists
		 */
		public function testMethodMainPluginFile()
		{
			$this->assertEquals( $this->_mock_path . 'my-super-cool-plugin.php', $this->_controller->main_plugin_file() );
		}
		
		/**
		 * Test for admin_init action hook
		 *
		 * Because $this->_controller has a settings model, the admin_init function should be hooked.
		 *
		 * @since 0.1
		 */
		public function testAdminInitActionExists()
		{
			$this->assertFalse( false === has_action( 'admin_init', array( $this->_controller, 'admin_init' ) ) );
		}
		
		/**
		 * Test for admin_menu action hook
		 *
		 * Because $this->_controller has a settings model, the admin_menu function should be hooked.
		 *
		 * @since 0.1
		 */
		public function testAdminMenuActionExists()
		{
			$this->assertFalse( false === has_action( 'admin_menu', array( $this->_controller, 'admin_menu' ) ) );
		}
		
		/**
		 * @depends testAdminInitActionExists
		 */
		public function testMethodRegisterOptions()
		{	
			ob_start();
			settings_fields( 'test_options' );
			$output = ob_get_clean();

			$this->assertStringStartsWith( 
				"<input type='hidden' name='option_page' value='test_options' />",
				$output
			);
		}
		
		/**
		 *
		 * This test should trigger an error due to the 'my-fake-submenu-page' set in the
		 * testStubSettingsModel class.
		 *
		 * @depends testAdminMenuActionExists
		 * @expectedException PHPUnit_Framework_Error
		 * @exectedExceptionMessage Unable to add submenu page due to insufficient user capability: my-fake-submenu-page
		 */
		public function testMethodAddMenuPages()
		{
			if( ! did_action( 'admin_init' ) ) {
				do_action( 'admin_init' );
				do_action( 'admin_menu' );
			}
			
			//set up a reflection of $this->_controller to access the settings_model property
			$reflection = new \ReflectionClass( $this->_controller );
			$settings_model_reflection = $reflection->getProperty( 'settings_model' );
			$settings_model_reflection->setAccessible( true );
			$settings_model = $settings_model_reflection->getValue( $this->_controller );
			
			//set up a reflection of $settings_model pages object
			$reflection = new \ReflectionClass( $settings_model );
			$pages_reflection = $reflection->getProperty( 'pages' );
			$pages_reflection->setAccessible( true );
			$pages = $pages_reflection->getValue( $settings_model );
			
			$this->assertEquals( 'toplevel_page_my-page-slug', $pages['my-page-slug']['hook_suffix'] );
			$this->assertEquals( 'my-page-menu-title_page_my-submenu-page-slug', $pages['my-submenu-page-slug']['hook_suffix'] );
		}
		
		public function testRenderOptionsPageExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_options_page' ) );
		}
		
		/**
		 * Ensure the default options page view exists and has a certain format.
		 * 
		 * @depends testRenderOptionsPageExists
		 */
		public function testMethodRenderOptionsPageNoView()
		{
			global $_REQUEST;
			$_REQUEST['page'] = 'my-page-slug';
			
			$this->assertFileExists( WPMVCB_SRC_DIR . '/views/base_options_page.php' );
			
			ob_start();
			$this->_controller->render_options_page();
			$output = ob_get_clean();
			
			//$this->assertRegExp( 'foo', $output );
			$this->markTestIncomplete( 'Not yet implemented' );
		}
		
		public function testMethodRenderOptionsPageViewExists()
		{
			$this->markTestIncomplete( 'Not yet implemented' );
			global $_REQUEST;
			$_REQUEST['page'] = 'my-page-slug';
			
			//set up a reflection to get the controller->settings_model object
			$controller_reflection = new \ReflectionClass( $this->_controller );
			$settings_model_reflection = $controller_reflection->getProperty( 'settings_model' );
			$settings_model_reflection->setAccessible( true );
			$settings_model = $settings_model_reflection->getValue( $this->_controller );
			
			//get the settings pages
			$this->assertTrue( method_exists( $settings_model, 'get_pages' ) );
			$pages = $settings_model->get_pages();
			
			//make the app views directory and verify it exists
			mkdir( $this->_mock_path . 'app/views/', 0755, true );
			$this->assertTrue( $this->_filesystem->hasChild( 'app/views' ) );
			
			//create the view file for this options page and verify it exists
			$handle = fopen( $this->_mock_path . 'app/views/' . $pages['my-page-slug']['view'], 'w' );
			fwrite( $handle, 'This is foobar.' );
			fclose( $handle );
			$this->assertTrue( $this->_filesystem->hasChild( 'app/views/' . $pages['my-page-slug']['view'] ) );
			
			//test the output for a match
			$this->expectOutputString( 'This is foobar.' );
			$this->_controller->render_options_page();
		}
		
		/**
		 * @depends testAdminInitActionExists
		 */
		public function testMethodAddSettingsSections()
		{
			if( ! did_action( 'admin_init' ) ) {
				do_action( 'admin_init' );
				do_action( 'admin_menu' );
			}
			
			global $wp_settings_sections;
			$this->assertArrayHasKey( 'my-page-slug', $wp_settings_sections );
			$this->assertArrayHasKey( 'my-settings-section', $wp_settings_sections['my-page-slug'] );
		}
		
		public function testMethodAddSettingsFields()
		{
			if( ! did_action( 'admin_init' ) ) {
				do_action( 'admin_init' );
				do_action( 'admin_menu' );
			}
			
			global $wp_settings_fields;
			
			$this->assertArrayHasKey(
				'my-settings-field',
				$wp_settings_fields['my-page-slug']['my-settings-section']
			);
			
		}
		
		public function testMethodRenderSettingsFieldExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_settings_field' ) );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodRenderInputText()
		{
			$field = array(
				'type' => 'text',
				'id' => 'my-super-cool-field',
				'name' => 'my_super_cool_field',
				'value' => 'foo',
				'placeholder' => 'Enter some value',
				'after' => 'bar'
			);
			
			$expected = '<input type="text" id="my-super-cool-field" name="my_super_cool_field" value="foo" placeholder="Enter some value" />bar';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodReturnInputText()
		{
			$field = array(
				'type' => 'text',
				'id' => 'my-super-cool-field',
				'name' => 'my_super_cool_field',
				'value' => 'foo',
				'placeholder' => 'Enter some value',
				'after' => dirname( dirname( __FILE__ ) ) . '/sample_file.txt'
			);
			
			$expected = '<input type="text" id="my-super-cool-field" name="my_super_cool_field" value="foo" placeholder="Enter some value" />';
			
			ob_start();
			require_once( dirname( __FILE__ ) . '/../sample_file.txt' );
			$expected .= ob_get_clean();
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodRenderInputCheckbox()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '0',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" />';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodReturnInputCheckbox()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '0',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" />';
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodRenderInputCheckboxChecked()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '1',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" checked />';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodReturnInputCheckboxChecked()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '1',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" checked />';
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodRenderInputSelect()
		{
			$field = array(
				'type'		=> 'select',
				'id'		=> 'my-super-cool-select',
				'name'		=> 'my_super_cool_select',
				'value'		=> 'my-super-cool-value',
				'options'	=> array(
					'my_super_cool_option' => 'My Super Cool Option'
				)
			);
			
			$expected = '<select id="my-super-cool-select" name="my_super_cool_select"><option value="">Select…</option><option value="my_super_cool_option" >My Super Cool Option</option></select>';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodReturnInputSelect()
		{
			$field = array(
				'type'		=> 'select',
				'id'		=> 'my-super-cool-select',
				'name'		=> 'my_super_cool_select',
				'value'		=> 'my-super-cool-value',
				'options'	=> array(
					'my_super_cool_option' => 'My Super Cool Option'
				)
			);
			
			$expected = '<select id="my-super-cool-select" name="my_super_cool_select"><option value="">Select…</option><option value="my_super_cool_option" >My Super Cool Option</option></select>';
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodRenderTextarea()
		{
			$field = array(
				'type'		=> 'textarea',
				'id'		=> 'my-super-cool-textarea',
				'name'		=> 'my_super_cool_textarea',
				'value'		=> 'My textarea content'
			);
			$expected = '<textarea id="my-super-cool-textarea" name="my_super_cool_textarea">My textarea content</textarea>';
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field, 'echo' );
		}
		
		/**
		 * @depends testMethodRenderSettingsFieldExists
		 */
		public function testMethodReturnTextarea()
		{
			$field = array(
				'type'		=> 'textarea',
				'id'		=> 'my-super-cool-textarea',
				'name'		=> 'my_super_cool_textarea',
				'value'		=> 'My textarea content'
			);
			$expected = '<textarea id="my-super-cool-textarea" name="my_super_cool_textarea">My textarea content</textarea>';
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		public function testMethodAddCptExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_cpt' ) );
		}
		
		/*
		 * The following functions use the assertFalse because WP has_action may occasionally
		 * return a non-boolean value that evaluates to false
		 */
		 
		/**
		 * @depends testMethodAddCptExists
		 */
		public function testAddCptRegisterCallbackExists()
		{
			$cpt = $this->_controller->get_cpt();
			$this->assertFalse( false === has_action( 'init', array( $cpt, 'register' ) ) );
		}
		
		/**
		 * @depends testMethodAddCptExists
		 */
		public function test_add_cpt_add_meta_boxes()
		{
			$this->assertFalse( false === has_action( 'add_meta_boxes', array( $this->_controller, 'add_meta_boxes' ) ) );
		}
		
		/**
		 * @depends testMethodAddCptExists
		 */
		public function test_add_cpt_add_post_updated_messages()
		{
			$this->assertFalse( false === has_action( 'post_updated_messages', array( $this->_controller, 'post_updated_messages' ) ) );
		}
		
		/**
		 * @depends testMethodAddCptExists
		 */
		public function test_add_cpt_add_the_post()
		{
			$this->assertFalse( false === has_action( 'the_post', array( $this->_controller, 'callback_the_post' ) ) );
		}
		
		/**
		 * @depends testMethodAddCptExists
		 */
		public function test_add_cpt_add_save_post()
		{
			$this->assertFalse( false === has_action( 'save_post', array( $this->_controller, 'callback_save_post' ) ) );
		}
		
		/**
		 * @depends testMethodAddCptExists
		 */
		public function test_add_cpt_add_delete_post()
		{
			$this->assertFalse( false === has_action( 'delete_post', array( $this->_controller, 'callback_delete_post' ) ) );
		}
		
		/**
		 * @depends testMethodAddCptExists
		 */
		public function test_add_cpt_help_tabs()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\WPMVCB\Testing\Test_Controller' );
		}
		
		/**
		 * @depends testMethodAddCptExists
		 */
		public function test_add_cpt_shortcodes()
		{
			//$this->assertTrue( shortcode_exists( 'tscshortcode' ) );
			$this->markTestIncomplete( 'This test not yet implemented' );
		}
		
		public function test_callback_the_post_for_post()
		{
			$post = $this->_controller->callback_the_post( get_post( $this->_post ) );
			$this->assertObjectHasAttribute( 'foo', $post );
		}
		
		public function test_callback_the_post_for_page()
		{
			$post = $this->_controller->callback_the_post( get_post( $this->_page ) );
			$this->assertObjectHasAttribute( 'foo', $post );
		}
		
		public function test_callback_the_post_for_cpt()
		{
			$post = $this->_controller->callback_the_post( get_post( $this->_cpt ) );
			$this->assertObjectHasAttribute( 'foo', $post );
		}
		
		public function test_post_updated_messages()
		{
			global $post;
			
			$post = get_post( $this->_cpt );
			$cpt = $this->_controller->get_cpt();
			$messages = $this->_controller->post_updated_messages( $messages );
			
			$this->assertFalse( false === has_action( 'post_updated_messages', array( $this->_controller, 'post_updated_messages' ) ) );
			$this->assertArrayHasKey( 'tbc-cpt', $messages );
		}
		
		public function test_callback_save_post_for_post()
		{
			//set up the post
			global $post;
			$post = get_post( $this->_post );
			setup_postdata( $post );
			
			//set the current user to admin
			wp_set_current_user( 1 );
			
			//set up the POST variables to emulate form submission
			$GLOBALS['_POST'][ $this->_controller->nonce_name ] = wp_create_nonce( $this->_controller->nonce_action );
			wp_update_post( array( 'ID' => $this->_post, 'content' => 'Flibbertygibbet' ) );
			
			$meta = get_post_meta( $this->_post, 'foo', true );
			$this->assertEquals( 'this is a post', $meta );
		}
		
		public function test_callback_save_post_for_page()
		{
			//set up the post
			global $post;
			$post = get_post( $this->_page );
			setup_postdata( $post );
			
			//set the current user to admin
			wp_set_current_user( 1 );
			
			//set up the POST variables to emulate form submission
			$GLOBALS['_POST'][ $this->_controller->nonce_name ] = wp_create_nonce( $this->_controller->nonce_action );
			wp_update_post( array( 'ID' => $this->_page, 'content' => 'Flibbertygibbet' ) );
			
			$meta = get_post_meta( $this->_page, 'foo', true );
			$this->assertEquals( 'this is a page', $meta );
		}
		
		public function test_callback_save_post_for_cpt()
		{
			do_action( 'init' );
			
			//set up the post
			global $post;
			$post = get_post( $this->_cpt );
			setup_postdata( $post );
			
			//set the current user to admin
			wp_set_current_user( 1 );
			
			//set up the POST variables to emulate form submission
			$GLOBALS['_POST'][ $this->_controller->nonce_name ] = wp_create_nonce( $this->_controller->nonce_action );
			wp_update_post( array( 'ID' => $this->_cpt, 'content' => 'Flibbertygibbet' ) );
			
			$this->assertEquals( 'SAVE CPT', $this->_controller->callback_save_post( $this->_cpt ) );
		}
		
		public function testAdminRegisterControllerScripts()
		{
			/*
$this->_controller->admin_enqueue_scripts( 'post.php' );
			$this->assertTrue( wp_script_is( 'fooscript', 'registered' ) );
			$this->assertTrue( wp_script_is( 'fooscript', 'enqueued' ) );
*/
			$this->markTestIncomplete( 'This test not yet implemented' );
		}
		
		public function testAdminRegisterCptScripts()
		{
			/*
do_action( 'admin_init' );
			
			//set up the screen object
			global $current_screen;
			$current_screen->base = 'post';
			$current_screen->id = 'post';
			$current_screen->parent_base = 'edit';
			$current_screen->parent_file = 'edit.php';
			$current_screen->post_type = 'tbc-cpt';
			
			$this->_controller->admin_enqueue_scripts( 'post.php' );
			$this->assertTrue( wp_script_is( 'barscript', 'registered' ) );
			$this->assertTrue( wp_script_is( 'barscript', 'enqueued' ) );
*/
			$this->markTestIncomplete( 'This test not yet implemented' );
		}
		
		public function testCallbackDeletePostExists()
		{
			$this->assertFalse( false === has_action( 'delete_post', array( $this->_controller, 'callback_delete_post' ) ) );
		}
		public function testCallbackDeletePost()
		{
			//set the current user to admin
			wp_set_current_user( 1 );
			
			$this->assertEquals( 'DELETE DATA POST', $this->_controller->callback_delete_post( $this->_post ) );
		}
		
		public function testCallbackDeletePage()
		{
			//set the current user to admin
			wp_set_current_user( 1 );
			
			$this->assertEquals( 'DELETE DATA PAGE', $this->_controller->callback_delete_post( $this->_page ) );
		}
		
		public function testCallbackDeleteCPT()
		{
			//set the current user to admin
			wp_set_current_user( 1 );
			
			$this->assertEquals( 'DELETE CPT', $this->_controller->callback_delete_post( $this->_cpt ) );
		}
		
		public function testAdminEnqueueScriptsActionExists()
		{
			$this->assertFalse( false === has_action( 'admin_enqueue_scripts', array( &$this->_controller, 'admin_enqueue_scripts' ) ) );
		}
		
		
		public function testPluginControllerAdminScriptsRegistered()
		{
			$this->markTestSkipped( 'Causes errors in CI servers. Need to redesign.' );
			//set up a wp_screen object
			set_current_screen( 'edit.php' );
			
			do_action( 'admin_enqueue_scripts' );
			$this->assertTrue( wp_script_is( 'fooscript', 'registered' ) );
		}
		
		public function testPluginControllerAdminScriptsEnqueued()
		{
			$this->markTestSkipped( 'Causes errors in CI servers. Need to redesign.' );
			//set up a wp_screen object
			set_current_screen( 'edit.php' );
			
			do_action( 'admin_enqueue_scripts' );
			$this->assertTrue( wp_script_is( 'fooscript', 'enqueued' ) );
		}
		
		public function testRenderMetaboxExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_metabox' ) );
		}
		
		/**
		 * @depends testRenderMetaboxExists
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedExceptionMessage No view specified in the callback arguments for metabox id test-metabox
		 */
		public function testRenderMetaboxNoView()
		{
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array()
			);
			
			$this->_controller->render_metabox( $this->_post, $metabox );
		}
		
		/**
		 * @depends testRenderMetaboxExists
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedExceptionMessage The view file foo.php for metabox id test-metabox does not exist
		 */
		public function testRenderMetaboxViewNonexistent()
		{
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array(
					'view' => 'foo.php'
				)
			);
			
			$this->_controller->render_metabox( $this->_post, $metabox );
		}
		
		/**
		 * @depends testRenderMetaboxExists
		 */
		public function testRenderMetabox()
		{
			//create our mock view directory
			mkdir( $this->_mock_path . 'app/views', 0755, true );
			$this->assertTrue( $this->_filesystem->hasChild( 'app/views' ) );
			
			//create our mock View file
			$handle = fopen( $this->_mock_path . 'app/views/foo.php', 'w' );
			fwrite( $handle, 'This is foo.<?php echo $nonce; ?>' );
			fclose( $handle );
			$this->assertFileExists( $this->_mock_path . 'app/views/foo.php' );
			
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array(
					'view' => 'foo.php'
				)
			);
			
			$this->assertObjectHasAttribute( 'nonce_name', $this->_controller );
			$this->assertObjectHasAttribute( 'nonce_action', $this->_controller );
			
			$this->expectOutputString( 
				'This is foo.' . wp_nonce_field( $this->_controller->nonce_action, $this->_controller->nonce_name, true, false )
			);
			
			$this->_controller->render_metabox( $this->_post, $metabox );
		}
	}
}
?>