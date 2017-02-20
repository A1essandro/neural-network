<?php

namespace Neural\Abstraction;


use Closure;
use Neural\Network\Node\Bias;
use Neural\Network\Node\INode;
use Neural\Network\Node\Input;
use Neural\Network\Node\Neuron;

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