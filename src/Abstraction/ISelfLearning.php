<?php

namespace Neural\Abstraction;


interface ISelfLearning
{

    /**
     * @param $input
     *
     * @return array
     */
    public function learn(array $input);

}