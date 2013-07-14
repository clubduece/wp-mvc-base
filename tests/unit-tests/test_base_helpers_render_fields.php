<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/helpers/render_fields.php' );
	
	class testBaseHelpersRenderFields extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
			
			//set up our virtual filesystem
			\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();
		}
		
		public function testMethodRenderInputExists()
		{
			$this->assertTrue( method_exists( '\Base_Helpers_Render_Fields', 'render_input_text' ), 'Method does not exist' );
		}
		
		/**
		 * @depends testMethodRenderInputExists
		 */
		public function testMethodRenderInputText()
		{			
			$expected = '<input type="text" id="my-input" name="my_input" value="foo" placeholder="Enter some value" />bar';
			
			$this->assertEquals( 
				$expected,
				\Base_Helpers_Render_Fields::render_input_text( 'my-input', 'my_input', 'foo', 'Enter some value', 'bar' )
			);
		}
		
		/**
		 * @depends testMethodRenderInputExists
		 */
		public function testMethodRenderInputTextFileAfter()
		{
			$handle = fopen( $this->_mock_path . '/view.php', 'w' );
			fwrite( $handle, 'foo = bar' );
			fclose( $handle );
			
			$this->assertTrue( $this->_filesystem->hasChild( 'view.php' ) );
			
			$expected = '<input type="text" id="my-input" name="my_input" value="foo" placeholder="Enter some value" />foo = bar';
			
			$this->assertEquals( 
				$expected,
				\Base_Helpers_Render_Fields::render_input_text( 'my-input', 'my_input', 'foo', 'Enter some value', $this->_mock_path . '/view.php' )
			);
		}
		
		
		public function testMethodRenderInputCheckboxExists()
		{
			$this->assertTrue( method_exists( '\Base_Helpers_Render_Fields', 'render_input_checkbox' ) );
		}
		
		/**
		 * @depends testMethodRenderInputCheckboxExists
		 */
		public function testMethodRenderInputCheckbox()
		{
			$expected = '<input type="checkbox" id="my-checkbox" name="my_checkbox" value="1" />';
			
			$this->assertEquals( $expected, \Base_Helpers_Render_Fields::render_input_checkbox( 'my-checkbox', 'my_checkbox', 0 ) );
		}
		
		/**
		 * @depends testMethodRenderInputCheckboxExists
		 */
		public function testMethodRenderInputCheckboxChecked()
		{
			$expected = '<input type="checkbox" id="my-checkbox" name="my_checkbox" value="1" checked />';
			
			$this->assertEquals( $expected, \Base_Helpers_Render_Fields::render_input_checkbox( 'my-checkbox', 'my_checkbox', 1 ) );
		}
		
		
		public function testMethodRenderInputSelectExists()
		{
			$this->assertTrue( method_exists( '\Base_Helpers_Render_Fields', 'render_input_select' ) );
		}
		
		/**
		 * @depends testMethodRenderInputSelectExists
		 */
		public function testMethodRenderInputSelect()
		{	
			$expected = '<select id="my-select" name="my_select"><option value="">Select…</option><option value="my_option" >My Option</option></select>';
			
			$this->assertEquals(
				$expected,
				\Base_Helpers_Render_Fields::render_input_select(
					'my-select',
					'my_select',
					array( 'my_option' => 'My Option' ),
					null
				)
			);
		}
		
		/**
		 * @depends testMethodRenderInputSelectExists
		 */
		public function testMethodRenderInputSelectSelected()
		{	
			$expected = '<select id="my-select" name="my_select"><option value="">Select…</option><option value="my_option" selected>My Option</option></select>';
			
			$this->assertEquals(
				$expected,
				\Base_Helpers_Render_Fields::render_input_select(
					'my-select',
					'my_select',
					array( 'my_option' => 'My Option' ),
					'my_option'
				)
			);
		}
		
		public function testMethodRenderTextarea()
		{
			$field = array(
				'type'		=> 'textarea',
				'id'		=> 'my-textarea',
				'name'		=> 'my_textarea',
				'value'		=> 'My textarea content'
			);
			$this->assertTrue( method_exists( '\Base_Helpers_Render_Fields', 'render_input_textarea' ) );
			$expected = '<textarea id="my-textarea" name="my_textarea" >My textarea content</textarea>';
			
			$this->assertEquals( 
				$expected,
				\Base_Helpers_Render_Fields::render_input_textarea( 'my-textarea', 'my_textarea', 'My textarea content'	)
			);
		}
	}
}
?>
