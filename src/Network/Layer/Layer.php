<?php

namespace Neural\Network\Layer;


use Closure;
use Neural\Abstraction\ILayer;
use Neural\Network\Node\{
    Bias, INode, Input, Neuron
};


class Layer implements ILayer
{

    protected $nodes = [];

    public function __construct(int $neurons = 0, $nodeTypes = Neuron::class)
    {
        for ($i = 0; $i < $neurons; $i++) {
            $this->nodes[] = new $nodeTypes();
        }
    }

    /**
     * @param INode $node
     *
     * @return $this|Layer
     */
    public function addNode(INode $node): Layer
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * @param Closure|null $filter
     *
     * @return INode[]|Neuron[]|Input[]|Bias[]
     */
    public function getNodes(Closure $filter = null): array
    {
        if ($filter) {
            return array_filter($this->nodes, $filter);
        }

        return $this->nodes;
    }

    /**
     * @return INode
     */
    public function toLastNode(): INode
    {
        return end($this->nodes);
    }

}