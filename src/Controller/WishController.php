<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {

        $wishes = $wishRepository->findBy(["isPublished" => true], ["dateCreated" => "DESC"]);

        return $this->render('wish/list.html.twig', ["wishes"=>$wishes]);
    }

    #[Route('/{id}', name: 'show' , requirements: ["id" => "\d+"])]
    public function detail(Wish $id): Response
    {
        return $this->render('wish/detail.html.twig', ["wish"=>$id]);
    }


}
