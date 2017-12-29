<?php

namespace WPMVCB;

/**
 * The base CPT object model.
 *
 * @package WPMVCBase\Models
 * @version 0.2
 * @since   WPMVCBase 0.1
 *
 * @method \WP_Post post()
 * @method int      ID()
 * @method int[]    ancestors()
 * @method int      post_author()
 * @method string   post_category()
 * @method string   post_content()
 * @method string   post_content_filtered()
 * @method string   post_date()
 * @method string   post_date_gmt()
 * @method string   post_name()
 * @method string   post_title()
 */
class Post_Model_Base extends Model_Base {

	/**
	 * @var \WP_Post $post
	 */
	protected $_post;

	/**
	 * @var \WP_Post|int $post
	 * @var array $args
	 */
	public function __construct( $post, $args = array() ) {

		if ( is_int( $post ) ) {
			$post = get_post( $post );
		}

		if ( is_a( $post, 'WP_Post' ) ) {
			$args['post'] = $post;
		}

		parent::__construct( $args );

	}

	/**
	 * @return bool
	 */
	public function has_post() {

		$has_post = false;

		if ( isset( $this->_post ) ) {
			$has_post = true;
		}

		return $has_post;

	}

	/**
	 * @return \WP_Post
	 * @deprecated
	 */
	public function get_post() {

		$this->deprecated( __METHOD__, 'post()' );
		return $this->_post;

	}

	/**
	 * @return bool
	 */
	public function has_image() {

		$value = false;

		if ( $this->has_post() ) {
			$value = has_post_thumbnail( $this->_post->ID );
		}

		return $value;
	}

	/**
	 * @param  string $size
	 * @param  array $attr
	 * @return mixed|null|void
	 */
	public function get_image( $size = 'full', $attr = array() ) {

		$value = null;

		if( $this->has_image() ) {
			$value =  get_the_post_thumbnail( $this->_post->ID, $size, $attr );
		}

		return $value;
	}

	/**
	 * @return int
	 */
	public function get_image_id() {

		$value = 0;

		if ( $this->has_post() ) {
			if ( $this->has_image() ) {
				$value  = get_post_thumbnail_id( $this->_post->ID );
			}
		}

		return $value;

	}

	public function get_permalink() {

		$permalink = '';

		if ( $this->has_post() ) {
			$permalink = get_permalink( $this->_post->ID );
		}

		return $permalink;

	}

	/**
	 * @param  string $method
	 * @param  array $args
	 *
	 * @return null
	 */
	public function __call( $method, $args ) {

		do {

			if ( $this->has_post() && $this->_is_post_property( $method ) ) {
				$value = $this->_post->{$method};
				break;
			}

			$value = parent::__call( $method, $args );
		} while ( false );

		return $value;
	}

	/**
	 * @param  string $property
	 *
	 * @return bool
	 */
	protected function _is_post_property( $property ) {

		do {
			if ( property_exists( \WP_Post::class, $property ) ) {
				$is_pp = true;
				break;
			}

			if ( in_array( $property, array( 'ancestors', 'post_category', 'tags_input', 'page_template' ) ) ) {
				$is_pp = true;
				break;
			}

			if ( metadata_exists( 'post', $this->_post->ID, $property ) ) {
				$is_pp = true;
				break;
			}

			$is_pp = false;
		} while ( false );

		return $is_pp;

	}

}
