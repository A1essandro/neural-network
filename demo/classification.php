<?php

use Neural\KohonenNetwork;

require_once '../vendor/autoload.php';

$start = microtime(true);

$n = new KohonenNetwork([2, 7]);
$n->generateSynapses();

$nominals = [1, 1.2, 1.5, 1.8, 2.2, 2.7, 3.3, 3.9, 4.7, 5.6, 6.8, 8.2];
$students = [];
$forTraining = [];

for ($i = 0; $i < 500; $i++) {
    $forTraining[] = [$nominals[array_rand($nominals)], ($i % 6) * 7];
}

for ($i = 0; $i < 50; $i++) {
    $v = $nominals[array_rand($nominals)];
    $pow = $i % 6;
    $students['Resistor ' . ($v * pow(10, $pow))] = [$v, $pow * 7];
}

for ($i = 0; $i <= 100; $i++) {
    foreach ($forTraining as $student) {
        $n->learn($student);
    }
}

foreach ($students as $name => $student) {
    echo $name . ': ' . array_search(1, $n->input($student)->output()) . PHP_EOL;
}

echo PHP_EOL . 'Time: ' . round(microtime(true) - $start, 3);