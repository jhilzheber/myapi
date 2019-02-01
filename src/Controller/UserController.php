<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractFOSRestController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository,EntityManagerInterface $entityManager )
    {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }

    /**
     * @Rest\Get("/api/user/{firstname}")
     * @param User $user
     * @return \FOS\RestBundle\View\View
     */
    public function getApiUser(User $user){
        return $this->view($user);
    }
    /**
     * @Rest\Get("/api/users")
     * @Rest\View(serializerGroups={"user"})
     */
    public function getApiUsers (){
        $users = $this->userRepository ->findAll();
        return $this->view($users);
    }

    /**
     * @Rest\Post("/api/users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param User $user
     * @return \FOS\RestBundle\View\View
     */
    public function postApiUser(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    /**
     * @Rest\Patch("/api/user/{email}")
     * @param User $user
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */

    public function patchApiUser(User $user, Request $request){

        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $createdAt = $request->get('createdAt');
        $apiKey = $request->get('api_key');

        if($firstname !== null){
            $user->setFirstname($firstname);
        }
        if($lastname !== null){
            $user->setLastname($lastname);
        }
        if($email !== null){
            $user->setEmail($email);
        }
        if($createdAt !== null){
            $user->setCreatedAt($createdAt);
        }
        if ($apiKey !== null) {
            $user->setApiKey($apiKey);
        }
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    /**
     * @Rest\Delete("/api/user/{email}")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteApiUser(User $user){
        $this->em->remove($user);
        $this->em->flush();
        return $this->json('OK');
    }
}