<?php

namespace Neural;


use Neural\Abstraction\IOutput;
use Neural\Abstraction\Node;

class Neuron extends Node implements IOutput
{

    /**
     * @var Synapse[]
     */
    protected $synapses = [];

    /**
     * Add link to the previous layer neuron
     *
     * @param Synapse $synapse
     *
     * @return void
     */
    public function addSynapse(Synapse $synapse)
    {
        $this->synapses[] = $synapse;
    }

    /**
     * Getting all synapses to nodes of the previous layer
     *
     * @return Synapse[]
     */
    public function getSynapses()
    {
        return $this->synapses;
    }

    public function output()
    {
        if ($this->calculatedOutput !== 0) {
            return $this->calculatedOutput;
        }

        $sum = 0;
        foreach ($this->synapses as $synapse) {
            $sum += $synapse->output();
        }
        return $this->calculatedOutput = $this->activation($sum);
    }

    public function refresh()
    {
        $this->calculatedOutput = 0;
    }

    protected function activation($value)
    {
        return round(1 / (1 + exp(-$value)), 5);
    }
}