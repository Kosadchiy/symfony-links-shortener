<?php

namespace App\Controller;

use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkController extends AbstractController
{

    public function shorten(Request $request, LinkRepository $linkRepository)
    {
        $link = $linkRepository->create($request->getContent());

        return new Response('Saved new link with shorten '.$link->getShortUrl());
    }
}