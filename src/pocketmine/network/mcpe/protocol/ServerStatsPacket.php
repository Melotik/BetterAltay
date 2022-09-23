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

/**
 * Relays server performance statistics to the client.
 * It's currently unclear what the purpose of this packet is - probably to power some fancy debug screen.
 */
class ServerStatsPacket extends DataPacket {
	public const NETWORK_ID = ProtocolInfo::SERVER_STATS_PACKET;

	private float $serverTime;
	private float $networkTime;

	/**
	 * @generate-create-func
	 */
	public static function create(float $serverTime, float $networkTime) : self{
		$result = new self;
		$result->serverTime = $serverTime;
		$result->networkTime = $networkTime;
		return $result;
	}

	public function getServerTime() : float{ return $this->serverTime; }

	public function getNetworkTime() : float{ return $this->networkTime; }

	protected function decodePayload(){
		$this->serverTime = $this->getLFloat();
		$this->networkTime = $this->getLFloat();
	}

	protected function encodePayload(){
		$this->putLFloat($this->serverTime);
		$this->putLFloat($this->networkTime);
	}

	public function handle(NetworkSession $handler) : bool{
		return $handler->handleServerStats($this);
	}
}