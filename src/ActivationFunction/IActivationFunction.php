<?php

namespace Neural\ActivationFunction;


interface IActivationFunction
{

    /**
     * Formal possibility to execute object as function.
     *
     * @param float $value
     *
     * @return float
     */
    function __invoke(float $value): float;

}