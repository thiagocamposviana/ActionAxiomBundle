<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier;

use \Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token\PhpStemmer;
use \Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document\NormalizerInterface;

/**
 * General public accessible variables
 */
class Settings
{
    public static string $modelName = 'bayes';
    public static bool $useStemmer = false;
    public static ?PhpStemmer $stemmer = null;
    public static string $language = 'por';
    public static string $group = 'paragraph';
    public static ?NormalizerInterface $documentNormalizer = null;
    public static int $initialExtraDefinitions = 10;
    public static array $testingData = [];
    public static array $validatingData = [];
    public static array $introspectionMaxSimulations = ['definition' => 10, 'other' => 20];
}