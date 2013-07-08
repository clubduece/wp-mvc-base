<?php
/**
 * Helper functions
 *
 * @package WPMVCBase\Helper Functions
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @version 0.2
 * @since 0.1
 */
 
if ( ! class_exists( 'Helper_Functions' ) ):
	/**
	 * Helper functions class
	 *
	 * @package WPMVCBase\Helper Functions
	 * @version 0.2
	 * @since WPMVCBase 0.1
	 */
	class Helper_Functions
	{	
		/**
		 * Enqueue styles.
		 *
		 * This function enqueues styles using wp_enqueue_style. 
		 * It exposes a filter ( ah_base_filter_styles-$style_handle ) that can be used to alter
		 * the style object properties.
		 *
		 * @package WPMVCBase\Helper Functions
		 * @param array $styles The collection of style objects to be enqueued.
		 * @since 0.1
		 */
		public static function enqueue_styles( $styles )
		{
			foreach( $styles as $style ):
				//filter the style object
				$style = apply_filters( 'ah_base_filter_styles-' . $style['handle'], $style );
				if ( isset( $style['src'] ) ):
					wp_enqueue_style( 
						$style['handle'],
						$style['src'],
						$style['deps'],
						$style['ver'],
						$style['media']
					);
				else:
					wp_enqueue_style( $style['handle'] );
				endif;
			endforeach;
		}
		
		/**
		 * Enqueue scripts.
		 *
		 * This function enqueues scripts using wp_enqueue_script.
		 *
		 * @package WPMVCBase\Helper Functions
		 * @param array $scripts The collection of script objects to be enqueued.
		 * @since 0.1
		 */
		public static function enqueue_scripts( $scripts )
		{
			foreach( $scripts as $script ):
				$script->enqueue();
			endforeach;
		}
		
		/**
		 * Create a directory and possibly add index.php
		 *
		 * This function will create the directory specified in $target if it does not already exist.
		 * It will also add an index.php file if $index is set to TRUE.
		 *
		 * @package WPMVCBase\Helper Functions
		 * @param string $target The directory absolute path.
		 * @param bool $index Create an index.php in the directory (default true).
		 * @param octal $permissions The directory permissions (default 0755 ).
		 * @since 0.1
		 */
		public static function create_directory( $target, $index = true, $permissions = 0755 )
		{
			if( ! is_dir ( $target ) )
				mkdir( $target, $permissions, true );
			
			//create an index file in this directory if it does not exist
			if( ! file_exists( trailingslashit( $target ) .'index.php' ) ):
				$handle = fopen( trailingslashit( $target ) .'index.php', 'w' );
				fwrite( $handle, '<?php //silence is golden. ?>' );
				fclose( $handle );
			endif;
		}
		
		/**
		 * Get the contents of a local filesystem directory.
		 *
		 * @package WPMVCBase
		 * @param string $directory The absolute path to the directory.
		 * @returns array array An array containg the directory contents on success, NULL on failure.
		 * @since 0.1
		 */
		public static function get_local_directory_contents( $directory )
		{
			if ( is_dir( $directory ) ):
				if ( $files = scandir( $directory ) ):
					foreach( $files as $entry ):
						$filetype = wp_check_filetype( $entry );
						$contents[] = array(
							'filename' 	=> $entry,
							'filetype' 	=> $filetype['ext'],
							'mimetype' 	=> $filetype['type']
						);
					endforeach;
				endif;
				
				return $contents;
			else:
				return null;
			endif;
		}
		
		/**
		 * Remove a directory and all contents from the local filesystem
		 *
		 * @package WPMVCBase
		 * @param string $dirname The absolute path to the directory to be deleted.
		 * @param bool $force Delete all folder contents recursively (TRUE). Default FALSE.
		 * @return bool TRUE on success, FALSE on failure.
		 * @since 0.1
		 */
		public static function remove_local_directory( $dirname, $force = false )
		{
			if( $dirname == '/' || $dirname == '' || ! is_dir( $dirname )  )
				return false;
				
			if( $force ):
				$it = new RecursiveDirectoryIterator( $dirname );
				$files = new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );
				foreach( $files as $file ):
					if ( $file->getFilename() === '.' || $file->getFilename() === '..' ) {
						continue;
					}
				    if ( $file->isDir() ){
				        rmdir( $file->getRealPath() );
				    } else {
				        unlink( $file->getRealPath() );
				    }
				endforeach;
			endif;
			
			return rmdir( $dirname );
		}
		
		/**
		 * Delete a file on the local filesystem.
		 *
		 * @package WPMVCBase\Helper Functions
		 * @param string $file The absolute path to the file.
		 * @return TRUE on success, FALSE on failure.
		 * deprecated
		 * @since 0.1
		 */
		public static function delete_local_file( $file )
		{
			self::deprecated( 'delete_local_file', 'PHP unlink' );
			
			if( file_exists( $file ) ) {
				return unlink( $file );
			}
		}
		
		/**
		 * Sanitize an array with sanitize_text_field
		 *
		 * @package WPMVCBase\Helper Functions
		 * @param array $array Contains the elements to be sanitized
		 * @return array The sanitized array
		 * @since 0.1
		 */
		public static function sanitize_text_field_array( $array )
		{
			if ( is_array( $array ) ):
				foreach( $array as $key => $val ):
					$array[$key] = sanitize_text_field( $val );
				endforeach;
			endif;
			
			return $array;
		}
		
		/**
		 * Generate a deprecated warning message.
		 *
		 * This function is used to trigger a PHP warning message to notify user
		 * a deprecated function has been called.
		 *
		 * @internal
		 * @since 0.2
		 */
		public static function deprecated( $deprecated, $replacement, $txtdomain = '' )
		{
			trigger_error(
				sprintf( 
					__( 'DEPRECATED: The function %s is deprecated. Please use %s instead.', $txtdomain ), $deprecated, $replacement ),
				E_USER_WARNING
			);
		}
	}
endif;
?>