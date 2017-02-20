<?php

namespace Neural\Network\Node;


use Neural\Abstraction\IInput;

class Input implements INode, IInput
{

    /**
     * @var int input value
     */
    protected $input = 0;

    /**
     * @param $input
     *
     * @return void
     */
    public function input($input)
    {
        $this->input = $input;
    }

    /**
     * Returns processing result
     *
     * @return float
     */
    public function output()
    {
        return $this->input;
    }

}