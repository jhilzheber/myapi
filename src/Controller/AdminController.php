<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SubscriptionRepository;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractFOSRestController
{
    /**
     * @Route("/admin", name="admin")
     * @param UserRepository $userRepository
     * @param SubscriptionRepository $subscriptionRepository
     * @param CardRepository $cardRepository
     */

    public function index(UserRepository $userRepository, SubscriptionRepository $subscriptionRepository, CardRepository $cardRepository)
    {
        $users = $userRepository->findAll();
        $subscriptions = $subscriptionRepository->findAll();
        $cards = $cardRepository->findAll();
    }
}