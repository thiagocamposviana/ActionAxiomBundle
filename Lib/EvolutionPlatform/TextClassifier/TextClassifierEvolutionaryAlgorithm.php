<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier;

use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token\PhpStemmer;
use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\EvolutionaryAlgorithm;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Member as AbstractMember;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State;

class TextClassifierEvolutionaryAlgorithm extends EvolutionaryAlgorithm
{
    private $totalMembers = 20;
    private $language = 'por';
    private $group = 'paragraph';
    private $testingData;
    private float $instrospectionThreshold = .97;
    private bool $instrospect;
    
    const SVM = 'svm';
    const BAYES = 'bayes';

    function __construct(string $modelName, bool $useStemmer, bool $instrospect, State $initialState, float $crossoverRate, float $mutationRate, int $maxSteps, $maxFitness = null, $language = 'por')
    {
        parent::__construct($crossoverRate, $mutationRate, $maxSteps, $maxFitness);
        $this->initialState = $initialState;
        Settings::$documentNormalizer = new Document\None();
        $this->language = $language;
        Settings::$language = $language;
        Settings::$modelName = $modelName;
        Settings::$group = $this->group;
        echo "\n\n{$modelName} " . get_class($this->initialState);
        $this->instrospect = $instrospect;
        if( $useStemmer )
        {
            echo " with Stemmer";
            Settings::$useStemmer = true;
            Settings::$stemmer = new PhpStemmer($this->language);
        }
        echo "\n\n";
        Settings::$testingData = [
            'definition' => $this->getData('definition'),
            'other' => $this->getData('other'),
        ];
        Settings::$validatingData = [
            'definition' => $this->getData('definition', 'validate'),
            'other' => $this->getData('other', 'validate'),
        ];
    }

    private function getData($item, $type='test')
    {
        $filePath = dirname(__DIR__, 3) . "/Resources/data/predict/{$this->language}/{$this->group}/{$type}/{$item}";
        if(file_exists($filePath) )
        {
            $contents = file_get_contents($filePath);
            return array_map('trim', explode("\n", $contents));
        }
        throw new \Exception('File not found: ' . $filePath);
    }

    private function createMember( $dataSource = null, $introspect = true )
    {
        return MemberFactory::getInstance()->create($dataSource);
    }

    public function initialPopulation() : array
    {
        $population = [];
        for($i = 0; $i < $this->totalMembers; $i ++)
        {
            if( $i > 0 )
            {
                $population[] = $this->createMember();
            }
            else
            {

                $population[] = $this->createMember();
            }

        }
        return $population;
    }

    public function fitness(AbstractMember $member) : float
    {
        return $member->getFitness();
    }

    public function crossover($parent1, $parent2) : AbstractMember
    {
        $member = CrossoverFactory::getInstance()->crossover($parent1, $parent2);
        if( $this->instrospect && $member->getFitness() >= $this->instrospectionThreshold * $this->bestFitness )
        {
            $member = IntrospectionFactory::getInstance()->mutate($member);
        }
        return $member;
    }

    public function mutate($member) : AbstractMember
    {
        $member = MutationFactory::getInstance()->mutate($member);
        if( $this->instrospect && $member->getFitness() >= $this->instrospectionThreshold * $this->bestFitness )
        {
            $member = IntrospectionFactory::getInstance()->mutate($member);
        }
        return $member;
    }
}
