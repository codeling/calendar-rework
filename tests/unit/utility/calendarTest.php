<?php
/**
 * ownCloud - Calendar App
 *
 * @author Georg Ehrke
 * @copyright 2014 Georg Ehrke <oc.list@georgehrke.com>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OCA\Calendar\Utility;

class CalendarTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Initialize the calendar object we are going to test
	 */
	protected function setup() {

	}


	/**
	 * @dataProvider suggestUriProvider
	 */
	public function testSuggestUri($input, $expected) {
		$this->assertSame($expected, CalendarUtility::suggestURI($input));
	}


	public function suggestUriProvider() {
		return [
			['test', 'test-1'],
			['test-1', 'test-2'],
			['test-', 'test-1'],
			['test-99', 'test-100'],
			['test-99abc', 'test-99abc-1'],
		];
	}
}