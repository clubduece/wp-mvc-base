<?php
namespace WPMVCB\Testing\UnitTests
{
	require_once WPMVCB_SRC_DIR . '/models/class-base-model-taxonomy.php';
	
	/**
	 * The base taxonomy model unit tests.
	 *
	 *
	 * @file       testBaseModelTaxonomy.php
	 * @package    WPMVCN\Testing\UnitTests
	 * @filesource tests/unit-tests/testBaseModelTaxonomy.php
	 * @since      0.3
	 */
	class testBaseModelTaxonomy extends \WPMVCB\Testing\WPMVCB_Test_Case
	{
		/**
		 * The test model.
		 * 
		 * @access private
		 * @var    Base_Model_Taxonomy
		 * @since  0.3
		 */
		private $model;
		
		public function setUp()
		{
			$this->model = new stubTaxonomy('foo','bar','baz','foobar','foobaz');
		}
		
		public function tearDown()
		{
			unset($this->model);
		}
		
		/**
		 * @covers Base_Model_Taxonomy::get_slug
		 */
		public function testMethodGetSlug()
		{
			$this->assertTrue(method_exists($this->model, 'get_slug'), 'Method get_slug() does not exist');
			
			$this->setReflectionPropertyValue($this->model, 'slug', 'foo slug');
			$this->assertEquals('foo slug', $this->model->get_slug());
		}
		
		/**
		 * @covers Base_Model_Taxonomy::get_object_types
		 */
		public function testMethodGetObjectTypes()
		{
			$this->assertTrue(method_exists($this->model, 'get_object_types'), 'Method get_object_types() does not exist');
			
			$this->setReflectionPropertyValue($this->model, 'object_types', 'foo types');
			$this->assertEquals('foo types', $this->model->get_object_types());
		}
		
		/**
		 * @covers Base_Model_Taxonomy::get_args
		 */
		public function testMethodGetArgs()
		{
			$this->assertTrue(method_exists($this->model, 'get_args'), 'Method get_args() does not exist');
			
			$this->setReflectionPropertyValue($this->model, 'args', 'foo args');
			$this->assertEquals('foo args', $this->model->get_args());
		}
		
		/**
		 * @covers Base_Model_Taxonomy::get_labels
		 */
		public function testMethodGetLabels()
		{
			$this->assertTrue(method_exists($this->model, 'get_labels'), 'Method get_labels() does not exist');
			
			$this->markTestIncomplete();
			$labels = $this->reflectionMethodInvokeArgs($this->model, 'get_labels', array('footxtdomain'));
			$this->assertEquals('foo slug', $labels);
		}
	}
	
	class stubTaxonomy extends \Base_Model_Taxonomy
	{
		public function init()
		{
			$this->singular = 'foo single';
			$this->plural   = 'foo plural';
			$this->slug     = 'foo slug';
		}
	}
}
	