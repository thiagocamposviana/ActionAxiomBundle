<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier;

use Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataSourceInterface;
use Mugo\ActionAxiomBundle\Lib\Classifier\Model\ModelInterface;
use RuntimeException;

/**
 * A generic classifier which can be used to built a classifier given a number of injected components
 */
abstract class Classifier implements ClassifierInterface
{
    /**
     * @var \Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataSourceInterface
     */
    protected $dataSource;
    /**
     * The model to apply the transforms to
     * @var \Mugo\ActionAxiomBundle\Lib\Classifier\Model\ModelInterface
     */
    protected $model;
    /**
     * @inheritdoc
     */
    public function is($category, $document)
    {
        if ($this->dataSource->hasCategory($category)) {
            return $this->classify($document) === $category;
        } else {
            throw new RuntimeException(
                sprintf(
                    "The category '%s' doesn't exist",
                    $category
                )
            );
        }
    }
    /**
     * Builds the model from the data source by applying transforms to the data source
     * @return null
     */
    abstract public function prepareModel();
    /**
     * Return an model which has been prepared for classification
     * @return \Mugo\ActionAxiomBundle\Lib\Classifier\Model\ModelInterface
     */
    protected function preparedModel()
    {
        if (!$this->model->isPrepared()) {
            $this->prepareModel();
        }

        return $this->model;
    }
    /**
     * Take a callable and run it passing in any additionally specified arguments
     * @param  callable          $transform
     * @throws \RuntimeException
     * @return mixed
     */
    protected function applyTransform($transform)
    {
        if (is_callable($transform)) {
            return call_user_func_array($transform, array_slice(func_get_args(), 1));
        } else {
            throw new RuntimeException("Argument to applyTransform must be callable");
        }
    }
    /**
     * @param \Mugo\ActionAxiomBundle\Lib\Classifier\Model\ModelInterface $model
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;
    }
    /**
     * @param \Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataSourceInterface $dataSource
     */
    public function setDataSource(DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }
}
