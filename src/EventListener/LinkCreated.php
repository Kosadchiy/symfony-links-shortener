<?php

namespace App\EventListener;

use App\Entity\Link;
use App\Repository\LinkRepository;
use App\Service\EncodeToBaseService;

class LinkCreated
{
    private $linkRepository;
    private $encodeToBaseService;

    public function __construct(LinkRepository $linkRepository, EncodeToBaseService $encodeToBaseService)
    {
        $this->linkRepository = $linkRepository;
        $this->encodeToBaseService = $encodeToBaseService;
    }

    public function postPersist(Link $link)
    {
        $shorten = $this->encodeToBaseService->toBase($link->getId());
        $link->setShortUrl($shorten);
        $this->linkRepository->save($link);
    }
}