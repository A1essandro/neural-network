<?php

use Neural\Input;

class InputNodeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Input;
     */
    protected $node;

    protected function setUp()
    {
        $this->node = new Input();
    }

    public function providerSetInput()
    {
        return array(
            array(-1),
            array(0),
            array(0.5),
            array(1),
            array(5)
        );
    }

    /**
     * @dataProvider providerSetInput
     *
     * @param $value float
     */
    public function testOutput($value)
    {
        $this->node->input($value);
        $this->assertEquals($value, $this->node->output());
    }

}