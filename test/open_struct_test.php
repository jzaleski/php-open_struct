<?php
/**
 * `Open_Struct` test-harness
 *
 * PHP Version 5+
 *
 * @author Jonathan W. Zaleski <JonathanZaleski@gmail.com>
 */

require_once __DIR__ . '/../lib/open_struct.php';

class Open_Struct_Test extends \PHPUnit_Framework_TestCase {
  /**
   * Test assigning a simple-key and simple-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_simple_key_and_simple_value() {
    $subject = new Open_Struct();

    $subject->foo = 1;

    $this->assertEquals($subject->foo, 1);
  }

  /**
   * Test assigning a simple-key and callback-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_simple_key_and_callback_value() {
    $subject = new Open_Struct();

    $subject->foo = function() { return 1; };

    $this->assertEquals($subject->foo, 1);
  }

  /**
   * Test assigning a simple-key and dictionary-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_simple_key_and_dictionary_value() {
    $subject = new Open_Struct();

    $subject->foo = ['bar' => 1];

    $this->assertEquals($subject->foo->bar, 1);
  }

  /**
   * Test assigning a simple-key and list-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_simple_key_and_list_value() {
    $subject = new Open_Struct();

    $subject->foo = [1];

    $this->assertEquals($subject->foo, [1]);
  }

  /**
   * Test reading a simple-value
   *
   * @return void
   *
   * @access public
   */
  public function test_reading_simple_value() {
    $subject = new Open_Struct(['foo' => 1]);

    $this->assertEquals($subject->foo, 1);
  }

  /**
   * Test reading a callback-value
   *
   * @return void
   *
   * @access public
   */
  public function test_reading_callback_value() {
    $subject = new Open_Struct(['foo' => function() { return 1; }]);

    $this->assertEquals($subject->foo, 1);
  }

  /**
   * Test reading a dictionary-value
   *
   * @return void
   *
   * @access public
   */
  public function test_reading_dictionary_value() {
    $subject = new Open_Struct(['foo' => ['bar' => 1]]);

    $this->assertEquals($subject->foo->bar, 1);
  }

  /**
   * Test reading a list-value
   *
   * @return void
   *
   * @access public
   */
  public function test_reading_list_value() {
    $subject = new Open_Struct(['foo' => [1]]);

    $this->assertEquals($subject->foo, [1]);
  }

  /**
   * Test indexing a simple-value
   *
   * @return void
   *
   * @access public
   */
  public function test_indexing_simple_value() {
    $subject = new Open_Struct(['foo' => 1]);

    $this->assertEquals($subject['foo'], 1);
  }

  /**
   * Test indexing a callback-value
   *
   * @return void
   *
   * @access public
   */
  public function test_indexing_callback_value() {
    $subject = new Open_Struct(['foo' => function() { return 1; }]);

    $this->assertEquals($subject['foo'], 1);
  }

  /**
   * Test indexing a dictionary-value
   *
   * @return void
   *
   * @access public
   */
  public function test_indexing_dictionary_value() {
    $subject = new Open_Struct(['foo' => ['bar' => 1]]);

    $this->assertEquals($subject['foo']['bar'], 1);
  }

  /**
   * Test indexing a list-value
   *
   * @return void
   *
   * @access public
   */
  public function test_indexing_list_value() {
    $subject = new Open_Struct(['foo' => [1]]);

    $this->assertEquals($subject['foo'], [1]);
  }

  /**
   * Test isset by an index
   *
   * @return void
   *
   * @access public
   */
  public function test_isset_by_index() {
    $subject = new Open_Struct(['foo' => 1]);

    $this->assertTrue(isset($subject['foo']));
  }

  /**
   * Test isset by a simple-key
   *
   * @return void
   *
   * @access public
   */
  public function test_isset_by_simple_key() {
    $subject = new Open_Struct(['foo' => 1]);

    $this->assertTrue(isset($subject->foo));
  }

  /**
   * Test a derived value
   *
   * @return void
   *
   * @access public
   */
  public function test_derived_value() {
    $subject = new Open_Struct(['foo' => 2, 'bar' => 3]);

    $subject->biz = function() use ($subject) { return $subject->foo * $subject->bar; };

    $this->assertEquals($subject->biz, 6);
  }

  /**
   * Test unsetting a top-level key
   *
   * @return void
   *
   * @access public
   */
  public function test_unsetting_a_top_level_key() {
    $subject = new Open_Struct(['foo' => 1]);

    unset($subject->foo);

    $this->assertNull($subject->foo);
  }

  /**
   * Test unsetting a top-level key by index
   *
   * @return void
   *
   * @access public
   */
  public function test_unsetting_a_top_level_key_by_index() {
    $subject = new Open_Struct(['foo' => 1]);

    unset($subject['foo']);

    $this->assertNull($subject['foo']);
  }

  /**
   * Test unsetting a nested key
   *
   * @return void
   *
   * @access public
   */
  public function test_unsetting_a_nested_key() {
    $subject = new Open_Struct(['foo' => ['bar' => 1]]);

    unset($subject->foo->bar);

    $this->assertNull($subject->foo->bar);
  }

  /**
   * Test unsetting a nested key by index
   *
   * @return void
   *
   * @access public
   */
  public function test_unsetting_a_nested_key_by_index() {
    $subject = new Open_Struct(['foo' => ['bar' => 1]]);

    unset($subject['foo']['bar']);

    $this->assertNull($subject['foo']['bar']);
  }
}
