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

namespace pocketmine\level;

use pocketmine\math\Vector3;

class Location extends Position{

	/** @var float */
	public $yaw;
	/** @var float */
	public $pitch;

	/**
	 * @param float|int $x
	 * @param float|int $y
	 * @param float|int $z
	 * @param float     $yaw
	 * @param float     $pitch
	 */
	public function __construct($x = 0, $y = 0, $z = 0, $yaw = 0.0, $pitch = 0.0, Level $level = null){
		$this->yaw = $yaw;
		$this->pitch = $pitch;
		parent::__construct($x, $y, $z, $level);
	}

	/**
	 * @param float $yaw default 0.0
	 * @param float $pitch default 0.0
	 */
	public static function fromObject(Vector3 $pos, Level $level = null, $yaw = 0.0, $pitch = 0.0) : Location{
		return new Location($pos->x, $pos->y, $pos->z, $yaw, $pitch, $level ?? (($pos instanceof Position) ? $pos->level : null));
	}

	/**
	 * Return a Location instance
	 */
	public function asLocation() : Location{
		return new Location($this->x, $this->y, $this->z, $this->yaw, $this->pitch, $this->level);
	}

	/**
	 * @return float
	 */
	public function getYaw(){
		return $this->yaw;
	}

	/**
	 * @return float
	 */
	public function getPitch(){
		return $this->pitch;
	}

	public function __toString(){
		return "Location (level=" . ($this->isValid() ? $this->getLevelNonNull()->getName() : "null") . ", x=$this->x, y=$this->y, z=$this->z, yaw=$this->yaw, pitch=$this->pitch)";
	}

	public function equals(Vector3 $v) : bool{
		if($v instanceof Location){
			return parent::equals($v) and $v->yaw == $this->yaw and $v->pitch == $this->pitch;
		}
		return parent::equals($v);
	}
}
