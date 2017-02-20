<?php


use Neural\Network\Layer\Layer;
use Neural\Network\LayeredNetwork;

class LayeredNetworkTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var LayeredNetwork
     */
    public $layeredNetwork;

    protected function setUp()
    {
        $this->layeredNetwork = $this->getMockForAbstractClass(LayeredNetwork::class);
    }

    public function testAddLayers()
    {
        $outputLayer = new Layer();
        $this->layeredNetwork->addLayer(new Layer())->addLayer($outputLayer);
        $this->assertCount(2, $this->layeredNetwork->getLayers());
        $this->assertTrue($outputLayer === $this->layeredNetwork->getOutputLayer());
    }

    public function testLayersMustBeNotNull()
    {
        $this->assertNotNull($this->layeredNetwork->getLayers());
    }

    /**
     * Try to resolve not covered string
     */
    public function testAddLayerReturn()
    {
        $this->assertInstanceOf(LayeredNetwork::class, $this->layeredNetwork->addLayer(new Layer()));
    }

}
