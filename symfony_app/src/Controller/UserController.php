<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $users_array = $this->serializer->normalize($users, null, ['groups' => ['user']]);
        return $this->json($users_array);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function read($id): Response
    {
        $user = $this->userRepository->find($id);
        $user_array = $this->serializer->normalize($user, null, ['groups' => ['user']]);
        return $this->json($user_array);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);

        if($form->isSubmitted()) {

            $user = $form->getData();

            $user->setRoles(["ROLE_ADMIN"]);

            $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$1p0D/j/2PrQKvfxAz/J+SA$NYaUQx44eRoyWtHcww4TjndGeYrqq26aYLZA7tdLMvQ');

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json($user, 201);
        } else {
            return $this->json($user, 500);
        }
    }
}
