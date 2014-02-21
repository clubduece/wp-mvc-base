<?php
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

if ( ! class_exists( 'Base_Controller' ) ):
	/**
	 * The base controller.
	 *
	 * @package  WPMVCBase\Controllers
	 * @abstract
	 * @version  0.2
	 * @since WPMVCBase 0.2
	 */
	class Base_Controller
	{
		/**
		 * The absolute path to the main plugin file. Ends with a slash.
		 * 
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $_main_plugin_file;
		
		/**
		 * The absolute path to the plugin app path. Ends with a slash.
		 * 
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $_app_path;
		
		/**
		 * The absolute path to the WPMVC Base path. Ends with a slash.
		 * 
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $_base_path;
		
		/**
		 * The uri to the plugin directory. Ends with a slash.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $_uri;
		
		/**
		 * The plugin text domain.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $_txtdomain;
		
		/**
		 * The class constructor
		 *
		 * @access protected
		 * @since WPMVCBase 0.1
		 */
		public function __construct()
		{	
			add_action( 'wp_enqueue_scripts',    array( &$this, 'wp_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
			add_action( 'add_meta_boxes',        array( &$this, 'add_meta_boxes' ) );
		}
		
		/**
		 * Add shortcodes to WP.
		 *
		 * @param  array $shortcodes
		 * @return WP_Error|null
		 * @since  WPMVCBase 0.1
		 */
		public function add_shortcodes( array $shortcodes )
		{
			if ( ! is_array( $shortcodes ) ) {
				return new WP_Error(
					'non-array',
					sprintf( __( '%s::%s expects an array', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
					$shortcodes
				);
			}
			
			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( $key, $shortcode );
			}
		}

		/**
		 * The WP add_meta_boxes action callback
		 *
		 * @param    array $metaboxes Array containing Base_Model_Metabox objects.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @see      Base_Model_Metabox
		 */
		public function add_meta_boxes( array $metaboxes )
		{
			global $post;

			foreach ( $metaboxes as $metabox ) {
				foreach( $metabox->get_post_types() as $post_type ) {
					add_meta_box( 
						$metabox->get_id(),
						$metabox->get_title(),
						is_callable( $metabox->get_callback() ) ? $metabox->get_callback() : array( &$this, 'render_metabox' ),
						$post_type,
						$metabox->get_context(),
						$metabox->get_priority(),
						$metabox->get_callback_args()
					);
				}
			}
		}
		
		/**
		 * Enqueue scripts.
		 *
		 * @param  array $scripts Array containing Base_Model_JS objects
		 * @return WP_Error|null WP_Error object on failure.
		 * @since  WPMVCBase 0.3
		 */
		public function enqueue_scripts( array $scripts )
		{
			
			if ( ! is_array( $scripts ) ) {
				return new WP_Error(
					'non-array',
					sprintf( __( '%s::%s expects an array', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
					$scripts
				);
			}
			
			foreach ( $scripts as $key => $script ) {
				if( is_a( $script, 'Base_Model_JS_Object' ) ) {
					wp_enqueue_script(
						$script->get_handle(),
						$script->get_src(),
						$script->get_deps(),
						$script->get_ver(),
						$script->get_in_footer()
					);
				}
				
				if( ! is_a( $script, 'Base_Model_JS_Object' ) ) {
					if( ! isset( $wp_error ) ) {
						$wp_error = new WP_Error();
					}
					
					$wp_error->add(
						'invalid object type',
						sprintf( __( '%s is not a Base_Model_JS_Object', 'wpmvcbase' ), $key ),
						$script
					);
				}
			}
			
			//return the error object for invalid script types
			if( isset( $wp_error ) ) {
				return $wp_error;
			}
		}
		
		/**
		 * Render a metabox.
		 *
		 * This function serves as the callback for a metabox.
		 *
		 * @param    object $post The WP post object.
		 * @param    object $metabox The WP_Metabox object to be rendered.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @todo     move the filter into the add function
		 */
		public function render_metabox( WP_Post $post, $metabox )
		{
			//Is a view file specified for this metabox?
			if ( isset( $metabox['args']['view'] ) ) {
				if ( file_exists( $metabox['args']['view'] ) ) {
				
					//include view for this metabox
					include $metabox['args']['view'];
					return;
				}
				
				if ( file_exists( $this->_app_path . 'views/' . $metabox['args']['view'] ) ) {
					include $this->_app_path . 'views/' . $metabox['args']['view'];
					return;
				}
				
				if ( ! file_exists( $metabox['args']['view'] ) ) {
					printf(
						__( 'The view file %s for metabox id %s does not exist', 'wpmvcb' ),
						$metabox['args']['view'],
						$metabox['id']
					);
					return;
				}
			}
			
			if ( ! isset( $metabox['args']['view'] ) ) {
				printf(
					__( 'No view specified in the callback arguments for metabox id %s', 'wpmvcb' ),
					$metabox['id']
				);
				return;
			}
		}
		
		/**
		 * Render a help tab.
		 *
		 * @param object Base_Model_Help_Tab
		 * access public
		 * @since 1.0
		 */
		public function render_help_tab( Base_Model_Help_Tab $tab )
		{
			$screen = get_current_screen();
			
			$screen->add_help_tab( 
				array( 
					'id'      => $tab->get_id(),
					'title'   => $tab->get_title(),
					'content' => $tab->get_content()
				)
			);
		}
	}
endif;
