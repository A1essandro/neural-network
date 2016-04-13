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
     * Is value calculated for current input (performance optimization)
     *
     * @var null|float
     */
    protected $calculated = null;

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

    public function getValue()
    {
        if (count($this->synapses)) {
            return $this->activation();
        }
        return $this->value;
    }

    public function output()
    {
        if ($this->calculated !== null) {
            return $this->calculated;
        }

        foreach ($this->synapses as $synapse) {
            $this->value += $synapse->output();
        }
        return $this->calculated = $this->activation();
    }

    public function refresh()
    {
        $this->value = 0;
        $this->calculated = null;
    }

    protected function activation()
    {
        return round(1 / (1 + exp(-$this->value)), 5);
    }
}