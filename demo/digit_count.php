<?php

use Neural\BackpropagationTeacher;
use Neural\MultilayerPerceptron;

require_once '../vendor/autoload.php';

$p = new MultilayerPerceptron([4, 4, 5]);
$p->generateSynapses();

$t = new BackpropagationTeacher($p);

echo $t->teachKit(
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

$roundElements = function (&$r) {
    $r = round($r);
};

$test = [rand(0, 1), rand(0, 1), rand(0, 1), rand(0, 1)];
$result = $p->input($test)->output();
array_walk($result, $roundElements);

echo 'Result for [' . implode(', ', $test) . ']:' . PHP_EOL;
echo '[' . implode(', ', $result) . ']';