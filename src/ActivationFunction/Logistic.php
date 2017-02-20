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
     * @param float $value
     * @return float
     */
    function __invoke(float $value): float
    {
        return 1 / (1 + exp(-$this->param * $value));
    }
}