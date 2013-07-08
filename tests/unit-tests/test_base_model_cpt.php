<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_cpt.php' );
	
	/**
	 * The Test Stub CPT Model
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @internal
	 * @since WP MVC Base Testing 0.1
	 */
	class Test_Stub_Base_Model_CPT extends \Base_Model_CPT
	{
		protected $slug = 'my-super-cool-cpt';
		protected $metakey = '_my-super-cool-metakey';
		protected $shortcodes = array(
			'my-super-cool-shortcode' => 'my-super-cool-callback'
		);
		
		public function __construct( $uri, $txtdomain )
		{
			parent::__construct( $uri, $txtdomain );
		}
		
		protected function init_help_tabs()
		{
			$this->help_tabs = array(  'title' => 'My Help Screen', 'id' => 'demo-help', 'call' => 'my_callback_function' );
		}
		
		protected function init_metaboxes()
		{
			$this->metaboxes = array(
				'book_metabox' => array(
					'id' => 'book_metabox',
					'title' => __( 'Book Metabox', $txtdomain ),
					'post_type' => 'my-super-cool-cpt',
					'context' => 'normal',
					'priority' => 'default',
					'callback_args' => array () 
				)
			);
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
	}
	
	/**
	 * An empty cpt model for testing errors
	 *
	 * @internal
	 * @since 0.2
	 */
	class Test_Stub_Base_Model_CPT_Empty extends \Base_Model_CPT
	{
		public function __construct( $uri, $txtdomain )
		{
			parent::__construct( $uri, $txtdomain );
		}
	}
	
	/**
	 * The test controller for Base_Model_CPT
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class Test_Base_Model_CPT extends \WP_UnitTestCase
	{
		private $_factory;
		private $_cpt;
		private $_cpt_empty;
		private $_post;
		
		public function SetUp()
		{
			$this->_factory = new \WP_UnitTest_Factory;
			$this->_cpt = new Test_Stub_Base_Model_CPT( 'http://my-super-cool-site.com', 'my-super-cool-text-domain' );
			$this->_cpt_empty = new Test_Stub_Base_Model_CPT_Empty( 'http://my-super-cool-site.com', 'my-super-cool-text-domain' );
			$this->_post = get_post(
				$this->_factory->post->create_object(
					array(
						'post_type' => 'my-super-cool-cpt',
						'post_title' => 'Test CPT'
					)
				)
			);
		}
		
		public function test_get_slug()
		{
			$this->assertEquals( 'my-super-cool-cpt', $this->_cpt->get_slug() );
		}
		
		public function test_get_metakey()
		{
			$this->assertEquals( '_my-super-cool-metakey', $this->_cpt->get_metakey() );
		}
		
		public function test_get_shortcodes()
		{
			$this->assertEquals( array( 'my-super-cool-shortcode' => 'my-super-cool-callback' ), $this->_cpt->get_shortcodes() );
		}
		
		public function test_get_help_screen_error()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_cpt->get_help_screen( __FILE__, 'my-super-cool-text-domain' );
		}
		
		public function test_get_help_screen_error_message()
		{
			@$this->_cpt->get_help_screen( __FILE__, 'my-super-cool-text-domain' );
			$error = error_get_last();
			
			$this->assertEquals( 'DEPRECATED: The function get_help_screen is deprecated. Please use get_help_tabs instead.', $error['message'] );
		}
		
		public function test_get_help_screen()
		{
			$this->assertEquals(
				array(  'title' => 'My Help Screen', 'id' => 'demo-help', 'call' => 'my_callback_function' ),
				@$this->_cpt->get_help_screen( __FILE__, 'my-super-cool-text-domain' )
			);
		}
		
		public function test_get_help_tabs()
		{
			$this->assertEquals( 
				array( 'title' => 'My Help Screen', 'id' => 'demo-help', 'call' => 'my_callback_function' ),
				$this->_cpt->get_help_tabs( __FILE__, 'my-super-cool-text-domain' )
			);
		}
		
		public function test_get_post_updated_messages()
		{
			$messages = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink( $this->_post->ID) ) ),
				2 => __('Custom field updated.', 'your_text_domain'),
				3 => __('Custom field deleted.', 'your_text_domain'),
				4 => __('Book updated.', 'your_text_domain'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('Book published. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink($this->_post->ID) ) ),
				7 => __('Book saved.', 'your_text_domain'),
				8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $this->_post->ID) ) ) ),
				9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'your_text_domain'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $this->_post->post_date ) ), esc_url( get_permalink( $this->_post->ID ) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $this->_post->ID) ) ) )
			);
			
			$this->assertEquals( $messages, $this->_cpt->get_post_updated_messages( $this->_post, 'my-super-cool-text-domain' ) );
		}

		/*
		public function test_register()
		{
			$this->assertFalse( is_wp_error( $this->_cpt->register( 'http://my-super-cool-site.com', 'my-super-cool-text-domain' ) ) );
		}
		*/

		public function test_get_metaboxes()
		{
			$this->assertEquals(  
				array(
					'book_metabox' => array(
						'id' => 'book_metabox',
						'title' => __( 'Book Metabox', $txtdomain ),
						'post_type' => 'my-super-cool-cpt',
						'context' => 'normal',
						'priority' => 'default',
						'callback_args' => array () 
					)
				),
				$this->_cpt->get_metaboxes( 4, 'my-super-cool-textdomain' )
			);
		}
		
		public function test_get_args()
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

			$args = array(
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
			
			$this->assertEquals( $args, $this->_cpt->get_args( 'my-super-cool-text-domain' ) );
		}
		
		public function test_empty_get_slug()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_cpt_empty->get_slug();
		}
		
		public function test_empty_get_metakey()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_cpt_empty->get_metakey();
		}
		
		public function test_empty_get_args()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_cpt_empty->get_args( 'my-super-cool-text-domain' );
		}
		
		public function test_empty_get_help_screen()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_cpt_empty->get_help_screen( __FILE__, 'my-super-cool-text-domain' );
		}
		
		public function test_empty_get_help_tabs()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_cpt_empty->get_help_tabs();
		}
		
		public function test_empty_get_messages()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->_cpt_empty->get_post_updated_messages( 4, 'my-super-cool-text-domain' );
		}
		
		public function testRegister()
		{
			$this->_cpt->register();
			$this->assertTrue( post_type_exists( $this->_cpt->get_slug() ) );
		}
	}
} //namespace
?>
