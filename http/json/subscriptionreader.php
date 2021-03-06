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
namespace OCA\Calendar\Http\JSON;

class SubscriptionReader extends SimpleReader {

	/**
	 * parse a json subscription
	 * @param array $data
	 * @param string $key
	 * @param mixed $value
	 */
	protected function setProperty(&$data, $key, $value) {
		switch($key) {
			case 'type':
			case 'url':
				$data[$key] = strval($value);
				break;

			//blacklist
			case 'userid':
			case 'id':
				break;

			default:
				break;
		}
	}
}