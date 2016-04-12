<?php

namespace Neural;


use Neural\Abstraction\IOutput;
use Neural\Abstraction\Node;

class Synapse implements IOutput
{

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var Node
     */
    protected $fromNode;

    /**
     * @param Node $fromNode
     * @param null $weight
     */
    public function __construct(Node $fromNode, $weight = null)
    {
        $this->setWeight($weight);
        $this->fromNode = $fromNode;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight = null)
    {
        $this->weight = $weight ?: $this->generateRandomWeight();
    }

    /**
     * @return float
     */
    protected function generateRandomWeight()
    {
        return 1 / rand(5, 25) * (rand(0, 1) ? -1 : 1);
    }

    /**
     * @return float
     */
    public function output()
    {
        return $this->weight * $this->fromNode->output();
    }

    /**
     * @param float $delta
     */
    public function recalculateWeight($delta)
    {
        $this->weight += $delta;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return Node
     */
    public function getInputNode()
    {
        return $this->fromNode;
    }

}