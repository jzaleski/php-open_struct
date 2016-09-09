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
   * The associative array of attributes
   *
   * @var array
   *
   * @access private
   */
  private $__attributes = [];

  /**
   * The associative array of changed attributes
   *
   * @var array
   *
   * @access private
   */
  private $__changed_attributes = [];

  /**
   * The initialization status of the instance
   *
   * @var bool
   *
   * @access private
   */
  private $__initialized = false;

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
    if (!empty($attributes)) {
      foreach ($attributes as $key => $value) {
        $this->offsetSet($key, $value);
      }
    }
    $this->__initialized = true;
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
   * Get the associative array of attributes
   *
   * @return array the associative array of attributes
   *
   * @access public
   */
  public function attributes() {
    return array_merge($this->__attributes, $this->__changed_attributes);
  }

  /**
   * Get the associative array of changed attributes
   *
   * @return array the associative array of changed attributes
   *
   * @access public
   */
  public function changed_attributes() {
    return array_merge([], $this->__changed_attributes);
  }

  /**
   * Determine whether or not the instance is dirty
   *
   * @return bool result
   *
   * @access public
   */
  public function dirty() {
    return !empty($this->__changed_attributes);
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
    return array_key_exists($key, $this->__attributes) || array_key_exists($key, $this->__changed_attributes);
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
    if (array_key_exists($key, $this->__changed_attributes)) {
      return $this->value_or_result($this->__changed_attributes[$key]);
    } elseif (array_key_exists($key, $this->__attributes)) {
      return $this->value_or_result($this->__attributes[$key]);
    } else {
      return null;
    }
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
    $value = $this->structify($value);
    if (!$this->__initialized) {
      $this->__attributes[$key] = $value;
    } elseif (!array_key_exists($key, $this->__attributes) || $this->__attributes[$key] !== $value) {
      $this->__changed_attributes[$key] = $value;
    } elseif (array_key_exists($key, $this->__attributes)) {
      unset($this->__changed_attributes[$key]);
    }
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
    unset($this->__changed_attributes[$key]);
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
      return array_reduce(array_keys($value), function ($memo, $key) use ($value) { $memo->offsetSet($key, $value[$key]); return $memo; }, new Open_Struct);
    } elseif ($this->is_list($value)) {
      return array_map(function ($value) { return $this->structify($value); }, $value);
    } else {
      return $value;
    }
  }

  /**
   * Return the value (if not `callable`) or execute (if `callable`) and return the result
   *
   * @param mixed $value anything
   *
   * @return mixed the result
   *
   * @access private
   */
  private function value_or_result($value) {
    return is_callable($value) ? call_user_func($value) : $value;
  }
}
