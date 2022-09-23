<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pocketmine\network\mcpe\NetworkSession;

class GameTestRequestPacket extends DataPacket {
	public const NETWORK_ID = ProtocolInfo::GAME_TEST_REQUEST_PACKET;

	public const ROTATION_0 = 0;
	public const ROTATION_90 = 1;
	public const ROTATION_180 = 2;
	public const ROTATION_270 = 3;

	private int $maxTestsPerBatch;
	private int $repeatCount;
	private int $rotation;
	private bool $stopOnFailure;
	private $testPosX;
	private $testPosY;
	private $testPosZ;
	private int $testsPerRow;
	private string $testName;

	/**
	 * @generate-create-func
	 */
	public static function create(
		int $maxTestsPerBatch,
		int $repeatCount,
		int $rotation,
		bool $stopOnFailure,
		int|float $testPosX,
		int|float $testPosY,
		int|float $testPosZ,
		int $testsPerRow,
		string $testName,
	) : self{
		$result = new self;
		$result->maxTestsPerBatch = $maxTestsPerBatch;
		$result->repeatCount = $repeatCount;
		$result->rotation = $rotation;
		$result->stopOnFailure = $stopOnFailure;
		$result->testPosX = $testPosX;
		$result->testPosY = $testPosY;
		$result->testPosZ = $testPosZ;
		$result->testsPerRow = $testsPerRow;
		$result->testName = $testName;
		return $result;
	}

	public function getMaxTestsPerBatch() : int{ return $this->maxTestsPerBatch; }

	public function getRepeatCount() : int{ return $this->repeatCount; }

	/**
	 * @see self::ROTATION_*
	 */
	public function getRotation() : int{ return $this->rotation; }

	public function isStopOnFailure() : bool{ return $this->stopOnFailure; }

	public function getTestPosX() { return $this->testPosX; }
	public function getTestPosY() { return $this->testPosY; }
	public function getTestPosZ() { return $this->testPosZ; }

	public function getTestsPerRow() : int{ return $this->testsPerRow; }

	public function getTestName() : string{ return $this->testName; }

	protected function decodePayload(){
		$this->maxTestsPerBatch = $this->getVarInt();
		$this->repeatCount = $this->getVarInt();
		$this->rotation = $this->getByte();
		$this->stopOnFailure = $this->getBool();
		$this->getSignedBlockPosition($this->testPosX, $this->testPosY, $this->testPosZ);
		$this->testsPerRow = $this->getVarInt();
		$this->testName = $this->getString();
	}

	protected function encodePayload(){
		$this->putVarInt($this->maxTestsPerBatch);
		$this->putVarInt($this->repeatCount);
		$this->putByte($this->rotation);
		$this->putBool($this->stopOnFailure);
		$this->putSignedBlockPosition($this->testPosX, $this->testPosY, $this->testPosX);
		$this->putVarInt($this->testsPerRow);
		$this->putString($this->testName);
	}

	public function handle(NetworkSession $handler) : bool{
		return $handler->handleGameTestRequest($this);
	}
}