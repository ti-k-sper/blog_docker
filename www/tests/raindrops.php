<?php
function raindrops2($num)
{
    $sound =
        function ($divisor) use ($num) {
            return !($num % $divisor);
        };
    $string = $sound(3) ? 'Pling' : '';
    $string .= $sound(5) ? 'Plang' : '';
    $string .= $sound(7) ? 'Plong' : '';
    return $string ? $string : strval($num);
}

function raindrops(int $number): string 
{
    $result = '';
    if ($number % 3 === 0) {
        $result .= 'Pling';
    }
    if ($number % 5 === 0) {
        $result .= 'Plang';
    }
    if ($number % 7 === 0) {
        $result .= 'Plong';
    }

    return strlen($result) > 0 ? $result : (string) $number;
}