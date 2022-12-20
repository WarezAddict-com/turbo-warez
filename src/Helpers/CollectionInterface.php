<?php

/** Collection Interface **/

/** Declares **/
declare(strict_types = 1);

/** Namespace **/
namespace Turbo\Helpers;

/** Use Libs **/
use Countable;
use IteratorAggregate;

/** CollectionInterface **/
interface CollectionInterface extends Countable, IteratorAggregate
{

	/**
	 * Constructor of the class
	 *
	 * @param array|\Traversable $items
	 */
	public function __construct(iterable $items = []);

	/**
	 * Adds the given value to the collection
	 *
	 * @param mixed $value
	 *
	 * @return CollectionInterface
	 */
	public function add($value) : CollectionInterface;

	/**
	 * Sets the given key/value pair to the collection
	 *
	 * @param mixed $key
	 * @param mixed $value
	 *
	 * @return CollectionInterface
	 */
	public function set($key, $value) : CollectionInterface;

	/**
	 * Gets a value for the given key from the collection
	 *
	 * If the given key is not found in the collection, returns the given default value.
	 *
	 * @param mixed $key
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get($key, $default = null);

	/**
	 * Removes a value for the given key from the collection
	 *
	 * If the given key is not found in the collection, returns the given default value.
	 *
	 * @param mixed $key
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function remove($key, $default = null);

	/**
	 * Searches the given value in the collection
	 *
	 * If the given value is found in the collection, returns its corresponding key.
	 *
	 * If the given value is not found in the collection, returns the given default value.
	 *
	 * @param mixed $value
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function search($value, $default = false);

	/**
	 * Checks if the given key exists in the collection
	 *
	 * If the given key is found in the collection, returns true.
	 *
	 * If the given key is not found in the collection, returns false.
	 *
	 * @param mixed $key
	 *
	 * @return bool
	 */
	public function exists($key) : bool;

	/**
	 * Checks if the given value contains in the collection
	 *
	 * If the given value is found in the collection, returns true.
	 *
	 * If the given value is not found in the collection, returns false.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function contains($value) : bool;

	/**
	 * Updates the collection using the given items
	 *
	 * If an item is found in the collection, it will not be overwritten.
	 *
	 * If an item is not found in the collection, it will be added.
	 *
	 * @param array $items
	 *
	 * @return CollectionInterface
	 */
	public function update(array $items) : CollectionInterface;

	/**
	 * Upgrades the collection using the given items
	 *
	 * If an item is found in the collection, it will be overwritten.
	 *
	 * If an item is not found in the collection, it will be added.
	 *
	 * @param array $items
	 *
	 * @return CollectionInterface
	 */
	public function upgrade(array $items) : CollectionInterface;

	/**
	 * Clears the collection
	 *
	 * @return CollectionInterface
	 */
	public function clear() : CollectionInterface;

	/**
	 * Gets the collection items as is
	 *
	 * @return array
	 */
	public function all() : array;

	/**
	 * Converts the collection to an array
	 *
	 * @return array
	 */
	public function toArray() : array;

}
