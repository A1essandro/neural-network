<?php

namespace Neural;


use Neural\Abstraction\LayeredNetwork;
use Neural\Node\Input;
use Neural\Node\Neuron;
use Neural\Node\Bias;

class MultilayerPerceptron extends LayeredNetwork
{

    /**
     * @param array $layersOptions
     */
    public function __construct(array $layersOptions = null)
    {
        if(is_null($layersOptions)) {
            return;
        }

        foreach ($layersOptions as $key => $neuronsInLayer) {
            $layer = new Layer(
                $neuronsInLayer, $key
                ? Neuron::class
                : Input::class
            );
            $this->addLayer($layer);
        }
        $this->addBiasNodes();
    }

    protected function addBiasNodes()
    {
        foreach ($this->layers as $layer) {
            if ($layer != $this->getOutputLayer()) {
                $layer->addNode(new Bias());
            }
        }
    }

    public function generateSynapses()
    {
        $filterNotBias = function($node) {
            return !$node instanceof Bias;
        };

        for ($i = 0; $i < count($this->layers) - 1; $i++) {
            $curLayer = $this->layers[$i];
            $nextLayer = $this->layers[$i + 1];
            foreach ($nextLayer->getNodes($filterNotBias) as $nextNeuron) {
                foreach ($curLayer->getNodes() as $curNeuron) {
                    $nextNeuron->addSynapse(new Synapse($curNeuron));
                }
            }
        }
    }

}
