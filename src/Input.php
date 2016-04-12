<?php

namespace Neural;


use Neural\Abstraction\IInput;
use Neural\Abstraction\Node;

class Input extends Node implements IInput
{

    /**
     * @param $input
     *
     * @return void
     */
    public function input($input)
    {
        $this->value = $input;
    }

    /**
     * Returns processing result
     *
     * @return float
     */
    public function output()
    {
        return $this->value;
    }

}