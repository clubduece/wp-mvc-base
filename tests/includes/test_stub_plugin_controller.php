<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/controllers/base_controller_plugin.php' );
	require_once( WPMVCB_SRC_DIR . '/models/base_model_js_object.php' );
	require_once( WPMVCB_TEST_DIR . '/includes/test_stub_model_settings.php' );
	require_once( WPMVCB_TEST_DIR . '/includes/test_stub_cpt_model.php' );
	
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
			$this->admin_scripts = array(
				new \Base_Model_JS_Object( 'fooscript', 'http://example.com/fooscript.js', null, false, false )
			);
			$this->settings_model = new TestStubModelSettings(
				'http://example.com',
				'/home/user/public_html/wp-content/plugins/my-super-cool-plugin',
				'footxtdomain'
			);
		}
		
		public function get_cpt()
		{
			return $this->cpts[ 'tbc-cpt'];
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
		
		public function delete_data_post()
		{
			return "DELETE DATA POST";
		}
		
		public function delete_data_page()
		{
			return "DELETE DATA PAGE";
		}
	}
}