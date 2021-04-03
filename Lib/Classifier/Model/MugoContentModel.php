<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Model;

class MugoContentModel extends Model
{
    /**
     * The name of the model
     * @var string
     */
    private $modelName;
    private $repository;
    private $categoryContent;
    private $classifications;

    /**
     * 
     * @param type $modelName
     * @param type $container
     */
    public function __construct(
        $categoryContent, $repository, $classifications
    ) {
        $this->repository = $repository;
        $this->classifications = $classifications;
        $this->categoryContent = $categoryContent;
        $this->modelName = $categoryContent->getFieldValue( 'title' )->text;
        $cachedModel = unserialize( $categoryContent->getFieldValue( 'cached_model' )->text );
        $cachedClassifications = $categoryContent->getFieldValue( 'cached_classifications' )->text;
        if ( is_array( $cachedModel ) && serialize($classifications) == $cachedClassifications ){
            $this->prepared = true;
            $this->model = $cachedModel;
        }
    }
    /**
     * @param  array      $model
     * @return mixed|void
     */
    public function setModel($model)
    {
        $this->model = $model;
        $contentService = $this->repository->getContentService();
        $contentInfo = $contentService->loadContentInfo( $this->categoryContent->id );
        $contentDraft = $contentService->createContentDraft( $contentInfo );
        $contentUpdateStruct = $contentService->newContentUpdateStruct();
        $contentUpdateStruct->setField( 'cached_model', serialize( $model ) );
        $contentUpdateStruct->setField( 'cached_classifications', serialize( $this->classifications ) );
        $contentDraft = $contentService->updateContent( $contentDraft->versionInfo, $contentUpdateStruct );
        $contentService->publishVersion( $contentDraft->versionInfo );
    }
}
