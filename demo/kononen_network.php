<?php

/*
 * Problem: We have few things, with 3 properties (normalized, from 0 to 1), and 2 boxes for this things.
 * How to distribute things?
 */

define('DIVIDER', 50);

use Neural\KohonenNetwork;

require_once '../vendor/autoload.php';

//Our things:
$control['Thing A'] = [1, 0.5, 0];
$control['Thing B'] = [0, 0.4, 1]; //Spoiler: this thing should be in different boxes with "Thing A"
$control['Thing C'] = [0, 0.7, 0.9]; //Spoiler: this thing should be in one box with "Thing B"

$p = new KohonenNetwork([3 /*thing's properties*/, 2 /*our boxes*/]);
$p->generateSynapses();

//Firstly, learn our network on random things
$learningData = [];
for ($i = 0; $i < 1000; $i++) {
    $randomProperty1 = round(rand(0, DIVIDER) / DIVIDER, 2); //random value from 0 to 1
    $randomProperty2 = round(rand(0, DIVIDER) / DIVIDER, 2); //random value from 0 to 1
    $randomProperty3 = round(rand(0, DIVIDER) / DIVIDER, 2); //random value from 0 to 1
    $learningData[] = [$randomProperty1, $randomProperty2, $randomProperty3];
}

for ($i = 0; $i < 100; $i++) {
    foreach ($learningData as $set) {
        $p->learn($set);
    }
}

//define box for every item
foreach ($control as $thingName => $thingProperties) {
    //$p->input($thingProperties).. - thing's properties to network, for classificate it
    //..->output() - network returns array with 2 (for this problem) digits. Index of "1" - it's an index of classification
    $boxNumber = array_search(1, $p->input($thingProperties)->output()) + 1;
    echo $thingName . ": to box #" . $boxNumber . PHP_EOL;
}
