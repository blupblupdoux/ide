<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/api/user", name="api_user_")
 */
class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="browse")
     */
    public function browse(): Response
    {
        $users = $this->userRepository->findAll();
        $users_json = $this->serializer->serialize($users, 'json', ['groups' => ['user']]);
        return $users_json;
    }
}
