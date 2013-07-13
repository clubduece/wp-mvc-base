<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/base_model.php' );
	
	/**
	 * Base Model Test Stub
	 *
	 * @internal
	 * @since 0.1
	 */
	class TestStubBaseModel extends \Base_Model
	{
		public function __construct()
		{
			$this->css = array( 'foo_css' => array( 'handle' => 'bar_css' ) );
			$this->admin_css = array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) );
			$this->scripts = array ( 'foo_scripts' => 'bar_scripts' );
			$this->admin_scripts = array( 'foo_admin_scripts' => 'bar_admin_scripts' );
			$this->metaboxes = array( 'foo_metaboxes' => 'bar_metaboxes' );
		}
	}
	
	/**
	 * Base Model Test Class
	 *
	 * @internal
	 * @since 0.1
	 */
	class TestBaseModel extends WPMVCB_Test_Case
	{
		public function SetUp()
		{
			parent::setUp();
			$this->_model = new TestStubBaseModel();
		}
		
		public function testMethodGetCssExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_css' ) );
		}
		
		/**
		 * @depends testMethodGetCssExists
		 */
		public function testMethodGetCss()
		{
			$this->assertEquals(
				array( 'foo_css' => array( 'handle' => 'bar_css' ) ),
				$this->_model->get_css( 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodGetAdminCssExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_admin_css' ) );
		}
		
		/**
		 * @depends testMethodGetAdminCssExists
		 */
		public function testMethodGetAdminCss()
		{
			$this->assertEquals(
				array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ),
				$this->_model->get_admin_css( 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodGetScriptsExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_scripts' ) );
		}
		
		/**
		 * @depends testMethodGetScriptsExists
		 */
		public function testMethodGetScripts()
		{
			global $post;
			
			$this->assertEquals(
				array ( 'foo_scripts' => 'bar_scripts' ),
				$this->_model->get_scripts( $post, 'my-super-cool-text-domain', 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodGetAdminScriptsExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_admin_scripts' ) );
		}
		
		/**
		 * @depends testMethodGetAdminScriptsExists
		 */
		public function testMethodGetAdminScripts()
		{
			global $post;
			
			$this->assertEquals(
				array( 'foo_admin_scripts' => 'bar_admin_scripts' ),
				$this->_model->get_admin_scripts( $post, 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodGetMetaboxesExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_metaboxes' ) );
		}
		
		/**
		 * @depends testMethodGetMetaboxesExists
		 */
		public function test_get_metaboxes()
		{	
			$this->assertEquals(
				array( 'foo_metaboxes' => 'bar_metaboxes' ),
				$this->_model->get_metaboxes( 4, 'http://my-super-cool-site' )
			);
		}
	}
}
?>