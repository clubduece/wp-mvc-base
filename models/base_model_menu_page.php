<?php

if( ! class_exists( 'Base_Model_Menu_Page' ) ) {
	/**
	 * The base options page model.
	 *
	 * @package WPMVCBase\Models
	 * @since 0.2
	 */
	class Base_Model_Menu_Page
	{
		/**
		 * The The slug name for the parent menu item.
		 * 
		 * @var string
		 * @since 0.2
		 */
		private $_parent_slug;
		
		/**
		 * The text to be displayed in the title tags of the page when the menu is selected.
		 * 
		 * @var string
		 * @since 0.2
		 */
		private $_page_title;
		
		/**
		 * The text to be used for the menu item.
		 *
		 * @var string
		 * @since 0.2
		 */
		private $_menu_title;
		
		/**
		 * The capability required for this menu to be displayed to the user.
		 * 
		 * @var string
		 * @since 0.2
		 * @link http://codex.wordpress.org/Roles_and_Capabilities
		 */
		private $_capability;
		
		/**
		 * The slug name to refer to this menu by (should be unique for this menu).
		 *
		 * If you want to NOT duplicate the parent menu item, you need to set the name of the 
		 * $menu_slug exactly the same as the parent slug.
		 * 
		 * @var string
		 * @since 0.2
		 */
		private $_menu_slug;
		
		/**
		 * The function to be called to output the content for this page.
		 *
		 * You can specify a function here, or leave it unset. If unset, the plugin controller will use
		 * the default render_options_page() method.
		 * 
		 * @var string|array
		 * @since 0.2
		 */
		private $_callback;
		
		/**
		 * The url to the icon to be used for this menu. 
		 *
		 * This parameter is optional. Icons should be fairly small, around 16 x 16 pixels for best results. 
		 * You can use the plugin_dir_url( __FILE__ ) function to get the URL of your plugin directory and 
		 * then add the image filename to it. You can set $icon_url to "div" to have wordpress generate 
		 * <br> tag instead of <img>. This can be used for more advanced formating via CSS, such as 
		 * changing icon on hover.
		 * 
		 * @var string
		 * @since 0.2
		 */
		private $_icon_url;
		
		/**
		 * The position in the menu order this menu should appear. 
		 *
		 * By default, if this parameter is omitted, the menu will appear at the bottom of the menu structure.
		 * The higher the number, the lower its position in the menu. WARNING: if two menu items use the same
		 * position attribute, one of the items may be overwritten so that only one item displays! Risk of 
		 * conflict can be reduced by using decimal instead of integer values, e.g. 63.3 instead of 63 
		 * (Note: Use quotes in code, IE '63.3').
		 * 
		 * @var string
		 * @since 0.2
		 */
		private $_position;
		
		/**
		 * The javascripts used on this page.
		 *
		 * This is a collection of Base_Model_JS_Objects.
		 * 
		 * @var array
		 * @since 0.2
		 * @see Base_Model_JS_Object
		 */
		private $_admin_scripts;
		
		/**
		 * The CSS used on this page.
		 * 
		 * @var array
		 * @since 0.2
		 */
		private $_admin_css;
		
		/**
		 * The help tabs for this page.
		 * 
		 * This is a collection of Base_Model_Help_Tab objects.
		 *
		 * @var array
		 * @since 0.2
		 * @see Base_Model_Help_Tabs
		 */
		private $_help_tabs;
		
		/**
		 * The name of the view file used to render the page.
		 * 
		 * This file must be present in the app/views folder. If not set ( or set and not present), 
		 * a PHP warning will occur and the plugin controller will use a default view.
		 *
		 * @var string
		 * @since 0.2
		 */
		private $_view;
		
		/**
		 * The hook suffix assigned by WordPress when the page is added.
		 * 
		 * @var string
		 * @since 0.2
		 */
		private $_hook_suffix;
		
		/**
		 * Set the _parent_slug property.
		 *
		 * @param $slug
		 * @since 0.2
		 */
		public function set_parent_slug( $slug )
		{
			$this->_parent_slug = $slug;
		}
		
		/**
		 * Get the _parent_slug property.
		 *
		 * @return string|void
		 * @since 0.2
		 */
		public function get_parent_slug()
		{
			if( isset( $this->_parent_slug ) ) 
				return $this->_parent_slug;
		}
		
		/**
		 * Set the _page_title property.
		 *
		 * @param string $page_title
		 * @since 0.2
		 */
		public function set_page_title( $page_title )
		{
			$this->_page_title = $page_title;
		}
		
		/**
		 * Get the _page_title property.
		 *
		 * @return string|void
		 * @since 0.2
		 */
		public function get_page_title()
		{
			if( isset( $this->_page_title ) ) 
				return $this->_page_title;
		}
		
		/**
		 * Set the _menu_title property.
		 *
		 * @param string $title
		 * @since 0.2
		 */
		public function set_menu_title( $title )
		{
			$this->_menu_title = $title;
		}
		
		/**
		 * Get the _menu_title property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_menu_title()
		{
			if ( isset( $this->_menu_title ) )
			 return $this->_menu_title;
		}
		
		/**
		 * Set the _capability property.
		 *
		 * @param string $capability
		 * @since 0.2
		 */
		public function set_capability( $capability )
		{
			$this->_capability = $capability;
		}
		
		/**
		 * Get the _capability property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_capability()
		{
			if ( isset( $this->_capability ) )
			 return $this->_capability;
		}
		
		/**
		 * Set the _menu_slug property.
		 *
		 * @param string $slug
		 * @since 0.2
		 */
		public function set_menu_slug( $slug)
		{
			$this->_menu_slug = $slug;
		}
		
		/**
		 * Get the _menu_slug property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_menu_slug()
		{
			if ( isset( $this->_menu_slug ) )
			 return $this->_menu_slug;
		}
		
		/**
		 * Set the _callback property.
		 *
		 * @param string $callback
		 * @since 0.2
		 */
		public function set_callback( $callback )
		{
			$this->_callback = $callback;
		}
		
		/**
		 * Get the _callback property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_callback()
		{
			if ( isset( $this->_callback ) )
			 return $this->_callback;
		}
		
		/**
		 * Set the _callback property.
		 *
		 * @param string $icon_url
		 * @since 0.2
		 */
		public function set_icon_url( $icon_url )
		{
			$this->_icon_url = $icon_url;
		}
		
		/**
		 * Get the _icon_url property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_icon_url()
		{
			if ( isset( $this->_icon_url ) )
			 return $this->_icon_url;
		}
		
		/**
		 * Set the _position property.
		 *
		 * @param string $position
		 * @since 0.2
		 */
		public function set_position( $position )
		{
			$this->_position = $position;
		}
		
		/**
		 * Get the _position property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_position()
		{
			if ( isset( $this->_position ) )
			 return $this->_position;
		}
		
		/**
		 * Set the _admin_scripts property.
		 *
		 * @param string $admin_scripts
		 * @since 0.2
		 */
		public function set_admin_scripts( $admin_scripts )
		{
			$this->_admin_scripts = $admin_scripts;
		}
		
		/**
		 * Get the _admin_scripts property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_admin_scripts()
		{
			if ( isset( $this->_admin_scripts ) )
			 return $this->_admin_scripts;
		}
		
		/**
		 * Set the _admin_css property.
		 *
		 * @param string $admin_css
		 * @since 0.2
		 */
		public function set_admin_css( $admin_css )
		{
			$this->_admin_css = $admin_css;
		}
		
		/**
		 * Get the _admin_css property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_admin_css()
		{
			if ( isset( $this->_admin_css ) )
			 return $this->_admin_css;
		}
		
		/**
		 * Set the _help_tabs property.
		 *
		 * @param string $help_tabs
		 * @since 0.2
		 */
		public function set_help_tabs( $help_tabs )
		{
			$this->_help_tabs = $help_tabs;
		}
		
		/**
		 * Get the _help_tabs property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_help_tabs()
		{
			if ( isset( $this->_help_tabs ) )
			 return $this->_help_tabs;
		}
		
		/**
		 * Set the _view property.
		 *
		 * @param string $view
		 * @since 0.2
		 */
		public function set_view( $view )
		{
			$this->_view = $view;
		}
		
		/**
		 * Get the _view property.
		 *
		 * @return string|null
		 * @since 0.2
		 */
		public function get_view()
		{
			if ( isset( $this->_view ) )
			 return $this->_view;
		}
		
		/**
		 * Get the _hook_suffix property.
		 *
		 * @return string|false
		 * @since 0.2
		 */
		public function get_hook_suffix()
		{
			if ( isset( $this->_hook_suffix ) )
			 return $this->_hook_suffix;
		}
		
		/**
		 * Add the options page
		 *
		 * @return string|false The hook suffix on success, FALSE if user does not have required capability.
		 * @since 0.2
		 * @link http://codex.wordpress.org/Function_Reference/add_menu_page
		 * @link http://codex.wordpress.org/Function_Reference/add_submenu_page
		 */
		public function add()
		{
			if( isset( $this->_parent_slug ) ):
				$this->_hook_suffix = add_submenu_page( $this->_parent_slug, $this->_page_title, $this->_menu_title, $this->_capability, $this->_menu_slug, $this->_callback );
			else:
				$this->_hook_suffix = add_menu_page( $this->_page_title, $this->_menu_title, $this->_capability, $this->_menu_slug, $this->_callback, $this->_icon_url, $this->_position );
			endif;
			
			/*
if ( false === $this->_hook_suffix ):
				trigger_error( 
					sprintf( __( 'Unable to add submenu page due to insufficient user capability: %s.', $this->txtdomain ), $key ),
					E_USER_WARNING
				);
			endif;
*/
			return $this->_hook_suffix;
		}
	}
}
?>