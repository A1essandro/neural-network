<?php

use Neural\KohonenNetwork;

class KohonenNetworkTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var KohonenNetwork
     */
    private $network;

    protected function setUp()
    {
        $this->network = new KohonenNetwork([3, 2]);
    }

    protected function tearDown()
    {
        $this->network = null;
    }

    public function testConfiguration()
    {
        $this->assertCount(2, $this->network->getLayers());
        $this->assertCount(2, $this->network->toLastLayer()->getNodes());
        $this->assertCount(3, $this->network->getLayers()[0]->getNodes());
    }

    public function testSynapses()
    {
        $this->network->generateSynapses();

        $this->assertCount(3, $this->network->toLastLayer()->getNodes()[0]->getSynapses());
    }

    public function testOutput()
    {
        $this->network->generateSynapses();

        $this->assertCount(2, $this->network->output());
        $this->assertEquals(1, array_sum($this->network->output()));
    }

}
