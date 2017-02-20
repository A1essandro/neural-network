<?php

namespace Neural\Network\Node;


class Bias implements INode
{

    function output()
    {
        return 1;
    }

}