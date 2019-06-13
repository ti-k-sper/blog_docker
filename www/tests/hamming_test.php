<?php

require "hamming.php";

use PHPUnit\Framework\TestCase;

class HammingComparatorTest extends TestCase
{
    public function test1NoDifferenceBetweenIdenticalStrands()
    {
        $this->assertEquals(0, distance('A', 'A'));
    }

    public function test2NoDifferenceBetweenIdenticalStrands()
    {
        $this->assertEquals(1, distance('B', 'C'));
    }

    public function test3NoDifferenceBetweenIdenticalStrands()
    {
        $this->assertEquals(2, distance('AB', 'CD'));
    }

    public function test4NoDifferenceBetweenIdenticalStrands()
    {
        $this->assertEquals(1, distance('AT', 'BT'));
    }

    public function testExceptionThrownWhenStransAreDifferentLenght()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("DNA strands must de of equal lengh");
        distance('ATFJ', 'BTGTDDGG');
    }
}