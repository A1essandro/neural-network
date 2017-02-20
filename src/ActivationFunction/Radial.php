<?php

namespace Neural\ActivationFunction;


class Radial implements IActivationFunction
{

    /**
     * @param float $value
     * @return float
     */
    public function __invoke(float $value): float
    {
        return exp(-pow($value, 2) / 2);
    }
}