<?php
namespace Mugo\ActionAxiomBundle\Controller;

use \eZ\Bundle\EzPublishCoreBundle\Controller;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;

class WordSuggestionController extends Controller
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string|null $language
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listAction(
        Request $request,
        ?string $language = null
    ) {
        if(strlen($language) > 3 || !ctype_alnum($language) )
        {
           $language = 'eng';
        }
        $baseDir = __DIR__ . '/../Resources/assets/words/';
        $fileName = $language . '_common.json';
        $result = [];
        if(file_exists($baseDir . $fileName))
        {
            $result = json_decode(file_get_contents($baseDir . $fileName));
        }
        else
        {
            $result = json_decode(file_get_contents($baseDir . 'eng_common.json'));
        }
        return $this->buildJSONResponse($result);
    }
    /**
     * Builds a response object
     *
     * @return JsonResponse Returns a Response object
     */
    protected function buildJSONResponse( $data )
    {
        $request  = Request::createFromGlobals();
        $response = new JsonResponse( $data );

        // Make the response vary against X-User-Hash header ensures that an HTTP
        // reverse proxy caches the different possible variations of the
        // response as it can depend on user role for instance.
        if ($request->headers->has('X-User-Hash'))
        {
            $response->setVary('X-User-Hash');
        }
        return $response;
    }
}