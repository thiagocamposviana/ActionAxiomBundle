<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token;
use Wamania\Snowball\StemmerFactory;
use Wamania\Snowball\Stemmer\Stemmer;

/**
 * @see https://github.com/hthetiot/php-stemmer.git
 */
class PhpStemmer implements NormalizerInterface
{

    /**
     * Stemmer.
     *
     * @var Stemmer
     */
    protected $stemmer;

    /**
     * Lang.
     *
     * @var string
     */
    protected $lang;

    /**
     * @param string $lang
     */
    public function __construct($lang)
    {
        $lang = strtolower($lang);
        $this->lang    = $lang;
        $this->stemmer = StemmerFactory::create($this->lang);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(array $tokens)
    {
        $stemmer = StemmerFactory::create($this->lang);
        foreach ($tokens as $k => $token) {
            $tokens[$k] = $this->stemmer->stem($token);
        }

        return $tokens;
    }
}
