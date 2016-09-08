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
   * Test assigning a simple-key and a simple-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_a_simple_key_and_a_simple_value() {
    $subject = new Open_Struct();

    $subject->foo = 1;

    $this->assertEquals($subject->foo, 1);
  }

  /**
   * Test assigning a simple-key and a callback-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_a_simple_key_and_a_callback_value() {
    $subject = new Open_Struct();

    $subject->foo = function() { return 1; };

    $this->assertEquals($subject->foo, 1);
  }

  /**
   * Test assigning a simple-key and a dictionary-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_a_simple_key_and_a_dictionary_value() {
    $subject = new Open_Struct();

    $subject->foo = ['bar' => 1];

    $this->assertEquals($subject->foo->bar, 1);
  }

  /**
   * Test assigning a simple-key and a list-value
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_a_simple_key_and_a_list_value() {
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
  public function test_reading_a_simple_value() {
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
  public function test_a_reading_callback_value() {
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
  public function test_reading_a_dictionary_value() {
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
  public function test_reading_a_list_value() {
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
  public function test_indexing_a_simple_value() {
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
  public function test_indexing_a_callback_value() {
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
  public function test_indexing_a_dictionary_value() {
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
  public function test_indexing_a_list_value() {
    $subject = new Open_Struct(['foo' => [1]]);

    $this->assertEquals($subject['foo'], [1]);
  }

  /**
   * Test empty by an index
   *
   * @return void
   *
   * @access public
   */
  public function test_empty_by_an_index() {
    $subject = new Open_Struct(['foo' => false]);

    $this->assertTrue(empty($subject['foo']));
  }

  /**
   * Test empty by a simple-key
   *
   * @return void
   *
   * @access public
   */
  public function test_empty_by_a_simple_key() {
    $subject = new Open_Struct(['foo' => false]);

    $this->assertTrue(empty($subject->foo));
  }

  /**
   * Test isset by an index
   *
   * @return void
   *
   * @access public
   */
  public function test_isset_by_an_index() {
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
  public function test_isset_by_a_simple_key() {
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
  public function test_a_derived_value() {
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

  /**
   * Test assigning the original value to a key by index removes the dirty status
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_the_original_value_to_a_key_by_index_removes_the_dirty_status() {
    $subject = new Open_Struct(['foo' => 'foo']);

    $subject['foo'] = 'bar';

    $this->assertTrue($subject->dirty());

    $subject['foo'] = 'foo';

    $this->assertFalse($subject->dirty());
  }

  /**
   * Test assigning the original value to a key removes the dirty status
   *
   * @return void
   *
   * @access public
   */
  public function test_assigning_the_original_value_to_a_key_removes_the_dirty_status() {
    $subject = new Open_Struct(['foo' => 'foo']);

    $subject->foo = 'bar';

    $this->assertTrue($subject->dirty());

    $subject->foo = 'foo';

    $this->assertFalse($subject->dirty());
  }

  /**
   * Test is clean (not dirty) until initialization (the constructor) is complete
   *
   * @return void
   *
   * @access public
   */
  public function test_is_clean_until_initialization_is_complete() {
    $subject = new Open_Struct(['foo' => 'foo']);

    $this->assertFalse($subject->dirty());
  }

  /**
   * Test is marked dirty when a value is assigned to a key after initialization (the constructor) is complete
   *
   * @return void
   *
   * @access public
   */
  public function test_is_marked_dirty_when_a_value_is_assigned_to_a_key_after_initialization_is_complete() {
    $subject = new Open_Struct;

    $subject->foo = 'foo';

    $this->assertTrue($subject->dirty());
  }

  /**
   * Test is marked dirty when a value is assigned to a key by index after initialization (the constructor) is complete
   *
   * @return void
   *
   * @access public
   */
  public function test_is_marked_dirty_when_a_value_is_assigned_to_a_key_by_index_after_initialization_is_complete() {
    $subject = new Open_Struct;

    $subject['foo'] = 'foo';

    $this->assertTrue($subject->dirty());
  }
}
