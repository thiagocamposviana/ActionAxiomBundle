<?php

namespace Mugo\ActionAxiomBundle\Controller;

use EzSystems\EzPlatformAdminUiBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;


class EvolutionPlatformController extends Controller
{
    public function manageAction()
    {
        return $this->render('@ezdesign/evolution_platform/manage.html.twig', [
            'title' => 'Evolution Platform Manager',
            'text' => 'Sample text.',
        ]);
    }

    /**
     * Checks if $parameterName is defined
     *
     * @param string $parameterName
     *
     * @return boolean
     */
    public function hasParameter( $parameterName )
    {
        return $this->get( 'ezpublish.config.resolver' )->hasParameter( $parameterName );
    }
    /**
     * Returns value for $parameterName and fallbacks to $defaultValue if not defined
     *
     * @param string $parameterName
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getParameter( $parameterName, $defaultValue = null, $namespace = null )
    {
        if( $this->get( 'ezpublish.config.resolver' )->hasParameter( $parameterName, $namespace ) )
        {
            return $this->get( 'ezpublish.config.resolver' )->getParameter( $parameterName, $namespace );
        }
        return $defaultValue;
    }
    /**
     * Builds a response object
     *
     * @return Response Returns a Response object
     */
    protected function buildJSONResponse( $data )
    {
        $request  = Request::createFromGlobals();
        $response = new JsonResponse( $data );
        if ($this->getParameter('content.ttl_cache') === true)
        {
            $response->setSharedMaxAge(
                $this->getParameter('content.default_ttl')
            );
            $response->setExpires(
                    new \DateTime( "+" . $this->getParameter('content.default_ttl') . " seconds" )
            );
        }
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