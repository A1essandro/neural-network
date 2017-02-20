<?php

namespace Neural\Learning;


interface ITeacher
{

    /**
     * @param array $input
     * @param array $expectation
     */
    function teach(array $input, array $expectation);

    /**
     * Teach until it learns
     *
     * @param array $kit
     * @param array $expectations
     * @param float $error
     * @param int $maxIterations
     *
     * @return int Iterations performed (no results if -1)
     */
    function teachKit(array $kit, array $expectations, float $error = 0.5, int $maxIterations = 10000): int;

}