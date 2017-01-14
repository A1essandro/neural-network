<?php

use Neural\BackpropagationTeacher;
use Neural\MultilayerPerceptron;

class BackpropagationTeacherTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var BackpropagationTeacher
     */
    public $teacher;

    protected function setUp()
    {
        $this->teacher = new BackpropagationTeacher(new MultilayerPerceptron([2, 1]));
    }

    protected function tearDown()
    {
        $this->teacher = null;
    }

    /**
     * @expectedException Exception
     */
    public function testException()
    {
        $this->teacher->teachKit([1], [1, 2]);
    }

    public function testIneffectuallyLearn()
    {
        $result = $this->teacher->teachKit(
            [[1, 0], [0, 1], [1, 1], [0, 0]], //kit for learning
            [[1], [1], [0], [0]], //appropriate expectations
            0.3, //error
            10 //max iterations
        );

        $this->assertEquals(BackpropagationTeacher::INEFFECTUALLY_LEARN, $result);
    }
}
