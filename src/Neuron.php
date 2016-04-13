<?php

namespace Neural;


use Neural\Abstraction\IActivationFunction;
use Neural\Abstraction\IOutput;
use Neural\Abstraction\Node;

class Neuron extends Node implements IOutput
{

    /**
     * @var Synapse[]
     */
    protected $synapses = [];

    /**
     * @var IActivationFunction
     */
    protected $activationFunction;

    const DEFAULT_ACTIVATION_FUNCTION = LogisticFunction::class;

    /**
     * Add link to the previous layer neuron
     *
     * @param Synapse             $synapse
     * @param IActivationFunction $activation
     */
    public function addSynapse(Synapse $synapse, IActivationFunction $activation = null)
    {
        $this->synapses[] = $synapse;
        $defaultActivation = self::DEFAULT_ACTIVATION_FUNCTION;
        $this->activationFunction = $activation ?: new $defaultActivation;
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
        return $this->calculatedOutput = $this->activationFunction->calculateValue($sum);
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