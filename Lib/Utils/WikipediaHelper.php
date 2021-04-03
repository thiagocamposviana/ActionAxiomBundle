<?php

namespace Mugo\ActionAxiomBundle\Lib\Utils;

class WikipediaHelper
{
    private static $indexCache = [];
    /**
     * 
     * @param string $lang
     * @return string[]
     */
    public static function getRandomArticleParagraphs( $lang )
    {
        $folderPath = dirname(__DIR__, 2) . "/Resources/data/wikipedia/{$lang}/";
        if( !isset(self::$indexCache[$lang]) )
        {
            self::$indexCache[$lang] = json_decode(@file_get_contents( $folderPath . "/index"), true);
            if( empty( self::$indexCache[$lang] ) )
            {
                throw new \Exception("Wikipedia articles for {$lang} are not cached.");
            }
        }
        $limit = count(self::$indexCache[$lang]) - 1;
        $articleId = rand(0, $limit);
        return json_decode(file_get_contents($folderPath . '/' . $articleId), true);
    }

    public static function cacheRandomPortugueseArticleParagraphs( $limit = 1000 )
    {
        $folderPath = dirname(__DIR__, 2) . "/Resources/data/wikipedia/por/";
        $index = json_decode(@file_get_contents( $folderPath . "/index"), true);
        if( !$index )
        {
            $index = [];
        }
        $offset = count($index);
        $x = 0 + $offset;
        while( $x < ($limit + $offset) )
        {
            $html = HTMLHelper::str_get_html(file_get_contents('https://pt.wikipedia.org/wiki/Especial:Aleat%C3%B3ria'));
            $articleTitle = trim($html->find('#firstHeading')[0]->plaintext);
            $hashTitle = md5($articleTitle);
            // we are not going to repeat articles
            if( isset($index[$hashTitle]) )
            {
                continue;
            }
            $results = [];
            $paragraphs = $html->find('#mw-content-text  p');
            if( count($paragraphs) > 2 )
            {
                foreach( $paragraphs as $paragraph )
                {
                    $result = html_entity_decode( preg_replace( '/\[(\s+)?[0-9]+\]/Uisu', '', trim($paragraph->plaintext) ) );
                    if(str_word_count($result) > 5)
                    {
                        $results[] = $result;
                    }
                }
            }
            if( !empty($results) )
            {
                $index[$hashTitle] = $x;
                file_put_contents($folderPath . $x, json_encode($results));
                file_put_contents($folderPath . "/index", json_encode($index));
                $x++;
            }
        }
        return true;
    }
}