<?php

namespace Neural\Network\Synapse;


use Neural\Network\Node\INode;

class Synapse implements ISynapse
{

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var INode
     */
    protected $parentNode;

    /**
     * @param INode $fromNode
     * @param null|float $weight
     */
    public function __construct(INode $fromNode, $weight = null)
    {
        $this->setWeight($weight);
        $this->parentNode = $fromNode;
    }

    /**
     * @return float
     */
    public function output()
    {
        return $this->weight * $this->parentNode->output();
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
     * @param float $weight
     */
    public function setWeight($weight = null)
    {
        $this->weight = $weight ?: $this->generateRandomWeight();
    }

    /**
     * @return INode
     */
    function getParentNode()
    {
        return $this->parentNode;
    }

    /**
     * @return float
     */
    protected function generateRandomWeight()
    {
        return 1 / rand(5, 25) * (rand(0, 1) ? -1 : 1);
    }

}