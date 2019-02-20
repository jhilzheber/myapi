<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Rest\Post("/api/user")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param User $user
     * @param ConstraintViolationListInterface $validationErrors
     * @return \FOS\RestBundle\View\View
     */
    public function postApiUser(User $user, ConstraintViolationListInterface $validationErrors)
    {
        $errors = array();
        if ($validationErrors ->count() > 0) {
            /** @var ConstraintViolation $constraintViolation */
            foreach ($validationErrors as $constraintViolation ){
// Returns the violation message. (Ex. This value should not be blank.)
                $message = $constraintViolation ->getMessage ();
// Returns the property path from the root element to the violation. (Ex. lastname)
                $propertyPath = $constraintViolation ->getPropertyPath ();
                $errors[] = ['message' => $message , 'propertyPath' => $propertyPath ];
            }
        }
        if (!empty($errors)) {
// Throw a 400 Bad Request with all errors messages (Not readable, you can do better)
            throw new BadRequestHttpException(\json_encode( $errors));
        }

        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    /**
     * @Rest\Patch("/api/user/{email}")
     * @param User $user
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return \FOS\RestBundle\View\View
     */

    public function patchApiUser(User $user, Request $request, ValidatorInterface $validator){

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
        $validationErrors = $validator->validate($user);
        if ($validationErrors->count() > 0) {
            /** @var ConstraintViolation $constraintViolation */
            foreach ($validationErrors as $constraintViolation) {
                // Returns the violation message. (Ex. This value should not be blank.)
                $message = $constraintViolation->getMessage();
                // Returns the property path from the root element to the violation. (Ex. lastname)
                $propertyPath = $constraintViolation->getPropertyPath();
                $errors[] = ['message' => $message, 'propertyPath' => $propertyPath];
            }
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