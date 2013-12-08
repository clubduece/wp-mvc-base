<?php

/**
 * The base admin notice model.
 *
 * @author Daryl Lozupone <daryl@clubduece.com>
 */

if ( ! class_exists( 'Base_Model_Admin_Notice' ) ) {
	/**
	 * The base admin notice object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.3
	 * @since WPMVCBase 0.3
	 */
	class Base_Model_Admin_Notice
	{
		/**
		 * The notice type ( updated or error ).
		 * 
		 * @var string
		 * @since 1.0
		 */
		private $type;
		
		/**
		 * The admin notice message.
		 * 
		 * @var string
		 * @since 1.0
		 */
		private $message;
		
		/**
		 * The screens on which to display this admin notice.
		 * 
		 * @var array
		 * @since 1.0
		 */
		private $screens;
		
		/**
		 * The class constructor.
		 *
		 * @param string $type The notice type. Either 'updated' or 'error'.
		 * @param string $message The notice message.
		 * @param array $screens The WP screen id's on which to display this notice. If not set, notice appears on all screens.
		 * @since 1.0
		 */
		public function __construct( $type, $message, array $screens = null )
		{
			$this->type    = $type;
			$this->message = $message;
			$this->screens = 'all';
			
			if ( isset( $screens ) ) {
				$this->screens  = $screens;
			}
		}
		
		/**
		 * Get the notice type.
		 *
		 * @return string $type Either 'updated' or 'error'.
		 * @since 1.0
		 */
		public function get_type()
		{
			return $this->type;
		}
		
		/**
		 * Get the admin notice message.
		 *
		 * @return string $message
		 * @since 1.0
		 */
		public function get_message()
		{
			return $this->message;
		}
		
		/**
		 * Get the screen(s) on which to apply this notice.
		 *
		 * @return array|string $screens An array of the screens or the string 'all' for all screens.
		 * @since 1.0
		 */
		public function get_screens()
		{
			return $this->screens;
		}
	}
}
	 