<?php

function distance($a, $b)
{
    if(strlen($a) !== strlen($b)){
        throw new \Exception("DNA strands must de of equal lengh");
    }
    return count(array_diff_assoc(str_split($a), str_split($b)));
    //correspond
    //$hamming_distance = count(array_diff_assoc(str_split($string1), str_split($string2)));
    //$splitA = str_split($a);
    //$splitB = str_split($b);
    //$result = 0;
    //for ($i=0; $i < count($splitA); $i++) { 
    //    if ($splitA[$i] !== $splitB[$i]) {
    //        $result++;
    //    }
    //}
    //return $result;
    //And if you are not sure if your strings have equal length :

    //$hamming_distance = count(array_diff_assoc(str_split(str_pad($string1,strlen($string2)-strlen($string1),' ')), str_split(str_pad($string2,strlen($string1)-strlen($string2),' '))));
}