<?php

use Neural\Layer;
use Neural\MultilayerPerceptron;
use Neural\Node\Bias;
use Neural\Node\Input;
use Neural\Node\Neuron;
use Neural\Synapse;

require_once '../vendor/autoload.php';

$p = new MultilayerPerceptron([2, 2, 1]);

//Equivalent to:

$p = new MultilayerPerceptron();
$p->addLayer(new Layer())->toLastLayer()
    ->addNode(new Input())
    ->addNode(new Input())
    ->addNode(new Bias());
$p->addLayer(new Layer())->toLastLayer()
    ->addNode(new Neuron())
    ->addNode(new Neuron())
    ->addNode(new Bias());
$p->addLayer(new Layer())->toLastLayer()
    ->addNode(new Neuron());

//Do not forget to add synapses:

$p->generateSynapses();

//Or you may direct the process:

$neuronFilter = function($node) {
    return $node instanceof Neuron;
};

/** @var Neuron $secondLayerNeuron */
$secondLayerNeuron = iterator_to_array($p->getLayers()[1]->getNodes($neuronFilter))[0];
$input = iterator_to_array($p->getLayers()[0]->getNodes())[0];
$secondLayerNeuron->addSynapse(new Synapse($input));

//and so on...