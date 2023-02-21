<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig');
    }

    #[Route('/{id}', name: 'wish_detail' , requirements: ["id" => "\d+"])]
    public function detail($id): Response
    {
        dump($id);
        return $this->render('wish/detail.html.twig');
    }


}
