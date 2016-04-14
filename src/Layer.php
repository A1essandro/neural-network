<?php

namespace Neural;


use Closure;
use Generator;
use Neural\Abstraction\ILayer;
use Neural\Node\INode;
use Neural\Node\Input;
use Neural\Node\Neuron;

class Layer implements ILayer
{

    const NODE_TYPE_NEURON = Neuron::class;
    const NODE_TYPE_INPUT = Input::class;

    protected $nodes = [];

    public function __construct($neurons, $nodeTypes = self::NODE_TYPE_NEURON)
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
     * @return Generator|INode[]|Neuron[]|Input[]|Bias[] Returns Generator!
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