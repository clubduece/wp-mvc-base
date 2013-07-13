<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/base_model_js_object.php' );	
	require_once( WPMVCB_SRC_DIR . '/models/base_model_settings.php' );
	
	class TestStubModelSettings extends \Base_Model_Settings
	{
		protected function init( $uri, $path, $txtdomain )
		{
			$this->options = array(
				'test_options'	=> array(
					'option_group'	=> 'my_option_group_name',
					'option_name'	=> 'my_option_name',
					'callback'		=> array( &$this, 'sanitize_callback' )
				)
			);
			
			$this->pages = array(
				'my-page-slug'		=> array(
					'page_title'	=> __( 'My Page Title', $txtdomain ),
					'menu_title'	=> __( 'My Page Menu Title', $txtdomain ),
					'capability'	=> 'manage_options',
					'menu_slug'		=> 'my-page-slug',
					'callback'		=> 'my_page_slug.php',
					'icon_url'		=> 'my-icon.png',
					'position'		=> 100.12345,
					'js'			=> array (
						new \Base_Model_JS_Object( 'foo', 'http://example.com/foo.js' )
					),
					'help_screen'	=> array (
					)
				),
				'my-submenu-page-slug'	=> array(
					'parent_slug'		=> 'my-page-slug',
					'page_title'		=> __( 'My Submenu Page Title', $txtdomain ),
					'menu_title'		=> __( 'My Submenu Page Menu Title', $txtdomain ),
					'capability'		=> 'manage_options',
					'menu_slug'			=> 'my-submenu-page-slug',
					'callback'			=> 'my_submenu_page_slug.php'
				),
				'my-fake-submenu-page'	=> array(
					'parent_slug'		=> 'my-page-slug',
					'page_title'		=> __( 'My Fake Submenu Page Title', $txtdomain ),
					'menu_title'		=> __( 'My Fake Submenu Page Menu Title', $txtdomain ),
					'capability'		=> 'nonexistent_capability',
					'menu_slug'			=> 'my-fake-submenu-page-slug',
					'callback'			=> 'my_fake_submenu_page_slug.php'
				)
			);
			
			$this->settings_sections = array(
				'my-settings-section' => array(
					'title'		=> __( 'General Settings', $txtdomain ),
					'callback'	=> null,
					'page'		=> 'my-page-slug',
					'content'	=> __( 'This is my settings section', 'mytxtdomain' )
				)
			);
			
			$this->settings_fields	= array(
				'my-settings-field' => array(
					'title' 		=> __( 'Setting Title', $txtdomain ),
					'callback'		=> null,
					'page'			=> 'my-page-slug',
					'section'		=> 'my-settings-section',
					'args' 			=> array(
						'label_for' => __( 'My Custom Label', $txtdomain ),
						'type'		=> 'text',
						'id'		=> 'my-settings-field',
						'name'		=> 'test_options[my_settings_field]',
						'value'		=> $this->get_settings( 'my_option_name', 'my_settings_field' )
					)
				)
			);
		}
		
		public function santize_callback( $input )
		{
			$input['foo'] = 'bar';
			return $input;
		}
	}
}
?>