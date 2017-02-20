<?php

namespace Neural\ActivationFunction;


class Radial implements IActivationFunction
{

    /**
     * @param number $value
     *
     * @return number
     */
    public function __invoke($value)
    {
        return exp(-pow($value, 2) / 2);
    }
}