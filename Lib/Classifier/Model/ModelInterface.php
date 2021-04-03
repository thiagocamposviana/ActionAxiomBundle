<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Model;

interface ModelInterface
{
    /**
     * Returns whether or not the model is prepared
     * @return boolean The prepared status
     */
    public function isPrepared();
    /**
     * @param $prepared
     * @return mixed
     */
    public function setPrepared($prepared);
    /**
     * Get the data
     * @return array
     */
    public function getModel();
    /**
     * @param $model
     * @return mixed
     */
    public function setModel($model);
}
