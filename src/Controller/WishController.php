<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishFormType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/wish/", name: "wish_")]
class WishController extends AbstractController
{
    #[Route('list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findAll();
        return $this->render('wish/list.html.twig', ['wishes' => $wishes]);
    }

    #[Route("details/{id}", name: "details")]
    public function details(int $id, WishRepository $wishRepository)
    {
        $wish = $wishRepository->find($id);
        return $this->render("/wish/details.html.twig", ['wish' => $wish]);
    }

    #[Route("create", name: "create")]
    public function create(Request $request, EntityManagerInterface $entityManager):Response
    {
        $wish = new Wish();

        $wishForm = $this->createForm(WishFormType::class, $wish);

        //On "hydrate" l'instance Wish avec les données de la request
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setDateCreated(new \DateTime('now'));
            $wish->setIsPublished(true);
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success',message: 'Votre souhait à bien été ajouté !');

            return $this->redirectToRoute('wish_details',['id'=>$wish->getId()]);
        }
        return $this->render('wish/create.html.twig',['wishForm'=>$wishForm->createView()]);

    }

    #[Route('demo', name: "demo")]
    public function demo(EntityManagerInterface $entityManager)
    {
        $wish3 = new Wish();
        $wish3->setTitle('Faire un long voyage en vélo');
        $wish3->setAuthor('Bob');
        $wish3->setDescription("Parcourir l'Europe en vélo ");
        $wish3->setIsPublished(true);
        $wish3->setDateCreated(new \DateTime());

        $wish4 = new Wish();
        $wish4->setTitle('Nager avec des méduses');
        $wish4->setAuthor('Bob');
        $wish4->setDescription('Aller à Palau pour nager dans le lac aux Méduses');
        $wish4->setIsPublished(false);
        $wish4->setDateCreated(new \DateTime('-2 year'));

        $entityManager->persist($wish3);
        $entityManager->persist($wish4);
        $entityManager->flush();


        return $this->render('wish/demo.html.twig');

    }
}
