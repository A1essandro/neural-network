<?php

namespace Neural\Abstraction;


use Closure;
use Generator;
use Neural\Node\Bias;
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
     * @return Neuron[]|Input[]|Bias[]
     */
    function getNodes(Closure $filter = null);

    /**
     * @return INode
     */
    function toLastNode();

}