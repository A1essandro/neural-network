<?php

namespace Neural\Abstraction;


use Generator;

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

}