<?php

use Neural\Layer;
use Neural\MultilayerPerceptron;
use Neural\Node\Bias;
use Neural\Node\Input;
use Neural\Node\Neuron;

class MultilayerPerceptronTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var MultilayerPerceptron
     */
    protected $network;
    protected $filterInput;
    protected $filterBias;
    protected $filterNeuron;

    protected function setUp()
    {
        $this->filterInput = function ($node) {
            return $node instanceof Input;
        };
        $this->filterBias = function ($node) {
            return $node instanceof Bias;
        };
        $this->filterNeuron = function ($node) {
            return $node instanceof Neuron;
        };

        $this->network = new MultilayerPerceptron([1, 1]);
        $this->network->generateSynapses();
    }

    protected function tearDown()
    {
        $this->network = null;
    }

    function testLayers()
    {
        $newLayer = new Layer(1);
        $this->network->addLayer($newLayer);
        $layersCount = count($this->network->getLayers());

        $this->assertEquals($layersCount, 3);
        $this->assertEquals(
            $this->network->getLayers()[$layersCount - 1],
            $this->network->getOutputLayer()
        );
        $this->assertEquals($this->network->getOutputLayer(), $newLayer);
    }

    public function testNodes()
    {
        $biasNodes = $this->network->getNodes($this->filterBias);
        $inputNodes = $this->network->getNodes($this->filterInput);
        $this->assertEquals(count(iterator_to_array($biasNodes)), 1);
        $this->assertEquals(count(iterator_to_array($inputNodes)), 1);

        $biasNodes = $this->network->getNodes($this->filterBias);
        $this->assertContainsOnlyInstancesOf(Bias::class, iterator_to_array($biasNodes));
    }

    public function testInput()
    {
        foreach( $this->network->getNodes($this->filterInput) as $neuron) {
            $this->assertEquals($neuron->output(), 0);
        }

        $this->network->input([1])->output();

        foreach( $this->network->getNodes($this->filterInput) as $neuron) {
            $this->assertEquals($neuron->output(), 1);
        }
    }

}
