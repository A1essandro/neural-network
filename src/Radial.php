<?php

namespace Neural;


use Neural\Abstraction\IActivationFunction;

class Radial implements IActivationFunction
{

    /**
     * @param number $value
     *
     * @return number
     */
    public function calculateValue($value)
    {
        return exp(-pow($value, 2) / 2);
    }
}