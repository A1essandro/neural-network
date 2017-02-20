<?php


use Neural\ActivationFunction\Logistic;
use Neural\Network\Layer\Layer;
use Neural\Network\MultilayerPerceptron;
use Neural\Network\Node\Input;
use Neural\Network\Node\Neuron;
use Neural\Network\Synapse\ISynapse;
use Neural\Network\Synapse\Synapse;

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
        $this->masterNeuron = new Neuron(new Logistic());
        $this->slaveNeuron = new Neuron(new Logistic());
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