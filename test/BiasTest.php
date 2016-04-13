<?php

use Neural\Bias;

class BiasTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Bias;
     */
    protected $node;

    protected function setUp()
    {
        $this->node = new Bias();
    }

    public function testOutput()
    {
        $this->assertEquals(1, $this->node->output());
    }


}