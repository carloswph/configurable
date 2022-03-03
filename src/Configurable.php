<?php 

namespace Ruse\Configurable;

interface Configurable
{
	/**
	 * Get all default values set for config properties,
	 * preferably ignoring those which are protected or
	 * private, but eventually returning a flag on that.
	 * 
	 * @return array
	 * 
	 */
	public function getDefaults() : array;

	/**
	 * Switch any boolean option from the current value
	 * to the opposite, even if the previous state is
	 * unknown. 
	 * 
	 * May admit additional options in order to switch
	 * all existing boolean properties at once, using
	 * the constant SWITCH_ALL as the main argument.
	 * 
	 * @param string|array|int $key
	 * @return void
	 * 
	 */
	public function switch(string|array|int $key) : void;

	/**
	 * Used for setting a configurable property just once.
	 * In other words: if the property is eventually set
	 * using this method, it can't be changed or updated anymore,
	 * and remains locked for the current class instance.
	 * 
	 * @param string $key Name of the configurable property
	 * @param mixed $value Value of the configurable property
	 * 
	 * @return void
	 */
	public function immutable(string $key, mixed $value) : void;

	/**
	 * Regular method for setting configurable properties.
	 * 
	 * @param string $key Name of the configurable property
	 * @param mixed $value Value of the configurable property
	 * 
	 * @return void
	 */
	public function set(string $key, mixed $value) : void;

	/**
	 * Regular method for getting configurable properties.
	 * 
	 * @param string $key Name of the configurable property
	 * 
	 * @return mixed
	 */
	public function get(string $key) : mixed;
}