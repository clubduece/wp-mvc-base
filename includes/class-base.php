<?php

namespace WPMVCB;

/**
 * Class Base
 * @package WPMVCB
 */
abstract class Base {

	/**
	 * @var array
	 */
	protected $_args = array();

	/**
	 * Base constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		$args = wp_parse_args( $args );

		foreach ( $args as $key => $value ) {
			do {
				if ( property_exists( $this, $property = "_{$key}" ) ) {
					$this->{$property} = $value;
					break;
				}

				$this->_args[ $key ] = $value;
			} while ( false );

		}

	}

	/**
	 * @param  string $method
	 * @param  array  $args
	 *
	 * @return null|mixed
	 */
	public function __call( $method, $args ) {

		do {
			if ( property_exists( $this, $property = "_{$method}" ) ) {
				$value = $this->{$property};
				break;
			}

			if ( isset( $this->_args[ $method ] ) ) {
				$value = $this->_args[ $method ];
				break;
			}

			$value = null;
		} while ( false );

		return $value;

	}

	/**
	 * @param string $method
	 * @param array  $args
	 *
	 * @return null|mixed
	 */
	public static function __callStatic( $method, $args ) {

		do {
			if ( property_exists( static::class, $property = "_{$method}" ) ) {
				$value = static::${$property};
				break;
			}

			$value = null;
		} while ( false );

		return $value;
	}

	/**
	 * @param string $method_name
	 * @param string $replacement
	 */
	protected function deprecated( $method_name, $replacement ) {

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$message = sprintf(
				__( 'The method %1$s is deprecated. Please use %2$s instead.', 'wpmvcb' ),
				$method_name,
				$replacement
			);

			trigger_error( $message, E_USER_WARNING );
		}

	}

}
