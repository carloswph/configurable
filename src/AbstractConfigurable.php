<?php 

namespace Ruse\Configurable;

use Ruse\Configurable\ConfigurableException;

abstract class AbstractConfigurable implements Configurable
{
	/**
	 * Pool of properties that have been set as immutables,
	 * which would be an equivalent of a Readonly.
	 * 
	 * @var array
	 */
	private $immutables = [];

	/**
	 * Container that stores any saved state of the
	 * object.
	 * 
	 * @var array
	 */
	private $states = [];

	/**
	 * Get all default values set for config properties,
	 * preferably ignoring those which are protected or
	 * private, but eventually returning a flag on that.
	 * 
	 * @return array
	 * 
	 */
	public function getDefaults() : array
	{
		$properties = new \ReflectionClass($this);

		return $properties->getProperties();
	}

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
	public function switch(string|array|int $key) : void
	{
		if(is_scalar($key)) {
			$this->{$key} = !$this->{$key};
		}

		if(is_array($key)) {
			foreach($key as $property) {
				$this->{$property} = !$this->{$property};
			}
		}
	}

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
	public function immutable(string $key, mixed $value) : void
	{
		if(!in_array($key, $this->immutables)) {
			try {
				$this->{$key} = $value;
				$this->immutables[] = $key;
			} catch (ConfigurableException $e) {
				echo (__('Property ' . $key . ' has been either defined as protected or private and cannot be changed.'));
			}
		}
	}

	/**
	 * Regular method for setting configurable properties.
	 * 
	 * @param string $key Name of the configurable property
	 * @param mixed $value Value of the configurable property
	 * 
	 * @return void
	 */
	public function set(string $key, mixed $value) : void
	{
		$property = new \ReflectionProperty($this, $key);

		if(!$property->isPublic()) {
			throw new ConfigurableException('Property $' . $key . ' has been either defined as protected or private and cannot be changed.');
			
		}

		if(!in_array($key, $this->immutables)) {

			try {
				$this->{$key} = $value;
			} catch (ConfigurableException $e) {
				$e->getMessage();
			} catch (\Exception $e) {
				$e->getMessage();
			}
		}
	}

	/**
	 * Regular method for getting configurable properties.
	 * 
	 * @param string $key Name of the configurable property
	 * 
	 * @return mixed
	 */
	public function get(string $key) : mixed
	{
		return $this->{$key};
	}
}