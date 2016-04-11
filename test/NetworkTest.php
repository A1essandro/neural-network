<?php

use Neural\Network;

class NetworkTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Network;
     */
    protected $network;

    protected function setUp()
    {
        $this->network = new Network([2, 2, 1]);
    }

    public function testLayersCount()
    {
        $this->assertEquals(count($this->network->getLayers()), 3);
    }

}