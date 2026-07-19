<?php

use PHPUnit\Framework\TestCase;

class GenerateOptionsTest extends TestCase
{
    public function test_key_value_array()
    {
        $result = generate_options(['1' => 'One', '2' => 'Two'], ['2']);
        $this->assertStringContainsString('<option value="2" selected>Two</option>', $result);
    }

    public function test_array_of_id_text()
    {
        $result = generate_options([['id' => 1, 'text' => 'One']], [1]);
        $this->assertStringContainsString('<option value="1" selected>One</option>', $result);
    }

    public function test_null_selected_marks_nothing()
    {
        $result = generate_options(['1' => 'One', '2' => 'Two'], null);
        $this->assertStringNotContainsString('selected', $result);
    }

    public function test_null_selected_still_renders_all_options()
    {
        $result = generate_options(['1' => 'One', '2' => 'Two'], null);
        $this->assertStringContainsString('<option value="1">One</option>', $result);
        $this->assertStringContainsString('<option value="2">Two</option>', $result);
    }

    public function test_int_id_matches_string_selected()
    {
        $result = generate_options([['id' => 1, 'text' => 'One']], '1');
        $this->assertStringContainsString('<option value="1" selected>One</option>', $result);
    }

    public function test_int_id_matches_int_selected()
    {
        $result = generate_options([['id' => 2, 'text' => 'Two'], ['id' => 3, 'text' => 'Three']], [2]);
        $this->assertStringContainsString('<option value="2" selected>Two</option>', $result);
        $this->assertStringContainsString('<option value="3">Three</option>', $result);
    }

    public function test_int_id_does_not_match_unrelated_string()
    {
        $result = generate_options([['id' => 0, 'text' => 'Zero']], 'foo');
        $this->assertStringNotContainsString('selected', $result);
    }

    public function test_callable_text_key()
    {
        $data = [(object) ['id' => 1, 'first' => 'John', 'last' => 'Doe']];
        $result = generate_options($data, [], '', false, fn($u) => "{$u->first} {$u->last}");
        $this->assertStringContainsString('John Doe', $result);
    }
}
