<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
//use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
    private $serializer;
    private $userRepository;

    public function __construct(SerializerInterface $serializer, UserRepository $userRepository)
    {
        $this->serializer = $serializer;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $content = $request->getContent();
        if (!$content)
            return (new JsonResponse)->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);

        $user = $this->serializer->deserialize($content, User::class, 'json');
        $user->confirm = json_decode($content)->confirm;

        /*$constraint = new Assert\Collection([
            'email' => [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Callback([
                    'callback' => function($value, $context) {
                        if (count($this->userRepository->findBy(['email' => $value]))) {
                            $context->addViolation('Email is alrady exists.');
                        }
                    },
                ])
            ],
            'password' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 6])
            ],
            'confirm' => [
                new Assert\NotBlank(),
                new Assert\EqualTo([
                    'message' => 'The confirmation should be equal to password.',
                    'value' => $content['password']
                ])
            ]
        ]);*/

        $errors = $validator->validate($user, null,  ['registration']);

        if ($errors->count() > 0) {
            $errors = $this->serializer->serialize($errors, 'json');
            $response = JsonResponse::fromJsonString($errors);
            return $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
        }

        $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
        $user = $this->userRepository->save($user);

        return (new JsonResponse)->setData([
            'user' => [
                'email' => $user->getEmail()
            ]
        ]);
    }

    /**
     * @Route("/security/login", name="login")
     */
    public function loginAction(): JsonResponse
    {
        $user = $this->getUser();
        $userClone = clone $user;
        $userClone->setPassword('');
        $data = $this->serializer->serialize($userClone, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @throws RuntimeException
     *
     * @Route("/security/logout", name="logout")
     */
    public function logoutAction(): void
    {
        throw new RuntimeException('This should not be reached!');
    }
}