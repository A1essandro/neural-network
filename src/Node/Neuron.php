<?php

namespace Neural\Node;


use Neural\Abstraction\IActivationFunction;
use Neural\Abstraction\ISynapse;
use Neural\LogisticFunction;
use Neural\Synapse;

class Neuron implements INode
{

    /**
     * @var Synapse[]
     */
    protected $synapses = [];

    /**
     * @var IActivationFunction
     */
    protected $activationFunction;

    /**
     * @var float
     */
    protected $calculatedOutput = 0;

    const DEFAULT_ACTIVATION_FUNCTION = LogisticFunction::class;

    /**
     * @param IActivationFunction|null $activation
     */
    public function __construct(IActivationFunction $activation = null)
    {
        $defaultActivation = static::DEFAULT_ACTIVATION_FUNCTION;
        $this->activationFunction = $activation ?: new $defaultActivation;
    }

    /**
     * Add link to the previous layer neuron
     *
     * @param ISynapse $synapse
     */
    public function addSynapse(ISynapse $synapse)
    {
        $this->synapses[] = $synapse;
    }

    /**
     * Getting all synapses to nodes of the previous layer
     *
     * @return ISynapse[]
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

}