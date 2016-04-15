<?php

namespace Neural\Abstraction;


use Closure;
use Generator;
use Neural\Node\INode;
use Neural\Node\Input;
use Neural\Node\Neuron;

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
        $inputsFilter = function ($node) {
            return $node instanceof Input;
        };
        $neuronsFilter = function ($node) {
            return $node instanceof Neuron;
        };

        foreach ($firstLayer->getNodes($inputsFilter) as $key => $neuron) {
            $neuron->input($input[$key]);
        }

        foreach($this->getNodes($neuronsFilter) as $neuron) {
            $neuron->refresh();
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
     * @return Generator|INode[]
     */
    protected function getOutputNeurons()
    {
        return $this->getOutputLayer()->getNodes();
    }

    /**
     * @param Closure $filter
     *
     * @return Generator|INode[]|Neuron[]
     */
    public function getNodes(Closure $filter = null)
    {
        foreach ($this->layers as $layer) {
            foreach ($layer->getNodes($filter) as $node) {
                yield $node;
            }
        }
    }

}