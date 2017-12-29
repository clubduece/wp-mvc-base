<?php
namespace WPMVCB;

/**
 * Class View_Base
 *
 * @package  WPMVCB
 * @since    1.0
 * @abstract
 *
 * @method Model_Base      model()
 * @method Controller_Base controller()
 */
abstract class View_Base {

	/**
	 * Magic method for implementing dynamic methods
	 *
	 * For example:
	 *
	 * $this->foo()     Return the value of foo fetched from the model
	 * $this->the_foo() Echo the value of foo fetched from the model
	 *
	 * @param  string $method
	 * @param  array  $args
	 *
	 * @return null|mixed
	 */
	public function __call( $method, $args ) {

		$value = null;

		do {
			if ( preg_match( '#^the_(.+)?$#', $method ) ) {
				break;
			}

			$value = $this->model()->{$method}();
		} while ( false );

		return $value;

	}
}