<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Model;

class MugoCachedModel extends Model
{
    /**
     * The name of the model
     * @var string
     */
    private $modelName;
    private $cache;
    private $cacheService;
    /**
     * 
     * @param type $modelName
     * @param type $container
     */
    public function __construct(
        $modelName, $container
    ) {
        $this->cacheService = $container->get( 'ezpublish.cache_pool' );
        $this->modelName = $modelName;
        $data = null;
        $this->cache = $this->cacheService->getItem( $this->modelName );
        if ( $this->cache->isHit() ){
            $data = $this->cache->get();
            $this->prepared = true;
            $this->model = unserialize( $data );
        }
    }
    /**
     * @param  array      $model
     * @return mixed|void
     */
    public function setModel($model)
    {
        $this->model = $model;
        $this->cache->set( serialize( $model ) );
        $this->cache->expiresAfter(60);
        $this->cacheService->save( $this->cache );
    }
}
