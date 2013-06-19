<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_cpt.php' );
	
	/**
	 * The Test Stub CPT Model
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WP MVC Base Testing 0.1
	 */
	class Test_Stub_Base_Model_CPT extends \Base_Model_CPT
	{
		protected $slug = 'my-super-cool-cpt';
		protected $metakey = '_my-super-cool-metakey';
		protected $shortcodes = array(
			'my-super-cool-shortcode' => 'my-super-cool-callback'
		);
		
		public function __construct( $uri, $txtdomain )
		{
			parent::__construct( $uri, $txtdomain );
			add_action( 'init', array( &$this, 'register' ) );
		}
		
		public function save( $postdata )
		{
			//dummy implementation of abstract function
		}
	}
	
	/**
	 * The test controller for Base_Model_CPT
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class Test_Base_Model_CPT extends \WP_UnitTestCase
	{
		private $_cpt;
		
		public function SetUp()
		{
			$this->_cpt = new Test_Stub_Base_Model_CPT( 'http://example.com', 'my-super-cool-text-domain' );
			$this->_post = new \StdClass;
			$this->_post->ID = 4;
		}
		
		public function test_get_slug()
		{
			$this->assertEquals( 'my-super-cool-cpt', $this->_cpt->get_slug() );
		}
		
		public function test_get_metakey()
		{
			$this->assertEquals( '_my-super-cool-metakey', $this->_cpt->get_metakey() );
		}
		
		public function test_get_shortcodes()
		{
			$this->assertEquals( array( 'my-super-cool-shortcode' => 'my-super-cool-callback' ), $this->_cpt->get_shortcodes() );
		}
		
		public function test_get_post_updated_messages()
		{
			$messages = array(
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
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $this->_post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $this->_post->ID) ) ) )
			);
			
			$this->assertEquals( $messages, $this->_cpt->get_post_updated_messages( $this->_post->ID, 'my-super-cool-text-domain' ) );
		}
	}
}
?>
