<?php
/**
 * A very flexible data-structure (inspired by Ruby's `ostruct` library)
 *
 * PHP Version 5+
 *
 * @author Jonathan W. Zaleski <JonathanZaleski@gmail.com>
 */

class Open_Struct implements \ArrayAccess {
  /**
   * The associative array of attribute keys/values
   *
   * @var array
   *
   * @access private
   */
  private $__attributes;

  /**
   * Constructor
   *
   * @param array $attributes an associative array of attribute keys/values
   *
   * @return void
   *
   * @access public
   */
  public function __construct($attributes = null) {
    $this->__attributes = $this->structify($attributes ?: []);
  }

  /**
   * Determine if a given attribute key exists
   *
   * @param mixed $key an attribute key
   *
   * @return bool whether or not the specified key exists
   *
   * @access public
   */
  public function __isset($key) {
    return $this->offsetExists($key);
  }

  /**
   * Read an attribute
   *
   * @param mixed $key an attribute key
   *
   * @return mixed the corresponding attribute value (if it exists) or null
   *
   * @access public
   */
  public function __get($key) {
    return $this->offsetGet($key);
  }

  /**
   * Write an attribute
   *
   * @param mixed $key   an attribute key
   * @param mixed $value an attribute value
   *
   * @return void
   *
   * @access public
   */
  public function __set($key, $value) {
    $this->offsetSet($key, $value);
  }

  /**
   * Remove an attribute
   *
   * @param mixed $key an attribute key
   *
   * @return void
   *
   * @access public
   */
  public function __unset($key) {
    $this->offsetUnset($key);
  }

  /**
   * Determine if a given attribute key exists
   *
   * @param mixed $key an attribute key
   *
   * @return bool whether or not the specified key exists
   *
   * @access public
   */
  public function offsetExists($key) {
    return isset($this->__attributes[$key]);
  }

  /**
   * Read an attribute
   *
   * @param mixed $key an attribute key
   *
   * @return mixed the corresponding attribute value (if it exists) or null
   *
   * @access public
   */
  public function offsetGet($key) {
    return $this->offsetExists($key) ? $this->__attributes[$key] : null;
  }

  /**
   * Write an attribute
   *
   * @param mixed $key   an attribute key
   * @param mixed $value an attribute value
   *
   * @return void
   *
   * @access public
   */
  public function offsetSet($key, $value) {
    $this->__attributes[$key] = $this->structify($value);
  }

  /**
   * Remove an attribute
   *
   * @param mixed $key an attribute key
   *
   * @return void
   *
   * @access public
   */
  public function offsetUnset($key) {
    unset($this->__attributes[$key]);
  }

  /**
   * Determine if the specified value is an associative-array
   *
   * @param mixed $value anything
   *
   * @return bool whether or not the specified value is an associative-array
   *
   * @access private
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
   *
   * @access private
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
   *
   * @access private
   */
  private function structify($value) {
    if (empty($value)) {
      return $value;
    } elseif ($this->is_associative_array($value)) {
      return array_reduce(array_keys($value), function ($memo, $key) use ($value) { $memo[$key] = $this->structify($value[$key]); return $memo; }, new Open_Struct);
    } elseif ($this->is_list($value)) {
      return array_map(function ($value) { return $this->structify($value); }, $value);
    } else {
      return $value;
    }
  }
}
