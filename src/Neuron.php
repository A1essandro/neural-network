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

    function getValue()
    {
        if (count($this->synapses)) {
            return round(1 / (1 + exp(-$this->value)), 5);
        }
        return $this->value;
    }

    function output()
    {
        $this->value = 0;
        foreach ($this->synapses as $synapse) {
            $this->value += $synapse->output();
        }
        return round(1 / (1 + exp(-$this->value)), 5);
    }

}