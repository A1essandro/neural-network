<?php

namespace Neural;


use Neural\Abstraction\ISynapse;
use Neural\Node\INode;

class Synapse implements ISynapse
{

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var INode
     */
    protected $fromNode;

    /**
     * @param INode $fromNode
     * @param null $weight
     */
    public function __construct(INode $fromNode, $weight = null)
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
    public function changeWeight($delta)
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
     * @return INode
     */
    function getParentNode()
    {
        return $this->fromNode;
    }

}