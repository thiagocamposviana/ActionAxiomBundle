<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Model;

class MugoFileCachedModel extends Model
{
    /**
     * The name of the model
     * @var string
     */
    private $modelName;
    private $cacheFolderPath;
    private $modelFilename;
    /**
     * 
     * @param type $modelName
     * @param type $cacheFolderPath
     */
    public function __construct(
        $modelName, $cacheFolderPath
    ) {
        $this->cacheFolderPath = $cacheFolderPath;
        $this->modelName = $modelName;
        $this->modelFilename = $this->cacheFolderPath . '/' . $this->modelName;
        $data = unserialize(@file_get_contents($this->modelFilename) );
        if ( $data !== false ){
            $this->prepared = true;
            $this->model = $data;
        }
    }
    /**
     * @param  array      $model
     * @return mixed|void
     */
    public function setModel($model)
    {
        $this->model = $model;
        file_put_contents($this->modelFilename, serialize( $model ) );
    }
}
