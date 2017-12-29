<?php
namespace WPMVCB;

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class WPMVCB  {

    /**
     * The class version number
     *
     * @var    string
     * @access private
     * @since  0.4
     */
    private $version = '0.4';

    /**
     * A list of files that must be loaded at plugin initialization
     *
     * @var array
     */
    private $mustload_files = array();

    /**
     * A list of all classes contained in the framework.
     *
     * @var array
     */
    private $autoload_classes = array();

    /**
     * A collection of post type slugs and arguments used to register the post type as key/value pairs
     *
     * @var array
     */
    private $post_type_args = array();

    /**
     * Initialize the class
     */
    public function __construct() {

        $this->autoload_classes = array(
        	__NAMESPACE__ . '\Base'                           => __DIR__ . '/includes/class-base.php',
            __NAMESPACE__ . '\Controller_Base'                => __DIR__ . '/controllers/class-controller-base.php',
            __NAMESPACE__ . '\Post_Type_Base'                 => __DIR__ . '/controllers/class-post-type-base.php',
	        __NAMESPACE__ . '\Post_Base'                      => __DIR__ . '/controllers/class-post-base.php',
//            'Base_Controller_Plugin'         => __DIR__ . '/controllers/class-base-controller-plugin.php',
//            'WPMVCB_Settings_Base'           => __DIR__ . '/controllers/class-settings-base.php',
            __NAMESPACE__ . '\Taxonomy_Base'                  => __DIR__ . '/controllers/class-taxonomy-base.php',
//            'WPMVCB_Metabox'                 => __DIR__ . '/controllers/class-metabox-base.php',
            __NAMESPACE__ . '\Model_Base'              => __DIR__ . '/models/class-model-base.php',
//            'WPMVCB_Admin_Notice_Model_Base' => __DIR__ . '/models/class-admin-notice-model-base.php',
            __NAMESPACE__ . '\Post_Model_Base'         => __DIR__ . '/models/class-post-model-base.php',
//            'Base_Model_Help_Tab'            => __DIR__ . '/models/class-base-model-help-tab.php',
//            'Base_Model_JS_Object'           => __DIR__ . '/models/class-base-model-js-object.php',
//            'WPMVCB_Menu_Page_Model_Base'    => __DIR__ . '/models/class-menu-page-model-base.php',
//            'WPMVCB_Metabox_Model_Base'      => __DIR__ . '/models/class-metabox-model-base.php',
//            'Base_Model_Plugin'              => __DIR__ . '/models/class-base-model-plugin.php',
//            'WPMVCB_Settings_Model_Base'     => __DIR__ . '/models/class-settings-model-base.php',
//            'WPMVCB_Taxonomy_Model_Base'     => __DIR__ . '/models/class-base-model-taxonomy.php',
            __NAMESPACE__ . '\Post_View_Base'          => __DIR__ . '/views/class-post-view-base.php',
//            'WPMVCB_Metabox_View_Base'       => __DIR__ . '/views/class-metabox-view-base.php',
//            'WPMVCB_Metabox_Default_View'    => __DIR__ . '/views/class-metabox-view-default.php',
//            'Helper_Functions'               => __DIR__ . '/helpers/class-base-helpers.php',
        );

        spl_autoload_register( array( $this, 'autoloader' ) );

        add_action( 'init', array( $this, 'init' ) );
        add_action( 'muplugins_loaded', array( $this, 'load_mustloads' ) );

    }

    /**
     * Add additional class name/absloute path pairs to the list of classes able to be autoloaded.
     *
     * @param array $classes
     */
    public function register_autoload_classes( array $classes ) {

        $this->autoload_classes = array_merge( $this->autoload_classes, $classes );

    }

    /**
     * Autoload classes
     *
     * $param string $class The class to be loaded
     * @return void
     */
    public function autoloader( $class ) {

        if ( isset( $this->autoload_classes[ $class ] ) ) {
            if ( file_exists( $this->autoload_classes[ $class ] ) ) {
                require_once $this->autoload_classes[ $class ];
                if ( is_callable( array( $class, 'on_load') ) ) {
                    call_user_func( array( $class, 'on_load' ) );
                }
            }
        }

    }

    /**
     * Add files that must be loaded at plugin initialization
     *
     * @param array $files
     */
    public function register_mustload_files( array $files ) {

        $this->mustload_files = array_merge( $files, $this->mustload_files );

    }

    /**
     * Load the files in the $mustload property
     */
    public function load_mustloads() {

        foreach( $this->mustload_files as $key => $file ) {
            if( file_exists( $file ) ) {
                require_once $file;
                if ( is_callable( "{$key}::on_load" ) ) {
                    call_user_func( array( $key, 'on_load' ) );
                }
            }
        }

    }

    /**
     * Register the post type slug and its post type arguments
     *
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     */
    public function register_post_type_args( $slug, $args = array() ) {

        $this->post_type_args[ $slug ] = $args;

    }

    /**
     * The WP init action callback
     */
    public function init() {

        $this->register_post_types();

    }

    /**
     * Register the post types stored in self::$post_type_args
     *
     * This method also adds rewrite rules for date based archives, if the post type itself supports archives.
     */
    private function register_post_types() {

        foreach( $this->post_type_args as $slug => $args ) {

            register_post_type( $slug, $args );

            $post_type = get_post_type_object( $slug );

            if ( $post_type && $post_type->has_archive ) {
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/([0-9]{2})/feed/(feed|rdf|rss|rss2|atom)/?$", 'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]$matches[3]&feed=$matches[4]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/([0-9]{2})/(feed|rdf|rss|rss2|atom)/?$",      'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]$matches[3]&feed=$matches[4]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/([0-9]{2})/page/?([0-9]{1,})/?$",             'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]$matches[3]&paged=$matches[4]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/([0-9]{1,2})/?$",                             'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]$matches[3]', 'top' );
                //Monthly archive
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/feed/(feed|rdf|rss|rss2|atom)/?$", 'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]&feed=$matches[3]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/(feed|rdf|rss|rss2|atom)/?$",      'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]&feed=$matches[3]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/page/?([0-9]{1,})/?$",             'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]&paged=$matches[3]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/([0-9]{2})/?$",                               'index.php?post_type=' . $slug . '&m=$matches[1]$matches[2]', 'top' );
                //Yearly archive
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$", 'index.php?post_type=' . $slug . '&m=$matches[1]&feed=$matches[2]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$",      'index.php?post_type=' . $slug . '&m=$matches[1]&feed=$matches[2]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/page/?([0-9]{1,})/?$",             'index.php?post_type=' . $slug . '&m=$matches[1]&paged=$matches[2]','top');
                add_rewrite_rule( "{$post_type->rewrite['slug']}/([0-9]{4})/?$",                               'index.php?post_type=' . $slug . '&m=$matches[1]', 'top' );
            }
        }
        
    }

    /**
     * Get the main library directory
     *
     * @return string
     */
    public function get_source_dir() {

        return __DIR__;

    }

    /**
     * Get the base version number
     */
    public function get_version() {

        return $this->version;

    }

}
