<?php
namespace WPMVCB;

/**
 * Class Post_View_Base
 * @package WPMVCB
 */
class Post_View_Base extends Base {

	/**
	 * @var Post_Base
	 */
	protected $item;

	/**
	 * Post_View_Base constructor.
	 *
	 * @param Post_Base $item
	 * @param array     $args
	 */
	public function __construct( $item, $args = array() ) {

		$this->item = $item;

		parent::__construct( $args );

	}

	/**
	 * @param string $template
	 * @param array  $args
	 */
	public function the_template( $template, $args = array() ) {

		$item = $this->item;

		/**
		 * Yes, we are aware of the dangers of extract. However, this is the
		 * exact intended use of extract(), which enables this library
		 * to emulate the global nature of WordPress variables available in theme templates.
		 */
		extract( $args );

		if( file_exists( $template ) ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				printf( '<!-- Template: %1$s -->', str_replace( WP_CONTENT_DIR, 'CONTENT_DIR', $template ) );
			}
			require $template;
		}

	}

	/**
	 * @param string $size
	 * @param array  $args
	 */
	public function the_image( $size = 'full', $args = array() ) {

		if ( is_callable( array( $this->item, 'get_image' ) ) ) {
			echo $this->item->get_image( $size, $args );
		}

	}

}
