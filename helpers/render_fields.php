<?php
if( ! class_exists( 'Base_Helpers_Render_Fields' ) ):
	/**
	 * Helper functions for rendering input fields
	 *
	 * @since
	 */
	final class Base_Helpers_Render_Fields
	{
		/**
		 * Render a checkbox input field.
		 *
		 * @param string $input_id The css id selector.
		 * @param string $name The css name selector
		 * @param string $value The field value.
		 * @return string The html string.
		 * @access public
		 * @static
		 * @since 0.3
		 */
		public static function render_input_checkbox( $input_id, $name, $value )
		{
			$html = sprintf( '<input type="checkbox" id="%1$s" name="%2$s" value="1" %3$s/>',
				$input_id,
				$name,
				$value ? 'checked ' : ''
			);
			
			return $html;
		}
		
		/**
		 * Render a text input field.
		 *
		 * @param string $input_id The css id selector.
		 * @param string $name The css name selector
		 * @param string $value The field value.
		 * @param string $placeholder The input field placeholder element.
		 * @param string $after Content to render after the input field. This can be the absolute path to a 
		 * 		file to be included or an HTML string.
		 * @return string The heml string.
		 * @access public
		 * @static
		 * @since 0.3
		 */
		public static function render_input_text( $input_id, $name, $value = null, $placeholder = null, $after = null )
		{
			if( isset ( $after ) && is_file( $after ) ):
				ob_start();
				require( $after );
				$after = ob_get_clean();
			endif;
			
			$html = sprintf( '<input type="text" id="%1$s" name="%2$s" value="%3$s" %4$s />%5$s',
				$input_id,
				$name,
				isset( $value ) ? $value : '',
				isset( $placeholder ) ? sprintf( 'placeholder="%s"', $placeholder ) : '',
				isset( $after ) ? $after : ''
			);
			
			return $html;
		}
		
		/**
		 * Render a select input field.
		 *
		 * @param string $input_id The css id selector.
		 * @param string $name The css name selector
		 * @param array $options An array containing select options as key/value pairs.
		 * @return string The html string.
		 * @access public
		 * @static
		 * @since 0.3
		 */
		public static function render_input_select( $input_id, $name, $options, $value = null )
		{
			$html = sprintf( '<select id="%1$s" name="%2$s">%3$s</select>',
				$input_id,
				$name,
				self::_render_input_select_options( $options, $value )
			);
			
			return $html;
		}
		
		/**
		 * Render a select input field options block.
		 *
		 * @param array $options A key/value pair of values and option display strings.
		 * @param string $current_value The current value for this option field.
		 * @access private
		 * @static
		 * @since 0.1
		 */
		private static function _render_input_select_options( $options, $current_value )
		{	
			$html = sprintf( '<option value="">Select…</option>',
				_x( 'Select…', 'Select an option', 'wpmvcb' ) );
			
			if( is_array( $options ) ):
				foreach( $options as $key => $val ):
					$html .= sprintf ( '<option value="%1$s" %2$s>%3$s</option>', 
						$key,
						$current_value == $key ? 'selected' : '',
						$val
					);
				endforeach;
			endif;
			
			return $html;
		}
		
		/**
		 * Return a text area input
		 *
		 * @param string $input_id The css id selector.
		 * @param string $name The css name selector
		 * @param string $value The field value.
		 * @param string $placeholder The input field placeholder element.
		 * @access private
		 * @since 0.2
		 */
		public static function render_input_textarea( $input_id, $name, $value = null, $placeholder = null )
		{
			$html = sprintf( '<textarea id="%1$s" name="%2$s" %4$s>%3$s</textarea>',
				$input_id,
				$name,
				isset( $value ) ? $value : '',
				isset( $placeholder ) ? sprintf( 'placeholder="%s"', $placeholder ) : ''
			);
			
			return $html;
		}
	}
endif;	//class exists
?>