<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/models/class-base-model-cpt.php';
	require_once( WPMVCB_SRC_DIR . '/controllers/class-base-controller.php' );
	require_once( WPMVCB_SRC_DIR . '/controllers/class-base-controller-cpt.php' );

	/**
	 * The test controller for Base_Controller_Plugin.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @covers Base_Controller_CPT
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class testBaseControllerCpt extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
			$this->_controller = new \Base_Controller_CPT();
		}

		public function tearDown()
		{
			//remove actions set up by these tests
			remove_action( 'the_post', 'foo' );
			remove_action( 'save_post', 'bar' );
			remove_action( 'delete_post', 'baz' );
			remove_action( 'post_updated_messages', array( $cpt_model, 'get_post_updated_messages' ) );
			unset( $this->_controller );
		}

		private function _createStubCptModel()
		{
			// Create stub for cpt_model
			$cpt_model = $this->getMockBuilder( '\Base_Model_CPT' )
						 ->disableOriginalConstructor()
						 ->setMethods( 
						 	array( 
						 		'get_slug',
						 		'get_args',
						 		'get_post_updated_messages',
						 		'get_metaboxes',
						 		'get_singular',
						 		'get_plural',
						 		'get_scripts',
						 		'get_admin_scripts',
						 		'save_post'
						 	)
						 )
						 ->getMockForAbstractClass();
			          
			return $cpt_model;
		}
		
		public function testPropertyCptModelsExists()
		{
			$this->assertClassHasAttribute( 'cpt_models', '\Base_Controller_CPT' );
		}
		
		public function testActionExistsWpEnqueueScripts()
		{
			$this->assertFalse(
				false === has_action( 'wp_enqueue_scripts', array( &$this->_controller, 'wp_enqueue_scripts' ) ),
				'wp_enqueue_scripts not hooked'
			);
		}
		
		/**
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testActionExistsAdminEnqueueScripts()
		{
			$this->assertFalse(
				false === has_action( 'admin_enqueue_scripts', array( $this->_controller, 'admin_enqueue_scripts' ) ),
				'admin_enqueue_scripts not hooked'
			);
		}
		
		public function testActionExistsAddMetaBoxes()
		{
			$this->assertFalse(
				false === has_action( 'add_meta_boxes', array( &$this->_controller, 'add_meta_boxes' ) ),
				'add_meta_boxes not hooked'
			);
		}
		
		public function testMethodAddModelExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_model' ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_model
		 * @depends testMethodAddModelExists
		 */
		public function testMethodAddModel()
		{
			$cpt_model = $this->_createStubCptModel();

			//set up stub function get_slug method
			$cpt_model->expects( $this->any() )
			          ->method( 'get_slug' )
			          ->will( $this->returnValue( 'fooslug' ) );
			          
			$cpt_model->expects( $this->any() )
			          ->method( 'save_post' )
			          ->will( $this->returnValue( 'bar' ) );

			$expected = array( 'fooslug' => $cpt_model );

			$this->_controller->add_model( $cpt_model );
			$this->assertEquals( $expected, $this->getReflectionPropertyValue( $this->_controller, 'cpt_models' ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_model
		 * @expectedException PHPUnit_Framework_Error
		 * @depends testMethodAddModelExists
		 */
		public function testMethodAddModelFail()
		{
			$this->_controller->add_model( new \StdClass );
		}

		/**
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testActionInitRegisterExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'register' ), __( 'Method does not exist', 'wmvcb' ) );
			$this->assertFalse( false === has_action( 'init', array( $this->_controller, 'register' ) ) );
		}

		/**
		 * @covers Base_Controller_CPT::register
		 */
		public function testMethodRegister()
		{
			$this->assertTrue( method_exists( '\Base_Controller_CPT', 'register' ) );

			$cpt_model = $this->_createStubCptModel();

			$cpt_model->expects( $this->any() )
			          ->method( 'get_slug')
			          ->will( $this->returnValue( 'fooslug' ) );
			$cpt_model->expects( $this->any() )
			          ->method( 'get_args' )
			          ->will( $this->returnValue( 'fooargs' ) );

			//add the model to the controller's cpt_models property
			$this->setReflectionPropertyValue( $this->_controller, 'cpt_models', array( 'fooslug' => $cpt_model ) );

			$this->_controller->register();
			$this->assertTrue( post_type_exists( 'fooslug' ) );
		}

		/**
		 * @covers Base_Controller_CPT::post_updated_messages
		 */
		public function testMethodPostUpdatedMessages()
		{
			$this->assertTrue( method_exists( $this->_controller, 'post_updated_messages' ) );

			//create a stub cpt model for testing
			$model = $this->_createStubCptModel();
			$model->expects( $this->any() )
				  ->method( 'get_singular' )
				  ->will( $this->returnValue( 'Book' ) );
			$model->expects( $this->any() )
				  ->method( 'get_slug' )
				  ->will( $this->returnValue( 'foocptslug' ) );

			//add the model to the controller's cpt_models property
			$this->setReflectionPropertyValue( $this->_controller, 'cpt_models', array( 'foocptslug' => $model ) );
			
			$messages = $this->_controller->post_updated_messages( array() );
			
			$expected = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink( $this->_post->ID) ) ),
				2 => __('Custom field updated.', 'your_text_domain'),
				3 => __('Custom field deleted.', 'your_text_domain'),
				4 => __('Book updated.', 'your_text_domain'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('Book published. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink($this->_post->ID) ) ),
				7 => __('Book saved.', 'your_text_domain'),
				8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $this->_post->ID) ) ) ),
				9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'your_text_domain'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $this->_post->post_date ) ), esc_url( get_permalink( $this->_post->ID ) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $this->_post->ID) ) ) )
			);
			
			$this->assertArrayHasKey( 'foocptslug', $messages, __( 'Messages not present in array', 'wpmvcb' ) );
			$this->assertEquals( $expected, $messages['foocptslug'] );
		}
				
		/**
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testActionPostUpdatedMessagesExists()
		{
			$cpt_model = $this->_createStubCptModel();
			$this->_controller->add_model( $cpt_model );
			$this->assertFalse( false === has_action( 'post_updated_messages', array( $this->_controller, 'post_updated_messages' ) ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_meta_boxes
		 */
		public function testMethodAddMetaBoxes()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_meta_boxes' ) );

			//create a stub metabox
			$metabox = $this->getMockBuilder( '\Base_Model_Metabox' )
			                ->setMethods( array( '__construct', 'get_id', 'get_title', 'get_callback', 'get_post_types', 'get_priority', 'get_context', 'get_callback_args' ) )
			                ->disableOriginalConstructor()
			                ->getMock();

			$metabox->expects( $this->any() )
			        ->method( 'get_id' )
			        ->will( $this->returnValue( 'foocptmetabox' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_title' )
			        ->will( $this->returnValue( 'Foo Metabox' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback' )
			        ->will( $this->returnValue( 'time' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_post_types' )
			        ->will( $this->returnValue( array( 'post', 'page' ) ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_context' )
			        ->will( $this->returnValue( 'side' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_priority' )
			        ->will( $this->returnValue( 'high' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback_args' )
			        ->will( $this->returnValue( array( 'bar' => 'baz' ) ) );

			//stub the cpt model
			$model = $this->_createStubCptModel();

			$model->expects( $this->any() )
			      ->method( 'get_metaboxes' )
			      ->will( $this->returnValue( array( $metabox ) ) );

			//add the model to the controller
			$this->setReflectionPropertyValue( $this->_controller, 'cpt_models', array( 'foocptmetabox' => $model ) );

			$this->_controller->add_meta_boxes();

			$this->assertMetaboxExists( array( 'foocptmetabox', 'Foo Metabox', 'time', 'post', 'side', 'high', array( 'bar' => 'baz' ) ) );
			$this->assertMetaboxExists( array( 'foocptmetabox', 'Foo Metabox', 'time', 'page', 'side', 'high', array( 'bar' => 'baz' ) ) );
		}
		
		public function testMethodAdminEnqueueScripts()
		{
			$this->assertTrue( method_exists( $this->_controller, 'admin_enqueue_scripts' ) );
			
			$script = $this->getMockBuilder( '\Base_Model_JS_Object' )
			               ->setMethods( array( 'get_handle', 'get_src', 'get_deps', 'get_ver', 'get_in_footer' ) )
			               ->disableOriginalConstructor()
			               ->getMock();
			
			$script->expects( $this->any() )
			       ->method( 'get_handle' )
			       ->will( $this->returnValue( 'adminscript' ) );
			$script->expects( $this->any() )
			       ->method( 'get_src' )
			       ->will( $this->returnValue( 'http://www.example.com/foo.js' ) );
			$script->expects( $this->any() )
			       ->method( 'get_deps' )
			       ->will( $this->returnValue( array( 'fooscript' ) ) );
			$script->expects( $this->any() )
			       ->method( 'get_ver' )
			       ->will( $this->returnValue( true ) );
			$script->expects( $this->any() )
			       ->method( 'get_in_footer' )
			       ->will( $this->returnValue( true ) );
			       
			//stub the cpt model
			$model = $this->_createStubCptModel();

			$model->expects( $this->any() )
			      ->method( 'get_admin_scripts' )
			      ->will( $this->returnValue( array( $script ) ) );
			
			//add the model to the controller
			$this->setReflectionPropertyValue( $this->_controller, 'cpt_models', array( 'fooadminscript' => $model ) );
			
			//call the SUT
			$this->_controller->admin_enqueue_scripts();
			
			//make the assertion
			$this->assertScriptRegistered( 
				array(
					'adminscript',
					'http://www.example.com/foo.js',
					array( 'fooscript' ),
					true,
					true
				)
			);

		}
		
		/**
		 * @covers Base_Controller_CPT::wp_enqueue_scripts
		 */
		public function testMethodWpEnqueueScripts()
		{
			$this->assertTrue( method_exists( $this->_controller, 'wp_enqueue_scripts' ) );
			
			//create a stub script
			$script = $this->getMockBuilder( '\Base_Model_JS_Object' )
			               ->setMethods( array( 'get_handle', 'get_src', 'get_deps', 'get_ver', 'get_in_footer' ) )
			               ->disableOriginalConstructor()
			               ->getMock();
			
			$script->expects( $this->any() )
			       ->method( 'get_handle' )
			       ->will( $this->returnValue( 'fooscript' ) );
			$script->expects( $this->any() )
			       ->method( 'get_src' )
			       ->will( $this->returnValue( 'http://www.example.com/foo.js' ) );
			$script->expects( $this->any() )
			       ->method( 'get_deps' )
			       ->will( $this->returnValue( array( 'barscript' ) ) );
			$script->expects( $this->any() )
			       ->method( 'get_ver' )
			       ->will( $this->returnValue( true ) );
			$script->expects( $this->any() )
			       ->method( 'get_in_footer' )
			       ->will( $this->returnValue( true ) );
			       
			//stub the cpt model
			$model = $this->_createStubCptModel();

			$model->expects( $this->any() )
			      ->method( 'get_scripts' )
			      ->will( $this->returnValue( array( $script ) ) );
			
			//add the model to the controller
			$this->setReflectionPropertyValue( $this->_controller, 'cpt_models', array( 'foocptscript' => $model ) );
			
			//call the SUT
			$this->_controller->wp_enqueue_scripts();
			
			//make the assertion
			$this->assertScriptRegistered( 
				array(
					'fooscript',
					'http://www.example.com/foo.js',
					array( 'barscript' ),
					true,
					true
				)
			);
		}
	}
}
