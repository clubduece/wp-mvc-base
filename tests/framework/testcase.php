<?php
namespace WPMVCBase\Testing
{
	class WPMVBC_Test_Case extends \WP_UnitTestCase
	{
		public function __construct()
		{
			//parent::setUp();
			$this->factory = new \WP_UnitTest_Factory;
		}
	}
}
?>