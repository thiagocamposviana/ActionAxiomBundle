<?php

namespace Mugo\ActionAxiomBundle\Command;

use eZ\Publish\API\Repository\Repository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mugo\ActionAxiomBundle\Lib\Classifier\ComplementNaiveBayes;
use Mugo\ActionAxiomBundle\Lib\Classifier\SVM;
use Mugo\ActionAxiomBundle\Lib\Classifier\Model\SVMMugoCachedModel;
use Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataArray;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier\FitnessEvaluator;
use \Mugo\ActionAxiomBundle\Lib\Classifier\Model\MugoFileCachedModel;

use \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier\TextClassifierEvolutionaryAlgorithm;
use \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State\DefaultLoop;
use \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier\State\LoopT1;
use \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier\Settings;
use \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier\MemberFactory;
use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token\PhpStemmer;

class ClassifierCacheCommand extends Command {

    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;

    private $cacheService;

    public function __construct(Repository $repository, $cacheService) {
        parent::__construct(null);
        $this->repository = $repository;
        $this->cacheService = $cacheService;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
                ->setName('mugo:classifier:cache')
                ->addOption(
                        'script_user', 'u', InputOption::VALUE_OPTIONAL, 'eZ Platform username (with Role containing at least Content policies: read, versionread, edit, remove, versionremove)', 'admin'
                )
                ->setDescription('Cache classifiers');
    }

    protected function initialize(InputInterface $input, OutputInterface $output) {
        parent::initialize($input, $output);
        $this->repository->getPermissionResolver()->setCurrentUserReference(
                $this->repository->getUserService()->loadUserByLogin($input->getOption('script_user'))
        );
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

    private function outputResults( $results )
    {
        foreach( $results as $result )
        {
            echo "\nAccuracy: {$result['accuracy']}\n";
            //print_r($result['errors']);
        }
    }

    private function getCacheFolderPath($language, $group)
    {
        $folderPath = dirname(__DIR__) . "/Resources/data/predict/{$language}/{$group}/cache";
        if(file_exists($folderPath) )
        {
            return $folderPath;
        }
        throw new \Exception('File not found: ' . $filePath);
    }

    private function cacheBayesModel( $lang, $type, $useStemmer, $source, $testData )
    {
        $time_start = microtime(true);
        $modelName = "bayes_{$lang}_{$type}";
        $stemmer = null;
        if( $useStemmer )
        {
            $modelName .= '_stemmer';
            $stemmer = new PhpStemmer($lang);
            echo "\n\nBayes with Stemmer:\n";
        }
        else
        {
            echo "\n\nBayes without Stemmer:\n";
        }

        $bayesModel = new MugoFileCachedModel($modelName, $this->getCacheFolderPath($lang, $type));
        $bayesClassifier = new ComplementNaiveBayes($source, $bayesModel, null, null, $stemmer);

        $testingResults = FitnessEvaluator::getInstance()->evaluate(['classifier' => $bayesClassifier, 'data' => $testData]);
        $this->outputResults($testingResults);

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "\n\nTotal Time:($time)\n";
    }

    private function cacheSVMModel( $lang, $type, $useStemmer, $source, $testData )
    {
        $time_start = microtime(true);
        $modelName = "svm_{$lang}_{$type}";
        $stemmer = null;
        if( $useStemmer )
        {
            $modelName .= '_stemmer';
            $stemmer = new PhpStemmer($lang);
            echo "\n\nSVM with Stemmer:\n";
        }
        else
        {
            echo "\n\nSVM without Stemmer:\n";
        }
        $svmModel = new SVMMugoCachedModel($modelName, $this->getCacheFolderPath($lang, $type));
        $svmClassifier = new SVM($source, $svmModel, null, null, $stemmer);
        $svmClassifier->setThreshold(0.001);

        $testingResults = FitnessEvaluator::getInstance()->evaluate(['classifier' => $svmClassifier, 'data' => $testData]);
        $this->outputResults($testingResults);

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "\n\nTotal Time:($time)\n";
    }

    public function storeCachedSource( $classifierFolder, $cacheName, $data, $language )
    {
        $folderPath = dirname(__DIR__) . "/Resources/data/predict/{$language}/paragraph/cache/{$classifierFolder}";
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        file_put_contents("{$folderPath}/{$cacheName}", json_encode($data) );
        return true;
    }

    public function getCachedSource( $classifierFolder, $cacheName, $language )
    {
        $dataSource = json_decode(file_get_contents(dirname(__DIR__) . "/Resources/data/predict/{$language}/paragraph/cache/{$classifierFolder}/{$cacheName}"), true);
        $source = new DataArray();
        foreach( $dataSource as $category => $categoryItem )
        {
            foreach( $categoryItem as $index => $sourceItem )
            {
                $source->addDocument($category, $sourceItem);
            }
        }
        return $source;
    }

    private function saveStats($data)
    {
        $language = Settings::$language;
        $group = Settings::$group;
        $filePath = dirname(__DIR__) . "/Resources/data/predict/{$language}/{$group}/stats.csv";
        $handle = fopen($filePath, "a");
        fputcsv($handle, $data);
        fclose($handle);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $init = microtime(true);
        $initialState = LoopT1::getInstance();
        $introspect = false;
        $maxSteps = 30;
        $mutationRate = .7;
        $crossoverRate = .5;
        $useStemmer = false;
        $maxFitness = null;
        $languages = ['por', 'eng'];
        foreach( $languages as $language )
        {
            $classifierFolder = "sample_{$language}";
            $cacheName = "EvolutionaryAlgorithmSample_{$language}";
            $algorithm = new TextClassifierEvolutionaryAlgorithm(
                    TextClassifierEvolutionaryAlgorithm::SVM, // model name
                    $useStemmer, // use stemmer
                    $introspect, // introspect
                    $initialState, // Initial State
                    $crossoverRate, // $crossoverRate
                    $mutationRate, // $mutationRate
                    $maxSteps, // $maxSteps
                    $maxFitness,
                    $language
            );
            $member = $algorithm->run()[0];
            Settings::$testingData = Settings::$validatingData;
            $this->storeCachedSource( $classifierFolder, $cacheName, $member->getData(), $language );        
            $testData = [
                'definition' => $this->getData($language, 'paragraph', 'test', 'definition'),
                'other' => $this->getData($language, 'paragraph', 'test', 'other'),
            ];
            $this->cacheSVMModel($language, 'paragraph', true, $this->getCachedSource($classifierFolder, $cacheName, $language), $testData );
            $this->cacheSVMModel($language, 'paragraph', false, $this->getCachedSource($classifierFolder, $cacheName, $language), $testData );
            $this->cacheBayesModel($language, 'paragraph', true, $this->getCachedSource($classifierFolder, $cacheName, $language), $testData );
            $this->cacheBayesModel($language, 'paragraph', false, $this->getCachedSource($classifierFolder, $cacheName, $language), $testData );
        }
        $last = microtime(true);
        $totalTime = $last - $init;
        echo "\nTotal elapsed time is: ". $totalTime . "\n";
        return Command::SUCCESS;
    }
}
