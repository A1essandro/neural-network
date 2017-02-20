<?php

namespace Neural\ActivationFunction;


interface IActivationFunction
{

    /**
     * @param number $value
     *
     * @return number
     */
    function calculateValue($value);

}