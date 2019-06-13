<?php

function squareOfSum($max)
{
    $sum = 0;
    //      range->Crée un tableau contenant un intervalle d'éléments
    foreach (range(1, $max) as $i) {
        $sum += $i;
    }
    //     pow->exponentielle
    $sum = pow($sum, 2);
    return $sum;
}
function sumOfSquares($max)
{
    $sum = 0;
    foreach (range(1, $max) as $i) {
        $sum += pow($i, 2);
    }
    return $sum;
}
function difference($max)
{
    return squareOfSum($max) - sumOfSquares($max);
}