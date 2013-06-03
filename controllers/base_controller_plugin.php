<?php
/**
 * The base plugin controller.
 *
 * @package WP Base\Controllers
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @since WP Base 0.1
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
 
if ( ! class_exists( 'Base_Controller_Plugin' ) ):
	/**
	 * The base plugin controller.
	 *
	 * @package WP Base\Controllers
	 * @abstract
	 * @version 0.1
	 * @since WP_Base 0.1
	 */
	abstract class Base_Controller_Plugin
	{
		/**
		 * The plugin slug.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $slug;
		
		/**
		 * The plugin version.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $version;
		
		/**
		 * The plugin path.
		 *
		 * This is the base directory for the plugin ( e.g. /home/user/public_html/wp-content/plugins/my-plugin ).
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $path;
		
		/**
		 * The plugin app path.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $app_path;
		
		/**
		 * The plugin controllers path.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $app_controllers_path;
		
		/**
		 * The plugin models path.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $app_models_path;
		
		/**
		 * The plugin views path
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $app_views_path;
		
		/**
		 * The base directory path.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $base_path;
		
		/**
		 * The base controllers path.
		 *
		 * This is the absolute path to the base classes (e.g. /home/user/public_html/wp-content/plugins/my-plugin/base )
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $base_controllers_path;
		
		/**
		 * The base models path.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $base_models_path;
		
		/**
		 * The base views path.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $base_views_path;
		
		/**
		 * The absoulte path to the main plugin file.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $main_plugin_file;
		
		/**
		  * The plugin uri.
		  *
		  * @package WP Base\Controllers
		  * @var string
		  * @since 0.1
		  */
		protected $uri;
		
		/**
		 * The uri to the js assets.
		 * 
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $js_uri;
		
		/**
		 * The uri to the css assets.
		 * 
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $css_uri;
		
		/**
		 * The plugin text domain
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $txtdomain;
		
		/**
		 * The plugin css files
		 *
		 * An array containing css used by the controller.
		 *
		 * @package WP Base\Controllers
		 * @var array
		 * @since 0.1
		 */
		protected $css;
		
		/**
		 * The plugin admin css files
		 *
		 * An array containing css used by the controller on admin pages.
		 *
		 * @package WP Base\Controllers
		 * @var array
		 * @since 0.1
		 */
		protected $admin_css;
		
		/**
		 * The controller javascript files
		 *
		 * An array containing javascripts used by the controller.
		 *
		 * @package WP Base\Controllers
		 * @var array
		 * @since 0.1
		 */
		protected $scripts;
		
		/**
		 * The controller admin javascript files
		 *
		 * An array containing javascripts used by the controller on admin pages.
		 *
		 * @package WP Base\Controllers
		 * @var array
		 * @since 0.1
		 */
		protected $admin_scripts;
		
		/**
		 * Metaboxes required by the controller.
		 *
		 * @package WP Base\Controllers
		 * @var array Contains an array of WP_Base_Metabox objects
		 * @since 0.1
		 */
		protected $metaboxes;
		
		/**
		 * The plugin custom post types.
		 *
		 * @package WP Base\Controllers
		 * @var array Contains an array of cpt model objects
		 * @since 0.1
		 */
		protected $cpts;
		
		/**
		 * The plugin settings model.
		 * 
		 * @package WP Base\Controllers
		 * @var object
		 * @since 0.1
		 */
		protected $settings_model;
		
		/**
		 * The plugin help tabs.
		 *
		 * @package WP Base\Controllers
		 * @var array
		 * @since 0.1
		 */
		protected $help_tabs = array();
		
		/**
		 * The nonce name to be used for plugin form submissions.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $nonce_name;
		
		/**
		 * The nonce action to be used for plugin form submissions.
		 *
		 * @package WP Base\Controllers
		 * @var string
		 * @since 0.1
		 */
		protected $nonce_action;
		
		/**
		 * The class constructor
		 *
		 * Example when called from the main plugin file:
		 * <code>
		 * $my_plugin_controller = new Base_Controller_Plugin(
		 *		'my_plugin_slug',
		 *		'1.1.5',
		 *		plugin_dir_path( __FILE__ ),
		 *		__FILE__,
		 *		plugin_dir_uri( __FILE__ ),
		 *		'my_text_domain'
		 * }
		 * </code>
		 *
	 	 * @package WP Base\Controllers
	 	 *
	 	 * @param string $slug The plugin slug.
	 	 * @param string $version The plugin version.
		 * @param string $path The plugin directory path.
		 * @param string $file The main plugin file absolute path.
		 * @param string $uri The plugin directory uri.
		 * @param string $txtdomain The plugin text domain.
	 	 * @since 0.1
	 	 */
		public function __construct( $slug, $version, $path, $file, $uri, $txtdomain )
	 	{
	 		$this->slug = 			$slug;
	 		$this->version = 		$version;
	 		$this->main_plugin_file = 	$file;
	 		$this->path = 			trailingslashit( $path );
	 		$this->app_path = 		$this->path . 'app/';
	 		$this->app_controllers_path = 	$this->app_path . 'controllers/';
	 		$this->app_models_path = 	$this->app_path . 'models/';
	 		$this->app_views_path = 	$this->app_path . 'views/';
	 		$this->base_path = 		trailingslashit( dirname( dirname( __FILE__ ) ) );
	 		$this->base_controllers_path = 	$this->base_path . 'controllers/';
	 		$this->base_models_path = 	$this->base_path . 'models/';
	 		$this->base_views_path = 	$this->base_path . 'views/';
	 		$this->uri = 			trailingslashit( $uri );
	 		$this->js_uri = 		$this->uri . 'js/';
	 		$this->css_uri = 		$this->uri . 'css/';
	 		$this->txtdomain = 		$txtdomain;
	 		$this->init();
	 		
	 		//add default WP action callbacks
	 		add_action( 'init',		array( &$this, 'wp_init' ) );
	 		add_action( 'admin_menu', 	array( &$this, 'admin_menu' ) );
	 		add_action( 'admin_init', 	array( &$this, 'admin_init' ) );
	 		add_action( 'admin_notices',	array( &$this, 'admin_notice' ) );
	 		
	 		//register our post updated messages
	 		add_action( 'post_updated_messages', 	array( &$this, 'post_updated_messages' ), 5 );
	 		
	 		//load the plugin text domain
	 		add_action( 'plugins_loaded', 	array( &$this, 'plugins_loaded' ) );
	 		add_action( 'add_meta_boxes', 	array( &$this, 'add_meta_boxes' ) );
	 		
	 		//enqueue scripts and css
	 		add_action( 'admin_enqueue_scripts',	array( &$this, 'admin_enqueue_scripts' ) );
	 		add_action( 'wp_enqueue_scripts',	array( &$this, 'wp_enqueue_scripts' ) );
	 		
	 		//post actions
	 		add_action( 'the_post',			array( &$this, 'callback_the_post' ) );
	 		add_action( 'save_post', 		array( &$this, 'callback_save_post' ) );
	 		add_action( 'delete_post', 		array( &$this, 'callback_delete_post' ) );
	 		
	 		//register the page load callback
	 		add_action( "load-{$GLOBALS['pagenow']}", array( $this, 'load_admin_page' ), 10, 3 );
	 		
	 		//register our plugin activation/deactivation/delete callbacks
	 		register_activation_hook( $this->main_plugin_file,	array( &$this, 'activate_plugin' ) );
	 		register_deactivation_hook( $this->main_plugin_file,	array( &$this, 'deactivate_plugin' ) );
	 		register_uninstall_hook( $this->main_plugin_file,	array( 'Base_Controller_Plugin', 'delete_plugin' ) );
	 	}
		
		/**
		 * Initialize the controller
		 *
		 * Use this function to require files, add actions and filters, etc. that are specific to this plugin.
		 *
		 * @package WP Base\Controllers
		 * @abstract
		 * @since 0.1
		 */
		abstract public function init();

		/**
		 * The plugins loaded action callback.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public function plugins_loaded()
		{
			if( is_dir( $this->path . '/languages/' ) )
				load_plugin_textdomain( $this->txtdomain, false, $this->path . '/languages/' );
		}
		
		/**
		 * The WP init callback
		 *
		 * @package WP Base\Controllers
		 * @uses Base_Controller_Plugin::add_shortcodes()
		 * @since 0.1
		 */
		public function wp_init()
		{
			//register our cpts and any exposed shortcodes
			if ( isset( $this->cpts ) && is_array( $this->cpts ) ):
				foreach( $this->cpts as $cpt ):
					$cpt->register( $this->uri, $this->txtdomain );
					$this->add_shortcodes( $cpt->get_shortcodes() );
					
					//initialize the help screen tabs for the cpts
					$help_screen = $cpt->get_help_screen( $this->app_views_path, $this->txtdomain );
					if ( isset( $help_screen ) && is_array( $help_screen ) )
						$this->help_tabs[$cpt->get_slug()] = $help_screen;
				endforeach;
			endif;
		}
		
		/**
		 * The admin menu callback.
		 *
		 * This callback is used to register the menu pages.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public function admin_menu()
		{
			//register our settings pages
			if ( isset( $this->settings_model ) ):
				$this->add_menu_pages();
			endif;
		}
		
		/**
		 * Render admin notices for this screen.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public function admin_notice()
		{
			$screen = get_current_screen();
			
			if( isset ( $this->admin_notices[$screen->id] ) ):
				foreach( $this->admin_notices[$screen->id] as $notice ):
					echo $notice;
				endforeach;
			endif;
		}
		
		/**
		 * The WP admin_init callback.
		 *
		 * This function registers the options, settings sections, and settings fields.
		 (
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public function admin_init()
		{
			//register our settings, sections, and fields
			if ( isset( $this->settings_model ) ):
				$this->add_settings_sections();
				$this->add_settings_fields();
				$this->register_options();
			endif;
		}
		
		/**
		 * The WP load-{$page} action callback
		 *
		 * @package WP Models
		 * @since 0.1
		 */
		public function load_admin_page()
		{
			//determine the type of page we are on and if there are any help tabs defined for this page
			$screen = get_current_screen();

			if ( isset( $this->help_tabs[$screen->id] ) ):
				foreach( $this->help_tabs[$screen->id] as $tab ):
					$tab->add();
				endforeach;
			endif;
			
			if ( isset( $this->admin_js[$screen->id] ) ):
				foreach( $this->admin_js[$screen->id] as $script ):
					$script->enqueue();
				endforeach;
			endif;
			
			if ( isset( $this->admin_css[$screen->id] ) ):
				Helper_Functions::enqueue_styles( $this->admin_css[$screen->id] );
			endif;
		}
		
		/**
		 * Add meta boxes required by this plugin for the currently active post type
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public function add_meta_boxes()
		{
			global $post;
			
			if ( is_array( $this->metaboxes ) ):
				foreach( $this->metaboxes as $metabox ):
					$metabox->add();
				endforeach;
			endif;
			
			//register the cpt metaboxes
			if ( isset( $this->cpts[$post->post_type] ) ):
				$metaboxes = $this->cpts[$post->post_type]->get_metaboxes( $post->ID, $this->txtdomain );
				if ( is_array( $metaboxes ) ):
					foreach( $metaboxes as $metabox ):
						if( is_null( $metabox->get_callback() ) )
							$metabox->set_callback( array( &$this, 'render_metabox' ) );
						$metabox->add();
					endforeach;
				endif;
			endif;
		}
		
		/**
		 * Render a metabox.
		 *
		 * This function serves as the callback for a metabox.
		 *
		 * @package WP Base\Controllers
		 * @param object $post The WP post object.
		 * @param object $metabox The WP_Metabox object to be rendered.
		 * @todo move the filter into the add function
		 * @since 0.1
		 */
		public function render_metabox( $post, $metabox )
		{
			//get elements required for this particular view
			$metabox = apply_filters( 'filter_metabox_callback_args', $metabox, $post );
			
			//add the uri
			$metabox['args']['uri'] = $this->uri;
			
			//generate a nonce
			$nonce = wp_nonce_field( $this->nonce_action, $this->nonce_name, true, false );
			
			$txtdomain = $this->txtdomain;
			
			//require the appropriate view for this metabox
			require_once( $this->app_views_path . $metabox['args']['view'] );
		}
		
		/**
		 * Filter to ensure the CPT label is displayed when user updates the CPT
		 *
		 * @package WP Base\Controllers
		 * @param array $messages The existing messages array.
		 * @return array $messages The updated messages array.
		 * @since 0.1
		 */
		public function post_updated_messages( $messages )
		{
			global $post;
			
			if( is_array( $this->cpts ) ):
				foreach( $this->cpts as $cpt ):
					$messages[$cpt->get_slug()] = $cpt->get_post_updated_messages( $post, $this->txtdomain );
				endforeach;
			endif;
						
			return $messages;
		}
		
		/**
		 * Enqueue scripts and styles for admin pages
		 *
		 * @package WP Base\Controllers
		 * @param string $hook The WP page hook.
		 * @uses globalHelper_Functions::enqueue_styles() to enqueue the styles.
		 * @uses Helper_Functions::enqueue_scripts() to enqueue the scripts.
		 * @uses Base_Model_CPT::get_admin_css() to retrieve the CPT admin css.
		 * @uses Base_Model_CPT::get_admin_scripts() to retrieve the CPT admin scripts.
		 * @since 0.1
		 */
		public function admin_enqueue_scripts( $hook )
		{
			global $post;
			$screen = get_current_screen();
			
			//register the scripts
			if( isset( $this->admin_scripts ) ):
				foreach( $this->admin_scripts as $script ):
					$script->register();
				endforeach;
			endif;

			if( ( $hook == 'post.php' || $hook == 'edit.php' || $hook == 'post-new.php' ) ) {
				if ( isset( $this->cpts ) ) {
					foreach($this->cpts as $cpt){
						if( $cpt->get_slug() == $screen->post_type ) {
							//enqueue the admin css
							$css = $cpt->get_admin_css( $this->css_uri );
							if ( is_array( $css ) ) 
								Helper_Functions::enqueue_styles( $css );
							
							if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
								//enqueue the scripts on single post edit pages
								$scripts = $cpt->get_admin_scripts( $post, $this->txtdomain, $this->js_uri );
								if ( is_array( $scripts ) ){
									foreach( $scripts as $script ):
										$script->enqueue();
										$script->localize();
									endforeach;
								}
							}
							break;
						}
					}
				}
			}
		}
		
		/**
		 * Enqueue scripts and styles for frontend pages
		 *
		 * @package WP Base\Controllers
		 * @uses Helper_Functions::enqueue_styles()
		 * @uses Helper_Functions::enqueue_scripts()
		 * @uses Base_Model_CPT::get_css()
		 * @uses Base_Model_CPT::get_scripts()
		 * @since 0.1
		 */
		public function wp_enqueue_scripts()
		{
			global $post;
			 
			//add any global css
			if( is_array( $this->css ) ):
				Helper_Functions::enqueue_styles( $this->css, $this->css_uri );
			endif;
			
			//add the global javascripts
			if( isset( $this->js) && is_array( $this->js ) )
				Helper_Functions::enqueue_scripts( $this->js );
			
			//get our cpt scripts and css
			if ( isset ( $this->cpts ) ):
				foreach( $this->cpts as $cpt ):
					if( $cpt->get_slug() == $post->post_type ):
						//enqueue the cpt scripts
						$scripts = $cpt->get_scripts( $post, $this->txtdomain, $this->js_uri );						
						if ( is_array( $scripts ) )
							Helper_Functions::enqueue_scripts( $scripts );
															
						//enqueue the cpt css
						$css = $cpt->get_css( $this->css_uri );
						if ( is_array( $css ) )
							Helper_Functions::enqueue_styles( $css );
						break;
					endif;
				endforeach;
			endif;
		}
		
		/**
		 * WP the_post action callback.
		 *
		 * @package WP Models
		 * @param object $post The WP post object.
		 * @return object $post The modified post object.
		 * @since 0.1
		 */
		public function callback_the_post( $post )
		{
			switch( $post->post_type )
			{
				case 'post':
					if ( method_exists( $this, 'the_post' ) )
						$this->the_post( $post );
					break;
				case 'page':
					if ( method_exists( $this, 'the_page' ) )
						$this->the_page( $post );
					break;
				case 'attachment':
					if ( method_exists( $this, 'the_attachment' ) )
						$this->the_attachment( $post );
					break;
				default:
					if( isset( $this->cpts ) ):
						foreach($this->cpts as $cpt):
							if ( $cpt->get_slug() == $post->post_type && method_exists( $cpt, 'the_post' ) ):
								return $cpt->the_post( $post );
								break;
							endif;
						endforeach;
					endif;
					break;
			}
		}
		
		/**
		 * WP save_post action hook callback
		 *
		 * @package WP Base\Controllers
		 * @param string $post_id
		 * @since 0.1
		 */
		public function callback_save_post( $post_id )
		{
			global $post_type;
			
			// verify if this is an auto save routine. 
			// If it is our form has not been submitted, so we dont want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return;
				
			// We need to check if the current user is authorised to do this action. 
			if ( 'page' == $post_type ) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
					return;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
					return;
			}
			
			// Third we need to check if the user intended to change this value.
			if ( ! isset( $_POST[$this->nonce_name] ) || ! wp_verify_nonce( $_POST[$this->nonce_name], $this->nonce_action ) )
				return;
			
			//If we made it this far, we can save the POST data
			//decide the post type, and then call the appropriate save function
			switch( $post_type )
			{
				case 'post':
					if ( method_exists( $this, 'save_data_post' ) )
						$this->save_data_post( $post_id );
					break;
				case 'page':
					if ( method_exists( $this, 'save_data_page' ) )
						$this->save_data_page( $post_id );
					break;
				case 'attachment':
					if ( method_exists( $this, 'save_data_attachment' ) )
						$this->save_data_attachment( $post_id );
					break;
				default:
					if( isset( $this->cpts ) ):
						foreach($this->cpts as $cpt):
							if ( $cpt->get_slug() ==  $post_type && method_exists( $cpt, 'save' ) ):
								$cpt->save( $_POST );
								break;
							endif;
						endforeach;
					endif;
					break;
			}
		}
		
		/**
		 * WP delete_post action hook callback
		 *
		 * @package WP Base\Controllers
		 * @param string $post_id
		 * @since 0.1
		 */
		public function callback_delete_post( $post_id )
		{	
			global $post_type;
			
			// We need to check if the current user is authorised to do this action. 
			if ( ! current_user_can( 'delete_post', $post_id ) )
					return;
			
			//If we made it this far, we can delete the post
			//decide the post type, and then call the appropriate delete function
			switch( $post_type )
			{
				case 'post':
					if ( method_exists( $this, 'delete_data_post' ) )
						$this->delete_data_post( $post_id );
					break;
				case 'page':
					if ( method_exists( $this, 'delete_data_page' ) )
						$this->delete_data_page( $post_id );
					break;
				case 'attachment':
					if ( method_exists( $this, 'delete_data_attachment' ) )
						$this->delete_data_attachment( $post_id );
					break;
				default:
					if( isset( $this->cpts ) ):
						foreach($this->cpts as $cpt):
							if ( $cpt->get_slug() ==  $post->post_type && method_exists( $cpt, 'save' ) ):
								$cpt->delete( $_POST );
								break;
							endif;
						endforeach;
					endif;
					break;
			}
		}
		
		/**
		 * The plugin activation callback.
		 *
		 * This function performs tasks at plugin activation such as table creation, settings initialization, permalinks updates, etc.
		 * It currently initiiates a permalinks update. If you have additional activities, add the function activate() to your child class.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public function activate_plugin()
		{
			if ( is_array( $this->cpts ) ):
				foreach( $this->cpts as $cpt ):
					if( method_exists( $cpt, 'activate' ) )
						$cpt->activate();
					$cpt->register( $this->uri, $this->txtdomain );
				endforeach;
				
				//update the permalinks
				flush_rewrite_rules();
			endif;
			
			
			if ( function_exists( 'get_called_class' ) ):
				$called_class = get_called_class();
				if ( method_exists( $called_class, 'activate' ) )
					$called_class::activate();
			endif;
			
			if( isset( $this->settings_model ) && method_exists( $this->settings_model, 'activate' ) )
				$this->settings_model->activate();
		}
		
		/**
		 * The plugin deactivation callback.
		 *
		 * Use this function to perform tasks at plugin deactivation. If you have additional activities, add the function deactivate() to your child class.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public function deactivate_plugin()
		{
			if ( is_array( $this->cpts ) ):
				foreach( $this->cpts as $cpt ):
					if ( method_exists( $cpt, 'deactivate' ) )
						$cpt->deactivate();
				endforeach;
			endif;
			
			if ( function_exists( 'get_called_class' ) ):
				$called_class = get_called_class();
				if ( method_exists( $called_class, 'deactivate' ) )
					$called_class->deactivate();
			endif;
			
			flush_rewrite_rules();
		}
		
		/**
		 * The plugin deletion callback.
		 *
		 * Use this function to perform tasks at plugin deletion, such as drop tables, remove settings, etc.
		 * If you have additional activities, add the function delete() to your child class.
		 *
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		public static function delete_plugin()
		{	
			if ( function_exists( get_called_class ) ):
				$called_class = get_called_class();
				if ( method_exists( $called_class, 'delete' ) )
					$called_class::delete();
			endif;
		}
		
		/**
		 * Register shortcodes.
		 *
		 * @package WP Base\Controllers
		 * @param array $shortcodes
		 * @since 0.1
		 */
		private function add_shortcodes( $shortcodes )
		{
			if ( is_array( $shortcodes ) ):
				foreach( $shortcodes as $key => $callback ):
					add_shortcode( $key, $callback );
				endforeach;
			endif;
		}
		
		/**
		 * Register options.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		protected function register_options()
		{
			$options = $this->settings_model->get_options();
			
			if( is_array( $options ) ):
				foreach( $options as $option ):
					if ( is_null( $option['callback'] ) )
						$option['callback'] = array( $this->settings_model, 'sanitize_input' );
					
					register_setting( $option['option_group'], $option['option_name'], $option['callback'] );
				endforeach;
			endif;
		}
		
		/**
		 * Add the settings sections.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		protected function add_settings_sections()
		{
			$sections = $this->settings_model->get_settings_sections();
			
			if( is_array( $sections ) ):
				foreach( $sections as $key => $section ):
					if ( is_null( $section['callback'] ) )
						$section['callback'] = array( &$this, 'render_settings_section' );
					
					$section['callback'] = apply_filters( 'ah_filter_settings_section_callback' . $key, $section['callback'] );
					
					add_settings_section( $key, $section['title'], $section['callback'], $section['page'] );
				endforeach;
			endif;
		}
		
		/**
		 * Add the settings fields.
		 *
		 * @package WP Base\Controllers
		 * @since 0.1
		 */
		protected function add_settings_fields()
		{
			$fields = apply_filters( 'ah_filter_settings_fields', $this->settings_model->get_settings_fields() );
			
			if( is_array( $fields ) ):
				foreach( $fields as $key => $field ):
					if ( is_null( $field['callback'] ) )
						$field['callback'] = array( &$this, 'render_settings_field' );
						
					$field = apply_filters( 'ah_filter_settings_field-' . $key, $field );
					
					if ( ! is_null( $field ) )
						add_settings_field( $key, $field['title'], $field['callback'], $field['page'], $field['section'], $field['args'] );
				endforeach;
			endif;
		}
		
		/**
		 * Add the options pages.
		 *
		 * @package WP Base\Controllers
		 * @link http://codex.wordpress.org/Function_Reference/add_menu_page
		 * @link http://codex.wordpress.org/Function_Reference/add_submenu_page
		 * @since 0.1
		 */		
		protected function add_menu_pages()
		{
			$menu_pages = apply_filters( 'ah_filter_settings_pages', $this->settings_model->get_pages() );
			
			if ( is_array( $menu_pages ) ):
				foreach( $menu_pages as $key => &$page ):
					//set the callback if necessary
					if( ! isset( $page['callback'] ) )
						$page['callback'] = array( &$this, 'render_options_page' );
					
					$page['callback'] = apply_filters( 'ah_filter_menu_page_callback' . $key, $page['callback'] );
					
					if( ! isset( $page['parent_slug'] ) ):
						$page['hook_suffix'] = add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
					else:
						$page['hook_suffix'] = add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
					endif;
					
					//update the page element with these new properites
					$this->settings_model->edit_page( $key, $page);
					
					//set up the help tab
					if( isset( $page['help_screen'] ) && is_array( $page['help_screen'] ) )
						$this->help_tabs[$page['hook_suffix']] = $page['help_screen'];
						add_action( "load-{$page['hook_suffix']}", array( &$this, 'load_admin_page' ) );
						
					//add necessary js
					if ( isset( $page['js'] ) && is_array( $page['js'] ) )
						$this->admin_js[$page['hook_suffix']] = $page['js'];
						add_action( "load-{$page['hook_suffix']}", array( &$this, 'load_admin_page' ) );
					
					//add css
					if ( isset( $page['css'] ) && is_array( $page['css'] ) )
						$this->admin_css[$page['hook_suffix']] = $page['css'];
						add_action( "load-{$page['hook_suffix']}", array( &$this, 'load_admin_page' ) );
							
					if ( isset( $page['admin_notices'] ) && is_array( $page['admin_notices'] ) )
						$this->admin_notices[$page['hook_suffix']] = $page['admin_notices'];
						add_action( "admin_notices", array( &$this, 'admin_notice' ) );
				endforeach;
			endif;
		}
		
		/**
		 * Render an options page.
		 *
		 * Thuis function can be used as a generic callback for the WP add_x_page() function.
		 * @package WP Base\Controllers
		 * @link http://codex.wordpress.org/Function_Reference/add_menu_page
		 * @link http://codex.wordpress.org/Function_Reference/add_submenu_page
		 * @link http://codex.wordpress.org/Function_Reference/add_options_page
		 * @since 0.1
		 */
		public function render_options_page()
		{
			$pages = $this->settings_model->get_pages();
			$page = $pages[$_REQUEST['page']];
			$options = $this->settings_model->get_options();
			
			if ( isset( $page['view'] ) && file_exists( trailingslashit( $this->app_views_path ) . $page['view'] ) ):
				$view = trailingslashit( $this->app_views_path ) . $page['view'];
			else:
				$view = trailingslashit( $this->base_views_path ) . 'base_options_page.php';
			endif;
			
			require_once( $view );
		}
		
		/**
		 * Render a settings section.
		 *
		 * This function can be used as a generic callback for add_settings_sections().
		 *
		 * @package WP Base\Controllers
		 * @param object $section The section object.
		 * @link http://codex.wordpress.org/Function_Reference/add_settings_section
		 * @since 0.1
		 */
		public function render_settings_section( $section )
		{
			//get the corresponding section
			$setting_section = $this->settings_model->get_settings_sections( $section['id'] );
		
			if( $setting_section ):
				$filename = trailingslashit( $this->app_views_path ) . $section['id'] . '.php';
				
				if ( file_exists( $filename ) ):
					require_once( $filename );
				else:
					require_once( trailingslashit( $this->base_views_path ) . 'base_settings_section.php' );
				endif;
			endif;
		}
		
		/**
		 * A generic add_settings_field() callback function.
		 *
		 * @package WP Base\Controllers
		 * @param array $args The settings field arguments.
		 * @since 0.1
		 */
		public function render_settings_field( $args )
		{
			switch( $args['type'] )
			{
				case 'checkbox':
					$this->render_input_checkbox( $args );
					break;
				case 'select':
					$this->render_input_select( $args );
					break;
				case 'text':
					$this->render_input_text( $args );
					break;
				case 'textarea':
					$this->render_input_textarea( $args );
					break;
				case 'hidden':
					$this->render_input_hidden( $args );
					break;
			}
		}
		
		/**
		 * Render a checkbox input field.
		 *
		 * @package WP Base\Controllers
		 * @param array $args The field arguments.
		 * @since 0.1
		 */
		private function render_input_checkbox( $args )
		{
			printf( '<input type="checkbox" id="%1$s" name="%2$s" value="1" %3$s/>',
				$args['id'],
				$args['name'],
				true == $args['value'] ? 'checked ' : ''
			);
		}
		
		/**
		 * Render a text input field.
		 *
		 * @package WP Base\Controllers
		 * @param array $args The field arguments.
		 * @since 0.1
		 */
		private function render_input_text( $args )
		{
			$txtdomain = $this->txtdomain;
			
			if( isset ( $args['after'] ) && is_file( $args['after'] ) ):
				ob_start();
				require_once($args['after'] );
				$args['after'] = ob_get_clean();
			endif;
			
			printf( '<input type="text" id="%1$s" name="%2$s" value="%3$s" %4$s />%5$s',
				$args['id'],
				$args['name'],
				$args['value'],
				isset( $args['placeholder'] ) ? "placeholder='{$args['placeholder']}'" : '',
				isset( $args['after'] ) ? $args['after'] : ''
			);
		}
		
		/**
		 * Render a hidden input field.
		 *
		 * @package WP Base\Controllers
		 * @param array $args The field arguments.
		 * @since 0.1
		 */
		private function render_input_hidden( $args )
		{
			printf( '<input type="hidden" id="%1$s" name="%2$s" value="%3$s" />',
				$args['id'],
				$args['name'],
				$args['value']
			);
		}
		
		/**
		 * Render a select input field.
		 *
		 * @package WP Base\Controllers
		 * @param array $args The field arguments.
		 * @since 0.1
		 */
		private function render_input_select( $args )
		{
			printf( '<select id="%1$s" name="%2$s">%3$s</select>',
				$args['id'],
				$args['name'],
				$this->render_input_select_options( $args['options'], $args['value'] )
			);
		}
		
		/**
		 * Render a select input field options block.
		 *
		 * @package WP Base\Controllers
		 * @param array $options A key/value pair of values and option display strings.
		 * @param string $current_value The current value for this option field.
		 * @since 0.1
		 */
		private function render_input_select_options( $options, $current_value )
		{	
			$html = sprintf( '<option value="">Select…</option>',
				_x( 'Select…', 'Select an option', $this->txtdomain ) );
			
			if( is_array( $options ) ):
				foreach( $options as $key => $val ):
					$html .= sprintf ( '<option value="%1$s" %2$s>%3$s</option>', 
						$key,
						$current_value == $key ? 'selected' : '',
						$val
					);
				endforeach;
			endif;
			
			return $html;
		}
		
		/**
		 * Get the main plugin file.
		 *
		 * @package WP Base\Controllers
		 * @return string The absolute path to the main plugin file.
		 * @since 0.1
		 */
		public function main_plugin_file()
		{
			return $this->main_plugin_file;
		}
		
		/**
		 * Get the plugin version.
		 *
		 * @package WP Base\Controllers
		 * @return string The plugin version.
		 * @since 0.1
		 */
		public function get_version()
		{
			return $this->version;
		}
	}
endif;
?>
