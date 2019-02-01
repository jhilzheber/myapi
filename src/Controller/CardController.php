<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionController extends AbstractFOSRestController
{
    private $subscriptionRepository;
    private $em;

    public function __construct(SubscriptionRepository $subscriptionRepository,EntityManagerInterface $entityManager )
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->em = $entityManager;
    }

    /**
     * @Rest\Get("/api/subscription/{name}")
     * @param Subscription $subscription
     * @return \FOS\RestBundle\View\View
     */
    public function getApiSubscription(Subscription $subscription){
        return $this->view($subscription);
    }
    /**
     * @Rest\Get("/api/subscriptions")
     * @Rest\View(serializerGroups={"subscriptions"})
     */
    public function getApiSubscriptions (){
        $subscriptions = $this->subscriptionRepository ->findAll();
        return $this->view($subscriptions);
    }

    /**
     * @Rest\Post("/api/subscription")
     * @ParamConverter("subscription", converter="fos_rest.request_body")
     * @param Subscription $subscription
     * @return \FOS\RestBundle\View\View
     */
    public function postApiSubscription(Subscription $subscription)
    {
        $this->em->persist($subscription);
        $this->em->flush();
        return $this->view($subscription);
    }

    /**
     * @Rest\Patch("/api/subscription/{id}")
     * @param Subscription $subscription
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function patchApiUser(Subscription $subscription, Request $request){

        $name = $request->get('name');
        $slogan = $request->get('slogan');
        $url = $request->get('url');

        if($name !== null){
            $subscription->setName($name);
        }
        if($slogan !== null){
            $subscription->setSlogan($slogan);
        }
        if($url !== null){
            $subscription->setUrl($url);
        }
        $this->em->persist($subscription);
        $this->em->flush();
        return $this->view($subscription);
    }

    /**
     * @Rest\Delete("/api/subscription/{name}")
     * @param Subscription $subscription
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteApiSubscription(Subscription $subscription){
        $this->em->remove($subscription);
        $this->em->flush();
        return $this->json('OK');
    }
}