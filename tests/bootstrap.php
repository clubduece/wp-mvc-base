<?php

define( 'WPMVCB_TEST_DIR', dirname( __FILE__ ) );
define( 'WPMVCB_SRC_DIR', dirname( dirname( __FILE__ ) ) );

require_once getenv( 'WP_TESTS_DIR' ) . '/includes/functions.php';

require getenv( 'WP_TESTS_DIR' ) . '/includes/bootstrap.php';

require_once( 'framework/testcase.php' );
require_once( WPMVCB_SRC_DIR . '/helpers/base_helpers.php' );

echo 'Welcome to the WP MVC Base Test Suite' . PHP_EOL;
echo 'Version 1.0' . PHP_EOL;
echo 'Author: Daryl Lozupone <daryl@actionhook.com>' . PHP_EOL;
?>