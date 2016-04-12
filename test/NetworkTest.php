<?php

use Neural\MultilayerPerceptron;

class NetworkTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var MultilayerPerceptron;
     */
    protected $network;

    protected function setUp()
    {
        $this->network = new MultilayerPerceptron([2, 2, 1]);
    }

    public function testLayersCount()
    {
        $this->assertEquals(count($this->network->getLayers()), 3);
    }

}