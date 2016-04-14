<?php

namespace Neural\Node;

class Bias implements INode
{

    function output()
    {
        return 1;
    }

}