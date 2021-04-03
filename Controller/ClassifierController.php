<?php
namespace Mugo\ActionAxiomBundle\Controller;

use \eZ\Bundle\EzPublishCoreBundle\Controller;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;
use Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataArray;
use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token\PhpStemmer;
use Mugo\ActionAxiomBundle\Lib\Classifier\Model\SVMMugoCachedModel;
use \Mugo\ActionAxiomBundle\Lib\Classifier\Model\MugoFileCachedModel;
use Mugo\ActionAxiomBundle\Lib\Classifier\ComplementNaiveBayes;
use Mugo\ActionAxiomBundle\Lib\Classifier\SVM;


class ClassifierController extends Controller
{
    /**
     * 
     * @param string|null $classifier
     * @param string|null $language
     * @param string|null $useStemmer
     * @return JsonResponse
     * @throws \Exception
     */
    public function classifyParagraphsAction(
        ?string $classifier = null,
        ?string $language = null,
        ?string $useStemmer = null
    ) {
        if( !in_array($classifier, ['svm', 'bayes']) )
        {
            throw new \Exception('Invalid classifier.');
        }
        if( !in_array($useStemmer, ['true', 'false']) )
        {
            throw new \Exception('Stemmer value should be "true" or "false".');
        }
        if(strlen($language) > 3 || !ctype_alnum($language) )
        {
           $language = 'eng';
        }
        $stemmer = null;
        $modelName = "{$classifier}_{$language}_paragraph";
        if( $useStemmer == 'true')
        {
            $modelName .= '_stemmer';
            $stemmer = new PhpStemmer($language);
        }

        $folderPath = dirname(__DIR__) . "/Resources/data/predict/{$language}/paragraph/cache";
        

        $filePath = $folderPath . "/{$modelName}";

        if(file_exists($filePath) )
        {
            $classifierObject = null;

            $model = null;
            
            if( $classifier == 'bayes' )
            {
                $model = new MugoFileCachedModel($modelName, $folderPath);
                $classifierObject = new ComplementNaiveBayes(new DataArray(), $model, null, null, $stemmer);
            }
            else
            {
                $model = new SVMMugoCachedModel($modelName, $folderPath);
                $classifierObject = new SVM(new DataArray(), $model, null, null, $stemmer);
            }

            $request  = Request::createFromGlobals();
            $paragraphs = json_decode($request->get('paragraphs'));
            $results = [];
            if( $paragraphs )
            {
                foreach( $paragraphs as $paragraph )
                {
                    if( empty($paragraph) )
                    {
                        continue;
                    }
                    $sentences = preg_split("/(?<!\.\.\.)(?<=[.?!]|\.\))\s+(?=[a-zà-ú])/Uisu", $paragraph);
                    $result = '';
                    foreach( $sentences as $sentence )
                    {
                        if( empty($sentence) )
                        {
                            continue;
                        }
                        $classification = $classifierObject->classify($sentence);
                        $result .= "<span class=\"$classification\">{$sentence}</span> ";
                    }
                    $results[] = $result;
                }
            }
            else
            {
                throw new \Exception('Invalid post');
            }

            return new JsonResponse( $results );
        }
        else
        {
            throw new \Exception('Model does not exist');
        }
    }

    private function getData($language, $group, $type, $item)
    {
        $filePath = dirname(__DIR__) . "/Resources/data/predict/{$language}/{$group}/{$type}/{$item}";
        if(file_exists($filePath) )
        {
            $contents = file_get_contents($filePath);
            return array_map('trim', explode("\n", $contents));
        }
        throw new \Exception('File not found: ' . $filePath);
    }
}