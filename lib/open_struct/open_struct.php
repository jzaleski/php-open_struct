<?php
/**
 * A very flexible data-structure (inspired by Ruby's `ostruct` library)
 *
 * PHP version 5+
 *
 * @author Jonathan W. Zaleski <JonathanZaleski@gmail.com>
 */

class Open_Struct implements \ArrayAccess {

  /**
   * Attributes
   *
   * @var array an associative array of attribute keys/values
   */
  private $attributes;

  /**
   * Constructor
   *
   * @param array $attributes an associative array of attribute keys/values
   *
   * @return void
   */
  public function __construct($attributes = null) {
    $this->attributes = $this->structify($attributes ?: []);
  }

  /**
   * Read attribute
   *
   * @param mixed $key an attribute key
   *
   * @return mixed the corresponding attribute value (if it exists) or null
   */
  public function __get($key) {
    return $this->offsetGet($key);
  }

  /**
   * Write attribute
   *
   * @param mixed $key   an attribute key
   * @param mixed $value an attribute value
   *
   * @return void
   */
  public function __set($key, $value) {
    $this->offsetSet($key, $value);
  }

  /**
   * Determine if a given attribute key exists
   *
   * @param mixed $key an attribute key
   *
   * @return bool whether or not the specified key exists
   */
  public function offsetExists($key) {
    return isset($this->attributes[$key]);
  }

  /**
   * Read attribute
   *
   * @param mixed $key an attribute key
   *
   * @return mixed the corresponding attribute value (if it exists) or null
   */
  public function offsetGet($key) {
    return $this->offsetExists($key) ? $this->attributes[$key] : null;
  }

  /**
   * Write attribute
   *
   * @param mixed $key   an attribute key
   * @param mixed $value an attribute value
   *
   * @return void
   */
  public function offsetSet($key, $value) {
    $this->attributes[$key] = $this->structify($value);
  }

  /**
   * Remove attribute
   *
   * @param mixed $key an attribute key
   *
   * @return void
   */
  public function offsetUnset($key) {
    unset($this->attributes[$key]);
  }

  /**
   * Determine if the specified value is an associative-array
   *
   * @param mixed $value anything
   *
   * @return bool whether or not the specified value is an associative-array
   */
  private function is_associative_array($value) {
    return is_array($value) && array_keys($value) !== range(0, count($value) - 1);
  }

  /**
   * Determine if the specified value is a list
   *
   * @param mixed $value anything
   *
   * @return bool whether or not the specified value is a list
   */
  private function is_list($value) {
    return is_array($value) && array_keys($value) === range(0, count($value) - 1);
  }

  /**
   * Get the `Open_Struct` representation of a given value (recursive)
   *
   * @param mixed $value anything
   *
   * @return mixed the value itself, an `Open_Struct` or a list of values (potentially containing `Open_Struct` instances)
   */
  private function structify($value) {
    if (empty($value)) {
      return $value;
    } elseif ($this->is_associative_array($value)) {
      return array_reduce(array_keys($value), function ($memo, $key) use ($value) { $memo[$key] = $this->structify($value[$key]); return $memo; }, new Open_Struct());
    } elseif ($this->is_list($value)) {
      return array_map(function ($value) { return $this->structify($value); }, $value);
    } else {
      return $value;
    }
  }
}
