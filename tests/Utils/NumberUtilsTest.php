<?php

namespace App\Tests\Utils;

use App\Utils\NumberUtils;
use PHPUnit\Framework\TestCase;

class NumberUtilsTest extends TestCase
{
    private NumberUtils $numberUtils;

    public function setUp(): void
    {
        $this->numberUtils = new NumberUtils();
    }

    public function testFibonacci(): void
    {
        $result = $this->numberUtils->fibonacci(10);
        $this->assertEquals([0, 1, 1, 2, 3, 5, 8, 13, 21, 34], $result);
    }
}
