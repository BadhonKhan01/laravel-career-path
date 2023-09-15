#! /usr/bin/env php
<?php 
$inputString = $argv[1];
preg_match_all('/[A-Za-z]/', $inputString, $matches);
$characterCount = (string) count($matches[0]);
printf("Your alphabets/characters is: $characterCount");