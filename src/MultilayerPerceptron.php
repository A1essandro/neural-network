<?php

namespace Neural;


use Neural\Abstraction\LayeredNetwork;
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
                ? Layer::NODE_TYPE_NEURON
                : Layer::NODE_TYPE_INPUT
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

    public function trace()
    {
        $this->output();
        foreach ($this->layers as $lk => $layer) {
            echo 'L' . $lk . ': ' . PHP_EOL;
            foreach ($layer->getNodes() as $nk => $neuron) {
                echo "\t" . 'N' . $nk . ': ' . $neuron->output() . PHP_EOL;
                if ($neuron instanceof Neuron) {
                    foreach ($neuron->getSynapses() as $sk => $synapse) {
                        echo "\t\tS" . $sk . ': ' . $synapse->getWeight() . PHP_EOL;
                    }
                }
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
