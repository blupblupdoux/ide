<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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

    /**
     * @var ValidatorInterface
     */
    private $validator;
    

    public function __construct(UserRepository $userRepository, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
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
    public function add(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $data = json_decode($request->getContent(), true);

        if($data) {

            $user = new User();
            
            $form = $this->createForm(UserType::class, $user);
            $form->submit($data);

            $errors = $this->validator->validate($user);
            
            if($form->isSubmitted() && count($errors) === 0) 
            {
                $user = $form->getData();

                if(array_key_exists('admin', $data))
                {
                    if($data['admin']) 
                    {
                        $user->setRoles(["ROLE_ADMIN"]);
                    }
                }

                if(array_key_exists('birthday', $data))
                {
                    if($data['birthday']) 
                    {
                        $user->setBirthday(new \DateTime($data['birthday']));
                    }
                }

                $user->setPassword($encoder->encodePassword($user, $data['password']));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->json($user, 201);
            } else 
            {
                return $this->json($errors, 500);
            }
        } else 
        {
            return $this->json("You cannot send empty request", 400);
        }
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit(Request $request): Response
    {   
        $data = json_decode($request->getContent(), true);

        if($data) 
        {
            if(array_key_exists('id', $data)) 
            {
                $user = $this->userRepository->find($data['id']);

                if($user) 
                {
                    $form = $this->createForm(UserType::class, $user);
                    $form->submit($data);

                    $errors = $this->validator->validate($user);

                    if($form->isSubmitted() && count($errors) === 0) 
                    {
                        $user = $form->getData();

                        $user->setUpdatedAt(new \DateTime());

                        if(array_key_exists('admin', $data))
                        {
                            if($data['admin']) 
                            {
                                $user->setRoles(["ROLE_ADMIN"]);
                            } 
                            else 
                            {
                                $user->setRoles([]);
                            }
                        }

                        if(array_key_exists('birthday', $data))
                        {
                            if($data['birthday']) 
                            {
                                $user->setBirthday(new \DateTime($data['birthday']));
                            }
                        }

                        $em = $this->getDoctrine()->getManager();
                        $em->flush();

                        return $this->json($user, 200);
                    } 
                    else 
                    {
                        return $this->json([$user,$errors], 500);
                    }
                } 
                else 
                {
                    return $this->json("The user you want to edit doesn't exist", 404);
                }
            } 
            else 
            {
                return $this->json("The user you want to edit doesn't have an id", 400);
            }
        } 
        else 
        {
            return $this->json("You cannot send empty request", 400);
        }
    }
}
