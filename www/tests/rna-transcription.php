<?php
//
// This is only a SKELETON file for the “Hamming” exercise. It’s been provided as a
// convenience to get you started writing code faster.
//
function toRna($strand)
{
    return strtr($strand, 'GCTA', 'CGAU');//+++que str_replace
}