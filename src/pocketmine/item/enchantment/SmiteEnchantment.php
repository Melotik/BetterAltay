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

namespace pocketmine\item\enchantment;

use pocketmine\entity\Entity;
use pocketmine\entity\Smite;

class SmiteEnchantment extends DamageEnchantment{

	public function getMinEnchantAbility(int $level) : int{
		return 5 + ($level - 1) * 8;
	}

	public function getMaxEnchantAbility(int $level) : int{
		return $this->getMinEnchantAbility($level) + 20;
	}

	public function isApplicableTo(Entity $victim) : bool{
		return $victim instanceof Smite;
	}

	public function getDamageBonus(int $enchantmentLevel) : float{
		return $enchantmentLevel * 2.5;
	}
}
