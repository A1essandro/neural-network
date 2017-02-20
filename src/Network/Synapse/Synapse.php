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
     * @param float|null $weight
     */
    public function __construct(INode $fromNode, float $weight = null)
    {
        $this->setWeight($weight);
        $this->parentNode = $fromNode;
    }

    /**
     * @return float
     */
    public function output(): float
    {
        return $this->weight * $this->parentNode->output();
    }

    /**
     * @param float $delta
     */
    public function changeWeight(float $delta)
    {
        $this->weight += $delta;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight = null)
    {
        $this->weight = $weight ?: $this->generateRandomWeight();
    }

    /**
     * @return INode
     */
    public function getParentNode(): INode
    {
        return $this->parentNode;
    }

    /**
     * @return float
     */
    private function generateRandomWeight(): float
    {
        return 1 / rand(5, 25) * (rand(0, 1) ? -1 : 1);
    }

}