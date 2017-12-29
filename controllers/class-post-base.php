<?php

namespace WPMVCB;

/**
 * Class Post_Base
 * @package WPMVCB
 *
 * @property Post_Model_Base $_model
 * @property Post_View_Base  $_view
 *
 * @method   Post_Model_Base model()
 * @method   Post_View_Base  view()
 *
 * @mixin    Post_Model_Base
 */
class Post_Base extends Controller_Base {

	/**
	 * Post_Base constructor.
	 *
	 * @param \WP_Post|int $item
	 * @param array $args
	 */
	public function __construct( $item, $args = array() ) {

		$args = wp_parse_args( $args, array(
			'model' => new Post_Model_Base( $item, $args ),
			'view'  => new Post_View_Base( $this ),
		) );

		parent::__construct( $args );
	}

}