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

require_once 'class-base-model.php';

if ( ! class_exists( 'Base_Model_CPT' ) && class_exists( 'Base_Model' ) ):
	/**
	 * The base CPT object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since   WPMVCBase 0.1
	 */
	abstract class Base_Model_CPT extends Base_Model
	{
		/**
		 * The cpt slug. Used to register the post type.
		 *
		 * @var string
		 * @access protected
		 * @since WPMVCBase 0.1
		 */
		protected $slug;
		
		/**
		 * The cpt singular name, e.g. Book.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $singular;
		
		/**
		 * The cpt plural name, e.g. Books.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 *
		 */
		protected $plural;
		
		/**
		 * The CPT labels.
		 * 
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $labels;
		
		/**
		 * The arguments passed to register_post_type.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $args;
	
		/**
		 * The CPT post updated/deleted/etc messages.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		protected $messages;
	
		/**
		 * The class constructor.
		 *
		 * Use this function to initialize class variables, require necessary files, etc.
		 *
		 * @param  string $slug             The post type slug.
		 * @param  string $singular         The singular post type name in lower case (e.g. Book).
		 * @param  string $plural           The plural post type name in lower case (e.g. Books).
		 * @param  string $main_plugin_file The absolute path to the main plugin file.
		 * @param  string $plugin_path      The absolute path to the plugin directory
		 * @param  string $app_path         The absolute path to the plugin app directory.
		 * @param  string $base_path        The absolute path to the plugin base directory.
		 * @param  string $uri              The uri to the plugin app directory.
		 * @param  string $txtdomain        The plugint text domain.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( $slug, $singular, $plural, $main_plugin_file, $plugin_path, $app_path, $base_path, $uri, $txtdomain = 'wpmvcb' )
		{
			$this->slug     = $slug;
			$this->singular = $singular;
			$this->plural   = $plural;
			$this->uri      = $uri;
			
			$this->init_labels( $txtdomain );
			
			parent::__construct( $main_plugin_file, $plugin_path, $app_path, $base_path, $uri, $txtdomain );
		}
		
		/**
		 * Initialize the CPT labels property.
		 *
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @param string $txtdomain
		 */
		protected function init_labels( $txtdomain )
		{
			$this->labels = array(
				'name'                => $this->plural,
				'singular_name'       => $this->singular,
				'menu_name'           => $this->plural,
				'parent_item_colon'   => sprintf( __( 'Parent %s', $txtdomain ), $this->singular ),
				'all_items'           => sprintf( __( 'All %s', $txtdomain ), $this->plural ),
				'view_item'           => sprintf( __( 'View %s', $txtdomain ), $this->singular ),
				'add_new_item'        => sprintf( __( 'Add New %s', $txtdomain ), $this->singular ),
				'add_new'             => sprintf( __( 'New %s', $txtdomain ), $this->singular ),
				'edit_item'           => sprintf( __( 'Edit %s', $txtdomain ), $this->singular ),
				'update_item'         => sprintf( __( 'Update %s', $txtdomain ), $this->singular ),
				'search_items'        => sprintf( __( 'Search %s', $txtdomain ), $this->plural ),
				'not_found'           => sprintf( __( 'No %s found', $txtdomain ), strtolower( $this->plural ) ),
				'not_found_in_trash'  => sprintf( __( 'No %s found in Trash', $txtdomain ), strtolower( $this->plural ) ),
			);
		}
		
		/**
		 * Get the singular label
		 *
		 * @return string $singular
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_singular()
		{
			return $this->singular;
		}
		
		/**
		 * Get the plural label.
		 *
		 * @return string $plural
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_plural()
		{
			return $this->plural;
		}
		
		/**
		 * get the cpt slug
		 *
		 * @return string $slug
		 * @access public
		 * @since WPMVCBase 0.1
		 */
		public function get_slug()
		{
			return $this->slug;
		}
	
		/**
		 * Get the cpt arguments.
		 *
		 * If this property is not explicitly set in the child class, some default values will be returned.
		 *
		 * @return array $args
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_args()
		{
			if ( isset( $this->args ) ) {
				return $this->args;
			}
			
			return array(
				'description'         	=> $this->plural,
				'labels'              	=> $this->labels,
				'supports'            	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'hierarchical'        	=> false,
				'public'              	=> true,
				'show_ui'             	=> true,
				'show_in_menu'        	=> true,
				'show_in_nav_menus'   	=> true,
				'show_in_admin_bar'   	=> true,
				'menu_icon'           	=> null,
				'can_export'          	=> true,
				'has_archive'         	=> true,
				'exclude_from_search' 	=> false,
				'publicly_queryable'  	=> true,
				'rewrite' 			  	=> array( 'slug' => $this->slug ),
			);
		}
		
		/**
		 * Set the $args property
		 *
		 * @param  array $args
		 * @return bool|object TRUE on success, WP_Error object on failure.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_args( $args )
		{	
			if( ! is_array( $args ) ) {
				return new WP_Error( 
					'FAIL',
					sprintf( __( '%s::%s expects an array', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
					$args
				);
			}
			
			$this->args = $args;
			return true;			
		}
	}
endif;
