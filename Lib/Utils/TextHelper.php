<?php

namespace Mugo\ActionAxiomBundle\Lib\Utils;

class TextHelper
{
    /**
     *
     * @param string $lang
     * @return string[]
     */
    public static function getSentences( $text )
    {
        $sentences = array_map( 'trim', preg_split("/(?<!\.\.\.)(?<=[.?!]|\.\))\s+(?=[a-zà-ú])/Uisu", $text));
        foreach( $sentences as $i => $sentence )
        {
            // avoiding lists and also really short sentences
            if( str_word_count($sentence) <= 3
                    || substr_count($sentence, '\u2022') > 3
                    || substr_count($sentence, '|') > 3
                    || substr_count($sentence, '·') > 3
                    || substr_count($sentence, '•') > 3
            )
            {
                $sentences[$i] = '';
            }
        }

        return array_filter($sentences);
    }

    public static function applyTextCommonTransformations( $text, $stemmer = null )
    {
        $text = mb_strtolower($text, 'utf-8');
        $tokens = preg_split('/\PL+/u', $text, null, PREG_SPLIT_NO_EMPTY);
        if( $stemmer )
        {
            $tokens = $stemmer->normalize($tokens);
        }
        return join( ' ',  $tokens);
    }

    public static function startsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }

    public static function endsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }

}