<?php

define( 'WPMVCB_TEST_DIR', dirname( __FILE__ ) );
define( 'WPMVCB_SRC_DIR', dirname( dirname( __FILE__ ) ) );

require_once getenv( 'WP_TESTS_DIR' ) . '/tests/phpunit/includes/functions.php';

require getenv( 'WP_TESTS_DIR' ) . '/tests/phpunit/includes/bootstrap.php';

//include vfsStream support
require_once( WPMVCB_TEST_DIR . '/includes/vfs/Quota.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStream.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamException.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamContainerIterator.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamContainer.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamContent.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamAbstractContent.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamFile.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamDirectory.php' );
require_once( WPMVCB_TEST_DIR . '/includes/vfs/vfsStreamWrapper.php' );

require_once 'framework/class-constraint-metabox-exists.php';
require_once 'framework/class-constraint-script-registered.php';
require_once 'framework/testcase.php';

echo 'Welcome to the WP MVC Base Test Suite' . PHP_EOL;
echo 'Version 1.0' . PHP_EOL;
echo 'Author: Daryl Lozupone <daryl@actionhook.com>' . PHP_EOL;
