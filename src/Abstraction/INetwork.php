<?php

namespace Neural\Abstraction;


use Closure;
use Generator;
use Neural\Neuron;

interface INetwork extends IInput, IOutput
{

    /**
     * @param Closure $filter
     *
     * @return Generator|INode[]|Neuron[]
     */
    function getNodes(Closure $filter = null);

}