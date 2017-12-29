<?php

namespace WPMVCB\Tests\Unit;

use WPMVCB\Base;
use WPMVCB\Tests\testCase;

/**
 * Class testBase
 * @package WPMVCB\Tests\Unit
 *
 * @coversDefaultClass \WPMVCB\Base
 */
class testBase extends testCase {

	/**
	 * @var Base
	 */
	protected $_sut;

	public function setUp() {
		$this->_sut = $this->getMockBuilder(Base::class)
			->setConstructorArgs(array(array('foo' => 'bar')))
			->getMockForAbstractClass();

		parent::setUp();
	}

	/**
	 * @covers ::__construct
	 * @covers ::__call
	 */
	public function testCall() {
		$this->assertEquals('bar', $this->_sut->foo());
	}

	/**
	 * @covers ::__call
	 */
	public function testCallIsNull() {
		$this->assertNull($this->_sut->bar());
	}
}