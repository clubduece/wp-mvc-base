<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model.php' );
	
	class Test_Stub_Base_Model extends \Base_Model
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
	
	class Test_Base_Model extends \WP_UnitTestCase
	{
		public function SetUp()
		{
			$this->_model = new Test_Stub_Base_Model();
		}
		
		public function test_get_css()
		{
			$this->assertEquals(
				array( 'foo_css' => array( 'handle' => 'bar_css' ) ),
				$this->_model->get_css( 'http://my-super-cool-site' )
			);
		}
		
		public function test_get_admin_css()
		{
			$this->assertEquals(
				array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ),
				$this->_model->get_admin_css( 'http://my-super-cool-site' )
			);
		}
		
		public function test_get_scripts()
		{
			global $post;
			
			$this->assertEquals(
				array ( 'foo_scripts' => 'bar_scripts' ),
				$this->_model->get_scripts( $post, 'my-super-cool-text-domain', 'http://my-super-cool-site' )
			);
		}
		
		public function test_get_admin_scripts()
		{
			global $post;
			
			$this->assertEquals(
				array( 'foo_admin_scripts' => 'bar_admin_scripts' ),
				$this->_model->get_admin_scripts( $post, 'http://my-super-cool-site' )
			);
		}
		
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