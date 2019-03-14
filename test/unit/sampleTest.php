<?php

// run using: vendor\bin\phpunit test     - running all tests in the folder

class SampleTest extends PHPUnit\Framework\TestCase
{
    public function testTrueAssertsToTrue()
    {
        $this->assertTrue(true);
        $this->assertEquals(1, 1);
    }
}