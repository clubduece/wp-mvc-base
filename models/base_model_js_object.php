<?php
/**
 * The base javascript object model.
 *
 * @package WP Base\Models
 * @author authtoken
 * @version 0.1
 * @since WP Base 0.1
 */
if ( ! class_exists( 'Base_Model_JS_Object' ) ):
	/**
	 * The base javascript object model.
	 * 
	 * Example:
	 * <code>
	 * $script = new Base_Model_JS_Object(
	 * 		'my-script'
	 * 		'http://example.com/wp-content/plugins/my-plugin/js/my-script.js',
	 * 		array( 'jquery', 'jquery-ui' ),
	 * 		'5.4.17'
	 * 		false,
	 * 		'myscriptl10n',
	 *		array( 'errorMessage' => __( 'There was an error.', 'mytxtdomain')
	 * );
	 * </code>
	 *
	 * This class exposes two filters, ah_base_filter_script_src-$handle and ah_base_filter_script_localization_args-$handle.
	 * These are included to allow the plugin controller to modify these elements immediately prior to enqueuing of the script.
	 *
	 * Example:
	 * <code>
	 * public function filter_script_source( $source )
	 * {
	 * 		$source = 'http://example.com/wp-content/plugins/my-plugin/js/my-script.min.js';
	 * 		return $source;
	 * }
	 * add_filter( 'ah_base_filter_script_src-my-script', 'filter_script_source' );
	 *
	 * public function filter_script_localization( $args )
	 * {
	 * 		$args['my_arg'] = 'foo';
	 * 		return $args;
	 * }
	 * add_filter( 'ah_base_filter_script_localization_args-my-script', 'filter_script_localization' );
	 * </code>
	 * 
	 * If using a script already registered by WordPress, you need only specify the handle.
	 *
	 * @package WP Base\Models
	 * @since WP Base 0.1
	 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
	 */
	class Base_Model_JS_Object
	{
		/**
		 * The script handle.
		 *
		 * Name used as a handle for the script. As a special case, if the string contains a '?' character, 
		 * the preceding part of the string refers to the registered handle, and the succeeding part is 
		 * appended to the URL as a query string.
		 *
		 * @package WP Base\Models
		 * @var string
		 * @since 0.1
		 */
		private $handle;
		
		/**
		 * The script source uri.
		 *
		 * URL to the script, e.g. http://example.com/wp-content/themes/my-theme/my-theme-script.js. 
		 * You should never hardcode URLs to local scripts. To get a proper URL to local scripts, use plugins_url() 
		 * for plugins and get_template_directory_uri() for themes. Remote scripts can be specified with a protocol-agnostic 
		 * URL, e.g. //otherdomain.com/js/their-script.js. This parameter is only required when the script with the given 
		 * $handle has not been already registered using wp_register_script().
		 *
		 * @package WP Base\Models
		 * @var string
		 * @since 0.1
		 */
		private $src;
		
		/**
		 * The script dependencies.
		 *
		 * Array of the handles of all the registered scripts that this script depends on, that is the scripts that must be 
		 * loaded before this script. Set false if there are no dependencies.
		 *
		 * @package WP Base\Models
		 * @var array
		 * @since 0.1
		 */
		private $deps;
		
		/**
		 * The script version number.
		 *
		 * String specifying the script version number, if it has one, which is concatenated to the end of the path as a query string. 
		 * If no version is specified or set to false, then WordPress automatically adds a version number equal to the current version 
		 * of WordPress you are running. If set to null no version is added. This parameter is used to ensure that the correct version 
		 * is sent to the client regardless of caching, and so should be included if a version number is available and makes sense for the script.
		 *
		 * @package WP Base\Models
		 * @var string|bool
		 * @since 0.1
		 */
		private $version;
		
		/**
		 * Script placement.
		 *
		 * Normally, scripts are placed in <head> of the HTML document. If this parameter is true, the script is placed before the </body> end tag.
		 *
		 * @package WP Base\Models
		 * @var bool
		 * @since 0.1
		 */
		private $in_footer;
		
		/**
		 * The localization variable name.
		 *
		 * String specifying the localization variable name to be used in the wp_localize_script() function. If set, the $localization_args property
		 * is required and this class will attempt to localize the script immediately after enqueuing the script. 
		 *
		 * @package WP Base\Models
		 * @var string
		 * @since 0.1
		 */
		private $localization_var;
		
		/**
		 * The localization arguments.
		 *
		 * An array of key/value pairs containing the argument name(s) and value(s).
		 * If the $localization_var property is set, this will be used as the $args parameter of the wp_localize_script function.
		 *
		 * @package WP Base\Models
		 * @var array
		 * @since 0.1
		 */
		private $localization_args;
		
		/**
		 * The class constructor
		 *
		 * @package WP Base\Models
		 * @param string $handle
		 * @param string $src
		 * @param array $deps
		 * @param string|bool $version
		 * @param bool $in_footer
		 * @param string $localization_var
		 * @param array $localization_args
		 * @since 0.1
		 */
		public function __construct( $handle, $src = false, $deps = array(), $version = false, $in_footer = false, $localization_var = null, $localization_args = null )
		{
			$this->handle				= $handle;
			$this->src					= $src;
			$this->deps					= $deps;
			$this->version				= $version;
			$this->in_footer			= $in_footer;
			$this->localization_var		= $localization_var; 
			$this->localization_args	= $localization_args;
		}
		
		
		/**
		 * Register the script globally.
		 *
		 * @package WP Base\Models
		 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
		 * @since 0.1
		 */
		public function register()
		{	
			wp_register_script( $this->handle, $this->src, $this->deps, $this->version, $this->in_footer );
		}
		
		/**
		 * Enqueue the script.
		 *
		 * @package WP Base\Models
		 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
		 * @since 0.1
		 */
		public function enqueue()
		{
			//apply filters
			$this->src = apply_filters( 'ah_base_filter_script_src-' . $this->handle, $this->src );
			$this->localization_args = apply_filters( 'ah_base_filter_script_localization_args-' . $this->handle, $this->localization_args );
			
			wp_enqueue_script( $this->handle, $this->src, $this->deps, $this->version, $this->in_footer );
			if( isset( $this->localization_var ) && isset( $this->localization_args ) )
				$localize = $this->_localize();
		}
		
		/**
		 * Localize the script
		 *
		 * @package WP Base\Models
		 * @link http://codex.wordpress.org/Function_Reference/wp_localize_script
		 * @since 0.1
		 */
		public function localize()
		{
			if ( isset( $this->localization_var ) && isset( $this->localization_args ) ):
				return wp_localize_script( $this->handle, $this->localization_var, $this->localization_args );
			else:
				return false;
			endif;
		}
		
		/**
		 * Dequeue the script.
		 *
		 * @package WP Base\Models
		 * @link http://codex.wordpress.org/Function_Reference/wp_dequeue_script
		 * @since 0.1
		 */
		public function dequeue()
		{
			wp_dequeue_script( $this->handle );
		}
	}
endif;
?>