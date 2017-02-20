<?php

namespace Neural\Network\Synapse;


use Neural\Abstraction\IOutput;
use Neural\Network\Node\INode;

interface ISynapse extends IOutput
{

    /**
     * @param float $delta
     */
    function changeWeight(float $delta);

    /**
     * @return float
     */
    function getWeight(): float;

    /**
     * @return INode
     */
    function getParentNode(): INode;

}