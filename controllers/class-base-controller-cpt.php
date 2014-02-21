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
require_once 'class-base-controller.php';

if ( ! class_exists( 'Base_Controller_CPT' ) && class_exists( 'Base_Controller' ) ) :
	/**
	 * The base custom post type controller.
	 *
	 * @package WPMVCBase\Controllers
	 * @version 0.2
	 * @since   WPMVCBase 0.2
	 */
	class Base_Controller_CPT extends Base_Controller
	{
		/**
		 * The attached custom post type models.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $_cpt_models;
		
		/**
		 * The class constructor.
		 *
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct()
		{	
			parent::__construct();
			
			add_action( 'init',                  array( &$this, 'register' ) );
			add_filter( 'post_updated_messages', array( &$this, 'post_updated_messages' ) );
		}

		/**
		 * Add a cpt model to this controller.
		 *
		 * @param  Base_Model_CPT         $model The Base_Model_CPT for this controller.
		 * @return array          $_cpt_models
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function add_model( Base_Model_Cpt $model )
		{	
			$this->_cpt_models[ $model->get_slug() ] = $model;
			
			//register a save_post action
			if ( method_exists( $model, 'save_post' ) ) {
				add_action( 'save_post', array( &$model, 'save_post' ) );
			}
			
			//register the help tabs
			$tabs = $model->get_help_tabs();
			
			if ( isset( $tabs ) && is_array( $tabs ) ) {
				foreach( $tabs as $tab ) {
					//get the screens on which to load the help tab
					$screens = $tab->get_screens();
					if ( isset( $screens ) && is_array( $screens ) ) {
						//register the help tab for each screen
						foreach( $screens as $screen ) {
							add_action ( $screen, array( &$this, 'render_help_tabs' ) );
						}
					}
				}
			}
			
			return $this->_cpt_models;
		}

		/**
		 * Register this post type.
		 *
		 * @return array An array containing the registered post type objects on success, WP_Error object on failure
		 * @access public
		 * @since  WPMVCBase 0.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		public function register()
		{
			if ( isset( $this->_cpt_models ) ) {
				foreach ( $this->_cpt_models as $cpt ) {
					$return[ $cpt->get_slug() ] = register_post_type( $cpt->get_slug(), $cpt->get_args() );
				}
			}
			return $return;
		}

		/**
		 * Filter to ensure the CPT labels are displayed when user updates the CPT
		 *
		 * @param    array $messages The existing messages array.
		 * @return   array $messages The updated messages array.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @link     http://codex.wordpress.org/Plugin_API/Filter_Reference
		 */
		public function post_updated_messages( $messages )
		{
			global $post;
			
			if ( isset( $this->_cpt_models ) ) {
				foreach ( $this->_cpt_models as $cpt ) {
					$messages[ $cpt->get_slug() ] = array(
						0 => null, // Unused. Messages start at index 1.
						1 => sprintf(
							__( '%1$s updated. <a href="%3$s">View %2$s</a>', $this->_txtdomain ),
							$cpt->get_singular(),
							strtolower( $cpt->get_singular() ),
							esc_url( get_permalink( $post->ID ) )
						),
						2 => __( 'Custom field updated.', $this->_txtdomain ),
						3 => __( 'Custom field deleted.', $this->_txtdomain ),
						4 => sprintf( __( '%s updated.', $this->_txtdomain ), $cpt->get_singular() ),
						/* translators: %2$s: date and time of the revision */
						5 => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %s', $this->_txtdomain ), $cpt->get_singular(), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
						6 => sprintf( __( '%s published. <a href="%s">View book</a>', $this->_txtdomain ), $cpt->get_singular(), esc_url( get_permalink( $post->ID ) ) ),
						7 => sprintf( __( '%s saved.', $this->_txtdomain ), $cpt->get_singular() ),
						8 => sprintf(
							__( '%1$s submitted. <a target="_blank" href="%3$s">Preview %2$s</a>', $this->_txtdomain ),
							$cpt->get_singular(),
							strtolower( $cpt->get_singular() ),
							esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
						),
						9 => sprintf(
							__( '%3$s scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview %4$s</a>', $this->_txtdomain ),
							// translators: Publish box date format, see http://php.net/date
							date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ),
							esc_url( get_permalink( $post->ID ) ),
							$cpt->get_singular(),
							strtolower( $cpt->get_singular() )
						),
						10 => sprintf(
							__( '%1$s draft updated. <a target="_blank" href="%3$s">Preview %2$s</a>', $this->_txtdomain ),
							$cpt->get_singular(),
							strtolower( $cpt->get_singular() ),
							esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
						)
					);
				}
			}

			return $messages;
		}
		
		/**
		 * Add the metaboxes necessary for the custom post types.
		 *
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function add_meta_boxes()
		{
			global $post;
			
			if ( isset( $this->_cpt_models ) && is_array( $this->_cpt_models ) ) {
				foreach ( $this->_cpt_models as $cpt ) {
					if ( $metaboxes = $cpt->get_metaboxes( $post, $this->_txtdomain ) ) {
						parent::add_meta_boxes( $metaboxes );
					}
				}
			}
		}
		
		/**
		 * The admin_enqueue_scripts_callback.
		 *
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function admin_enqueue_scripts()
		{
			foreach( $this->_cpt_models as $cpt ) {
				$scripts = $cpt->get_admin_scripts();
				
				if ( isset( $scripts ) && is_array( $scripts ) ) {
					foreach( $scripts as $script ) {
						wp_register_script(
							$script->get_handle(),
							$script->get_src(),
							$script->get_deps(),
							$script->get_ver(),
							$script->get_in_footer()
						);
					}
				}
			}
		}
		
		/**
		 * The wp_enqueue_scripts_callback.
		 *
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function wp_enqueue_scripts()
		{
			foreach( $this->_cpt_models as $cpt ) {
				$scripts = $cpt->get_scripts();
				
				if ( isset( $scripts ) && is_array( $scripts ) ) {
					foreach( $scripts as $script ) {
						wp_register_script(
							$script->get_handle(),
							$script->get_src(),
							$script->get_deps(),
							$script->get_ver(),
							$script->get_in_footer()
						);
					}
				}
			}
		}
		
		/**
		 * Render the help tabs for the attached cpts
		 *
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function render_help_tabs()
		{
			$screen = get_current_screen();
			
			foreach( $this->_cpt_models as $cpt ) {
				if ( $screen->post_type == $cpt->get_slug() ) {
					$tabs = $cpt->get_help_tabs();
					
					if ( isset( $tabs ) && is_array( $tabs ) ) {
						foreach( $tabs as $tab ) {
							parent::render_help_tab( $tab );
						}
					}
				}
			}
		}
	}
endif;
