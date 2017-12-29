<?php
namespace WPMVCB\Tests;

/**
 * Class Test_Case
 * @package WPMVCB\Tests
 */
class testCase extends \WP_UnitTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->factory = new Factory();
	}

	public function getReflectionPropertyValue( $class, $property )
	{
		$reflection = new \ReflectionProperty( $class, $property );
		$reflection->setAccessible( true );
		return $reflection->getValue( $class );
	}

	public function setReflectionPropertyValue( $class, $property, $value )
	{
		$reflection = new \ReflectionProperty( $class, $property );
		$reflection->setAccessible( true );
		return $reflection->setValue( $class, $value );
	}

	public function reflectionMethodInvoke( $class, $method )
	{
		$reflection = new \ReflectionClass($class);
		$method     = $reflection->getMethod($method);
		$method->setAccessible( true );
		return $method->invoke($class);
	}

	/**
	 * @param string|object $class
	 * @param string        $method
	 * @param array         $args
	 *
	 * @return mixed
	 */
	public function reflectionMethodInvokeArgs($class, $method, $args = array())
	{
		$reflection = new \ReflectionClass($class);
		$method = $reflection->getMethod($method);
		$method->setAccessible(true);
		return $method->invokeArgs($class, $args);
	}
}
