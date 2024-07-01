<?php

namespace App\Utils;

class NumberUtils
{
    /**
     * 
     * @param int $n 
     * @return array<int>
     */
    public static function fibonacci(int $n): array
    {
        $result = [];
        $num1 = 0;
        $num2 = 1;

        while (count($result) < $n) {
            $result[] = $num1;
            $num3 = $num2 + $num1;
            $num1 = $num2;
            $num2 = $num3;
        }

        return $result;
    }
}
