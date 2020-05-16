<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function register(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $content = $request->getContent();
        if (!$content)
            return (new JsonResponse)->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);

        $user = $this->serializer->deserialize($content, User::class, 'json');
        $user->confirm = json_decode($content)->confirm;
        $errors = $validator->validate($user, null,  ['registration']);

        if ($errors->count() > 0) {
            $errors = $this->serializer->serialize($errors, 'json');
            $response = JsonResponse::fromJsonString($errors);
            return $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->save($user);

        return (new JsonResponse)->setData([
            'user' => [
                'email' => $user->getEmail()
            ]
        ]);
    }

    /**
     * @Route("/user", name="user", methods={"GET"} )
     */
    public function user(Security $security)
    {
        $user = $security->getUser();
        return (new JsonResponse)->setData([
            'user' => [
                'email' => $user->getEmail()
            ]
        ]);
    }
}