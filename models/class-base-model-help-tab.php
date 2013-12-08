<?php
/**
 * The base help tab model
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @copyright 2013
 * @version 0.1
 * @since WPMVCBase 0.1
 */

if ( ! class_exists( 'Base_Model_Help_Tab' ) ):
	/**
	 * The help tab model.
	 *
	 * @package WPMVCBase\Models
	 * @since 0.1
	 */
	class Base_Model_Help_Tab
	{
		/**
		 * The help tab id.
		 *
		 * @var string
		 * @see http://codex.wordpress.org/Function_Reference/add_help_tab
		 * @since 0.1
		 */
		private $id;

		/**
		 * The help tab title.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $title;
		
		/**
		 * The admin screens on which to display this help tab.
		 * 
		 * This array contains the WP screen id's for the screens on which to load this help tab 
		 * ( e.g. 'Add New Post', 'Reading Settings', etc ). There is a highly incomplete listing of screen ids
		 * @link http://codex.wordpress.org/Plugin_API/Admin_Screen_Reference
		 *
		 * Primarily, the most used are:
		 * load-post.php      The 'All Posts' page. This also applies to pages and custom post types.
		 * load-post-edit.php The page loaded to edit an existing post/page/cpt.
		 * load-post-new.php  The page loaded when creating a new post/page/cpt.
		 *
		 * @var array
		 * @since 1.0
		 */
		private $screens;
		
		/**
		 * The post types on which to display this help tab.
		 * 
		 * This property is used in conjunction with the $screens property to determine upon which admin pages
		 * to display this help tab.
		 *
		 * For example, if the post_types property is set to 'post' and the $screens property is set to 'load-post-new.php',
		 * this tab will appear on only the Create New Post page for posts ( not pages ).
		 *
		 * @var array
		 * @since 1.0
		 */
		private $post_types;
		
		/**
		 * The help tab content.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $content;

		/**
		 * The class constructor.
		 *
		 * @param string       $title      The help tab title.
		 * @param string       $id         The help tab id.
		 * @param array        $screens    The screens on which to add the help screen tab.
		 * @param array        $post_types The post types on which to display this help tab
		 * @param string       $content    The help tab content. If null, the callback will be used to populate the content.
		 * @since 0.1
		 */
		public function __construct( $id, $title, array $screens, array $post_types, $content )
		{
			$this->id         = $id;
			$this->title      = $title;
			$this->screens    = $screens;
			$this->post_types = $post_types;
			$this->content    = $content;
		}

		/**
		 * Get the help tab title.
		 *
		 * @since 0.1
		 */
		public function get_title()
		{
			return $this->title;
		}

		/**
		 * Get the help tab id.
		 *
		 * @since 0.1
		 */
		public function get_id()
		{
			return $this->id;
		}
		
		/**
		 * Get the help tab screens.
		 *
		 * @return array $screens
		 * @since 1.0
		 */
		public function get_screens()
		{
			return $this->screens;
		}

		/**
		 * Get the post types associated with this help tab.
		 *
		 * @return array $post_types
		 * @since 1.0
		 */
		public function get_post_types()
		{
			return $this->post_types;
		}
		
		/**
		 * Set the help tab content.
		 *
		 * @return string $content
		 * @since 0.1
		 */
		
		public function get_content()
		{
			return $this->content;
		}
	}
endif;
