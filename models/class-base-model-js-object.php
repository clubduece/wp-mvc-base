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

if ( ! class_exists( 'Base_Model_JS_Object' ) ):
	/**
	 * The base javascript object model.
	 *
	 * @package WPMVCBase\Models
	 * @since   WPMVCBase 0.1
	 */
	class Base_Model_JS_Object
	{
		/**
		 * The script handle.
		 *
		 * Name used as a handle for the script. As a special case, if the string contains a '?' character,
		 * the preceding part of the string refers to the registered handle, and the succeeding part is
		 * appended to the URL as a query string.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $handle;

		/**
		 * The script source uri.
		 *
		 * URL to the script, e.g. http://example.com/wp-content/themes/my-theme/my-theme-script.js.
		 * You should never hardcode URLs to local scripts. To get a proper URL to local scripts, use plugins_url()
		 * for plugins and get_template_directory_uri() for themes. Remote scripts can be specified with a protocol-agnostic
		 * URL, e.g. //otherdomain.com/js/their-script.js. This parameter is only required when the script with the given
		 * $handle has not been already registered using wp_register_script().
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $src;

		/**
		 * The script dependencies.
		 *
		 * Array of the handles of all the registered scripts upon which this script depends, that is the scripts that must be
		 * loaded before this script. Set false if there are no dependencies.
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $deps;

		/**
		 * The script version number.
		 *
		 * String specifying the script version number, if it has one, which is concatenated to the end of the 
		 * path as a query string. If no version is specified or set to false, then WordPress automatically adds 
		 * a version number equal to the current version of WordPress you are running. If set to null no version
		 * is added. This parameter is used to ensure that the correct version is sent to the client regardless 
		 * of caching, and so should be included if a version number is available and makes sense for the script.
		 *
		 * @var    string|bool
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $version;

		/**
		 * Script placement.
		 *
		 * Normally, scripts are placed in <head> of the HTML document. If this parameter is true, 
		 * the script is placed before the </body> end tag.
		 *
		 * @var    bool
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $in_footer;

		/**
		 * The localization variable name.
		 *
		 * String specifying the localization variable name to be used in the wp_localize_script() function. 
		 * If set, the $localization_args property is required and this class will attempt to localize the 
		 * script immediately after enqueuing the script.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $localization_var;

		/**
		 * The localization arguments.
		 *
		 * An array of key/value pairs containing the argument name(s) and value(s).
		 * If the $localization_var property is set, this will be used as the $args parameter of 
		 * the wp_localize_script function.
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $localization_args;

		/**
		 * The class constructor
		 *
		 * @param  string      $handle
		 * @param  string      $src
		 * @param  array       $deps
		 * @param  string|bool $version
		 * @param  bool        $in_footer
		 * @param  string      $localization_var
		 * @param  array       $localization_args
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( $handle, $src = false, $deps = array(), $version = false, $in_footer = false, $localization_var = null, $localization_args = null )
		{
			$this->handle            = $handle;
			$this->src               = $src;
			$this->deps              = $deps;
			$this->version           = $version;
			$this->in_footer         = $in_footer;
			$this->localization_var  = $localization_var;
			$this->localization_args = $localization_args;
		}

		/**
		 * Register the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
		 * @return void
		 * @since WPMVCBase 0.1
		 */
		public function register()
		{
			wp_register_script( $this->handle, $this->src, $this->deps, $this->version, $this->in_footer );
		}

		/**
		 * Enqueue the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
		 * @return void
		 * @since WPMVCBase 0.1
		 */
		public function enqueue()
		{
			//apply filters
			$this->src = apply_filters( 'ah_base_filter_script_src-' . $this->handle, $this->src );
			$this->localization_args = apply_filters( 'ah_base_filter_script_localization_args-' . $this->handle, $this->localization_args );

			wp_enqueue_script( $this->handle, $this->src, $this->deps, $this->version, $this->in_footer );
			if ( isset( $this->localization_var ) && isset( $this->localization_args ) ) {
				$this->localize();
			}
		}

		/**
		 * Localize the script
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_localize_script
		 * @return bool TRUE on success, FALSE on failure
		 * @since WPMVCBase 0.1
		 */
		public function localize()
		{
			if ( isset( $this->localization_var ) && isset( $this->localization_args ) ) {
				return wp_localize_script( $this->handle, $this->localization_var, $this->localization_args );
			}
			
			return false;
		}

		/**
		 * Dequeue the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_dequeue_script
		 * @return void
		 * @since WPMVCBase 0.1
		 */
		public function dequeue()
		{
			wp_dequeue_script( $this->handle );
		}

		/**
		 * Deregister the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_deregister_script
		 * @return void
		 * @since WPMVCBase 0.1
		 */
		public function deregister()
		{
			wp_deregister_script( $this->handle );
		}
		
		/**
		 * Get the script handle.
		 *
		 * @return string $handle
		 * @since WPMVCBase 0.3
		 */
		function get_handle()
		{
			return $this->handle;
		}
		
		/**
		 * Get the script source.
		 *
		 * @return string $src
		 * @since WPMVCBase 0.3
		 */
		function get_src()
		{
			return $this->src;
		}
		
		/**
		 * Get the script dependencies.
		 *
		 * @return array $deps
		 * @since WPMVCBase 0.3
		 */
		function get_deps()
		{
			return $this->deps;
		}
		
		/**
		 * Get the script version.
		 *
		 * @return string $version
		 * @since WPMVCBase 0.3
		 */
		function get_version()
		{
			return $this->version;
		}
		
		/**
		 * Get the script placement.
		 *
		 * @return boolean $in_footer
		 * @since WPMVCBase 0.3
		 */
		function get_in_footer()
		{
			return $this->in_footer;
		}
		
		/**
		 * Get the script localization variable name.
		 *
		 * @return string|false $localization_var if set, FALSE if not.
		 * @since WPMVCBase 0.3
		 */
		function get_localization_var()
		{
			if ( isset( $this->localization_var ) ) {
				return $this->localization_var;
			}
			
			return false;
		}
		
		/**
		 * Get the script localization arguments.
		 *
		 * @return string|bool $localization_args if set, FALSE if not.
		 * @since WPMVCBase 0.3
		 */
		function get_localization_args()
		{
			if ( isset( $this->localization_args ) ) {
				return $this->localization_args;
			}
			
			return false;
		}
	}
endif;
