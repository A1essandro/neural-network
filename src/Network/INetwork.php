<?php

namespace Neural\Network;


use Closure;
use Neural\Abstraction\{
    IInput, IOutput
};
use Neural\Network\Node\{
    INode, Neuron
};

interface INetwork extends IInput, IOutput
{

    /**
     * @param Closure $filter
     *
     * @return INode[]|Neuron[]
     */
    function getNodes(Closure $filter = null): array;

    /**
     * @param $input
     * @return $this
     */
    function input($input);

}