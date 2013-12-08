<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/models/class-base-model-metabox.php';
	require_once WPMVCB_SRC_DIR . '/models/class-base-model-cpt.php';
	require_once WPMVCB_SRC_DIR . '/controllers/class-base-controller-cpt.php';
	
	/**
	 * The custom post type model.
	 *
	 * @since 1.0
	 * @internal
	 */
	class testStubCptModel extends \Base_Model_Cpt
	{
		protected function init()
		{
			//implemented, but does nothing
		}
		
		protected function init_metaboxes()
		{
			$this->metaboxes = array(
				'book_metabox' => new \Base_Model_Metabox(
					'book_metabox',
					__( 'Book Metabox', $txtdomain ),
					null,
					array( $this->slug ),
					'normal',
					'default',
					array( 
						'view' => $this->app_path . 'views/metabox-book-metabox.php',
					)
				)
			);
		}
		
		protected function init_help_tabs()
		{
			//implemented but does nothing
		}
		
		public function save_post()
		{
			//implemented, but does nothing
		}
	}
	
	/**
	 * The WordPress integration test controller for Custom Post Types.
	 *
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class testCustomPostType extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
			
			//create the cpt model
			$this->model = new testStubCptModel(
				'book-cpt',
				'Book',
				'Books',
				'/home/foo/plugin.php',
				'/home/foo',
				'/home/foo/app',
				'/home/foo/base',
				'http://example.com/foo',
				'footxtdomain' );
			
			//create a new controller
			$this->controller = new \Base_Controller_CPT();
		}

		public function tearDown()
		{
			unset( $this->model );
			unset( $this->controller );
		}
		
		/**
		 * @covers Base_Controller_Cpt::add_model
		 */
		public function testMethodAddModel()
		{
			$this->controller->add_model( $this->model );
			$this->assertFalse( false === has_action( 'save_post', array( &$this->model, 'save_post' ) ) );
		}
		
		/**
		 * @covers Base_Model::get_metaboxes
		 */
		public function testMethodGetMetaboxes()
		{
			$expected = array(
				'book_metabox' => new \Base_Model_Metabox(
					'book_metabox',
					'Book Metabox',
					null,
					array( 'book-cpt' ),
					'normal',
					'default',
					array( 
						'view' => '/home/foo/app/views/metabox-book-metabox.php',
					)
				)
			);
			
			$this->assertEquals( $expected, $this->model->get_metaboxes( 23, 'footxtdomain' ) );
		}
		
		/**
		 * @covers Base_Model::get_help_tabs
		 */
		public function testMethodGetHelpTabs()
		{
			$this->model->get_help_tabs();
		}
	}
}
