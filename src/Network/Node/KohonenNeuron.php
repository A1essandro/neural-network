<?php

namespace Neural\Network\Node;


use Neural\ActivationFunction\Radial;

class KohonenNeuron extends Neuron
{

    const DEFAULT_ACTIVATION_FUNCTION = Radial::class;

    /**
     * Euclidean distance between vectors Weights and Input passed through the activation function
     *
     * @return float
     */
    public function output()
    {
        if ($this->calculatedOutput !== 0) {
            return $this->calculatedOutput;
        }

        $pre = 0;
        foreach ($this->synapses as $synapse) {
            $weight = $synapse->getWeight();
            $input = $synapse->output() / $synapse->getWeight();

            $pre += pow($input - $weight, 2);
        }
        $euclid = sqrt($pre);

        return $this->calculatedOutput = $this->activationFunction->__invoke($euclid);
    }

}