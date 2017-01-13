<?php

use Neural\Abstraction\LayeredNetwork;
use Neural\Layer;

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

}
