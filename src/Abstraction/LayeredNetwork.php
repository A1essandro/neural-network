<?php

namespace Neural\Abstraction;


use Generator;
use Neural\Input;

abstract class LayeredNetwork implements INetwork
{

    /**
     * @var ILayer[]
     */
    protected $layers;

    /**
     * @return ILayer
     */
    public function getOutputLayer()
    {
        $this->layers[0]->getNodes();
        return $this->layers[count($this->layers) - 1];
    }

    /**
     * @return ILayer[]
     */
    public function getLayers()
    {
        return $this->layers;
    }

    /**
     * @return Generator|ILayer[] Returns Generator!
     */
    public function getLayersReverse()
    {
        for ($i = count($this->layers) - 1; $i >= 0; $i--) {
            yield $this->layers[$i];
        }
    }

    /**
     * @param ILayer $layer
     *
     * @return $this
     */
    public function addLayer(ILayer $layer)
    {
        $this->layers[] = $layer;

        return $this;
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

    /**
     * @return Generator|Node[]
     */
    protected function getOutputNeurons()
    {
        return $this->getOutputLayer()->getNodes();
    }

}