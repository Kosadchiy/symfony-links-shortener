<?php

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LinkController extends AbstractController
{
    private $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function shorten(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $content = $request->getContent();
        if (!$content)
            return (new JsonResponse)->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
            
        $link = $serializer->deserialize($content, Link::class, 'json');
        $errors = $validator->validate($link);

        if (count($errors) > 0) {
            $errors = $serializer->serialize($errors, 'json');
            $response = JsonResponse::fromJsonString($errors);
            return $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
        }

        $link = $this->linkRepository->save($link);

        return (new JsonResponse)->setData([
            'url' => $request->getSchemeAndHttpHost() . '/' . $link->getShortUrl()
        ]);
    }
}