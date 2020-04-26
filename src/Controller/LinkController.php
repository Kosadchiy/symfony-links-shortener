<?php

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $link = $serializer->deserialize($request->getContent(), Link::class, 'json');
        $errors = $validator->validate($link);

        if (count($errors) > 0) {
            $errors = $serializer->serialize($errors, 'json');
            return (new Response($errors))->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $link = $this->linkRepository->save($link);

        return new Response('Saved new link with shorten '.$link->getShortUrl());
    }
}