<?php

namespace Neural;


use Neural\Abstraction\IActivationFunction;

class LogisticFunction implements IActivationFunction
{

    /**
     * @var int
     */
    private $param;

    /**
     * @param int $param
     */
    public function __construct($param = 1)
    {
        $this->param = $param;
    }

    /**
     * @param number $value
     *
     * @return number
     */
    function calculateValue($value)
    {
        return 1 / (1 + exp(-$this->param * $value));
    }
}