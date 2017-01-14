<?php

use Neural\BackpropagationTeacher;
use Neural\MultilayerPerceptron;

require_once '../vendor/autoload.php';

//Creation neural network, with 2 input-neurons, one hidden layer with 2 neurons and one output neuron:
$p = new MultilayerPerceptron([2, 2, 1]); //You may add more hidden layers or neurons to layers: [2, 3, 2, 1]

$p->generateSynapses(); //automatically add synapses

$t = new BackpropagationTeacher($p); //Teacher with backpropagation algorithm

//Teach until it learns
$learningResult = $t->teachKit(
    [[1, 0], [0, 1], [1, 1], [0, 0]], //kit for learning
    [[1], [1], [0], [0]], //appropriate expectations
    0.3, //error
    10000 //max iterations
);

if ($learningResult != BackpropagationTeacher::INEFFECTUALLY_LEARN) {
    echo '1,0: ' . round($p->input([1, 0])->output()[0]) . PHP_EOL;
    echo '0,1: ' . round($p->input([0, 1])->output()[0]) . PHP_EOL;
    echo '0,0: ' . round($p->input([0, 0])->output()[0]) . PHP_EOL;
    echo '1,1: ' . round($p->input([1, 1])->output()[0]) . PHP_EOL;
}
