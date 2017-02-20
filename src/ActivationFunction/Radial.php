<?php

namespace Neural\ActivationFunction;


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