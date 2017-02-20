<?php

namespace Neural\Network;


use Closure;
use Neural\Abstraction\IInput;
use Neural\Abstraction\IOutput;
use Neural\Network\Node\INode;
use Neural\Network\Node\Neuron;

interface INetwork extends IInput, IOutput
{

    /**
     * @param Closure $filter
     *
     * @return INode[]|Neuron[]
     */
    function getNodes(Closure $filter = null);

    /**
     * @param $input
     * @return $this
     */
    function input($input);

}