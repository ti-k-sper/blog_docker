<?php
//
// This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
// convenience to get you started writing code faster.
//
//GIGASECOND = 1000000000;

function from(\DateTime $from)
{
   //$interval = new DateInterval("PT1000000000S");
   //$date = clone $from;
   //return $date->add(new DateInterval("PT1000000000S"));
   //                          10 puissance 9
   return (clone $from)->modify((10 ** 9). ' seconde');
}