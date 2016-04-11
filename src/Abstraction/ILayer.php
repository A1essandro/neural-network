<?php

namespace Neural\Abstraction;


use Closure;
use Generator;
use Neural\Bias;
use Neural\Input;
use Neural\Neuron;

interface ILayer
{

    /**
     * @param Node $node
     *
     * @return $this
     */
    function addNode(Node $node);

    /**
     * @param Closure $filter
     *
     * @return Generator|Node[]|Neuron[]|Input[]|Bias[] Returns Generator!
     */
    function getNodes(Closure $filter = null);

}