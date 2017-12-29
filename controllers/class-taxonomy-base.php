<?php
namespace WPMVCB;

/**
 * Class Taxonomy_Base
 *
 * @method static array    taxonomy_args()
 * @method static string[] object_types()
 *
 * @since WPMVCBase 0.4
 */
class Taxonomy_Base extends Base {

	/**
	 * The taxonomy slug
	 */
	const TAXONOMY = null;

	/**
	 * The term class
	 */
	const INSTANCE_CLASS = null;
	
	/**
	 * The post type slugs to which this taxonomy is assigned
	 *
	 * @var array
	 */
	protected static $_object_types = array();

	/**
	 * The taxonomy slug and arguments stored as key/value pairs
	 */
	protected static $_taxonomy_args = array();

	/**
	 *
	 */
	public static function get_term() {

	}

	public static function register_object_types( $types = array() ) {

		self::$_object_types = $types;

	}

	/**
	 * Register the taxonomy arguments
	 *
	 * @param array  $args
	 */
	public static function register_taxonomy_args( $args ) {

		self::$_taxonomy_args = $args;

	}

	/**
	 * The WP init action callback
	 */
	public static function init() {

		register_taxonomy( static::TAXONOMY, static::object_types(), static::taxonomy_args() );

	}

	/**
	 * Initialize the labels.
	 * 
	 * @access public
	 * @param  string $singular
	 * @param  string $plural
	 * @return array            An array containing key/value pairs for the taxonomy labels.
	 */
	public static function init_labels( $singular, $plural ) {

		return array(
			'name'              => $plural,
			'singular_name'     => $singular,
			'search_items'      => sprintf( __( 'Search %s',   'wpmvcb' ), $plural ),
			'all_items'         => sprintf( __( 'All %s',      'wpmvcb' ), $plural ),
			'parent_item'       => sprintf( __( 'Parent %s',   'wpmvcb' ), $singular ),
			'parent_item_colon' => sprintf( __( 'Parent %s:',  'wpmvcb' ), $singular ),
			'edit_item'         => sprintf( __( 'Edit %s',     'wpmvcb' ), $singular ),
			'update_item'       => sprintf( __( 'Update %s',   'wpmvcb' ), $singular ),
			'add_new_item'      => sprintf( __( 'Add New %s',  'wpmvcb' ), $singular ),
			'new_item_name'     => sprintf( __( 'New %s Name', 'wpmvcb' ), $singular ),
			'menu_name'         => $plural,
		);

	}

	/**
	 * Initialize the controller
	 */
	public static function on_load() {

		add_action( 'init', array( __CLASS__, 'init' ) );

	}

}
