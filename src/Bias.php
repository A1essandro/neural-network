<?php

namespace Neural;


use Neural\Abstraction\IOutput;
use Neural\Abstraction\Node;

class Bias extends Node implements IOutput
{

    function output()
    {
        return 1;
    }

}