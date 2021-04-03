<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token;
use Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document;
use Mugo\ActionAxiomBundle\Lib\Classifier\Tokenizer\TokenizerInterface;

class TokenPreparation
{
    /**
     * @var \Mugo\ActionAxiomBundle\Lib\Classifier\Tokenizer\TokenizerInterface
     */
    protected $tokenizer;
    /**
     * @var \Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document\NormalizerInterface
     */
    protected $documentNormalizer;
    /**
     * @var \Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token\NormalizerInterface
     */
    protected $tokenNormalizer;
    /**
     * @param \Mugo\ActionAxiomBundle\Lib\Classifier\Tokenizer\TokenizerInterface $tokenizer
     * @param \Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document\NormalizerInterface $documentNormalizer
     * @param \Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token\NormalizerInterface $tokenNormalizer
     */
    public function __construct(
        TokenizerInterface $tokenizer,
        Document\NormalizerInterface $documentNormalizer = null,
        Token\NormalizerInterface $tokenNormalizer = null
    ) {
        $this->tokenizer = $tokenizer;
        $this->documentNormalizer = $documentNormalizer;
        $this->tokenNormalizer = $tokenNormalizer;
    }

    public function __invoke($data)
    {
        foreach ($data as $category => $documents) {
            foreach ($documents as $index => $document) {
                if ($this->documentNormalizer) {
                    $document = $this->documentNormalizer->normalize($document);
                }
                
                $tokens = $this->tokenizer->tokenize($document);
                
                if ($this->tokenNormalizer) {
                    $tokens = $this->tokenNormalizer->normalize($tokens);
                }
                
                $data[$category][$index] = $tokens;
            }
        }
        
        return $data;
    }
} 