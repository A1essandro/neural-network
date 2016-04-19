<?php

namespace Neural\Node;


class KohonenNeuron extends Neuron
{

    /**
     * Euclidean distance between vectors Weights and Input passed through the activation function
     * @return float
     */
    public function output()
    {
        $pre = 0;
        foreach ($this->synapses as $synapse) {
            $weight = $synapse->getWeight();
            $input = $synapse->output() / $synapse->getWeight();

            $pre += pow($input - $weight, 2);
        }

        //must be exp(-pow(sqrt($pre), 2)), but equal to
        return exp(-$pre);
    }

}