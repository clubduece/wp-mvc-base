<?php

/**
 * the base CPT class model
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 */

require_once( 'base_model.php' );

if ( ! class_exists( 'Base_Model_CPT' ) && class_exists( 'Base_Model' ) ):
	/**
	 * The base CPT object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @abstract
	 * @since WPMVCBase 0.1
	 */
	 abstract class Base_Model_CPT extends Base_Model
	 {
	 	/**
		 * The cpt slug.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $slug;
		
		/**
		 * The cpt metakey .
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $metakey;
		
		/**
		 * The arguments passed to register_post_type.
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $args;
		
		/**
		 * The CPT post updated/deleted/etc messages.
		 * 
		 * @var array
		 * @access protected
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		protected $messages;
		
		/**
		 * Shortcodes exposed by this CPT.
		 *
		 * This property is an array of key/value pairs of the shortcode name and the callback function.
		 * Example:
		 * <code>
		 * $this->shortcodes = array( 'myshortcode' => 'myshortcode_callback_function );
		 * </code>
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $shortcodes;
		
		/**
		 * The Help screen tabs for this CPT
		 *
		 * This property is an array containing individual help screen definitions.
		 * Example:
		 * <code>
		 * $help_tabs = array(  'title' => __( 'My Help Screen', 'my_text_domain' ), 'id' => 'demo-help', 'call' => 'my_callback_function' );
		 * </code>
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $help_tabs;
		
		/**
		 * The class constructor.
		 *
		 * Use this function to initialize class variables, require necessary files, etc.
		 *
		 * @param string $uri The plugin uri.
		 * @param string $txtdomain The plugin text domain.
		 * @return void
		 * @access public
		 * @since 0.1
		 */
		public function __construct( $uri = '', $txtdomain = '' )
		{
			$this->txtdomain = $txtdomain;
			
			if ( method_exists( $this, 'init' ) )
				$this->init( $uri, $txtdomain );
				
			if ( method_exists( $this, 'init_args' ) )
				$this->init_args( $txtdomain );
			
			if ( method_exists( $this, 'init_shortcodes' ) )
	 			$this->init_shortcodes();
		}
		
		
		/**
		 * Get the CPT messages
		 *
		 * @param object $post The WP post object.
		 * @param string $txtdomain The text domain to use for localization.
		 * @return array $messages The messages array.
		 * @access public
		 * @since 0.1
		 */
		public function get_post_updated_messages( $post, $txtdomain ) 
		{
			if ( ! isset( $this->messages ) && method_exists( $this, 'init_messages' ) )
				$this->init_messages( $post, $this->txtdomain );
				
			if( ! isset( $this->messages ) ):
				trigger_error( 
					sprintf( __( 'CPT messages are not set for %s', $this->txtdomain ), get_class( $this ) ),
					E_USER_WARNING 
				);
			endif;
			
			return $this->messages;
		}
		
		/**
		 * get the cpt slug
		 *
		 * @return string $slug
		 * @access public
		 * @since 0.1
		 */
		public function get_slug()
		{
			if ( !isset( $this->slug ) || $this->slug == '' )
				trigger_error( 
					sprintf( __( 'CPT Slug is not set for', $this->txtdomain ), get_class( $this ) ),
					E_USER_WARNING
				);

			return $this->slug;
		}
		
		/**
		 * Get the cpt arguments.
		 *
		 * @param string $txtdomain The plugin text domain.
		 * @return array $args
		 * @access public
		 * @since 0.1
		 */
		public function get_args( $txtdomain )
		{				
			if( ! isset( $this->args ) ):
				if ( ! method_exists( $this, 'init_args' ) ):
					trigger_error(
						sprintf(
							__( 'Arguments for %s post type not set', $this->txtdomain ),
							$this->slug
						),
						E_USER_WARNING
					);
				else:
					$this->init_args( $txtdomain );
				endif;
			endif;
			
			return $this->args;
		}
		
		/**
		 * Get the cpt shortcodes.
		 *
		 * @return array $shortcodes
		 * @access public
		 * @since 0.1
		 */
		public function get_shortcodes()
		{				
			if( ! isset( $this->shortcodes ) && method_exists( $this, 'init_shortcodes' ) )
				$this->init_shortcodes();
			
			return $this->shortcodes;
		}
		
		/**
		 * Get the cpt help screen tabs.
		 *
		 * @param string $path The plugin app views path.
		 * @param string $txtdomain The plugin text domain.
		 * @return array $help_tabs Contains the help screen tab objects.
		 * @access public
		 * @since 0.1
		 */
		public function get_help_tabs( $path, $txtdomain )
		{
			if( ! isset( $this->help_tabs ) && method_exists( $this, 'init_help_tabs' ) )
				$this->init_help_tabs( $path, $txtdomain );
			
			return $this->help_tabs;
		}
		
		/**
		 * Get the cpt help screen tabs.
		 *
		 * @param string $path The plugin app views path.
		 * @param string $txtdomain The plugin text domain.
		 * @return array $help_tabs Contains the help screen tab objects.
		 * @access public
		 * @deprecated
		 * @since 0.1
		 */
		public function get_help_screen( $path, $txtdomain )
		{
			//warn the user about deprecated function use
			Helper_Functions::deprecated( __FUNCTION__, 'get_help_tabs', $this->txtdomain );
			
			//and point to the replacement function
			return $this->help_tabs;
		}
		
		/**
		 * Get the cpt metakey.
		 *
		 * @return string $metakey
		 * @return void
		 * @access public
		 * @since 0.1
		 */
		public function get_metakey()
		{
			if( ! isset( $this->metakey ) )
				trigger_error( 
					sprintf( __( 'Metakey is not set for %s', $this->txtdomain ), get_class( $this ) ),
					E_USER_WARNING
				);
			
			return $this->metakey;
		}
		
		/**
		 * Register this post type.
		 *
		 * @param string $uri The plugin uri.
		 * @param string $txtdomain The plugin text domain.
		 * @return object The registered post type object on success, WP_Error object on failure
		 * @access public
		 * @since 0.1
		 */
		public function register()
		{	
			return register_post_type( $this->slug, $this->args );
		}
	 }
endif;

?>