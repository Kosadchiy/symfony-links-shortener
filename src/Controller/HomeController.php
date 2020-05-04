<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route(
     *  "/{vueRouting?}", 
     *  requirements={"vueRouting"="^(?!api|_(profiler|wdt)).*"}, 
     *  name="index", 
     *  methods={"GET"}
     * )
     * @return Response
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
}