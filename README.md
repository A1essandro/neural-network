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
composer require a1essandro/neural-network dev-master
```

####Method #2: Clone repository
Execute command 
```
git clone https://github.com/A1essandro/neural-network
```

##Usage

###XOR example:

```php
require_once '../vendor/autoload.php';

//Creation neural network, with 2 input-neurons, one hidden layer with 2 neurons and one output neuron:
$p = new Neural\Network([2, 2, 1]); //You may add more hidden layers or neurons to layers: [2, 3, 2, 1]
$p->generateSynapses(); //automatically add synapses

$t = new Neural\BackpropagationTeacher($p); //Teacher with backpropagation algorithm

//Teach until it learns
$learningResult = $t->teachKit(
    [[1, 0], [0, 1], [1, 1], [0, 0]], //kit for learning
    [[1], [1], [0], [0]], //appropriate expectations 
    0.3 //error
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