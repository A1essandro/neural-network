<?php

namespace Neural\Abstraction;


use Closure;
use Generator;
use Neural\Bias;
use Neural\Node\INode;
use Neural\Node\Input;
use Neural\Node\Neuron;

interface ILayer
{

    /**
     * @param INode $node
     *
     * @return $this
     */
    function addNode(INode $node);

    /**
     * @param Closure $filter
     *
     * @return Generator|Neuron[]|Input[]|Bias[] Returns Generator!
     */
    function getNodes(Closure $filter = null);

}