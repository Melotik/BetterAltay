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

namespace pocketmine\entity;

use ArrayAccess;
use InvalidArgumentException;
use RuntimeException;
use function array_filter;

/**
 * @phpstan-implements ArrayAccess<int, float>
 */
class AttributeMap implements ArrayAccess{
	/** @var Attribute[] */
	private $attributes = [];

	public function addAttribute(Attribute $attribute) : void{
		$this->attributes[$attribute->getId()] = $attribute;
	}

	public function getAttribute(int $id) : ?Attribute{
		return $this->attributes[$id] ?? null;
	}

	/**
	 * @return Attribute[]
	 */
	public function getAll() : array{
		return $this->attributes;
	}

	/**
	 * @return Attribute[]
	 */
	public function needSend() : array{
		return array_filter($this->attributes, function(Attribute $attribute) : bool{
			return $attribute->isSyncable() and $attribute->isDesynchronized();
		});
	}

	/**
	 * @param int $offset
	 */
	public function offsetExists($offset) : bool{
		return isset($this->attributes[$offset]);
	}

	/**
	 * @param int $offset
	 */
	public function offsetGet($offset) : float{
		return $this->attributes[$offset]->getValue();
	}

	/**
	 * @param int|null $offset
	 * @param float    $value
	 */
	public function offsetSet($offset, $value) : void{
		if($offset === null){
			throw new InvalidArgumentException("Array push syntax is not supported");
		}
		$this->attributes[$offset]->setValue($value);
	}

	/**
	 * @param int $offset
	 */
	public function offsetUnset($offset) : void{
		throw new RuntimeException("Could not unset an attribute from an attribute map");
	}
}
