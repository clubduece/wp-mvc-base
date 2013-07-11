<?php
/**
 * The base settings model
 *
 * @package WPMVCBase\Models
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @since WPMVCBase 0.1
 */
 
if ( ! class_exists( 'Base_Model_Settings' ) ):
	/**
	 * The base settings model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.1
	 * @since WPMVCBase 0.1
	 */
	abstract class Base_Model_Settings
	{
		/**
		 * The class version
		 *
		 * @var string
		 * @since 0.1
		 */
		private $version = '0.1';
		
		/**
		 * The plugin options. 
		 *
		 * Contains an array of option objects in key/value pairs. Example:
		 * <code>
		 * $this->options = array(
		 * 		'handle' => array(
		 * 			'option_group' =>	'my_option_group_name',
		 * 			'option_name' =>	'my_option_name',	//This will be used as the option key in the wp_options table
		 * 			'callback' =>		'my_santization_function'
		 * 		), ...
		 * );
		 * </code>
		 *
		 * @var array
		 * @since 0.1
		 */
		protected $options;
		
		/**
		 * The options pages.
		 *
		 * Contains an array of page elements. These items are added to the WP Dashboard Sidebar. The key should match the menu_slug property.
		 * Example:
		 * <code>
		 * $this->pages = array(
		 * 		'my-page-slug' => array(
		 * 			'parent_slug'	=> 'my-menu-page',	//See below
		 * 			'page_title'	=>	__( 'My Page Title', 'mytextdomain' ),
		 * 			'menu_title'	=>	__( 'My Submenu Title', 'mytextdomain' ),
		 * 			'capability'	=>	'manage_posts',
		 * 			'menu_slug'		=> 'my-page-slug',
		 * 			'callback'		=> 'my_page_slug.php',	//The view file name. Can be anything. Will be prepended with the plugin view path.
		 * 			'icon_url'		=> 'my-icon.png',	//this property is ignored for submenu pages
		 * 			'position'		=> 100,			//this property is ignored for submenu pages
		 * 			'js'			=> array (
		 * 								@see Base_Controller_Plugin::$scripts for elements
		 * 			),
		 * 			'help_screen'	=> array (
		 * 								@see Base_Model_Help_Tab for elements
		 * 			)
		 *		),...
		 * );
		 * </code>
		 *
		 * If the parent_slug property is specified, the page will be added using the WP add_submenu_page function. 
		 * Otherwise add_menu_page will be used, thus creating a top-level menu page.
		 *
		 * @var array
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/add_menu_page
		 * @link http://codex.wordpress.org/Function_Reference/add_submenu_page
		 */
		protected $pages;
		
		/**
		 * The settings sections.
		 *
		 * Contains an array of settings section objects. Example:
		 * <code>
		 * $this->settings_sections = array(
		 *		'section-id' => array(
		 * 			'title' =>		__( 'General Settings', 'mytextdomain' ),
		 * 			'callback' =>	'my_settings_section', 	//See below
		 *			'page' =>		'my-options-page',	//This MUST match the key of the corresponding $pages object.
		 * 			'content' =>	__( 'This is my settings section', 'mytxtdomain' ) //This content will be displayed in the settings section
		 * 		), ...
		 * );
		 * </code>
		 *
		 * The key for each section element will be used as the HTML id for the section.
		 *
		 * The callback parameter can be one of two values: NULL to use the default controller method, 
		 * or you can specify a custom class function.
		 * If set to NULL, the controller will include the view file in the app views directory with the 
		 * name matching the key of the section object. If that file does not exist, it will use the 
		 * default view included with this base package.
		 * If set to any other value, the named function will be used. This method goes against strict 
		 * MVC principles, as this forces the model to break encapsulation. 
		 * This is necessary given the WP Settings API procedural nature.
		 *
		 * @var array
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/add_settings_section
		 */
		protected $settings_sections;
		
		/**
		 * The settings fields.
		 *
		 * Contains an array of settings field objects. Example (storing individual fields in option group array):
		 * <code>
		 * $this->settings_fields => array(
		 *		'my-settings-field' => array(
		 * 			'title' =>		__( 'Setting Title', 'mytextdomain' ),
		 * 			'callback' =>	'my_callback', // See below.
		 * 			'page' =>		'my-options-page',	//This MUST match the key of the corresponding $pages object.
		 * 			'section' =>	'my-settings-section',	//This MUST match the key of the corresponding $settings_section object.
		 * 			'args' =>		array(
		 * 				'label_for' => __( 'My Custom Label', 'mytextdomain' ), //optional
		 * 				'type'		=> '$fieldtype', //Required if using the default render method. Can be checkbox, select, text, textarea
		 * 				'id'		=> 'my-settings-field', //Required if using the default render method.
		 *				'name'		=> 'my_option_name[my_settings_field]', //This MUST match the option name specified in the corresponding $options object. Required if using the default render method.
		 *				'value'		=> $this->get_settings( 'my_option_name', 'my_settings_field' ) //Required if using the default render method.
		 * 			)
		 * 		), ...
		 * );
		 * </code>
		 *
		 * The key for each field will be used as the id for the WP add_settings_field function.
		 *
		 * The callback parameter can be one of two values: NULL to use the default controller method, or you can specify a custom class function.
		 * If set to NULL, the controller will use the built-in rendering functions based upon the field args.
		 * If set to any other value, the named function will be used. This method goes against strict MVC principles, as this forces the model
		 * to break encapsulation. This is necessary given the WP Settings API procedural nature.
		 *
		 * @var array
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/add_settings_field
		 */
		protected $settings_fields;
		
		/**
		 * The plugin settings.
		 *
		 * This property contains key/value pairs of the plugin options and their current values.
		 *
		 * @var array
		 * @since 0.1
		 */
		protected $settings;
		
		/**
		 * The class constructor.
		 *
		 * @param string $uri The plugin base uri.
		 * @param string $path The plugin absoulte path.
		 * @param string $txtdomain The plugin text domain. Used to localize section/field headings, titles, etc.
		 * @return void
		 * @since 0.1
		 */
		public function __construct( $uri, $path, $txtdomain )
		{
			$this->init( $uri, $path, $txtdomain );
			$this->init_settings();
		}
		
		/**
		 * Initialize all class properties.
		 *
		 * @param string $uri The plugin base uri.
		 * @param string $path The plugin absoulte path.
		 * @param string $txtdomain The plugin text domain. Used to localize section/field headings, titles, etc.
		 * @since 0.1
		 */
		abstract protected function init( $uri, $path, $txtdomain );
		
		/**
		 * Initialize the settings property.
		 *
		 * This function loads all existing settings from the wp_options table for the options specified in the $options property.
		 *
		 * @return void
		 * @since 0.1
		 */
		protected function init_settings()
		{
			//load up our current settings
			if( isset( $this->options ) ):
				foreach( $this->options as $option ):
					$this->settings[$option['option_name']] = get_option( $option['option_name'] );
				endforeach;
			endif;
		}
		
		/**
		 * Get the options.
		 *
		 * @return array $options
		 * @since 0.1
		 */
		public function get_options()
		{
			return $this->options;
		}
		
		/**
		 * Get the menu pages.
		 *
		 * @return array $menu_pages
		 * @since 0.1
		 */
		public function get_pages()
		{
			return $this->pages;
		}
		
		/**
		 * Get the settings sections.
		 *
		 * @param string $key The setting section key. If specfied, the function will return that one section. 
		 * @return array|bool The settings section(s) on success, FALSE on non-existence of the section.
		 * @since 0.1
		 */
		public function get_settings_sections( $key = null )
		{
			if ( ! is_null( $key ) ):
				if ( isset( $this->settings_sections[$key] ) ):
					return $this->settings_sections[$key];
				else:
					return false;
				endif;
			else:
				return $this->settings_sections;
			endif;
		}
		
		/**
		 * Get the settings fields.
		 *
		 * @return array $settings_fields
		 * @since 0.1
		 */
		public function get_settings_fields()
		{		
			return $this->settings_fields;
		}
		
		/**
		 * Set a page's properties
		 *
		 * @param string $key The page key.
		 * @param array $args The page elements.
		 * @return bool TRUE if page key exists, FALSE otherwise.
		 * @since 0.1
		 */
		public function edit_page( $key, $args )
		{
			if( ! isset( $this->pages[$key] ) )
				return false;
			
			$this->pages[$key] = $args;
			return true;
		}
		
		/**
		 * Set a section's properties
		 *
		 * @param string $key The settings section key.
		 * @param array $args The section elements.
		 * @return bool TRUE if section key exists, FALSE otherwise.
		 * @since 0.1
		 */
		public function edit_settings_section( $key, $args )
		{
			if( ! isset( $this->settings_sections[$key] ) )
				return false;
			
			$this->settings_sections[$key] = $args;
			return true;
		}
		
		/**
		 * Get the plugin settings.
		 *
		 * @param string $option_name The option name. Required if $option is specified. Default NULL.
		 * @param string $option_element The option element name. Default NULL.
		 * @return array|string|bool Array containing setting(s), the option value (or default) if an element is specified (but does not exist), FALSE on non-existence of setting default.
		 * @since 0.1
		 */
		public function get_settings( $option_name = null, $option_element = null )
		{
			if( ! isset( $this-> settings ) )
				$this->init_settings();
			
			//Was a specific setting requested?
			if ( is_null( $option_name ) ):
				return $this->settings;
			else:
				//Was a specific element requested?
				if( is_null( $option_element ) ):
					//no
					return $this->settings[$option_name];
				else:
					//a specfic option was requested
					if ( isset( $this->settings[$option_name][$option_element] ) ):
						return $this->settings[$option_name][$option_element];
					else:
						//Return the default value if specified. Otherwise FALSE.
						if( isset( $this->settings_fields[$option_element]['default'] ) ):
							return $this->settings_fields[$option_element]['default'];
						else:
							return false;
						endif;
					endif;
				endif;
			endif;
		}
		
		/**
		 * Add a settings section.
		 *
		 * @param array $section The section to be added.
		 * @return void
		 * @since 0.1
		 */
		public function add_settings_section( $section )
		{
			$this->settings_sections = array_merge( $this->settings_sections, $section );
		}
		
		/**
		 * Add a settings field.
		 *
		 * @param array $settings The fields to be added.
		 * @return void
		 * @since 0.1
		 */
		public function add_settings_field( $settings )
		{
			$this->settings_fields = array_merge( $this->settings_fields, $settings );
		}
		
		/**
		 * A generic sanitization routine.
		 * 
		 * Assumes all values are text strings. You can overwrite this function by including a function
		 * using the same name in the child class.
		 *
		 * @param array $input The POSTed data.
		 * @return array $input The modified POST data.
		 * @since 0.1
		 */
		public function sanitize_input( $input )
		{
			if( is_array( $input ) ):
				foreach( $input as $key => $value ):
					$input[$key] = sanitize_text_field( $value );
				endforeach;
			endif;
			
			return $input;
		}
	}
endif;
?>