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

if ( ! class_exists( 'Base_Controller_Settings' ) ) {
	include_once 'class-base-controller.php';

	/**
	 * The base settings controller class.
	 *
	 * @package WPMVCBase\Controllers
	 * @version 0.2
	 * @since   WPMVCBase 0.2
	 */
	class Base_Controller_Settings extends Base_Controller
	{
		/**
		 * The settings model.
		 *
		 * @var   object Base_Settings_Model
		 * @since WPMVCBase 0.2
		 */
		protected $model;

		/**
		 * The class constructor.
		 *
		 * @param  Base_Model_Settings $model The Base_Model_Settings object.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function __construct( Base_Model_Settings $model )
		{
			$this->model = $model;

			if ( is_array( $this->model->get_settings_sections() ) ) {
				add_action( 'admin_init', array( &$this, 'add_settings_sections' ) );
			}

			if ( is_array( $this->model->get_settings_fields() ) ) {
				add_action( 'admin_init', array( &$this, 'add_settings_fields' ) );
			}

			if ( is_array( $this->model->get_options() ) ) {
				add_action( 'admin_init', array( &$this, 'register_options' ) );
			}

			if ( is_array( $this->model->get_pages() ) ) {
				add_action( 'admin_menu', array( &$this, 'add_menu_pages' ) );
			}
		}

		/**
		 * Register options.
		 *
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.2
		 */
		public function register_options()
		{
			$options = $this->model->get_options();

			if ( is_array( $options ) ) {
				foreach ( $options as $option ) {
					if ( is_null( $option['callback'] ) ) {
						$option['callback'] = array( $this->model, 'sanitize_input' );
					}
					register_setting( $option['option_group'], $option['option_name'], $option['callback'] );
				}
			}
		}

		/**
		 * Add the menu pages.
		 *
		 * @return   bool|object TRUE on success, WP_Error on failure.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @link     http://codex.wordpress.org/Function_Reference/add_menu_page
		 * @link     http://codex.wordpress.org/Function_Reference/add_submenu_page
		 */
		public function add_menu_pages()
		{
			$menu_pages = apply_filters( 'ah_filter_settings_pages', $this->model->get_pages() );

			if ( is_array( $menu_pages ) ) {
				foreach ( $menu_pages as $key => $page ) {
					if ( is_a( $page, 'Base_Model_Menu_Page' ) ) {
						if ( ! $page->get_callback() ) {
							$page->set_callback( array( $this, 'render_options_page' ) );
						}
						
						$result = $page->add();
						
						if ( false == $result ) {
							if ( !isset( $wp_error ) ) {
								$wp_error = new WP_Error();
							}
							
							$wp_error->add(
								'failure',
								sprintf( __( 'Unable to add submenu page: %s.', $this->txtdomain ), $key ),
								$page
							);
						}
					}
										
					//update the page element with these new properites
					$this->model->edit_page( $key, $page );
				} // end foreach
				if ( isset( $wp_error ) ) {
					return $wp_error;
				}
			} // end if
			
			return true;
		}

		/**
		 * Add the settings sections.
		 *
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 */
		public function add_settings_sections()
		{
			$sections = $this->model->get_settings_sections();

			if ( is_array( $sections ) ) {
				foreach ( $sections as $key => $section ) {
					if ( is_null( $section['callback'] ) ) {
						$section['callback'] = array( &$this, 'render_settings_section' );
					}

					$section['callback'] = apply_filters( 'ah_filter_settings_section_callback' . $key, $section['callback'] );

					add_settings_section( $key, $section['title'], $section['callback'], $section['page'] );
				}
			}
		}

		/**
		 * Add the settings fields.
		 *
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 */
		public function add_settings_fields()
		{
			$fields = apply_filters( 'ah_filter_settings_fields', $this->model->get_settings_fields() );

			if ( is_array( $fields ) ) {
				foreach ( $fields as $key => $field ) {
					if ( is_null( $field['callback'] ) ) {
						$field['callback'] = array( &$this, 'render_settings_field' );
					}

					$field = apply_filters( 'ah_filter_settings_field-' . $key, $field );

					if ( ! is_null( $field ) ) {
						add_settings_field( $key, $field['title'], $field['callback'], $field['page'], $field['section'], $field['args'] );
					}
				}
			}
		}

		/**
		 * Render an options page.
		 *
		 * This function can be used as a generic callback for the WP add_x_page() function. It will render
		 * the options page template defined in the page object if it exists, otherwise it will use a generic
		 * template included in this package (views/base_options_page.php).
		 *
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @link     http://codex.wordpress.org/Function_Reference/add_menu_page
		 * @link     http://codex.wordpress.org/Function_Reference/add_submenu_page
		 * @link     http://codex.wordpress.org/Function_Reference/add_options_page
		 * @todo     Modify this to use get_current_screen()
		 */
		public function render_options_page()
		{
			$screen = get_current_screen();
			
			if ( isset( $this->model ) ) {
				//get the pages as set up in the settings model
				$pages = $this->model->get_pages();

				//if ( isset( $pages[ $_REQUEST['page'] ] ) ) {
				if ( isset( $pages[ $screen->id ] ) ) {
					//get the page being requested
					$page = $pages[ $screen->id ];
					
					//$options is used in the view file
					$options = $this->model->get_options();
					
					//set the default view
					$view = dirname( dirname( __FILE__ ) ) . '/views/base_options_page.php';
					
					if ( isset( $page['view'] ) ) {
						if ( file_exists( $page['view'] ) ) {
							$view = $page['view'];
						}
					}
					
					include $view;
				}
			}
		}

		/**
		 * Render a settings section.
		 *
		 * This function can be used as a generic callback for add_settings_sections().
		 *
		 * @param    object $section The section object.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @link     http://codex.wordpress.org/Function_Reference/add_settings_section
		 */
		public function render_settings_section( $section )
		{
			//get the corresponding section
			$setting_section = $this->model->get_settings_sections( $section['id'] );
			
			if ( $setting_section ) {
				$view = dirname( dirname( __FILE__ ) ) . '/views/base_settings_section.php';
				
				//The following clause should be removed, but is currently kept for backwards compatibility
				if ( file_exists( dirname( dirname( __FILE__ ) ) . '/views/' . $section['id'] . '.php' ) ) {
					$view = dirname( dirname( __FILE__ ) ) . '/views/' . $section['id'] . '.php';
				}
				
				if ( isset( $setting_section['view'] ) ) {
					if ( file_exists( $setting_section['view'] ) ) {
						$view = $setting_section['view'];
					}
				}
				
				require $view;
			}
		}

		/**
		 * A generic add_settings_field() callback function.
		 *
		 * @param  array       $args The settings field arguments.
		 * @param  string      $echo Either echo the output (echo) or return it (any other value). Default is 'echo'.
		 * @return string|void       void on ECHO, HTML string on any other $echo value.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function render_settings_field( $args, $echo = 'echo' )
		{
			if ( ! isset( $args['type'] ) || ! isset( $args['id'] ) || ! isset( $args['name'] ) ) {
				trigger_error( __( 'The settings field type, id and name must be set', 'wpmvcb' ), E_USER_WARNING );
			}

			include_once dirname( dirname( __FILE__ ) ) . '/helpers/render_fields.php';

			switch ( $args['type'] ) {
				case 'checkbox':
					$html = Base_Helpers_Render_Fields::render_input_checkbox( $args['id'], $args['name'], $args['value'] );
					break;
				case 'select':
					if ( ! isset( $args['options'] ) ) {
						trigger_error(
							__( 'The options must be set to render a select field.', 'wpmvcb' ),
							E_USER_WARNING
						);
					}
					
					$html =	Base_Helpers_Render_Fields::render_input_select( $args['id'], $args['name'], $args['options'], $args['value'] );
					break;
				case 'text':
					$html = Base_Helpers_Render_Fields::render_input_text( $args['id'], $args['name'], $args['value'], $args['placeholder'], $args['after'] );
					break;
				case 'textarea':
					$html = Base_Helpers_Render_Fields::render_input_textarea( $args['id'], $args['name'], $args['value'], $args['placeholder'] );
					break;
			}

			if ( $echo !== 'echo' ) {
				return $html;
			}
			
			echo $html;
		}
	}
}
