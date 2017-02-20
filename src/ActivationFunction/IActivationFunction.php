<?php

namespace Neural\ActivationFunction;


interface IActivationFunction
{

    /**
     * Formal possibility to execute object as function.
     *
     * @param number $value
     *
     * @return number
     */
    function __invoke($value);

}