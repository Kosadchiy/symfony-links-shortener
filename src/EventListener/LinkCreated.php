<?php

namespace App\EventListener;

use App\Entity\Link;
use App\Repository\LinkRepository;

class LinkCreated
{
    private $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function postPersist(Link $link)
    {
        $shorten = $this->toBase($link->getId());
        $link->setShortUrl($shorten);
        $this->linkRepository->save($link);
    }

    /**
     * @todo move out of here
     *
     */
    public function toBase($num, $b = 62) {
        $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $r = $num % $b ;
        $res = $base[$r];
        $q = floor($num/$b);
        while ($q) {
            $r = $q % $b;
            $q = floor($q/$b);
            $res = $base[$r] . $res;
        }
        return $res;
    }
}