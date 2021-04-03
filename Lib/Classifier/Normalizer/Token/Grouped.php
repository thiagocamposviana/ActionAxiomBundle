<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token;

use InvalidArgumentException;

class Grouped implements NormalizerInterface
{
    /**
     * An array of normalizers to run
     * @var array
     */
    protected $normalizers = array();
    /**
     * Create the normalizer using an array or normalizers as input
     * @param  mixed                     $normalizers
     * @throws \InvalidArgumentException
     */
    public function __construct($normalizers = array())
    {
        if (!is_array($normalizers)) {
            $normalizers = func_get_args();
        }

        if (count($normalizers) === 0) {
            throw new InvalidArgumentException('A group of normalizers must contain at least one normalizer');
        }

        foreach ($normalizers as $normalizer) {
            $this->addNormalizer($normalizer);
        }
    }
    /**
     * Add a normalizer to the group
     * @param NormalizerInterface $normalizer The normalizer
     */
    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }
    /**
     * @{inheritdoc}
     */
    public function normalize(array $tokens)
    {
        foreach ($this->normalizers as $normalizer) {
            $tokens = $normalizer->normalize($tokens);
        }

        return $tokens;
    }
}
