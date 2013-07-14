<?php
namespace WPMVCB\Testing
{	
	require( WPMVCB_SRC_DIR . '/models/base_model_settings.php' );
	
	class foo extends \Base_Model_Settings
	{
		protected function init( $uri, $path, $txtdomain )
		{
			//implemented, but does nothing
		}
	}
	
	class testBaseModelSettings extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			$this->_settings_model = new foo( 'http://example.com', 'foopath', 'footxtdomain');
			parent::setUp();
		}
		
		public function testPropertyOptionsExists()
		{
			$this->assertClassHasAttribute( 'options', '\Base_Model_Settings' );
		}
		
		public function testPropertyPagesExists()
		{
			$this->assertClassHasAttribute( 'pages', '\Base_Model_Settings' );
		}
		
		public function testPropertySettingsSectionsExists()
		{
			$this->assertClassHasAttribute( 'settings_sections', '\Base_Model_Settings' );
		}
		
		public function testPropertySettingsFieldsExists()
		{
			$this->assertClassHasAttribute( 'settings_fields', '\Base_Model_Settings' );
		}
		
		public function testPropertySettingsExists()
		{
			$this->assertClassHasAttribute( 'settings', '\Base_Model_Settings' );
		}
		
		public function testMethodInitSettings()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'init_settings' ), 'Method does not exist' );
			
			$this->setReflectionPropertyValue( $this->_settings_model, 'options', array( 'foo', 'bar', 'baz' ) );
			$this->reflectionMethodInvoke( $this->_settings_model, 'init_settings' );
			$this->markTestIncomplete( 'Missing assertions' );
		}
		
		public function testMethodGetOptions()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_options' ), 'Method does not exist' );
			
			$this->setReflectionPropertyValue( $this->_settings_model, 'options', array( 'foo', 'bar', 'baz' ) );
			
			$this->assertEquals( array( 'foo', 'bar', 'baz' ), $this->_settings_model->get_options() );
		}
		
		public function testMethodGetPages()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_pages' ), 'Method does not exist' );
			
			$this->setReflectionPropertyValue( $this->_settings_model, 'pages', array( 'foo', 'bar', 'baz' )
			);
			
			$this->assertEquals( array( 'foo', 'bar', 'baz' ), $this->_settings_model->get_pages() );
		}
		
		public function testMethodGetSettingsSectionsExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_settings_sections' ), 'Method does not exist' );
		}
		
		/**
		 * @depends testMethodGetSettingsSectionsExists
		 */
		public function testMethodGetSettingsSectionsAll()
		{			
			$this->setReflectionPropertyValue(
				$this->_settings_model,
				'settings_sections',
				array(
					'foo' => 'bar', 
					'baz'
				)
			);
			
			//get all sections
			$this->assertEquals( 
				array( 'foo' => 'bar', 'baz' ),
				$this->_settings_model->get_settings_sections() , 
				'Get all sections failed'
			);
		}
		
		/**
		 * @depends testMethodGetSettingsSectionsExists
		 */
		public function testMethodGetSettingsSectionsKeyExisting()
		{			
			$this->setReflectionPropertyValue(
				$this->_settings_model,
				'settings_sections',
				array(
					'foo' => 'bar', 
					'bar'
				)
			);
			
			$this->assertEquals(
				'bar',
				$this->_settings_model->get_settings_sections( 'foo' ),
				'Get one section failed'
			);
		}
		
		/**
		 * @depends testMethodGetSettingsSectionsExists
		 */
		public function testMethodGetSettingsSectionsKeyNonexistent()
		{			
			$this->setReflectionPropertyValue(
				$this->_settings_model,
				'settings_sections',
				array(
					'foo' => 'bar', 
					'bar'
				)
			);

			$this->assertFalse(
				$this->_settings_model->get_settings_sections( 'baz' ),
				'Get nonexistent section failed'
			);
		}
		
		
		public function testMethodGetSettingsFields()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_settings_fields' ), 'Method does not exist' );
			
			$this->setReflectionPropertyValue( $this->_settings_model, 'settings_fields', array( 'foo', 'bar', 'baz' )
			);
			
			$this->assertEquals( array( 'foo', 'bar', 'baz' ), $this->_settings_model->get_settings_fields() );
		}
		
		public function testEditPageExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'edit_page' ) );
		}
		
		/**
		 * @depends testEditPageExists
		 */
		public function testMethodEditPage()
		{
			$this->setReflectionPropertyValue( $this->_settings_model, 'pages', array( 'foo' => array() ) );
			$this->assertTrue( $this->_settings_model->edit_page( 'foo', array( 'bar' => 'baz' ) ) );
			$this->assertEquals(
				array( 'foo' => array( 'bar' => 'baz') ),
				$this->getReflectionPropertyValue( $this->_settings_model, 'pages' )
			);
		}
		
		/**
		 * @depends testEditPageExists
		 */
		public function testMethodEditPageFail()
		{
			$this->assertFalse( $this->_settings_model->edit_page( 'foo', array( 'bar' => 'baz' ) ) );
		}
		
		public function testMethodEditSettingsSectionExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'edit_settings_section' ) );
		}
		
		/**
		 * @depends testMethodEditSettingsSectionExists
		 */
		public function testMethodEditSettingsSection()
		{
			$this->setReflectionPropertyValue( $this->_settings_model, 'settings_sections', array( 'foo' => array() ) );
			$this->assertTrue( $this->_settings_model->edit_settings_section( 'foo', array( 'bar' => 'baz' ) ) );
			$this->assertEquals(
				array( 'foo' => array( 'bar' => 'baz') ),
				$this->getReflectionPropertyValue( $this->_settings_model, 'settings_sections' )
			);
		}
		
		/**
		 * @depends testMethodEditSettingsSectionExists
		 */
		public function testMethodEditSettingsSectionFail()
		{
			$this->assertFalse( $this->_settings_model->edit_settings_section( 'foo', array( 'bar' => 'baz' ) ) );
		}
		
		public function testMethodGetSettingsExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_settings' ), 'Method does not exist' );
		}
		
		/**
		 * Test the Base_Model_Settings class' ability to handle multiple options stored as key/value pairs.
		 *
		 * @depends testMethodGetSettingsExists
		 * @since 0.1
		 */
		public function testMethodGetSettingsSingleAll()
		{
			//add the options to wpdb
			\add_option( 'fooname', '1' );
			\add_option( 'barname', '2' );
			\add_option( 'bazname', '3' );
			
			//set up the settings_model options property
			$this->setReflectionPropertyValue(
				$this->_settings_model,
				'options',
				array(
					'foo' => array( 'option_name' => 'fooname' ),
					'bar' => array( 'option_name' => 'barname' ),
					'baz' => array( 'option_name' => 'bazname' )
				)
			);
			
			//initialize the settings_model options
			$this->reflectionMethodInvoke( $this->_settings_model, 'init_settings' );
			
			$this->assertEquals( array( 'fooname' => '1', 'barname' => '2', 'bazname' => '3' ), $this->_settings_model->get_settings() );
		}
		
		/**
		 * @depends testMethodGetSettingsSingleAll
		 */
		public function testMethodGetSettingsSingleKeyExists()
		{
			//add the options to wpdb
			\add_option( 'fooname', '1' );
			\add_option( 'barname', '2' );
			\add_option( 'bazname', '3' );
			
			//set up the settings_model options property
			$this->setReflectionPropertyValue(
				$this->_settings_model,
				'options',
				array(
					'foo' => array(	'option_name' => 'fooname' ),
					'bar' => array( 'option_name' => 'barname' ),
					'baz' => array( 'option_name' => 'bazname' )
				)
			);
			
			//initialize the settings_model options
			$this->reflectionMethodInvoke( $this->_settings_model, 'init_settings' );
			
			$this->assertEquals( '1', $this->_settings_model->get_settings( 'fooname' ) );
		}
		
		/**
		 * @depends testMethodGetSettingsExists
		 */
		public function testMethodGetSettingsSingleOptionElementError()
		{
			//add the options to wpdb
			\add_option( 'fooname', '1' );
			\add_option( 'barname', '2' );
			\add_option( 'bazname', '3' );
			
			//set up the settings_model options property
			$this->setReflectionPropertyValue(
				$this->_settings_model,
				'options',
				array(
					'foo' => array(	'option_name' => 'fooname' ),
					'bar' => array( 'option_name' => 'barname' ),
					'baz' => array( 'option_name' => 'bazname' )
				)
			);
			
			//initialize the settings_model options
			$this->reflectionMethodInvoke( $this->_settings_model, 'init_settings' );
			$this->assertFalse( $this->_settings_model->get_settings( 'barname', 'huzzah' ) );
			
		}
		
		/**
		 * This test emulates a multiple option group stored as serialized arrays setup.
		 *
		 * @depends testMethodGetSettingsExists
		 */
		public function testMethodGetSettingsArrayAll()
		{
			//set the options in the wpdb
			\add_option( 'fooname', array( 'foobar', 'foobaz' ) );
			\add_option( 'barname', array( 'barbar', 'barbaz' ) );
			
			//set up the settings_model options property
			$this->setReflectionPropertyValue(
				$this->_settings_model,
				'options',
				array(
					'foo' => array(	'option_name' => 'fooname' ),
					'bar' => array( 'option_name' => 'barname' ),
					'baz' => array( 'option_name' => 'bazname' )
				)
			);
			
			//initialize the settings_model options
			$this->reflectionMethodInvoke( $this->_settings_model, 'init_settings' );
			
			$this->assertEquals(
				array( 'fooname' => array( 'foobar', 'foobaz'), 'barname' => array( 'barbar', 'barbaz' ), 'bazname' => false ),
				$this->_settings_model->get_settings()
			);
		}
		
		/**
		 * @depends testMethodGetSettingsExists
		 */
		public function testMethodGetSettingsOptionGroupKeyExists()
		{
			$this->setReflectionPropertyValue( $this->_settings_model, 'settings', array( 'foo' => array( 'bar', 'baz' )	) );
			$this->assertEquals( array( 'bar', 'baz'), $this->_settings_model->get_settings( 'foo' ) );
		}
		
		/**
		 * @depends testMethodGetSettingsExists
		 */
		public function testMethodGetSettingsOptionGroupKeyNonexistent()
		{
			$this->setReflectionPropertyValue( $this->_settings_model, 'settings', array( 'foo' => array( 'bar', 'baz' )	) );
			$this->assertFalse( $this->_settings_model->get_settings( 'baz' ) );
		}
		
		/**
		 * Test for an existing option group key and an existing option key.
		 *
		 * This test asserts the Base_Model_Settings class' ability to process options stored as a serialized array.
		 *
		 * @depends testMethodGetSettingsOptionGroupKeyExists
		 */
		public function testMethodGetSettingsOptionGroupKeyExistsOptionKeyExists()
		{
			$this->setReflectionPropertyValue( $this->_settings_model, 'settings', array( 'foo' => array( 'bar' => 'baz' )	) );
			$this->assertEquals( 'baz', $this->_settings_model->get_settings( 'foo', 'bar' ) );
		}
		
		/**
		 * Test default value for non-existent option in an options array.
		 *
		 * @depends testMethodGetSettingsOptionGroupKeyExistsOptionKeyExists
		 */
		public function testMethodGetSettingsOptionGroupKeyExistsOptionKeyNonexistentDefault()
		{
			//set up a settings field with a default value
			$this->setReflectionPropertyValue( 
				$this->_settings_model,
				'settings_fields',
				array( 'bar' => array( 'default' => 'baz' ) )
			);
			
			//set up a settings structure
			$this->setReflectionPropertyValue(
				$this->_settings_model, 'settings',
				array( 'foo' => array( 'baz' ) ) 
			);
			
			$this->assertEquals( 'baz', $this->_settings_model->get_settings( 'foo', 'bar' ) );
		}
		
		/**
		 * Test no default value for non-existent option.
		 *
		 * @depends testMethodGetSettingsOptionGroupKeyExistsOptionKeyExists
		 */
		public function testMethodGetSettingsOptionGroupKeyExistsOptionKeyNonexistentNoDefault()
		{
			$this->setReflectionPropertyValue( $this->_settings_model, 'settings', array( 'foo' => array( 'bar', 'baz' )	) );
			$this->assertFalse( $this->_settings_model->get_settings( 'foo', 'yazoo' ) );
		}
		
		/**
		 * @depends testMethodGetSettingsExists
		 */
		public function testMethodGetSettingsKeyNonexistent()
		{
			$this->setReflectionPropertyValue( $this->_settings_model, 'settings', array( 'foo' => array( 'bar', 'baz' )	) );
			$this->assertFalse( $this->_settings_model->get_settings( 'yazoo' ) );
		}
		
		public function testMethodAddOptionExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'add_option' ) );
		}
		
		/**
		 * @depends testMethodAddOptionExists
		 */
		public function testMethodAddOption()
		{
			$expected = array( 'foo' => array( 'option_group' => 'bar', 'option_name' => 'baz' ) );
			
			$this->assertTrue( $this->_settings_model->add_option( $expected ) );
			$this->assertEquals( $expected, $this->getReflectionPropertyValue( $this->_settings_model, 'options' ) );
		}
		
		/**
		 * @depends testMethodAddOptionExists
		 */
		public function testMethodAddOptionPassNonarray()
		{
			$this->assertFalse( $this->_settings_model->add_option( 'foo' ) );
		}
		
		/**
		 * @depends testMethodAddOptionExists
		 */
		public function testMethodAddOptionPassNonarrayErrorMessage()
		{
			$this->_settings_model->add_option( 'foo' );
			$error = error_get_last();
			$this->assertEquals(
				sprintf(
					__( 'Method add_option expects an array. The passed in parameter is of type: %s', 'wpmvcb' ),
					gettype( 'foo' )
				),
				$error['message']
			);
		}
		
		public function testMethodAddSettingsSectionExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'add_settings_section' ) );
		}
		
		/**
		 * @depends testMethodAddSettingsSectionExists
		 */
		public function testMethodAddSettingsSection()
		{
			$expected = array(
				'foo-section'  => array(
					'title'    => 'foo',
					'callback' => 'foo-callback',
					'page'     => 'foo-page',
					'content'  => 'Content foo'
				)
			);
			
			$this->assertTrue( $this->_settings_model->add_settings_section( $expected ) );
			$this->assertEquals( $expected, $this->getReflectionPropertyValue( $this->_settings_model, 'settings_sections' ) );
		}
		
		/**
		 * @depends testMethodAddSettingsSectionExists
		 */
		public function testMethodAddSettingsSectionPassNonarray()
		{
			$this->assertFalse( $this->_settings_model->add_settings_section( 'foo' ) );
		}
		
		/**
		 * @depends testMethodAddSettingsSectionExists
		 */
		public function testAddSettingsSectionPassNonarrayErrorMessage()
		{
			$this->_settings_model->add_option( 'foo' );
			$error = error_get_last();
			$this->assertEquals(
				sprintf(
					__( 'Method add_option expects an array. The passed in parameter is of type: %s', 'wpmvcb' ),
					gettype( 'foo' )
				),
				$error['message']
			);
		}
		
		public function testMethodAddSettingsFieldExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'add_settings_field' ) );
		}
		
		/**
		 * @depends testMethodAddSettingsFieldExists
		 */
		public function testMethodAddSettingsField()
		{
			$expected = array(
				'foo-field'  => array(
					'title'    => 'foo',
					'callback' => 'foo-callback',
					'page'     => 'foo-page',
					'content'  => 'Content foo'
				)
			);
			
			$this->assertTrue( $this->_settings_model->add_settings_field( $expected ) );
			$this->assertEquals( $expected, $this->getReflectionPropertyValue( $this->_settings_model, 'settings_fields' ) );
		}
		
		/**
		 * @depends testMethodAddSettingsFieldExists
		 */
		public function testMethodAddSettingsFieldPassNonarray()
		{
			$this->assertFalse( $this->_settings_model->add_settings_field( 'foo' ) );
		}
		
		/**
		 * @depends testMethodAddSettingsFieldExists
		 */
		public function testMethodAddSettingsFieldPassNonarrayErrorMessage()
		{
			$this->_settings_model->add_settings_field( 'foo' );
			$error = error_get_last();
			$this->assertEquals(
				sprintf(
					__( 'Method add_settings_field expects an array. The passed in parameter is of type: %s', 'wpmvcb' ),
					gettype( 'foo' )
				),
				$error['message']
			);
		}
		
		public function testMethodSanitizeInputExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'sanitize_input' ) );
		}
		
		/**
		 * @depends testMethodSanitizeInputExists
		 */
		public function testMethodSanitizeInputString()
		{
			$input = sanitize_text_field(
				"`1234567890--=~!@#$%^&*()_+qwertyuiop[]\QWERTYUIOP{}|asdfghjkl;'ASDFGHJKL:\"zxcvbnm,./ZXCVBNM<>?"
			);
			
			$this->assertEquals( $input, $this->_settings_model->sanitize_input( $input ) );
		}
		
		/**
		 * @depends testMethodSanitizeInputExists
		 */
		public function testMethodSanitizeInputArray()
		{
			$input['foo'] = sanitize_text_field(
				"`1234567890--=~!@#$%^&*()_+qwertyuiop[]\QWERTYUIOP{}|asdfghjkl;'ASDFGHJKL:\"zxcvbnm,./ZXCVBNM<>?"
			);
			
			$this->assertEquals( $input, $this->_settings_model->sanitize_input( $input ) );
		}
	}
}
?>