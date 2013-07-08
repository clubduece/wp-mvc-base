<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/base_model_cpt.php' );
	
	/**
	 * The stub CPT for the controller tests
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since 0.2
	 * @internal
	 */
	class Test_Stub_CPT extends \Base_Model_CPT
	{
		protected $slug = 'tbc-cpt';
		public $help_tabs = array();
		
		public function init()
		{
			$this->shortcodes = array(
				'tscshortcode' => array( &$this, 'tscshortcode' )
			);
			$this->admin_scripts = array(
				new \Base_Model_JS_Object( 'barscript', 'http//example.com/barscript.js' )
			);
		}
		
		public function save()
		{
			return 'SAVE CPT';
		}
		
		public function the_post( $post )
		{
			$post->foo = 'bar';
			return $post;
		}
		
		public function delete()
		{
			return 'DELETE CPT';
		}
		
		protected function init_messages( $post )
		{
			$this->messages = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink( $post->ID) ) ),
				2 => __('Custom field updated.', 'your_text_domain'),
				3 => __('Custom field deleted.', 'your_text_domain'),
				4 => __('Book updated.', 'your_text_domain'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('Book published. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink($post->ID) ) ),
				7 => __('Book saved.', 'your_text_domain'),
				8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID) ) ) ),
				9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'your_text_domain'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $this->_post->post_date ) ), esc_url( get_permalink($post->ID) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID) ) ) )
			);
		}
		protected function init_args()
		{
			$labels = array(
				'name'                => _x( 'Books', 'Post Type General Name', 'my-super-cool-text-domain' ),
				'singular_name'       => _x( 'Book', 'Post Type Singular Name', 'my-super-cool-text-domain' ),
				'menu_name'           => __( 'Books', 'my-super-cool-text-domain' ),
				'parent_item_colon'   => __( 'Parent Book', 'my-super-cool-text-domain' ),
				'all_items'           => __( 'All Books', 'my-super-cool-text-domain' ),
				'view_item'           => __( 'View Book', 'my-super-cool-text-domain' ),
				'add_new_item'        => __( 'Add New Book', 'my-super-cool-text-domain' ),
				'add_new'             => __( 'New Book', 'my-super-cool-text-domain' ),
				'edit_item'           => __( 'Edit Book', 'my-super-cool-text-domain' ),
				'update_item'         => __( 'Update Book', 'my-super-cool-text-domain' ),
				'search_items'        => __( 'Search books', 'my-super-cool-text-domain' ),
				'not_found'           => __( 'No books found', 'my-super-cool-text-domain' ),
				'not_found_in_trash'  => __( 'No books found in Trash', 'my-super-cool-text-domain' ),
			);

			$this->args = array(
				'description'         	=> __( 'Books', 'my-super-cool-text-domain' ),
				'labels'              	=> $labels,
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
				'rewrite' 			  	=> array( 'slug' => 'books' ),
				//this is supported in 3.6
				'statuses'				=> array(
					'draft' => array(
						'label'                     => _x( 'New', 'book', 'my-super-cool-text-domain' ),
						'public'                    => true,
						'exclude_from_search'       => false,
						'show_in_admin_all_list'    => true,
						'show_in_admin_status_list' => true,
						'label_count'               => _n_noop( 'New <span class="count">(%s)</span>', 'New <span class="count">(%s)</span>', 'my-super-cool-text-domain' )
					)
				)
			);
		}
		
		public function my_super_cool_callback()
		{
			//implemented, but does nothing
		}
	}
}
?>