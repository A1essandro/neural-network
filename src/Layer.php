<?php

namespace Neural;


use Closure;
use Neural\Abstraction\ILayer;
use Neural\Node\Bias;
use Neural\Node\INode;
use Neural\Node\Input;
use Neural\Node\Neuron;

class Layer implements ILayer
{

    protected $nodes = [];

    public function __construct($neurons = 0, $nodeTypes = Neuron::class)
    {
        for ($i = 0; $i < $neurons; $i++) {
            $this->nodes[] = new $nodeTypes();
        }
    }

    /**
     * @param INode $node
     *
     * @return $this
     */
    public function addNode(INode $node)
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * @param Closure|null $filter
     *
     * @return INode[]|Neuron[]|Input[]|Bias[]
     */
    public function getNodes(Closure $filter = null)
    {
        if ($filter) {
            return array_filter($this->nodes, $filter);
        }

        return $this->nodes;
    }

    /**
     * @return INode
     */
    public function toLastNode()
    {
        return end($this->nodes);
    }

}