<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/wish", name: "wish_")]
class WishController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        return $this->render('/wish/list.html.twig', [

        ]);
    }
#[Route("/details/{id}")]
    public function details(int $id){
        return $this->render("/wish/details.html.twig");
    }
}
