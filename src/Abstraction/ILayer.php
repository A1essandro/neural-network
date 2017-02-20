<?php

namespace Neural\Abstraction;


use Closure;
use Neural\Network\Node\{
    Bias, INode, Input, Neuron
};

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