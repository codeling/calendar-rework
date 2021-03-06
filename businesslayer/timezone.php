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
namespace OCA\Calendar\BusinessLayer;

use OCA\Calendar\Db\TimezoneMapper;
use OCP\AppFramework\Http;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCA\Calendar\ITimezone;

class Timezone extends BusinessLayer {

	/**
	 * @var \OCA\Calendar\Db\TimezoneMapper
	 */
	protected $mapper;


	/**
	 * @param TimezoneMapper $mapper
	 */
	public function __construct(TimezoneMapper $mapper) {
		$this->mapper = $mapper;
	}


	/**
	 * find all timezones
	 *
	 * @param string $userId
	 * @param integer $limit
	 * @param integer $offset
	 * @return \OCA\Calendar\ITimezoneCollection
	 */
	public function findAll($userId, $limit, $offset) {
		return $this->mapper->findAll($userId, $limit, $offset);
	}


	/**
	 * list all timezones
	 *
	 * @param string $userId
	 * @return array
	 */
	public function listAll($userId) {
		return $this->mapper->listAll($userId);
	}


	/**
	 * find a timezone
	 *
	 * @param string $tzId
	 * @param string $userId
	 * @throws Exception
	 * @return \OCA\Calendar\ITimezone
	 */
	public function find($tzId, $userId) {
		try {
			return $this->mapper->find($tzId, $userId);
		} catch(DoesNotExistException $ex) {
			throw Exception::fromException($ex);
		} catch(MultipleObjectsReturnedException $ex) {
			throw Exception::fromException($ex);
		}
	}


	/**
	 * check if a timezone exists
	 *
	 * @param string $tzId
	 * @param string $userId
	 * @return boolean
	 */
	public function doesExist($tzId, $userId) {
		return $this->mapper->doesExist($tzId, $userId);
	}


	/**
	 * create a timezone
	 *
	 * @ignore
	 *
	 * @param \OCA\Calendar\ITimezone $timezone
	 * @throws \OCA\Calendar\BusinessLayer\Exception
	 * @return \OCA\Calendar\ITimezone
	 */
	public function create(ITimezone $timezone) {
		$this->checkIsValid($timezone);
		$this->mapper->insert($timezone);

		throw new Exception(
			'Creating timezones not yet supported',
			Http::STATUS_NOT_IMPLEMENTED
		);
	}


	/**
	 * update a timezone
	 *
	 * @ignore
	 *
	 * @param \OCA\Calendar\ITimezone $timezone
	 * @throws \OCA\Calendar\BusinessLayer\Exception
	 * @return \OCA\Calendar\ITimezone
	 */
	public function update(ITimezone $timezone) {
		$this->checkIsValid($timezone);
		$this->mapper->update($timezone);

		throw new Exception(
			'Updating timezones not yet supported',
			Http::STATUS_NOT_IMPLEMENTED
		);
	}


	/**
	 * delete a timezone
	 *
	 * @ignore
	 *
	 * @param \OCA\Calendar\ITimezone $timezone
	 * @throws \OCA\Calendar\BusinessLayer\Exception
	 */
	public function delete(ITimezone $timezone) {
		$this->mapper->delete($timezone);

		throw new Exception(
			'Deleting timezones not yet supported',
			Http::STATUS_NOT_IMPLEMENTED
		);
	}
}