<?php

namespace Neural\Learning;


interface ISelfLearning
{

    /**
     * @param $input
     *
     * @return array
     */
    public function learn(array $input);

}