<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../helpers/base_helpers.php' );
	
	/**
	 * The test controller for Helper_Functions
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class Test_Helper_Functions extends \WP_UnitTestCase
	{
		public function test_create_directory_dir_non_existent()
		{
			\Helper_Functions::create_directory( dirname( __FILE__ ) . '/foo/bar' );
			$this->assertFileExists( dirname( __FILE__ ) . '/foo/bar/index.php' );
		}
		
		public function test_create_directory_dir_existent()
		{
			\Helper_Functions::create_directory( dirname( __FILE__ ) );
			$this->assertFileExists( dirname( __FILE__ ) . '/index.php' );
		}
		
		public function test_get_local_directory_contents()
		{
			$this->assertEquals(
				array(
					0 => array (
			            'filename' => '.',
			            'filetype' => '',
			            'mimetype' => ''
			        ),
					1 => array (
			            'filename' => '..',
			            'filetype' => '',
			            'mimetype' => ''
			        ),
			        2 => array (
			            'filename' => 'index.php',
			            'filetype' => '',
			            'mimetype' => ''
			        )
			    ),
				\Helper_Functions::get_local_directory_contents( dirname( __FILE__ ) . '/foo/bar' )
			);
		}
		
		public function test_get_local_directory_contents_dir_non_existent()
		{
			$this->assertEquals( null, \Helper_Functions::get_local_directory_contents( dirname( __FILE__ ) . '/bar' ) );
		}
		
		public function test_remove_local_directory()
		{
			$this->assertTrue( \Helper_Functions::remove_local_directory( dirname( __FILE__ ) . '/foo', 'force' ) );
			$this->assertFalse( is_dir( dirname( __FILE__) . '/foo' ) );
		}
		
		public function test_remove_local_directory_dir_param_slash()
		{
			$this->assertFalse( \Helper_Functions::remove_local_directory( '/' ) );
		}
		
		public function test_remove_local_directory_dir_param_empty()
		{
			$this->assertFalse( \Helper_Functions::remove_local_directory( '' ) );
		}
		
		public function test_remove_local_directory_dir_slash()
		{
			$this->assertFalse( \Helper_Functions::remove_local_directory( '/' ) );
		}
		
		public function test_remove_local_directory_dir_non_existent()
		{
			$this->assertFalse( \Helper_Functions::remove_local_directory( dirname( __FILE__ ) . '/bar' ) );
		}
		
		public function test_delete_local_file_exception()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			\Helper_Functions::delete_local_file( dirname( __FILE__ ) . '/index.php' );
		}
		
		public function test_delete_local_file_message()
		{
			@\Helper_Functions::delete_local_file( dirname( __FILE__ ) . '/index.php' );
			$error = error_get_last();
			
			$this->assertEquals( 'DEPRECATED: The function delete_local_file is deprecated. Please use PHP unlink instead.', $error['message'] );
		}
		
		public function test_delete_local_file()
		{
			$handle = fopen( dirname( __FILE__ )  .'/index.php', 'w' );
			fwrite( $handle, '<?php //silence is golden. ?>' );
			fclose( $handle );
			
			@\Helper_Functions::delete_local_file( dirname( __FILE__ ) . '/index.php' );
			$this->assertFalse( file_exists( dirname( __FILE__ ) . '/index.php' ) );
		}
		
		public function test_sanitize_text_field_array()
		{
			$array = array(	
				'foo' => '~!@#$%^&*()_+`1234567890-=:;"<>?,./[]\{}|',
				'bar' => '<a href="http://my-super-cool-site.com">cool</a>'
			);
			$this->assertEquals(
				array(
					'foo' => '~!@#$%^&*()_+`1234567890-=:;"?,./[]\{}|',
					'bar' => 'cool'
				),
				\Helper_Functions::sanitize_text_field_array( $array )
			);
		}
		
		/**
		 * Test for deprecated() trigger error
		 *
		 * @since 0.1
		 */
		public function test_deprecated_exception()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			\Helper_Functions::deprecated( 'foo', 'bar', 'my-super-cool-text-domain' );
		}
		
		/**
		 * Test the deprecated() error message
		 *
		 * @since 0.1
		 */
		public function test_deprecated_message()
		{
			//the @ symbol supresses the expected error
			@\Helper_Functions::deprecated( 'foo', 'bar', 'my-super-cool-text-domain' );
			
			$error = error_get_last();
			$this->assertEquals( 'DEPRECATED: The function foo is deprecated. Please use bar instead.', $error['message'] );
		}
		
		public function testEnqueueScripts()
		{
			require_once( WPMVCB_SRC_DIR . '/models/base_model_js_object.php' );
			$scripts = array(
				new \Base_Model_JS_Object( 'foo', 'http://example.com/foo.js', null, false, false )
			);
			
			global $wp_scripts;
			
			\Helper_Functions::enqueue_scripts( $scripts );
			do_action( 'wp_enqueue_scripts' );
			$this->assertArrayHasKey( 'foo', $wp_scripts->registered );
		}
		
		public function testEnqueueStyles()
		{
			$styles = array(
				array(
					'handle'=> 'bar',
					'src' => 'http://example.com/bar.css',
					'deps' => null,
					'ver' => false,
					'media' => 'all'
				),
				array( 'handle' => 'thickbox' )
			);
			
			global $wp_styles;
			\Helper_Functions::enqueue_styles( $styles );
			do_action( 'wp_enqueue_scripts' );
			$this->assertArrayHasKey( 'bar', $wp_styles->registered );
		}
	}
}
?>