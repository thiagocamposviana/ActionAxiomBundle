<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier;

use Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataSourceInterface;
use Mugo\ActionAxiomBundle\Lib\Classifier\Model\Model;
use Mugo\ActionAxiomBundle\Lib\Classifier\Model\ModelInterface;
use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document;
use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token;
use Mugo\ActionAxiomBundle\Lib\Classifier\Tokenizer\TokenizerInterface;
use Mugo\ActionAxiomBundle\Lib\Classifier\Tokenizer\Word;
use Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

/**
 * An implementation of a Naive Bayes classifier.
 *
 * This classifier is based off *Tackling the Poor Assumptions of Naive Bayes Text Classifiers* by Jason Rennie
 */
class ComplementNaiveBayes extends Classifier
{
    /**
     * Tokenizer (the way of breaking up documents)
     * @var TokenizerInterface
     */
    protected $tokenizer;
    /**
     * Takes document and makes it consistent
     * @var Document\NormalizerInterface
     */
    protected $documentNormalizer;
    /**
     * Takes tokenized data and makes it consistent or stem it
     * @var Token\NormalizerInterface
     */
    protected $tokenNormalizer;
    /**
     * Create the Naive Bayes Classifier
     * @param DataSourceInterface          $dataSource
     * @param ModelInterface               $model              An model to store data in
     * @param Document\NormalizerInterface $documentNormalizer The normalizer to make document consistent
     * @param TokenizerInterface           $tokenizer          The tokenizer to break up the documents
     * @param Token\NormalizerInterface    $tokenNormalizer    The normaizer to make tokens consistent
     */
    public function __construct(
        DataSourceInterface $dataSource,
        ModelInterface $model = null,
        Document\NormalizerInterface $documentNormalizer = null,
        TokenizerInterface $tokenizer = null,
        Token\NormalizerInterface $tokenNormalizer = null
    ) {
        $this->dataSource         = $dataSource;
        $this->model              = $model ?: new Model();
        $this->documentNormalizer = $documentNormalizer ?: new Document\Lowercase();
        $this->tokenizer          = $tokenizer ?: new Word();
        $this->tokenNormalizer    = $tokenNormalizer;
    }
    /**
     * @inheritdoc
     */
    public function prepareModel()
    {
        $data = $this->applyTransform(
            new Transform\TokenPreparation(
                $this->tokenizer,
                $this->documentNormalizer,
                $this->tokenNormalizer
            ),
            $this->dataSource->getData()
        );
        
        $tokenCountByDocument = $this->applyTransform(
            new Transform\TokenCountByDocument(),
            $data
        );

        $documentCount = $this->applyTransform(
            new Transform\DocumentCount(),
            $data
        );

        unset($data);

        $tokenAppearanceCount = $this->applyTransform(
            new Transform\TokenAppearanceCount(),
            $tokenCountByDocument
        );

        $tokensByCateory = $this->applyTransform(
            new Transform\TokensByCategory(),
            $tokenCountByDocument
        );

        $tfidf = $this->applyTransform(
            new Transform\TFIDF(),
            $tokenCountByDocument,
            $documentCount,
            $tokenAppearanceCount
        );

        unset($tokenCountByDocument);
        unset($tokenAppearanceCount);

        $documentLength = $this->applyTransform(
            new Transform\DocumentLength(),
            $tfidf
        );

        unset($tfidf);

        $documentTokenCounts = $this->applyTransform(
            new Transform\DocumentTokenCounts(),
            $documentLength
        );

        $complement = $this->applyTransform(
            new Transform\Complement(),
            $documentLength,
            $tokensByCateory,
            $documentCount,
            $documentTokenCounts
        );

        unset(
            $documentLength,
            $tokensByCateory,
            $documentCount,
            $documentTokenCounts
        );

        $this->model->setModel(
            $this->applyTransform(
                new Transform\Weight(),
                $complement
            )
        );

        $this->model->setPrepared(true);
    }
    /**
     * @inheritdoc
     */
    public function classify($document)
    {
        $results = array();

        if ($this->documentNormalizer) {
            $document = $this->documentNormalizer->normalize($document);
        }

        $tokens = $this->tokenizer->tokenize($document);

        if ($this->tokenNormalizer) {
            $tokens = $this->tokenNormalizer->normalize($tokens);
        }

        $tokens = array_count_values($tokens);

        $weights = $this->preparedModel()->getModel();

        foreach (array_keys($weights) as $category) {
            $results[$category] = 0;
            foreach ($tokens as $token => $count) {
                if (array_key_exists($token, $weights[$category])) {
                    $results[$category] += $count * $weights[$category][$token];
                }
            }
        }

        asort($results, SORT_NUMERIC);

        $category = key($results);

        $value = array_shift($results);

        if ($value === array_shift($results)) {
            return false;
        } else {
            return $category;
        }
    }

    public function getResults($document)
    {
        $results = array();

        if ($this->documentNormalizer) {
            $document = $this->documentNormalizer->normalize($document);
        }

        $tokens = $this->tokenizer->tokenize($document);

        if ($this->tokenNormalizer) {
            $tokens = $this->tokenNormalizer->normalize($tokens);
        }

        $tokens = array_count_values($tokens);

        $weights = $this->preparedModel()->getModel();

        foreach (array_keys($weights) as $category) {
            $results[$category] = 0;
            foreach ($tokens as $token => $count) {
                if (array_key_exists($token, $weights[$category])) {
                    $results[$category] += $count * $weights[$category][$token];
                }
            }
        }

        asort($results, SORT_NUMERIC);
        $normalizationBase = array_sum($results);
        foreach( $results as $category => $value )
        {
            $results[$category] = $value/$normalizationBase;
        }
        return $results;
    }
}
