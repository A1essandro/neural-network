<?php

namespace Neural\Abstraction;


interface IActivationFunction
{

    /**
     * @param number $value
     *
     * @return number
     */
    function calculateValue($value);

}