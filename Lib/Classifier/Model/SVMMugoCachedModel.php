<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Model;

class SVMMugoCachedModel extends SVMModel
{
    /**
     * The name of the model
     * @var string
     */
    private $modelName;
    private $cacheFolderPath;
    private $modelFilename;
    /**
     * @param       $modelName
     * @param       $cacheFolderPath
     */
    public function __construct($modelName, $cacheFolderPath)
    {
        $this->cacheFolderPath = $cacheFolderPath;
        $this->modelName = $modelName;
        $this->modelFilename = $this->cacheFolderPath . '/' . $this->modelName;
        $data = unserialize(@file_get_contents($this->modelFilename . '.map') );
        if ( $data !== false && file_exists($this->modelFilename) ){
            $this->model = new \SVMModel;
            $this->model->load($this->modelFilename);
            $this->categoryMap = $data['categoryMap'];
            $this->tokenMap = $data['tokenMap'];
            $this->prepared = true;
        }
    }
    /**
     * @param  array      $model
     * @return mixed|void
     */
    public function setModel($model)
    {
        if (!$model instanceof \SVMModel) {
            throw new \RuntimeException("Expected SVMModel");
        }
        $this->model = $model;
        $this->model->save($this->modelFilename);
    }

    /**
     * @param $categoryMap
     * @param $tokenMap
     */
    public function setMaps($categoryMap, $tokenMap)
    {
        file_put_contents($this->modelFilename . '.map', serialize( array(
                'categoryMap' => $categoryMap,
                'tokenMap' => $tokenMap
            ) ));

        parent::setMaps($categoryMap, $tokenMap);
    }
}
