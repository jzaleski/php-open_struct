<?php

require_once __DIR__ . '/../lib/open_struct.php';

class Open_Struct_Test extends \PHPUnit_Framework_TestCase {

  public function test_assigning_simple_key_and_simple_value() {
    $subject = new Open_Struct();

    $subject->foo = 1;

    $this->assertEquals($subject->foo, 1);
  }

  public function test_assigning_simple_key_and_callback_value() {
    $subject = new Open_Struct();

    $subject->foo = function() { return 1; };

    $this->assertEquals(call_user_func($subject->foo), 1);
  }

  public function test_assigning_simple_key_and_dict_value() {
    $subject = new Open_Struct();

    $subject->foo = ['bar' => 1];

    $this->assertEquals($subject->foo->bar, 1);
  }

  public function test_assigning_simple_key_and_list_value() {
    $subject = new Open_Struct();

    $subject->foo = [1];

    $this->assertEquals($subject->foo, [1]);
  }

  public function test_simple_key_and_simple_value() {
    $subject = new Open_Struct(['foo' => 1]);

    $this->assertEquals($subject->foo, 1);
  }

  public function test_simple_key_and_callback_value() {
    $subject = new Open_Struct(['foo' => function() { return 1; }]);

    $this->assertEquals(call_user_func($subject->foo), 1);
  }

  public function test_simple_key_and_dict_value() {
    $subject = new Open_Struct(['foo' => ['bar' => 1]]);

    $this->assertEquals($subject->foo->bar, 1);
  }

  public function test_simple_key_and_list_value() {
    $subject = new Open_Struct(['foo' => [1]]);

    $this->assertEquals($subject->foo, [1]);
  }

  public function test_indexing_by_simple_key() {
    $subject = new Open_Struct(['foo' => 1]);

    $this->assertEquals($subject->foo, $subject['foo']);
  }

  public function test_unsetting_a_top_level_key() {
    $subject = new Open_Struct(['foo' => 1]);

    unset($subject['foo']);

    $this->assertNull($subject->foo);
  }

  public function test_unsetting_a_nested_key() {
    $subject = new Open_Struct(['foo' => ['bar' => 1]]);

    unset($subject->foo['bar']);

    $this->assertNull($subject->foo->bar);
  }
}
