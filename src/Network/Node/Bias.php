<?php

namespace Neural\Network\Node;


class Bias implements INode
{

    function output(): int
    {
        return 1;
    }

}