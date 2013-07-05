<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../controllers/base_controller_plugin.php' );
	require_once( dirname( __FILE__ ) . '../../../models/base_model_cpt.php' );
	
	/**
	 * The stub CPT for the controller tests
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since 0.2
	 * @internal
	 */
	class Test_Stub_CPT extends \Base_Model_CPT
	{
		protected $slug = 'my-test-cpt';
		
		public $help_tabs = array();
		
		public function save_post()
		{
			//implemented, but does nothing
		}
		
		public function the_post( $post )
		{
			$post->foo = 'bar';
			return $post;
		}
		
		public function delete_post()
		{
			//implemented, but does nothing
		}
		
		protected function init_messages( $post )
		{
			$this->messages = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink( $post->ID) ) ),
				2 => __('Custom field updated.', 'your_text_domain'),
				3 => __('Custom field deleted.', 'your_text_domain'),
				4 => __('Book updated.', 'your_text_domain'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('Book published. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink($post->ID) ) ),
				7 => __('Book saved.', 'your_text_domain'),
				8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID) ) ) ),
				9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'your_text_domain'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $this->_post->post_date ) ), esc_url( get_permalink($post->ID) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID) ) ) )
			);
		}
	}
		
	/**
	 * The stub controller for phpUnit tests.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class Test_Controller extends \Base_Controller_Plugin
	{
		//set up nonces to test form submits
		public $nonce_name = '65fyvbuyfvboicigu';
		public $nonce_action = 'save_post';
		
		public function init()
		{
			$cpt = new Test_Stub_CPT( 'http://example.com', 'my-txtdomain' );
			$this->add_cpt( $cpt );
		}
		
		public function get_cpt()
		{
			return $this->cpts[ 'my-test-cpt'];
		}
		
		public function the_post( $post )
		{
			$post->foo = 'bar';
			return $post;
		}
		
		public function save_data_post( $post_id )
		{	
			update_post_meta( $post_id, 'foo', 'this is a post' );
		}
		
		public function save_data_page( $post_id )
		{
			update_post_meta( $post_id, 'foo', 'this is a page' );
		}
		
		public function the_page( $post )
		{
			$post->foo = 'bar';
			return $post;
		}
	}
	
	/**
	 * The test controller for Base_Controller_Plugin.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class TestBaseControllerPlugin extends \WP_UnitTestCase
	{
		private $_controller;
		private $_post;
		private $_page;
		private $_attachment;
		private $_cpt;
		
		public function setUp()
		{
			$this->factory = new \WP_UnitTest_Factory;
			
			$this->_controller = new Test_Controller(
				'my-super-cool-plugin',
				'1.0',
				'/home/user/public_html/wp-content/plugins/my-super-cool-plugin',
				'/home/user/public_html/wp-content/plugins/my-super-cool-plugin/my-super-cool-plugin.php',
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
					'post_type' => 'my-test-cpt',
					'post_status' => 'publish'
				)
			);
		}
		
		public function testGetVersion()
		{
			$this->assertEquals( '1.0', $this->_controller->get_version() );
		}
		
		public function testGetSlug()
		{
			$this->assertEquals( 'my-super-cool-plugin', $this->_controller->get_slug() );
		}
		
		public function testGetTextdomain()
		{
			$this->assertEquals( 'my-super-cool-text-domain', $this->_controller->get_textdomain() );
		}
		
		public function testMainPluginFile()
		{
			$this->assertEquals( '/home/user/public_html/wp-content/plugins/my-super-cool-plugin/my-super-cool-plugin.php', $this->_controller->main_plugin_file() );
		}
		
		public function testRenderInputText()
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
		
		public function testReturnInputText()
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
		
		public function testRenderInputCheckbox()
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
		
		public function testReturnInputCheckbox()
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
		
		public function testRenderInputCheckboxChecked()
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
		
		public function testReturnInputCheckboxChecked()
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
		
		public function testRenderInputSelect()
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
		
		public function testReturnInputSelect()
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
		
		public function test_add_cpt_register()
		{
			$cpt = $this->_controller->get_cpt();
			$this->assertFalse( false === has_action( 'init', array( $cpt, 'register' ) ) );
		}
		
		/*
		 * The following functions use the assertFalse because WP has_action my occasionally
		 * return a non-boolean value that evaluates to false
		 */
		public function test_add_cpt_add_meta_boxes()
		{
			$this->assertFalse( false === has_action( 'add_meta_boxes', array( $this->_controller, 'add_meta_boxes' ) ) );
		}
		
		public function test_add_cpt_add_post_updated_messages()
		{
			$this->assertFalse( false === has_action( 'post_updated_messages', array( $this->_controller, 'post_updated_messages' ) ) );
		}
		
		public function test_add_cpt_add_the_post()
		{
			$this->assertFalse( false === has_action( 'the_post', array( $this->_controller, 'callback_the_post' ) ) );
		}
		
		public function test_add_cpt_add_save_post()
		{
			$this->assertFalse( false === has_action( 'save_post', array( $this->_controller, 'callback_save_post' ) ) );
		}
		
		public function test_add_cpt_add_delete_post()
		{
			$this->assertFalse( false === has_action( 'delete_post', array( $this->_controller, 'callback_delete_post' ) ) );
		}
		
		public function test_add_cpt_help_tabs()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\WPMVCBase\Testing\Test_Controller' );
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
			
			$this->assertArrayHasKey( 'my-test-cpt', $messages );
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
	}
}
?>