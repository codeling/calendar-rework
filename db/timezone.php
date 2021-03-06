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
namespace OCA\Calendar\Db;

use OCA\Calendar\ITimezone;
use Sabre\VObject\Component\VCalendar;
use Sabre\VObject\Reader;
use Sabre\VObject\ParseException;

class Timezone extends Entity implements ITimezone {

	/**
	 * @var \Sabre\VObject\Component\VCalendar
	 */
	public $vObject;


	/**
	 * Init timezone with vObject
	 *
	 * @param VCalendar $vcalendar
	 * @return ITimezone
	 */
	public static function fromVObject(VCalendar $vcalendar) {
		/** @var ITimezone $instance */
		$instance = new static();
		$instance->setVObject($vcalendar);

		return $instance;
	}


	/**
	 * Init timezone with calendar data
	 * @param string $data
	 * @return ITimezone
	 */
	public static function fromData($data) {
		/** @var ITimezone $instance */
		$instance = new static();

		self::wrapInVCalendarIfNecessary($data);

		try {
			$vObject = Reader::read($data);
			if (!($vObject instanceof VCalendar)) {
				\OC::$server->getLogger()->error(
					'Timezone::fromData: Not calendar data'
				);
				return null;
			}

			$instance->setVObject($vObject);
			return $instance;
		} catch(ParseException $ex) {
			\OC::$server->getLogger()->error(
				'Timezone::fromData: calendar data not valid'
			);
			return null;
		}
	}


	/**
	 * set vObject representation of timezone
	 *
	 * @param VCalendar $vcalendar
	 * @return $this|boolean
	 */
	public function setVObject(VCalendar $vcalendar) {
		if (!isset($vcalendar->{'VTIMEZONE'})) {
			\OC::$server->getLogger()->error(
				'Timezone::setVObject: No timezone found'
			);
			return false;
		}
		if (is_array($vcalendar->{'VTIMEZONE'})) {
			\OC::$server->getLogger()->error(
				'Timezone::setVObject: Multiple timezones found'
			);
			return false;
		}

		$this->vObject = $vcalendar;
		return $this;
	}


	/**
	 * get vObject representation of timezone
	 *
	 * @return \Sabre\VObject\Component\VCalendar
	 */
	public function getVObject() {
		return $this->vObject;
	}


	/**
	 * get timezone id
	 *
	 * @return string|null
	 */
	public function getTzId() {
		$vObject = $this->getVObject();

		if ($vObject instanceof VCalendar && isset($vObject->{'VTIMEZONE'})) {
			return $vObject->{'VTIMEZONE'}->{'TZID'}->getValue();
		} else {
			return null;
		}
	}


	/**
	 * @return void
	 */
	protected function registerTypes() {
		$this->addAdvancedFieldType('vObject',
			'Sabre\\VObject\\Component\\VCalendar');
	}


	/**
	 * @return void
	 */
	protected function registerMandatory() {
		$this->addMandatory('vObject');
	}


	/**
	 * @return string
	 */
	public function __toString() {
		return $this->vObject->serialize();
	}


	/**
	 * @param string $data
	 */
	private static function wrapInVCalendarIfNecessary(&$data) {
		if (substr($data, 0, 15) !== 'BEGIN:VCALENDAR') {
			$newData  = 'BEGIN:VCALENDAR';
			$newData .= "\n";
			$newData .= $data;
			$newData .= "\n";
			$newData .= 'END:VCALENDAR';

			$data = $newData;
		}
	}
}