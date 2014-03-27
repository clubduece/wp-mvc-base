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

if ( ! class_exists( 'Base_Model_Taxonomy' ) ) {
	/**
	 * The base taxonomy model.
	 *
	 *
	 * @file       class-base-model-taxonomy.php
	 * @package    WPMVCBase\Models
	 * @filesource models/class-base-model-taxonomy.php
	 * @since      WPMVCB 0.3
	 */
	abstract class Base_Model_Taxonomy extends Base_Model
	{
		/**
		 * The taxonomy slug.
		 * 
		 * @access protected
		 * @var    string
		 * @since  0.3
		 */
		protected $slug;
		
		/**
		 * The post types to which this taxonomy is applied.
		 * 
		 * @access protected
		 * @var    array
		 * @since  0.3
		 */
		protected $object_types = null;
		
		/**
		 * The taxonomy arguments passed to register_taxonomy().
		 * 
		 * @access protected
		 * @var    array
		 * @since  0.3
		 * @link   http://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
		 */
		protected $args;
		
		/**
		 * The singular name for the taxonomy (e.g. book genre).
		 * 
		 * @access protected
		 * @var    string
		 * @since  0.3
		 */
		protected $singular;
		
		/**
		 * The plural name for the taxonomy (e.g. book genres).
		 * 
		 * @access protected
		 * @var    string
		 * @since  0.3
		 */
		protected $plural;
		
		/**
		 * Get the slug.
		 * 
		 * @access public
		 * @return string $slug
		 * @since  0.3
		 */
		public function get_slug()
		{
			return $this->slug;
		}
		
		/**
		 * Get the object types.
		 * 
		 * @access public
		 * @return array|void $object_types
		 * @since  0.3
		 */
		public function get_object_types()
		{
			return $this->object_types;
		}
		
		/**
		 * Get the arguments.
		 * 
		 * @access public
		 * @return array|void $args
		 * @since  0.3
		 */
		public function get_args()
		{
			return $this->args;
		}
		
		/**
		 * Get the labels.
		 * 
		 * @access private
		 * @param  string  $txtdomain The text domain used for translations.
		 * @return array              An array containint key/value pairs for the taxonomy labels.
		 * @since  0.3
		 */
		protected function get_labels( $txtdomain )
		{
			return array(
				'name'              => $this->plural,
				'singular_name'     => $this->singular,
				'search_items'      => sprintf( __( 'Search %s', $txtdomain ), $this->plural ),
				'all_items'         => sprintf( __( 'All %s', $txtdomain ), $this->plural ),
				'parent_item'       => sprintf( __( 'Parent %s', $txtdomain ), $this->singular ),
				'parent_item_colon' => sprintf( __( 'Parent %s:', $txtdomain ), $this->singular ),
				'edit_item'         => sprintf( __( 'Edit %s', $txtdomain ), $this->singular ),
				'update_item'       => sprintf( __( 'Update %s', $txtdomain ), $this->singular ),
				'add_new_item'      => sprintf( __( 'Add New %s', $txtdomain ), $this->singular ),
				'new_item_name'     => sprintf( __( 'New %s Name', $txtdomain ), $this->singular ),
				'menu_name'         => $this->singular,
			);
		}
	}
}