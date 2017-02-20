<?php

namespace Neural\ActivationFunction;


class Logistic implements IActivationFunction
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