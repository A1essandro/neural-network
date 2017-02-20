<?php


use Neural\Abstraction\ILayer;
use Neural\Network\Layer\Layer;
use Neural\Network\Node\Bias;
use Neural\Network\Node\INode;
use Neural\Network\Node\Neuron;

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

        $biasNodes = $this->layer->getNodes($filterGetBias);
        $neuronNodes = $this->layer->getNodes($filterGetNeuron);

        $this->assertEquals(count($biasNodes), 2);
        $this->assertEquals(count($neuronNodes), 3);

        $this->assertContainsOnlyInstancesOf(Bias::class, $biasNodes);
        $this->assertContainsOnlyInstancesOf(Neuron::class, $neuronNodes);
    }

    public function testLastNode()
    {
        /** @var INode $node */
        $node = $this->getMockForAbstractClass(INode::class);
        $this->layer->addNode($node);
        $this->assertTrue($node === $this->layer->toLastNode());
    }

}