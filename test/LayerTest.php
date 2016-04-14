<?php

use Neural\Abstraction\ILayer;
use Neural\Layer;
use Neural\Node\Bias;
use Neural\Node\Neuron;

class LayerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ILayer;
     */
    protected $layer;

    protected function setUp()
    {
        $this->layer = new Layer(3);
    }

    public function testFilter()
    {
        $this->layer->addNode(new Bias())
            ->addNode(new Bias());

        $filterGetBias = function($node) {
            return $node instanceof Bias;
        };

        $filterGetNeuron = function($node) {
            return $node instanceof Neuron;
        };

        $biasNodes = iterator_to_array($this->layer->getNodes($filterGetBias));
        $neuronNodes = iterator_to_array($this->layer->getNodes($filterGetNeuron));

        $this->assertEquals(count($biasNodes), 2);
        $this->assertEquals(count($neuronNodes), 3);

        $this->assertContainsOnlyInstancesOf(Bias::class, $biasNodes);
        $this->assertContainsOnlyInstancesOf(Neuron::class, $neuronNodes);
    }


}