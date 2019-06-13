<?php
//
// This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
// convenience to get you started writing code faster.
//
function isPangram($string)
{
    //$string = str_replace(['_', ' '], '', mb_strtolower($string));
    //$letters = preg_split('//', $string);
    //$alphabet = str_split('abcdefghijklmnopqrstuvwxyz');
    //return count(array_intersect($alphabet, $letters)) === count($alphabet);
    $alphabet = str_split('abcdefghijklmnopqrstuvwxyz');
    $string = str_split(strtolower($string));
    return count(array_intersect($alphabet, $string)) === count($alphabet);
}