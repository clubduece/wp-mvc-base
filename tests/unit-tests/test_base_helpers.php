<?php
namespace WPMVCBase\Testing
{
	require_once( WPMVCB_SRC_DIR . '/helpers/base_helpers.php' );
	
	/**
	 * The test controller for Helper_Functions
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class Test_Helper_Functions extends \WP_UnitTestCase
	{
		public function setUp()
		{
			\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_base_dir_path = \org\bovigo\vfs\vfsStream::url( 'test_dir' );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();
		}
		
		public function testVfsDirectoryExists()
		{
			$this->assertTrue( is_dir( $this->_base_dir_path ) );
		}
		
		public function testCreateDirectoryDirNonexistent()
		{
			\Helper_Functions::create_directory( $this->_base_dir_path . '/foo/bar' );
			$this->assertTrue( $this->_filesystem->hasChild( 'foo/bar' ) );
		}
		
		public function testCreateDirectoryDirExistent()
		{
			\Helper_Functions::create_directory( $this->_base_dir_path );
			$this->assertTrue( $this->_filesystem->hasChild( 'index.php' ) );
		}
		
		public function testGetLocalDirectoryContents()
		{
			\Helper_Functions::create_directory( $this->_base_dir_path . '/foo/bar' );
			
			$this->assertEquals(
				array(
					0 => array (
			            'filename' => 'index.php',
			            'filetype' => '',
			            'mimetype' => ''
			        )
			    ),
				\Helper_Functions::get_local_directory_contents( $this->_base_dir_path . '/foo/bar' )
			);
		}
		
		public function testGetLocalDirectoryContentsDirNonexistent()
		{
			$this->assertEquals( null, \Helper_Functions::get_local_directory_contents( $this->_base_dir_path . '/bar' ) );
		}
		
		public function testRemoveLocalDirectory()
		{
			$this->markTestIncomplete( 'This cannot be implemented using vfsStream due to being incompatible with SplFileInfo::getRealPath(). See https://github.com/mikey179/vfsStream/wiki/Known-Issues.');
			/*
\Helper_Functions::create_directory( $this->_base_dir_path . '/foo' );
			$this->assertTrue( $this->_filesystem->hasChild( 'foo' ) );
			$this->assertTrue( \Helper_Functions::remove_local_directory( $this->_base_dir_path . '/foo', 'force' ) );
			$this->assertFalse( $this->_filesystem->hasChild ( 'foo' ) );
*/
		}
		
		public function testRemoveLocalDirectoryDirParamSlash()
		{
			$this->assertFalse( \Helper_Functions::remove_local_directory( '/' ) );
		}
		
		public function testRemoveLocalDirectoryDirParamEmpty()
		{
			$this->assertFalse( \Helper_Functions::remove_local_directory( '' ) );
		}
		
		public function testRemoveLocalDirectoryDirNonexistent()
		{
			$this->assertFalse( \Helper_Functions::remove_local_directory( $this->_base_dir_path . '/bar' ) );
		}
		
		public function testDeleteLocalFileException()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			\Helper_Functions::delete_local_file( $this->_base_dir_path . '/index.php' );
		}
		
		public function testDeleteLocalFileExceptionMessage()
		{
			@\Helper_Functions::delete_local_file( $this->_base_dir_path . '/index.php' );
			$error = error_get_last();
			
			$this->assertEquals( 'DEPRECATED: The function delete_local_file is deprecated. Please use PHP unlink instead.', $error['message'] );
		}
		
		public function testDeleteLocalFile()
		{
			$handle = fopen( $this->_base_dir_path  .'/index.php', 'w' );
			fwrite( $handle, '<?php //silence is golden. ?>' );
			fclose( $handle );
			
			@\Helper_Functions::delete_local_file( $this->_base_dir_path . '/index.php' );
			$this->assertFalse( file_exists( $this->_base_dir_path . '/index.php' ) );
		}
		
		public function testSanitizeTextFieldArray()
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
		public function testDeprecatedException()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			\Helper_Functions::deprecated( 'foo', 'bar', 'my-super-cool-text-domain' );
		}
		
		/**
		 * Test the deprecated() error message
		 *
		 * @since 0.1
		 */
		public function testDeprecatedExceptionMessage()
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