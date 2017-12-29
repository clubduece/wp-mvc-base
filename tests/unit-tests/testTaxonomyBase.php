<?php

namespace WPMVCB\Tests\Unit;

use WPMVCB\Taxonomy_Base;
use WPMVCB\Tests\testCase;

/**
 * Class testTaxonomyBase
 * @package WPMVCB\Tests\Unit
 *
 * @coversDefaultClass \WPMVCB\Taxonomy_Base
 */
class testTaxonomyBase extends testCase {

	/**
	 * @covers ::register_object_types
	 * @covers \WPMVCB\Base::__callStatic
	 */
	public function testObjectTypes() {
		Taxonomy_Base::register_object_types(array('post', 'page'));

		$types = Taxonomy_Base::object_types();

		$this->assertInternalType('array', $types);
		$this->assertEquals(2, count($types));
		$this->assertContains('post', $types);
		$this->assertContains('page', $types);
	}

	/**
	 * @covers ::register_taxonomy_args
	 * @covers \WPMVCB\Base::__callStatic
	 */
	public function testTaxonomyArgs() {
		Taxonomy_Base::register_taxonomy_args(array('foo' => 'bar'));

		$args = Taxonomy_Base::taxonomy_args();
	}

	/**
	 * @covers ::on_load
	 */
	public function testOnLoad() {
		Taxonomy_Base::on_load();
		$this->assertGreaterThan(0, has_action('init', array(Taxonomy_Base::class, 'init')));
	}
}