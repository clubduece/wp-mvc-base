<?php
/**
 * The base plugin controller.
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @since WPMVCBase 0.1
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

include_once 'class-base-controller.php';

if ( ! class_exists( 'Base_Controller_Plugin' ) ) {
	/**
	 * The base plugin controller.
	 *
	 * @package WPMVCBase\Controllers
	 * @abstract
	 * @version 0.2
	 * @since WP_Base 0.1
	 */
	abstract class Base_Controller_Plugin extends Base_Controller
	{
		/**
		 * The plugin model.
		 *
		 * @var object
		 * @since 0.2
		 */
		protected $plugin_model;

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
		 * @category Controllers
		 * @package WPMVCBase
		 *
		 * @param object $model The plugin model.
		 * @access public
		 * @since 0.1
		 */
		public function __construct( $model )
		{
			if ( ! is_a( $model, 'Base_Model_Plugin' ) ) {
				trigger_error(
					sprintf( __( '%s expects an instance of Base_Model_Plugin', 'wpmvcb' ), __FUNCTION__ ),
					E_USER_WARNING
				);
			}
			
			parent::__construct(
				$model->get_main_plugin_file(),
				$model->get_app_path(),
				$model->get_base_path(),
				$model->get_uri(),
				$model->get_textdomain()
			);
			
			$this->plugin_model = $model;
			
			add_action( 'plugins_loaded',        array( &$this, 'load_text_domain' ) );
			add_action( 'admin_notices',         array( &$this, 'admin_notice' ) );
			
			if ( method_exists( $this, 'init' ) ) {
				$this->init();
			}
			
			$this->init_help_tabs();
		}

		/**
		 * Load the plugin text domain.
		 *
		 * @internal
		 * @access public
		 * @since 0.1
		 */
		public function load_text_domain()
		{
			if ( is_dir( $this->plugin_model->get_path() . '/languages/' ) ) {
				load_plugin_textdomain( $this->txtdomain, false, $this->path . '/languages/' );
			}
		}

		/**
		 * Render admin notices for this screen.
		 *
		 * @internal
		 * @access public
		 * @since 0.1
		 */
		public function admin_notice()
		{
			$screen = get_current_screen();

			if ( isset ( $this->admin_notices[ $screen->id ] ) ) {
				foreach ( $this->admin_notices[ $screen->id ] as $notice ) {
					echo $notice;
				}
			}
		}

		/**
		 * The WP load-{$page} action callback
		 *
		 * @package WP Models
		 * @internal
		 * @access public
		 * @since 0.1
		 */
		public function load_admin_page()
		{
			//determine the page we are on
			$screen = get_current_screen();

			//are there help tabs for this screen?
			if ( isset( $this->help_tabs[ $screen->id ] ) ) {
				foreach ( $this->help_tabs[ $screen->id ] as $tab ) {
					$tab->add();
				}
			}

			//are there javascripts registered for this screen?
			if ( isset( $this->admin_js[ $screen->id ] ) ) {
				foreach ( $this->admin_js[ $screen->id ] as $script ) {
					$script->enqueue();
					$script->localize();
				}
			}

			//are there styles registered for this screen?
			if ( isset( $this->admin_css[ $screen->id ] ) ):
				Helper_Functions::enqueue_styles( $this->admin_css[ $screen->id ] );
			endif;
		}

		/**
		 * Enqueue scripts and styles for admin pages
		 *
		 * @param string $hook The WP page hook.
		 * @uses globalHelper_Functions::enqueue_styles() to enqueue the styles.
		 * @uses Helper_Functions::enqueue_scripts() to enqueue the scripts.
		 * @uses Base_Model_Plugin::get_admin_css() to retrieve the admin css.
		 * @uses Base_Model_Plugin::get_admin_scripts() to retrieve the admin scripts.
		 * @internal
		 * @access public
		 * @since 0.1
		 * @todo modify this function to enqueue scripts based on wp_screen object
		 */
		public function admin_enqueue_scripts( $hook )
		{
			global $post;
			$screen = get_current_screen();

			//register the scripts
			$scripts = $this->plugin_model->get_admin_scripts();
			
			if ( isset( $scripts ) && is_array( $scripts ) ) {
				foreach ( $scripts as $script ) {
					wp_enqueue_script(
						$script->get_handle(),
						$script->get_src(),
						$script->get_deps(),
						$script->get_version(),
						$script->get_in_footer()
					);
				}
			}
		}

		/**
		 * Enqueue scripts and styles for frontend pages
		 *
		 * @uses Base_Model_Plugin::get_scripts()
		 * @uses Base_Contoller::enqueue_scripts()
		 * @internal
		 * @access public
		 * @since 0.1
		 */
		public function wp_enqueue_scripts()
		{
			//add the global javascripts
			$scripts = $this->plugin_model->get_scripts();
			
			if ( isset( $scripts ) && is_array( $scripts ) ) {
				parent::enqueue_scripts( $scripts );
			}
		}
		
		/**
		 * Add metaboxes for the plugin model
		 *
		 * @uses Base_Model_plugin::get_metaboxes
		 * @uses Base_Controller::add_metaboxes
		 * @internal
		 * @since WPMVCBase 0.3
		 */
		public function add_meta_boxes()
		{
			global $post;
			
			$metaboxes = $this->plugin_model->get_metaboxes( $post );
			
			if ( is_array( $metaboxes ) ) {
				parent::add_meta_boxes( $metaboxes );
			}
		}
		
		/**
		 * Hook actions for the help tabs for the plugin model.
		 *
		 * @uses Base_Model_Plugin::get_help_tabs
		 * @uses Base_Model_Help_Tab::get_screens
		 * @since WPMVCBase 0.3
		 */
		protected function init_help_tabs()
		{
			// Get the help tabs defined for the plugin model
			$tabs = $this->plugin_model->get_help_tabs();
			
			if ( isset( $tabs ) && is_array( $tabs ) ) {
				foreach( $tabs as $tab ) {
					//get the screens on which to display this tab
					$screens = $tab->get_screens();
					foreach( $screens as $screen ) {
						add_action( $screen, array( &$this, 'render_help_tabs' ) );
					}
				}
			}
		}
		
		/**
		 * Render the help tabs for the plugin model.
		 *
		 * @uses Base_Model_Plugin::get_help_tabs
		 * @uses Base_Controller_Plugin::render_help_tab
		 * @since WPMVCBase 1.0
		 */
		public function render_help_tabs()
		{
			$tabs   = $this->plugin_model->get_help_tabs();
			$screen = get_current_screen();
			
			foreach( $tabs as $tab ) {
				if ( in_array( $screen->post_type, $tab->get_post_types() ) ) {
					parent::render_help_tab( $tab );
				}
			}
		}
	}
}	// ! class_exists( 'Base_Controller_Plugin' )
