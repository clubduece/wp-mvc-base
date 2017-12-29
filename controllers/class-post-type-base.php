<?php
namespace WPMVCB;

/**
 * The custom post type base.
 *
 * @package WPMVCB
 * @version 0.2
 * @since   WPMVCBase 0.2
 */
class Post_Type_Base {

	const POST_TYPE      = null;
	const INSTANCE_CLASS = null;

	/**
	 * The post type slug
	 *
	 * @var string
	 */
	public static $post_type = null;

	/**
	 * The singular name ( e.g. Book )
	 *
	 * @var    string
	 * @access protected
	 * @since  WPMVCBase 0.1
	 */
	protected static $_singular;

	/**
	 * The plural name ( e.g. Books )
	 *
	 * @var    string
	 * @access protected
	 * @since  WPMVCBase 0.1
	 */
	protected static $_plural;

	/**
	 * The arguments used to register the post type
	 *
	 * @var    array
	 * @access protected
	 * @since  WPMVCBase 0.4
	 */
	protected static $_post_type_args = array();

	/**
	 * @param  \WP_Post|int $post
	 * @return bool|mixed
	 */
	public static function get_instance( $post = null ) {

		$item  = null;

		do {
			if ( ! class_exists( $class = static::INSTANCE_CLASS ) ) {
				break;
			}

			// use the global post object
			if ( is_null( $post ) ) {
				$post = get_post();
			}

			if ( is_int( $post ) ) {
				$post = get_post( $post );
			}

			$item = new $class( $post );
		} while ( false );

		return $item;

	}

	/**
	 * Filter to ensure the CPT labels are displayed when user updates the CPT
	 *
	 * @param    array $messages The existing messages array.
	 * @return   array  $messages The updated messages array.
	 * @access   public
	 * @since    WPMVCBase 0.1
	 * @link     http://codex.wordpress.org/Plugin_API/Filter_Reference
	 */
	public static function post_updated_messages( $messages ) {

		$post = get_post();

		$post_type_object = get_post_type_object( $post->post_type );
		$singular         = $post_type_object->labels->singular_name;

		$messages[ $post->post_type ] = array(
			0 => null, // Unused. Messages start at index 1.
			1 => sprintf(
				__( '%1$s updated. <a href="%3$s">View %2$s</a>', 'wpmvcb' ),
				$singular,
				strtolower( $singular ),
				esc_url( get_permalink( $post->ID ) )
			),
			2 => __( 'Custom field updated.', 'wpmvcb' ),
			3 => __( 'Custom field deleted.', 'wpmvcb' ),
			4 => sprintf( __( '%s updated.', 'wpmvcb' ), $singular ),
			/* translators: %2$s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %s', 'wpmvcb' ), $singular, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( '%1$s published. <a href="%2$s">View %1$s</a>', 'wpmvcb' ), $singular, esc_url( get_permalink( $post->ID ) ) ),
			7 => sprintf( __( '%s saved.', 'wpmvcb' ), $singular ),
			8 => sprintf(
				__( '%1$s submitted. <a target="_blank" href="%3$s">Preview %2$s</a>', 'wpmvcb' ),
				$singular,
				strtolower( $singular ),
				esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
			),
			9 => sprintf(
				__( '%3$s scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview %4$s</a>', 'wpmvcb' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ),
				esc_url( get_permalink( $post->ID ) ),
				$singular,
				strtolower( $singular )
			),
			10 => sprintf(
				__( '%1$s draft updated. <a target="_blank" href="%3$s">Preview %2$s</a>', 'wpmvcb' ),
				$singular,
				strtolower( $singular ),
				esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
			)
		);

		return $messages;
	}

	/**
	 * Register necessary actions, filters, etc. when loading the class
	 */
	public static function on_load() {

		add_action( 'init', array( __CLASS__, '_init' ) );
		add_filter( 'post_updated_messages', array(  __CLASS__, 'post_updated_messages' ) );

	}

	/**
	 * Verify it is okay to save the post
	 *
	 * @param array $args
	 * @return bool
	 * @since  0.3.4
	 */
	public static function okay_to_save( $post_id, $args = array() ) {

		$okay = true;
		$args = wp_parse_args( $args, array(
			'post_type' => 'post',
		) );

		//do not respond to inline-save (aka Quick Edit)
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );
		if( 'inline-save' == $action ) {
			$okay = false;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			$okay = false;
		}

		if ( ! ( get_post_type( $post_id ) == $args['post_type'] ) ) {
			$okay = false;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			$okay = false;
		}

		return $okay;

	}

	/**
	 * @hook init
	 */
	public static function _init() {

		$post_type_args = array_merge( self::$_post_type_args, array(
			'labels' => self::init_labels(),
		) );

		register_post_type( static::POST_TYPE, $post_type_args );

	}

	/**
	 * Initialize the CPT labels
	 *
	 * @return string[]             The post type labels
	 * @access protected
	 * @since  WPMVCBase 0.1
	 */
	protected static function init_labels() {

		$plural = self::$_plural;
		$singular = self::$_singular;

		return array(
			'name'                => $plural,
			'singular_name'       => $singular,
			'menu_name'           => $plural,
			'parent_item_colon'   => sprintf( __( 'Parent %s:',           'wpmvcb' ), $singular ),
			'all_items'           => sprintf( __( 'All %s',               'wpmvcb' ), $plural ),
			'view_item'           => sprintf( __( 'View %s',              'wpmvcb' ), $singular ),
			'add_new_item'        => sprintf( __( 'Add New %s',           'wpmvcb' ), $singular ),
			'add_new'             => sprintf( __( 'New %s',               'wpmvcb' ), $singular ),
			'edit_item'           => sprintf( __( 'Edit %s',              'wpmvcb' ), $singular ),
			'update_item'         => sprintf( __( 'Update %s',            'wpmvcb' ), $singular ),
			'search_items'        => sprintf( __( 'Search %s',            'wpmvcb' ), $plural ),
			'not_found'           => sprintf( __( 'No %s found',          'wpmvcb' ), strtolower( $plural ) ),
			'not_found_in_trash'  => sprintf( __( 'No %s found in Trash', 'wpmvcb' ), strtolower( $plural ) ),
		);

	}
}
