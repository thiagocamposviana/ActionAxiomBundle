<?php
namespace Mugo\ActionAxiomBundle\Controller;

use \eZ\Bundle\EzPublishCoreBundle\Controller;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;

class DataDictionaryController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(
        ?string $language = null,
        ?string $dictionary = null
    ) {
        if( !ctype_alnum($dictionary) )
        {
            throw new Exception('Invalid dictionary name format');
        }
        if(strlen($language) > 3 || !ctype_alnum($language) )
        {
           $language = 'eng';
        }
        $filePath = __DIR__ . "/../Resources/data/dictionaries/{$language}/{$dictionary}";
        if(file_exists($filePath) )
        {
            $contents = file_get_contents($filePath);
            $results = array_filter(array_map('trim', explode("\n", $contents)));
            return new JsonResponse( $results );
        }
        else
        {
            throw new Exception('Dictionary does not exist');
        }
    }
}