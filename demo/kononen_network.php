<?php

use Neural\KohonenNetwork;

require_once '../vendor/autoload.php';

$p = new KohonenNetwork([3, 3]);
$p->generateSynapses();

$data = [];

//Init group:
$data[] = [1, 0, 0];
$data[] = [0, 1, 0];
$data[] = [0, 0, 1];

for ($i = 0; $i < 1000; $i++) {
    $data[] = [round(rand(0, 255) / 255, 2), round(rand(0, 255) / 255, 2), round(rand(0, 255) / 255, 2)];
}

//Control group:
$data[] = [1, 0.5, 0];
$data[] = [0, 0.5, 1]; //It should not be equal to the previous
$data[] = [0, 0.5, 1]; //It should be equal to the previous

for ($i = 0; $i < 100; $i++) {
    foreach ($data as $set) {
        $p->learn($set);
    }
}

foreach ($data as $set) {
    echo array_search(1, $p->input($set)->output()) . ':   ' . implode('  ', $set) . PHP_EOL;
}
