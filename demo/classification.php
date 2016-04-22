<?php

use Neural\KohonenNetwork;

require_once '../vendor/autoload.php';

$n = new KohonenNetwork([5, 3]);
$n->generateSynapses();

$forTraining = [];
for ($i = 0; $i < 50; $i++) {
    $forTraining[] = [rand(80, 100) / 100, rand(80, 100) / 100, rand(80, 100) / 100, rand(80, 100) / 100,
                      rand(80, 100) / 100,];
    $forTraining[] = [rand(5, 50) / 100, rand(5, 50) / 100, rand(5, 50) / 100, rand(5, 50) / 100, rand(5, 50) / 100,];
    $forTraining[] = [rand(5, 100) / 100, rand(5, 100) / 100, rand(5, 100) / 100, rand(5, 100) / 100,
                      rand(5, 100) / 100,];
}

$students = [
    'Arya'  => [0.8, 0.6, 0.3, 0.75, 0.7],
    'Sansa' => [1, 0.9, 0.93, 0.91, 0.95],
    'John'  => [0.3, 0.2, 0.35, 0.4, 0.23],
    'Rob'   => [0.55, 0.7, 0.8, 0.5, 0.75],
    'Bran'  => [0.8, 0.9, 1, 0.94, 0.8]
];

for ($i = 0; $i <= 100; $i++) {
    foreach ($forTraining as $student) {
        $n->learn($student);
    }
}

foreach ($students as $name => $student) {
    echo $name . ': ' . array_search(1, $n->input($student)->output()) . PHP_EOL;
}
