#neural-network

[![Build Status](https://travis-ci.org/A1essandro/neural-network.svg?branch=master)](https://travis-ci.org/A1essandro/neural-network)
[![Coverage Status](https://coveralls.io/repos/github/A1essandro/neural-network/badge.svg?branch=master)](https://coveralls.io/github/A1essandro/neural-network?branch=master)
[![Code Climate](https://codeclimate.com/github/A1essandro/neural-network/badges/gpa.svg)](https://codeclimate.com/github/A1essandro/neural-network)
[![Latest Stable Version](https://poser.pugx.org/a1essandro/neural-network/v/stable)](https://packagist.org/packages/a1essandro/neural-network) 
[![Latest Unstable Version](https://poser.pugx.org/a1essandro/neural-network/v/unstable)](https://packagist.org/packages/a1essandro/neural-network)
[![Total Downloads](https://poser.pugx.org/a1essandro/neural-network/downloads)](https://packagist.org/packages/a1essandro/neural-network)
[![License](https://poser.pugx.org/a1essandro/neural-network/license)](https://packagist.org/packages/a1essandro/neural-network)

######Language choice:
[![English](https://img.shields.io/:readme-EN-336699.svg)](https://github.com/A1essandro/neural-network/blob/master/README.md)
[![Russian](https://img.shields.io/:readme-RU-cc3300.svg)](https://github.com/A1essandro/neural-network/blob/master/README.ru.md)

##Requirements
This package is only supported on PHP 5.5 and above.

##Installing
####Method #1(recommended): Composer package
See more [getcomposer.org](http://getcomposer.org).

Execute command 
```
composer require a1essandro/neural-network:dev-master
```

####Method #2: Clone repository
Execute command 
```
git clone https://github.com/A1essandro/neural-network
```

##Usage

####XOR example:

```php
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

if ($learningResult != -1) {
    echo '1,0: ' . round($p->input([1, 0])->output()[0]) . PHP_EOL;
    echo '0,1: ' . round($p->input([0, 1])->output()[0]) . PHP_EOL;
    echo '0,0: ' . round($p->input([0, 0])->output()[0]) . PHP_EOL;
    echo '1,1: ' . round($p->input([1, 1])->output()[0]) . PHP_EOL;
}

/* Result:
1,0: 1
0,1: 1
0,0: 0
1,1: 0
*/
```

####Manualy configuration of network

```php
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

$secondLayerNeuron = iterator_to_array($p->getLayers()[1]->getNodes($neuronFilter))[0];
$input = iterator_to_array($p->getLayers()[0]->getNodes())[0];
$secondLayerNeuron->addSynapse(new Synapse($input));

//and so on...
```