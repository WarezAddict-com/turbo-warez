<?php

/** Collection **/

/** Declares **/
declare(strict_types = 1);

/** Namespace **/
namespace Turbo\Helpers;

/** Use Libs **/
use ArrayIterator, Traversable;
use \Turbo\Helpers\CollectionInterface;
use function array_key_exists, array_map, array_replace_recursive, array_search, in_array, count;

/** Collection **/
class Collection implements CollectionInterface
{

	protected $items = [];

	public function __construct(iterable $items = [])
	{
		foreach ($items as $key => $value)
		{
			$this->set($key, $value);
		}
	}

	public function add($value) : CollectionInterface
	{
		$this->items[] = $value;

		return $this;
	}

	public function set($key, $value) : CollectionInterface
	{
		$this->items[$key] = $value;

		return $this;
	}

	public function get($key, $default = null)
	{
		if (array_key_exists($key, $this->items))
		{
			return $this->items[$key];
		}

		return $default;
	}

	public function remove($key, $default = null)
	{
		if (array_key_exists($key, $this->items))
		{
			$value = $this->items[$key];

			unset($this->items[$key]);

			return $value;
		}

		return $default;
	}

	public function search($value, $default = false)
	{
		$offset = array_search($value, $this->items, false);

		if ($offset === false)
		{
			return $default;
		}

		return $offset;
	}

	public function exists($key) : bool
	{
		return array_key_exists($key, $this->items);
	}

	public function contains($value) : bool
	{
		return in_array($value, $this->items);
	}

	public function update(array $items) : CollectionInterface
	{
		$this->items = array_replace_recursive($items, $this->items);

		return $this;
	}

	public function upgrade(array $items) : CollectionInterface
	{
		$this->items = array_replace_recursive($this->items, $items);

		return $this;
	}

	public function clear() : CollectionInterface
	{
		$this->items = [];

		return $this;
	}

	public function all() : array
	{
		return $this->items;
	}

	public function toArray() : array
	{
		return array_map(function($item)
		{
			if ($item instanceof CollectionInterface)
			{
				return $item->toArray();
			}

			if ($item instanceof Traversable)
			{
				$item = new static($item);

				return $item->toArray();
			}

			return $item;

		}, $this->items);
	}

	public function count()
	{
		return count($this->items);
	}

	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}

}
