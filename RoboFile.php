<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
	// define public methods as commands

	/**
	 * Download the WP test suite, configure for testing, and run the tests themselves.
	 *
	 * @param string $version
	 */
	function tests($version = '4.9.1')
	{

		$this->taskExec('mysql -e "CREATE DATABASE IF NOT EXISTS test_db"')->run();
		$this->taskExec('mysql -e "GRANT ALL ON test_db.* to \'root\'@\'%\'"')->run();
		$this->taskSvnStack()
		     ->checkout("https://develop.svn.wordpress.org/tags/{$version} wp-tests")
		     ->run();

		$this->setTestConfig();
		$this->phpunit();

	}

	/**
	 * Run the test suite using the default configuration.
	 *
	 * @param string $config The relative path to the PHPUnit XML configuration file.
	 */
	function phpunit($config = 'tests/phpunit.xml.dist')
	{
		$this->taskPhpUnit('vendor/bin/phpunit')
		     ->configFile($config)
		     ->envVars(array('WP_TESTS_DIR' => 'wp-tests'))
		     ->run();
	}

	private function setTestConfig()
	{

		if (file_exists('wp-tests/wp-tests-config-sample.php')) {
			copy('wp-tests/wp-tests-config-sample.php', 'wp-tests/wp-tests-config.php');
		}

		$this->taskReplaceInFile( 'wp-tests/wp-tests-config.php')
		     ->from('youremptytestdbnamehere')
		     ->to('test_db')
		     ->run();

		$this->taskReplaceInFile( 'wp-tests/wp-tests-config.php')
		     ->from('yourusernamehere')
		     ->to('root')
		     ->run();

		$this->taskReplaceInFile( 'wp-tests/wp-tests-config.php')
		     ->from('yourpasswordhere')
		     ->to('')
		     ->run();
	}
}
