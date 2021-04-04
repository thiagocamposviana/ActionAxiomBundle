<?php
namespace Mugo\ActionAxiomBundle\Controller;

use \eZ\Bundle\EzPublishCoreBundle\Controller;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;
use Mugo\ActionAxiomBundle\Entity\MugoWordSynonym;

class WordSynonymsController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(
        Request $request,
        ?string $language = null,
        ?string $word = null
    ) {
        if(strlen($language) > 3 || !ctype_alnum($language) )
        {
           $language = 'eng';
        }
        $mugoWordSynonymRepository = $this->getDoctrine()->getRepository(MugoWordSynonym::class);
        $items = $mugoWordSynonymRepository->findBy(['word' => $word, 'language' => $language]);
        $results = [];
        foreach( $items as $item)
        {
            $result = [ 'type' => $item->getType(), 'synonyms' => [], 'antonyms' => [] ];
            $synonyms = $mugoWordSynonymRepository->findBy(['code' => $item->getCode(), 'language' => $language]);
            foreach( $synonyms as $synonym)
            {
                $result['synonyms'][] = $synonym->getWord();
            }
            $antonymsCode = $item->getAntonymsCode();
            if($antonymsCode)
            {
                $antonyms = $mugoWordSynonymRepository->findBy(['code' => $antonymsCode, 'language' => $language]);
                foreach( $antonyms as $antonym)
                {
                    $result['antonyms'][] = $antonym->getWord();
                }
            }
            $results[] = $result;
        }

        return new JsonResponse( $results );

    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function endingAction(
        Request $request,
        ?string $language = null,
        ?string $word = null
    ) {
        if(strlen($language) > 3 || !ctype_alnum($language) )
        {
           $language = 'eng';
        }
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM Mugo\ActionAxiomBundle\Entity\MugoWordSynonym s
            WHERE s.word LIKE :word and s.language = :language
            GROUP BY s.word
            ORDER BY s.word ASC'
        )
        ->setParameter('language', "{$language}")
        ->setParameter('word', "%{$word}");

        $items = $query->getResult();
        $results = [];
        foreach( $items as $item)
        {
            $results[] = $item->getWord();
        }
        return new JsonResponse( $results );

    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function startingAction(
        Request $request,
        ?string $language = null,
        ?string $word = null
    ) {
        if(strlen($language) > 3 || !ctype_alnum($language) )
        {
           $language = 'eng';
        }
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM Mugo\ActionAxiomBundle\Entity\MugoWordSynonym s
            WHERE s.word LIKE :word and s.language = :language
            GROUP BY s.word
            ORDER BY s.word ASC'
        )
        ->setParameter('language', "{$language}")
        ->setParameter('word', "{$word}%");
        $items = $query->getResult();
        $results = [];
        foreach( $items as $item)
        {
            $results[] = $item->getWord();
        }
        return new JsonResponse( $results );

    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function containingAction(
        Request $request,
        ?string $language = null,
        ?string $word = null
    ) {
        if(strlen($language) > 3 || !ctype_alnum($language) )
        {
           $language = 'eng';
        }
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM Mugo\ActionAxiomBundle\Entity\MugoWordSynonym s
            WHERE s.word LIKE :word and s.language = :language
            GROUP BY s.word
            ORDER BY s.word ASC'
        )
        ->setParameter('language', "{$language}")
        ->setParameter('word', "%{$word}%");

        $items = $query->getResult();
        $results = [];
        foreach( $items as $item)
        {
            $results[] = $item->getWord();
        }
        return new JsonResponse( $results );
    }
}