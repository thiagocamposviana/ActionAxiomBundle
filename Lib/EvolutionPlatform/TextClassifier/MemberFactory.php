<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier;

use Mugo\ActionAxiomBundle\Lib\Classifier\ComplementNaiveBayes;
use Mugo\ActionAxiomBundle\Lib\Classifier\SVM;
use Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataArray;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\MemberFactory as MemberFactoryInterface;
use Mugo\ActionAxiomBundle\Lib\Classifier\Model\Model;
use Mugo\ActionAxiomBundle\Lib\Classifier\Model\SVMModel;
use Mugo\ActionAxiomBundle\Lib\Utils\TextHelper;
use Mugo\ActionAxiomBundle\Lib\Utils\WikipediaHelper;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Singleton;

class MemberFactory extends Singleton implements MemberFactoryInterface
{
    public static function getTextData($definitionOnly = false)
    {
        $data = ['definition' => [], 'other' => []];
        $counter = 0;
        while($counter < 4 || empty($data['other']))
        {
            $paragraphs = WikipediaHelper::getRandomArticleParagraphs(Settings::$language);
            if( count($paragraphs) >= 2 )
            {
                foreach($paragraphs as $index => $p)
                {
                    // if we are going to use stemming, we apply it here
                    // this way the stemming does not repeat
                    // this is for performance
                    // this also lowercase the text and do some of the tokenization operations
                    $cleanText = TextHelper::applyTextCommonTransformations($p, Settings::$stemmer);
                    $sentences = TextHelper::getSentences($cleanText);
                    if( $index == 0 && !empty($sentences) )
                    {
                        if( $definitionOnly )
                        {
                            return array_shift($sentences);
                        }
                        $data['definition'][] = array_shift($sentences);
                    }
                    if(!empty($sentences) )
                    {
                        $data['other'] = array_merge($data['other'], $sentences);
                    }
                }
                $counter++;
            }
        }
        return $data;
    }

    public function create( ?array $dataSource = null ) : Member
    {
        $source = new DataArray();
        if( $dataSource === null )
        {
            $dataSource = MemberFactory::getTextData();
            for( $x = 0; $x < Settings::$initialExtraDefinitions; $x++ )
            {
                $dataSource['definition'][] = MemberFactory::getTextData(true);
            }
        }
        foreach( $dataSource as $category => $items )
        {
            $categoryItems = array_filter($items);
            foreach( $categoryItems as $index => $sourceItem )
            {
                $source->addDocument($category, $sourceItem);
            }
        }

        $model = null;
        $classifier = null;

        if( Settings::$modelName == 'svm' )
        {
            $model = new SVMModel();
            $classifier = new SVM($source, $model, Settings::$documentNormalizer, null, null, null, .01);
        }
        else
        {
            $model = new Model();
            $classifier = new ComplementNaiveBayes($source, $model, Settings::$documentNormalizer, null, null);
        }

        $member = new Member( $dataSource );
        $member->setFitness(FitnessEvaluator::getInstance()->evaluate(['classifier'=>$classifier, 'data' => Settings::$testingData])[0]['accuracy']);

        return $member;
    }
}