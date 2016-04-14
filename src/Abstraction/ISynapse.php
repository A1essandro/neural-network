<?php

namespace Neural\Abstraction;


use Neural\Node\INode;

interface ISynapse extends IOutput
{

    /**
     * @param float $delta
     */
    function changeWeight($delta);

    /**
     * @return float
     */
    function getWeight();

    /**
     * @return INode
     */
    function getParentNode();

}