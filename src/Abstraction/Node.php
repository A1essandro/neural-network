<?php

namespace Neural\Abstraction;


abstract class Node implements INode
{

    /**
     * @var float
     */
    protected $value = 0;

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

}