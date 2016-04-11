<?php

namespace Neural;


use Closure;
use Neural\Abstraction\ILayer;
use Neural\Abstraction\Node;

class Layer implements ILayer
{

    const NODE_TYPE_NEURON = 'Neural\Neuron';
    const NODE_TYPE_INPUT = 'Neural\Input';

    protected $nodes = [];

    public function __construct($neurons, $nodeTypes = self::NODE_TYPE_NEURON)
    {
        for ($i = 0; $i < $neurons; $i++) {
            $this->nodes[] = new $nodeTypes();
        }
    }

    /**
     * @param Node $node
     *
     * @return void
     */
    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * @param Closure|null $filter
     *
     * @return Node[]|Neuron[]|Input[]|Bias[] Returns Generator!
     */
    public function getNodes(Closure $filter = null)
    {
        foreach ($this->nodes as $node) {
            if ($filter && !$filter($node)) {
                continue;
            }

            yield $node;
        }
    }

}