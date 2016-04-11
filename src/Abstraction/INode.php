<?php

namespace Neural\Abstraction;


interface INode extends IOutput
{

    /**
     * @return float
     */
    function getValue();

}