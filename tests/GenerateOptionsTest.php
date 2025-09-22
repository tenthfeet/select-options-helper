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

    public function test_callable_text_key()
    {
        $data = [(object) ['id' => 1, 'first' => 'John', 'last' => 'Doe']];
        $result = generate_options($data, [], '', false, fn($u) => "{$u->first} {$u->last}");
        $this->assertStringContainsString('John Doe', $result);
    }
}
