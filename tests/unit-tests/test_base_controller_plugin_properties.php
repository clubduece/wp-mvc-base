<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/controllers/base_controller_plugin.php' );
	
	/**
	 * The test class for Base_Controller_Plugin attributes.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class TestBaseControllerPluginProperties extends \WP_UnitTestCase
	{
		public function setUp()
		{
		}
		
		public function testPropertySlug()
		{
			$this->assertClassHasAttribute( 'slug', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyVersion()
		{
			$this->assertClassHasAttribute( 'version', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyPath()
		{
			$this->assertClassHasAttribute( 'path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyAppPath()
		{
			$this->assertClassHasAttribute( 'app_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyAppControllersPath()
		{
			$this->assertClassHasAttribute( 'app_controllers_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyAppModelsPath()
		{
			$this->assertClassHasAttribute( 'app_models_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyAppViewsPath()
		{
			$this->assertClassHasAttribute( 'app_views_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyBasePath()
		{
			$this->assertClassHasAttribute( 'base_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyBaseControllersPath()
		{
			$this->assertClassHasAttribute( 'base_controllers_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyBaseModelsPath()
		{
			$this->assertClassHasAttribute( 'base_models_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyBaseViewsPath()
		{
			$this->assertClassHasAttribute( 'base_views_path', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyMainPluginFile()
		{
			$this->assertClassHasAttribute( 'main_plugin_file', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyUri()
		{
			$this->assertClassHasAttribute( 'uri', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyJsUri()
		{
			$this->assertClassHasAttribute( 'js_uri', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyCssUri()
		{
			$this->assertClassHasAttribute( 'css_uri', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyTxtdomain()
		{
			$this->assertClassHasAttribute( 'txtdomain', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyCss()
		{
			$this->assertClassHasAttribute( 'css', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyAdminCss()
		{
			$this->assertClassHasAttribute( 'admin_css', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyScripts()
		{
			$this->assertClassHasAttribute( 'scripts', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyAdminScripts()
		{
			$this->assertClassHasAttribute( 'admin_scripts', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyMetaboxes()
		{
			$this->assertClassHasAttribute( 'metaboxes', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyCpts()
		{
			$this->assertClassHasAttribute( 'cpts', '\Base_Controller_Plugin' );
		}
		
		public function testPropertySettingsModel()
		{
			$this->assertClassHasAttribute( 'settings_model', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyHelpTabs()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyNonceName()
		{
			$this->assertClassHasAttribute( 'nonce_name', '\Base_Controller_Plugin' );
		}
		
		public function testPropertyNonceAction()
		{
			$this->assertClassHasAttribute( 'nonce_action', '\Base_Controller_Plugin' );
		}
	}
}
?>