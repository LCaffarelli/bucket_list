<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/", name: "whish_")]
class WishController extends AbstractController
{
    #[Route('', name: 'list')]
    public function addWish(): Response
    {
        return $this->render('/wish/list.html.twig', [

        ]);
    }
}
