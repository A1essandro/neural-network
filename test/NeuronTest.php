<?php

use Neural\Abstraction\ISynapse;
use Neural\Layer;
use Neural\LogisticFunction;
use Neural\MultilayerPerceptron;
use Neural\Node\Input;
use Neural\Node\Neuron;
use Neural\Synapse;

class NeuronTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Neuron;
     */
    protected $masterNeuron;

    /**
     * @var Neuron;
     */
    protected $slaveNeuron;

    /**
     * @var Input
     */
    protected $inputNode;

    protected function setUp()
    {
        $this->inputNode = new Input();
        $this->masterNeuron = new Neuron(new LogisticFunction());
        $this->slaveNeuron = new Neuron(new LogisticFunction());
    }

    protected function tearDown()
    {
        $this->masterNeuron = null;
        $this->slaveNeuron = null;
    }

    public function testSynapses()
    {
        $this->slaveNeuron->addSynapse(new Synapse($this->masterNeuron));
        $this->assertInternalType('array', $this->slaveNeuron->getSynapses());
        $this->assertCount(1, $this->slaveNeuron->getSynapses());
        $this->assertInstanceOf(ISynapse::class, $this->slaveNeuron->getSynapses()[0]);
        $this->assertCount(1, $this->slaveNeuron->getSynapses());
    }

    public function testOutputEquability()
    {
        $mlp = new MultilayerPerceptron();
        $mlp->addLayer(new Layer())
            ->toLastLayer()->addNode($this->inputNode);
        $mlp->addLayer(new Layer())
            ->toLastLayer()->addNode($this->slaveNeuron);
        $this->slaveNeuron->addSynapse(new Synapse($this->inputNode));

        $this->assertEquals($this->slaveNeuron->output(), $mlp->output()[0]);
    }

}