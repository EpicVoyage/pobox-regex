<?php
use PHPUnit\Framework\TestCase;

class ParseReadmeTest extends TestCase
{
	private $regex;

	/**
	 * Retrieve the RegEx that we will be testing against.
	 */
	protected function setUp() {
		$this->regex = $this->parseRegex();
	}

	/**
	 * @dataProvider positiveList
	 */
	public function testPositiveList($positive) {
		$this->assertRegExp($this->regex, $positive);
	}

	/**
	 * @dataProvider negativeList
	 */
	public function testNegativeList($negative) {
		$this->assertNotRegExp($this->regex, $negative);
	}

	/**
	 * Readme file location. This has to be in a function or a global variable because of PHPUnit parse order.
	 */
	private function getReadmeLocation() {
		return dirname(__FILE__).'/../README.md';
	}

	/**
	 * Retrieve the official RegEx from the README file.
	 */
	private function parseRegex() {
		$readme_file = $this->getReadmeLocation();
		$this->assertFileExists($readme_file);
		$readme = file_get_contents($readme_file);

		// Grab the regex with a regex. What fun.
		preg_match('/````\w+\s+(.*)\s+````/m', $readme, $matches);
		return trim($matches[1]);
	}

	/**
	 * Retrieve a list of positive/negative values from the README file.
	 *
	 * @param $name Header in README file - "Positive List" or "Negative List"
	 */
	private function parseList($name = 'Positive List') {
		$readme_file = $this->getReadmeLocation();
		$this->assertFileExists($readme_file);
		$readme = @fopen($readme_file, 'r');
		$ret = array();

		if ($readme) {
			$store = false;
			while (($line = fgets($readme, 1024)) !== false) {
				// Every header in the readme file changes our mode.
				if ($line[0] == '#') {
					// If this header matches the string requested, start storing values.
					if (stripos($line, $name) !== false) {
						$store = true;

					// Otherwise, stop storing.
					} else {
						$store = false;
					}

				// If we are currently storing values, store this one.
				} else if ($store) {
					// Strip the '*' character used in markdown lists and extra spaces.
					$trimmed = trim(ltrim($line, '*'));

					// Only store actual values.
					if (strlen($trimmed)) {
						$ret[] = $trimmed;
					}
				}
			}

			// Verify that we read the entire file.
			$this->assertTrue(feof($readme));
			fclose($readme);
		}

		// Verify that we have some items to test, then return that list.
		$this->assertGreaterThan(1, count($ret));
		return $ret;
	}

	/**
	 * Returns an array of positive tests from the README file.
	 *
	 * @link https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.data-providers
	 */
	public function positiveList() {
		$list = $this->parseList('Positive List');
		$ret = array();

		// We must return an array of arrays.
		foreach ($list as $v) {
			$ret[] = [$v];
		}

		return $ret;
	}

	/**
	 * Returns an array of negative tests from the README file.
	 *
	 * @link https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.data-providers
	 */
	public function negativeList() {
		$list = $this->parseList('Negative List');
		$ret = array();

		// We must return an array of arrays.
		foreach ($list as $v) {
			$ret[] = [$v];
		}

		return $ret;
	}
}
