<?php

namespace Neural\Abstraction;


use Closure;
use Neural\Bias;
use Neural\Input;
use Neural\Neuron;

interface ILayer
{

    /**
     * @param Node $node
     *
     * @return void
     */
    function addNode(Node $node);

    /**
     * @param Closure $filter
     *
     * @return Node[]|Neuron[]|Input[]|Bias[] Returns Generator!
     */
    function getNodes(Closure $filter = null);

}