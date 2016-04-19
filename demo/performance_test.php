<?php

use Neural\BackpropagationTeacher;
use Neural\MultilayerPerceptron;

require_once '../vendor/autoload.php';

$p = new MultilayerPerceptron([4, 8, 5]);
$p->generateSynapses();

$t = new BackpropagationTeacher($p);

$startTime = microtime(true);
$epochs = $t->teachKit(
        [
            [0, 0, 0, 0],
            [0, 0, 0, 1], [0, 0, 1, 0], [0, 1, 0, 0], [1, 0, 0, 0],
            [1, 0, 0, 1], [0, 1, 1, 0], [1, 1, 0, 0], [0, 0, 1, 1], [1, 0, 1, 0], [0, 1, 0, 1],
            [0, 1, 1, 1], [1, 0, 1, 1], [1, 1, 0, 1], [1, 1, 1, 0],
            [1, 1, 1, 1],
        ],
        [
            [1, 0, 0, 0, 0],
            [0, 1, 0, 0, 0], [0, 1, 0, 0, 0], [0, 1, 0, 0, 0], [0, 1, 0, 0, 0],
            [0, 0, 1, 0, 0], [0, 0, 1, 0, 0], [0, 0, 1, 0, 0], [0, 0, 1, 0, 0], [0, 0, 1, 0, 0], [0, 0, 1, 0, 0],
            [0, 0, 0, 1, 0], [0, 0, 0, 1, 0], [0, 0, 0, 1, 0], [0, 0, 0, 1, 0],
            [0, 0, 0, 0, 1]
        ], 0.25
    ) . PHP_EOL;
$endTime = microtime(true);

echo 'Memory peak usage: ' . round(memory_get_peak_usage() / 1024, 1) . PHP_EOL;
echo 'Seconds per epoch: ' . round(($endTime - $startTime) / $epochs, 3);
