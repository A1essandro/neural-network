<?php

namespace Neural\Abstraction;


use Closure;
use Neural\Node\INode;
use Neural\Node\Neuron;

interface INetwork extends IInput, IOutput
{

    /**
     * @param Closure $filter
     *
     * @return INode[]|Neuron[]
     */
    function getNodes(Closure $filter = null);

    /**
     * @return $this
     */
    function input($input);

}