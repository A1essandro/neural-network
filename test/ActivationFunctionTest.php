<?php


use Neural\ActivationFunction\IActivationFunction;

class ActivationFunctionTest extends \PHPUnit_Framework_TestCase
{

    public function testInvoke()
    {
        $this->markTestSkipped('Must be revisited.');
        $func = $this->getMock(IActivationFunction::class);

        /** @var IActivationFunction $func */
        $this->assertEquals($func(1) === null, true);
    }

}
