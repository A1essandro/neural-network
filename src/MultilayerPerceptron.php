<?php

namespace Neural;


use Generator;
use Neural\Abstraction\LayeredNetwork;
use Neural\Abstraction\Node;

class MultilayerPerceptron extends LayeredNetwork
{

    /**
     * @param array $layersOptions
     */
    public function __construct(array $layersOptions)
    {
        $lastLayer = count($layersOptions) - 1;
        foreach ($layersOptions as $key => $neuronsInLayer) {
            $layer = new Layer(
                $neuronsInLayer, $key
                ? Layer::NODE_TYPE_NEURON
                : Layer::NODE_TYPE_INPUT
            );
            if ($lastLayer != $key) {
                $layer->addNode(new Bias());
            }
            $this->addLayer($layer);
        }
    }

    /**
     * @param array $input
     *
     * @return $this
     */
    public function input($input)
    {
        $firstLayer = $this->layers[0];
        $filter = function ($node) {
            return $node instanceof Input;
        };

        foreach ($firstLayer->getNodes($filter) as $key => $neuron) {
            $neuron->input($input[$key]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function output()
    {
        $result = [];
        $lastLayer = $this->getOutputLayer();
        foreach ($lastLayer->getNodes() as $neuron) {
            $result[] = $neuron->output();
        }

        return $result;
    }

    public function trace()
    {
        $this->output();
        foreach ($this->layers as $lk => $layer) {
            echo 'L' . $lk . ': ' . PHP_EOL;
            foreach ($layer->getNodes() as $nk => $neuron) {
                echo "\t" . 'N' . $nk . ': ' . $neuron->getValue() . PHP_EOL;
                foreach ($neuron->getSynapses() as $sk => $synapse) {
                    echo "\t\tS" . $sk . ': ' . $synapse->getWeight() . PHP_EOL;
                }
            }
        }
    }

    public function generateSynapses()
    {
        for ($i = 0; $i < count($this->layers) - 1; $i++) {
            $curLayer = $this->layers[$i];
            $nextLayer = $this->layers[$i + 1];
            foreach ($nextLayer->getNodes() as $nextNeuron) {
                foreach ($curLayer->getNodes() as $curNeuron) {
                    if (!$nextNeuron instanceof Bias) {
                        $curNeuron->addSynapse(new Synapse($nextNeuron));
                    }
                }
            }
        }
    }

    /**
     * @return Generator|Node[]
     */
    protected function getOutputNeurons()
    {
        return $this->getOutputLayer()->getNodes();
    }

}
