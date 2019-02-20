<?php

namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class CardController extends AbstractFOSRestController
{
    private $cardRepository;
    private $em;

    public function __construct(CardRepository $cardRepository,EntityManagerInterface $entityManager )
    {
        $this->cardRepository = $cardRepository;
        $this->em = $entityManager;
    }

    /**
     * @Rest\Get("/api/card/{name}")
     * @param Card $card
     * @return \FOS\RestBundle\View\View
     */
    public function getApiCard(Card $card){
        return $this->view($card);
    }
    /**
     * @Rest\Get("/api/cards")
     * @Rest\View(serializerGroups={"cards"})
     */
    public function getApiCards (){
        $cards = $this->cardRepository ->findAll();
        return $this->view($cards);
    }

    /**
     * @Rest\Post("/api/card")
     * @ParamConverter("card", converter="fos_rest.request_body")
     * @param Card $card
     * @return \FOS\RestBundle\View\View
     */
    public function postApiCard(Card $card)
    {
        $this->em->persist($card);
        $this->em->flush();
        return $this->view($card);
    }

    /**
     * @Rest\Patch("/api/card/{id}")
     * @param Card $card
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function patchApiCard(Card $card, Request $request){

        $name = $request->get('name');
        $creditCardType = $request->get('creditCardType');
        $creditCardNumber = $request->get('creditCardNumber');
        $currencyCode = $request->get('currencyCode');
        $value = $request->get('value');
        $user = $request->get( 'user' );

        if($name !== null){
            $card->setName($name);
        }
        if($creditCardType !== null){
            $card->setCreditCardType($creditCardType);
        }
        if($creditCardNumber !== null){
            $card->setCreditCardNumber($creditCardNumber);
        }
        if($currencyCode !== null){
            $card->setCurrencyCode($currencyCode);
        }
        if($value !== null){
            $card->setValue($value);
        }
        $this->em->persist($card);
        $this->em->flush();
        return $this->view($card);
    }

    /**
     * @Rest\Delete("/api/card/{name}")
     * @param Card $card
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteApiSubscription(Card $card){
        $this->em->remove($card);
        $this->em->flush();
        return $this->json('OK');
    }
}